<?php
// app/Http/Controllers/PdfController.php
namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Import facade PDF

class PdfController extends Controller
{
    public function downloadPesananPdf(Pesanan $pesanan) // Gunakan Route Model Binding
    {
        // Load relasi items agar bisa diakses di view
        $pesanan->loadMissing('items');

        // Nama file PDF yang akan didownload
        $namaFile = 'pesanan-' . $pesanan->id . '-' . $pesanan->nama_pelanggan . '.pdf';

        // Generate PDF dari view 'pdf.pesanan' dengan data $pesanan
        $pdf = Pdf::loadView('pdf.pesanan', compact('pesanan'));

        // Tampilkan di browser (stream) atau langsung download (download)
        // return $pdf->stream($namaFile);
        return $pdf->download($namaFile);
    }
}