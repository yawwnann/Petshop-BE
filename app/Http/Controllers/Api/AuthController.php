<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;    // <--- PASTIKAN INI ADA
use App\Http\Requests\Api\RegisterRequest; // <--- PASTIKAN INI ADA
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request; // Tetap dipertahankan untuk metode user() dan logout()
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Sudah ada, bagus
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Registrasi pengguna baru.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse // <--- Menggunakan RegisterRequest
    {
        try {
            Log::info('Register endpoint called', $request->all());

            $validatedData = $request->validated(); // Validasi otomatis dari RegisterRequest

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            try {
                $userRole = Role::where('slug', 'user')->firstOrFail();
                $user->roles()->attach($userRole->id);
                Log::info('User role attached successfully', ['user_id' => $user->id, 'role_slug' => 'user']);
            } catch (\Exception $e) {
                Log::error("Role 'user' not found or could not be attached for user ID: {$user->id}. Error: " . $e->getMessage(), ['exception' => $e]);
                // Lanjutkan, user sudah terbuat
            }

            // Load relasi roles SEBELUM membuat UserResource
            $user->load('roles'); // <--- PENTING UNTUK MENGATASI roles: []

            // Generate JWT token untuk user yang baru terdaftar
            // Kedua metode ini valid: JWTAuth::fromUser($user) atau Auth::guard('api')->login($user)
            $token = JWTAuth::fromUser($user);

            Log::info('User registered successfully', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return $this->respondWithToken($token, $user, 'Registrasi berhasil.')
                ->setStatusCode(201);

        } catch (\Exception $e) {
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all() // Tambahkan data request untuk debugging
            ]);

            // Sesuaikan status code untuk validasi error jika diperlukan (misal 422)
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data validasi tidak valid.',
                    'errors' => $e->errors()
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'Registrasi gagal. Silakan coba lagi.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Login pengguna.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse // <--- Menggunakan LoginRequest
    {
        try {
            Log::info('Login attempt', ['email' => $request->email]);

            $credentials = $request->validated(); // Validasi otomatis dari LoginRequest

            if (!$token = Auth::guard('api')->attempt($credentials)) {
                Log::warning('Login failed - invalid credentials', ['email' => $request->email]);
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password salah.'
                ], 401);
            }

            $user = Auth::guard('api')->user();
            // Pastikan $user adalah instance dari Eloquent Model sebelum memanggil load()
            if ($user instanceof \Illuminate\Database\Eloquent\Model) {
                $user->load('roles'); // <--- PENTING UNTUK MENGATASI roles: [] setelah login
            }

            Log::info('Login successful', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return $this->respondWithToken($token, $user, 'Login berhasil.');

        } catch (\Exception $e) {
            Log::error('Login error', [
                'error' => $e->getMessage(),
                'email' => $request->email ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);

            // Sesuaikan status code untuk validasi error jika diperlukan
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data validasi tidak valid.',
                    'errors' => $e->errors()
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'Login gagal. Silakan coba lagi.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Logout pengguna dan hapus token.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            Auth::guard('api')->logout();

            Log::info('User logged out successfully', ['user_id' => $request->user()->id ?? 'unknown']);

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil.'
            ]);

        } catch (\Exception $e) {
            Log::error('Logout error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return response()->json([
                'success' => false,
                'message' => 'Logout gagal.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Mendapatkan data pengguna yang sedang login.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan atau tidak terautentikasi.' // Pesan lebih jelas
                ], 404);
            }

            // Load relasi roles jika ada
            // Tidak perlu cek method_exists('loadMissing') karena User model pasti punya
            $user->loadMissing('roles');

            return response()->json([
                'success' => true,
                'user' => new UserResource($user)
            ]);

        } catch (\Exception $e) {
            Log::error('Get user error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data user.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     * @param  \App\Models\User|null $user
     * @param  string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user = null, $message = 'Operasi berhasil.')
    {
        if (!$user) {
            $user = Auth::guard('api')->user();
            // Jika user diambil di sini, pastikan roles juga di-load
            if ($user instanceof \Illuminate\Database\Eloquent\Model) {
                $user->load('roles'); // <--- Pastikan roles di-load jika user baru diambil di sini
            }
        }

        return response()->json([
            'success' => true, // Menambahkan success: true untuk konsistensi
            'message' => $message,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60, // dalam detik
            'user' => $user ? new UserResource($user) : null,
        ]);
    }
}