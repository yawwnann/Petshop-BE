<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'tanggal_pesanan');
        $order = $request->query('order', 'desc');
        $allowedSorts = ['id', 'tanggal_pesanan', 'status', 'total_harga'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'tanggal_pesanan';
        }
        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'desc';
        }
        $pesanans = \App\Models\Pesanan::orderBy($sort, $order)->get();
        return view('pesanan.index', compact('pesanans', 'sort', 'order'));
    }

    public function edit(Pesanan $pesanan)
    {
        return view('pesanan.form', compact('pesanan'));
    }

    public function update(Request $request, Pesanan $pesanan)
    {
        $data = $request->validate([
            'nama_pelanggan' => 'required|string',
            'nomor_whatsapp' => 'required|string',
            'alamat_pengiriman' => 'required|string',
            'status' => 'required|string',
            'total_harga' => 'required|numeric',
            'metode_pembayaran' => 'nullable|string',
            'catatan' => 'nullable|string',
            'catatan_admin' => 'nullable|string',
        ]);
        $pesanan->update($data);
        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil diupdate.');
    }

    public function destroy(Pesanan $pesanan)
    {
        $pesanan->delete();
        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dihapus.');
    }

    public function show(Pesanan $pesanan)
    {
        $pesanan->load('items.produk');
        return view('pesanan.show', compact('pesanan'));
    }
}