<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('kategoriProduk')->orderBy('created_at', 'desc')->get();
        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        $kategoris = KategoriProduk::orderBy('nama_kategori')->get();
        return view('produk.form', ['produk' => new Produk(), 'kategoris' => $kategoris]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_produk_id' => 'required|exists:kategori_produks,id',
            'nama_produk' => 'required|string|max:150',
            'slug' => 'nullable|string|max:170|unique:produks,slug',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'status_ketersediaan' => 'required|string|max:50',
            'gambar_utama' => 'nullable|image|max:2048',
            'merk' => 'nullable|string|max:100',
            'berat_volume' => 'nullable|string|max:50',
            'expired' => 'nullable|date',
        ]);
        $data['slug'] = $data['slug'] ?? Str::slug($data['nama_produk']);
        if ($request->hasFile('gambar_utama')) {
            $file = $request->file('gambar_utama');
            $cloudinary = app(\Cloudinary\Cloudinary::class);
            $upload = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder' => 'produk',
                'resource_type' => 'image',
            ]);
            $data['gambar_utama'] = $upload['public_id'];
        }
        Produk::create($data);
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        $kategoris = KategoriProduk::orderBy('nama_kategori')->get();
        return view('produk.form', compact('produk', 'kategoris'));
    }

    public function update(Request $request, Produk $produk)
    {
        $data = $request->validate([
            'kategori_produk_id' => 'required|exists:kategori_produks,id',
            'nama_produk' => 'required|string|max:150',
            'slug' => 'nullable|string|max:170|unique:produks,slug,' . $produk->id,
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'status_ketersediaan' => 'required|string|max:50',
            'gambar_utama' => 'nullable|image|max:2048',
            'merk' => 'nullable|string|max:100',
            'berat_volume' => 'nullable|string|max:50',
            'expired' => 'nullable|date',
        ]);
        $data['slug'] = $data['slug'] ?? Str::slug($data['nama_produk']);
        if ($request->hasFile('gambar_utama')) {
            $file = $request->file('gambar_utama');
            $cloudinary = app(\Cloudinary\Cloudinary::class);
            $upload = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder' => 'produk',
                'resource_type' => 'image',
            ]);
            $data['gambar_utama'] = $upload['public_id'];
        } else {
            unset($data['gambar_utama']); // Jangan overwrite jika tidak upload baru
        }
        $produk->update($data);
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}