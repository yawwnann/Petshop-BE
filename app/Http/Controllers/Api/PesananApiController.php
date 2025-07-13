<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PesananResource;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananApiController extends Controller
{
    // List pesanan milik user login
    public function index(Request $request)
    {
        $user = Auth::user();
        $pesanan = Pesanan::with('items.produk')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);
        return PesananResource::collection($pesanan);
    }

    // Detail pesanan
    public function show(Pesanan $pesanan)
    {
        $pesanan->load('items.produk');
        return new PesananResource($pesanan);
    }

    // Buat pesanan baru
    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'nama_pelanggan' => 'required|string',
            'alamat_pengiriman' => 'required|string',
            'nomor_whatsapp' => 'required|string',
            'catatan' => 'nullable|string',
            'metode_pembayaran' => 'nullable|string|in:transfer,qris,cash',
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'nama_pelanggan' => $data['nama_pelanggan'],
            'alamat_pengiriman' => $data['alamat_pengiriman'],
            'nomor_whatsapp' => $data['nomor_whatsapp'],
            'catatan' => $data['catatan'] ?? null,
            'metode_pembayaran' => $data['metode_pembayaran'] ?? 'transfer',
            'status' => 'Baru',
            'total_harga' => 0,
            'tanggal_pesanan' => now(),
        ]);
        $total = 0;
        foreach ($data['items'] as $item) {
            $produk = \App\Models\Produk::findOrFail($item['produk_id']);
            $harga = $produk->harga;
            $pesanan->items()->create([
                'produk_id' => $produk->id,
                'jumlah' => $item['quantity'],
                'harga_saat_pesanan' => $harga,
            ]);
            $total += $harga * $item['quantity'];
        }
        $pesanan->update(['total_harga' => $total]);
        $pesanan->load('items.produk');
        return new PesananResource($pesanan);
    }

    // Update status pesanan (hanya admin/user terkait)
    public function update(Request $request, Pesanan $pesanan)
    {
        $data = $request->validate([
            'status' => 'required|string|in:Baru,Diproses,Dikirim,Selesai,Batal',
        ]);
        $pesanan->update(['status' => $data['status']]);
        return new PesananResource($pesanan->fresh('items.produk'));
    }

    // Hapus pesanan (hanya admin/user terkait)
    public function destroy(Pesanan $pesanan)
    {
        $pesanan->delete();
        return response()->json(['message' => 'Pesanan dihapus']);
    }
}
