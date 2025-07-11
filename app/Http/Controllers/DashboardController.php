<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Pesanan
        $totalProduk = Produk::count();
        $produkTersedia = Produk::where('stok', '>', 0)->count();
        $produkHabis = Produk::where('stok', 0)->count();
        $produkExpired = Produk::whereNotNull('expired')->where('expired', '<', now())->count();

        $totalPesanan = Pesanan::count();
        $pesananBaru = Pesanan::where('status', 'Baru')->count();
        $pesananDiproses = Pesanan::where('status', 'Diproses')->count();
        $pesananDikirim = Pesanan::where('status', 'Dikirim')->count();
        $pesananSelesai = Pesanan::where('status', 'Selesai')->count();
        $pesananBatal = Pesanan::where('status', 'Batal')->count();
        $totalUser = User::count();

        // Total pemasukan dari pesanan selesai
        $totalPemasukan = Pesanan::where('status', 'Selesai')->sum('total_harga');

        // Grafik pemasukan per bulan (12 bulan terakhir, status selesai)
        $pemasukanBulanan = Pesanan::select(
            DB::raw('MONTH(tanggal_pesanan) as bulan'),
            DB::raw('YEAR(tanggal_pesanan) as tahun'),
            DB::raw('SUM(total_harga) as total')
        )
            ->where('status', 'Selesai')
            ->whereNotNull('tanggal_pesanan')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->limit(12)
            ->get()
            ->reverse()
            ->values();

        // Top 5 produk paling laris (status pesanan selesai)
        $topProduk = DB::table('item_pesanan')
            ->join('pesanan', 'item_pesanan.pesanan_id', '=', 'pesanan.id')
            ->join('produks', 'item_pesanan.produk_id', '=', 'produks.id')
            ->select('produks.nama_produk', DB::raw('SUM(item_pesanan.jumlah) as total_terjual'))
            ->where('pesanan.status', 'Selesai')
            ->groupBy('produks.nama_produk')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        // Pesanan terbaru (5 terakhir)
        $pesananTerbaru = Pesanan::orderBy('created_at', 'desc')->limit(5)->get();

        return view('dashboard', [
            'totalProduk' => $totalProduk,
            'produkTersedia' => $produkTersedia,
            'produkHabis' => $produkHabis,
            'produkExpired' => $produkExpired,
            'totalPesanan' => $totalPesanan,
            'pesananBaru' => $pesananBaru,
            'pesananDiproses' => $pesananDiproses,
            'pesananDikirim' => $pesananDikirim,
            'pesananSelesai' => $pesananSelesai,
            'pesananBatal' => $pesananBatal,
            'totalUser' => $totalUser,
            'totalPemasukan' => $totalPemasukan,
            'pemasukanBulanan' => $pemasukanBulanan->toArray(),
            'topProduk' => $topProduk->toArray(),
            'pesananTerbaru' => $pesananTerbaru,
        ]);
    }
}