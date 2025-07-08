<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KeranjangItem;
use App\Models\Produk;
use App\Http\Resources\ProdukResource;

class KeranjangController extends Controller
{
    // List keranjang user login
    public function index(Request $request)
    {
        $user = Auth::user();
        $items = KeranjangItem::with('produk')
            ->where('user_id', $user->id)
            ->get();
        // Ubah produk menjadi ProdukResource agar gambar_utama_url selalu ada
        $items = $items->map(function ($item) {
            $item->produk = $item->produk ? new ProdukResource($item->produk) : null;
            return $item;
        });
        return response()->json($items);
    }

    // Update item keranjang (tambah/ubah jumlah)
    public function update(Request $request, $id = null)
    {
        $user = Auth::user();
        // Jika ada $id, update quantity item keranjang tertentu
        if ($id) {
            $data = $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);
            $item = KeranjangItem::where('user_id', $user->id)->where('id', $id)->firstOrFail();
            $item->quantity = $data['quantity'];
            $item->save();
            $item->load('produk');
            return response()->json($item);
        }
        // Jika tidak ada $id, updateOrCreate (tambah/ubah berdasarkan produk_id)
        $data = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);
        $item = KeranjangItem::updateOrCreate(
            [
                'user_id' => $user->id,
                'produk_id' => $data['produk_id'],
            ],
            [
                'jumlah' => $data['jumlah'],
            ]
        );
        $item->load('produk');
        return response()->json($item);
    }

    // Hapus item keranjang
    public function destroy($id)
    {
        $user = Auth::user();
        $item = KeranjangItem::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        $item->delete();
        return response()->json(['message' => 'Item keranjang dihapus']);
    }
}