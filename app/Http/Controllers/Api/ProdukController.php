<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProdukResource;
use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
// use App\Http\Resources\KategoriResource;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar Produk dengan filter dan pencarian.
     * GET /api/produks
     */
    public function index(Request $request)
    {
        $request->validate([
            'q' => 'nullable|string|max:100',
            'sort' => 'nullable|string|in:harga,created_at,nama_produk',
            'order' => 'nullable|string|in:asc,desc',
            'status_ketersediaan' => 'nullable|string|in:Tersedia,Habis',
            'kategori_slug' => 'nullable|string|exists:kategori_produks,slug',
        ]);

        $searchQuery = $request->query('q');
        $sortBy = $request->query('sort', 'created_at');
        $sortOrder = $request->query('order', 'desc');
        $statusKetersediaan = $request->query('status_ketersediaan');
        $kategoriSlug = $request->query('kategori_slug');

        $produkQuery = Produk::with('kategoriProduk');

        if ($statusKetersediaan) {
            $produkQuery->where('status_ketersediaan', $statusKetersediaan);
        }

        if ($kategoriSlug) {
            $produkQuery->whereHas('kategoriProduk', function (Builder $query) use ($kategoriSlug) {
                $query->where('slug', $kategoriSlug);
            });
        }

        if ($searchQuery) {
            $produkQuery->where(function (Builder $query) use ($searchQuery) {
                $query->where('nama_produk', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('deskripsi', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('ras', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('warna', 'LIKE', "%{$searchQuery}%");
            });
        }

        $allowedSorts = ['harga', 'created_at', 'nama_produk'];
        $sortField = in_array($sortBy, $allowedSorts) ? $sortBy : 'created_at';
        $sortDirection = strtolower($sortOrder) === 'asc' ? 'asc' : 'desc';

        $produkQuery->orderBy($sortField, $sortDirection);

        if ($sortField !== 'nama_produk') {
            $produkQuery->orderBy('nama_produk', 'asc');
        }

        $produks = $produkQuery->paginate(12)->withQueryString();

        return ProdukResource::collection($produks);
    }

    /**
     * Menampilkan detail satu Produk.
     * GET /api/produks/{produk}
     */
    public function show(Produk $produk)
    {
        $produk->loadMissing('kategoriProduk');

        return new ProdukResource($produk);
    }

    /**
     * Menampilkan daftar kategori Produk.
     * GET /api/produks/kategori
     */
    public function daftarKategori()
    {
        $kategori = KategoriProduk::orderBy('nama_kategori', 'asc')->get();

        return response()->json([
            'data' => $kategori->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_kategori' => $item->nama_kategori,
                    'slug' => $item->slug,
                    'deskripsi' => $item->deskripsi,
                ];
            })
        ]);
    }
}