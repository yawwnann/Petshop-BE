<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Pastikan ini ada
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Throwable; // Import Throwable untuk menangkap semua jenis error

class UserProfileController extends Controller
{
    /**
     * Update the profile photo for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', File::image()->max(2048)], // Max 2MB
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        try {
            $oldPublicId = $user->profile_photo_public_id;

            // 1. Hapus foto lama di Cloudinary jika ada (opsional jika pakai overwrite:true)
            if ($oldPublicId) {
                try {
                    Log::info("Attempting to delete Cloudinary file with Public ID: {$oldPublicId}");
                    cloudinary()->uploadApi()->destroy($oldPublicId);
                    Log::info("Successfully deleted old Cloudinary photo for user {$user->id}: {$oldPublicId}");
                } catch (Throwable $e) { // Gunakan Throwable
                    Log::error("Could not delete old Cloudinary photo [{$oldPublicId}] for user {$user->id}. Error: " . $e->getMessage());
                    // Lanjutkan proses meskipun gagal hapus
                }
            }

            // 2. Upload foto baru ke Cloudinary
            $file = $request->file('photo');
            $publicId = 'user_photos/user_' . $user->id; // Public ID konsisten

            $this->info('Attempting to upload to Cloudinary...'); // Tambah log sebelum upload

            $uploadedFile = cloudinary()->uploadApi()->upload($file->getRealPath(), [
                'folder' => 'user_profile_photos',
                'public_id' => $publicId,
                'overwrite' => true,
                'resource_type' => 'image',
                'transformation' => [
                    ['width' => 500, 'height' => 500, 'crop' => 'limit']
                ]
            ]);

            // --- TAMBAHKAN DD DI SINI UNTUK MELIHAT STRUKTUR ASLI ---
            // Hentikan eksekusi dan tampilkan isi $uploadedFile
            dd($uploadedFile);
            // -------------------------------------------------------


            // --- Kode pengambilan public ID (Sementara tidak dieksekusi karena dd()) ---
            $newPublicId = null;
            // Logika pengecekan dan pengambilan public id akan disesuaikan
            // berdasarkan hasil dd() di atas.
            // Contoh sementara (akan kita perbaiki setelah lihat hasil dd):
            if (is_array($uploadedFile) && isset($uploadedFile['public_id'])) {
                $newPublicId = $uploadedFile['public_id'];
            } else {
                Log::error('DEBUG: Unexpected Cloudinary structure based on array check.', ['response' => $uploadedFile]);
                throw new \Exception('DEBUG: Failed array check.');
            }
            // ------------------------------------------------------


            // 3. Simpan Public ID baru ke database (Sementara tidak dieksekusi karena dd())
            $this->info('Attempting to save public ID to database...'); // Log sebelum save
            $user->forceFill([
                'profile_photo_public_id' => $newPublicId,
            ])->save();
            $this->info('Public ID saved successfully.'); // Log setelah save


            // 4. Kembalikan response sukses (Sementara tidak dieksekusi karena dd())
            return response()->json([
                'message' => 'Foto profil berhasil diperbarui.',
                'user' => $user->fresh(),
            ]);

        } catch (Throwable $e) { // Gunakan Throwable untuk menangkap semua error
            Log::error("Failed to update profile photo for user {$user->id}: " . $e->getMessage(), [
                'exception' => $e // Sertakan detail exception di log
            ]);
            return response()->json(['message' => 'Gagal mengupload foto profil.'], 500);
        }
    }

    // Helper method untuk logging info jika diperlukan
    private function info($message)
    {
        Log::info("[UserProfileController] {$message}");
        // Anda juga bisa echo jika menjalankan dari CLI murni, tapi log lebih baik
        // echo $message . "\n";
    }
}