<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriProdukController extends Controller
{
    public function index()
    {
        $kategoris = KategoriProduk::orderBy('nama_kategori')->get();
        return view('kategori_produk.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori_produk.form', ['kategori' => new KategoriProduk()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:120|unique:kategori_produks,nama_kategori',
            'slug' => 'nullable|string|max:120|unique:kategori_produks,slug',
            'deskripsi' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
        ]);
        $data['slug'] = $data['slug'] ?? Str::slug($data['nama_kategori']);
        KategoriProduk::create($data);
        return redirect()->route('kategori-produk.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(KategoriProduk $kategori_produk)
    {
        return view('kategori_produk.form', ['kategori' => $kategori_produk]);
    }

    public function update(Request $request, KategoriProduk $kategori_produk)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:120|unique:kategori_produks,nama_kategori,' . $kategori_produk->id,
            'slug' => 'nullable|string|max:120|unique:kategori_produks,slug,' . $kategori_produk->id,
            'deskripsi' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
        ]);
        $data['slug'] = $data['slug'] ?? Str::slug($data['nama_kategori']);
        $kategori_produk->update($data);
        return redirect()->route('kategori-produk.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy(KategoriProduk $kategori_produk)
    {
        $kategori_produk->delete();
        return redirect()->route('kategori-produk.index')->with('success', 'Kategori berhasil dihapus.');
    }
}