<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Konsultasi;

class KonsultasiController extends Controller
{
    // GET /api/konsultasi - riwayat konsultasi user
    public function index(Request $request)
    {
        $user = $request->user();
        $konsultasi = Konsultasi::with('dokter')
            ->where('user_id', $user->id)
            ->orderByDesc('tanggal')
            ->get();
        return response()->json($konsultasi);
    }

    // POST /api/konsultasi - ajukan konsultasi
    public function store(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'catatan' => 'nullable|string',
        ]);
        $konsultasi = Konsultasi::create([
            'user_id' => $user->id,
            'dokter_id' => $validated['dokter_id'],
            'tanggal' => $validated['tanggal'],
            'waktu' => $validated['waktu'],
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'pending',
        ]);
        return response()->json($konsultasi, 201);
    }
}
