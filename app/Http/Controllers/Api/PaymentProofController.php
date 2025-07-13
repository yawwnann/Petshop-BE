<?php
// File: app/Http/Controllers/Api/PaymentProofController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan; // Pastikan path model Pesanan Anda benar
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Cloudinary\Cloudinary; // Menggunakan class inti Cloudinary SDK

class PaymentProofController extends Controller
{
    /**
     * Menerima unggahan bukti pembayaran, mengirim ke Cloudinary,
     * menyimpan URL, mengirim notifikasi Telegram, dan mengembalikan respons.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pesanan  $pesanan (Route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitProof(Request $request, Pesanan $pesanan)
    {
        // 1. Validasi Input File Gambar
        try {
            $request->validate([
                'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
                'payment_method' => 'nullable|string|in:transfer,qris,cash',
            ]);
        } catch (ValidationException $e) {
            Log::warning("Validasi gagal untuk submitProof pesanan #" . ($pesanan->id ?? 'UNKNOWN') . ": ", $e->errors());
            return response()->json(['message' => 'Validasi gagal.', 'errors' => $e->errors()], 422);
        }

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $originalFileName = $file->getClientOriginalName();
            $uploadedFileUrl = null;

            // 2. Unggah Gambar ke Cloudinary
            try {
                Log::info("Mencoba unggah bukti pembayaran ke Cloudinary untuk pesanan #" . ($pesanan->id ?? 'UNKNOWN') . "...");

                $cloudinary = new Cloudinary(); // Menggunakan konfigurasi global dari .env
                $uploadResult = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                    'folder' => 'payment_proofs_pesanan',
                    'public_id' => 'pesanan_' . ($pesanan->id ?? 'temp') . '_' . time() . '_' . pathinfo($originalFileName, PATHINFO_FILENAME),
                    'resource_type' => 'image'
                ]);
                $uploadedFileUrl = $uploadResult['secure_url'];
                Log::info("Berhasil unggah ke Cloudinary untuk pesanan #" . ($pesanan->id ?? 'UNKNOWN') . ". URL: {$uploadedFileUrl}");

            } catch (\Exception $e) {
                Log::error("Gagal unggah bukti pembayaran ke Cloudinary untuk pesanan #" . ($pesanan->id ?? 'UNKNOWN') . ": " . $e->getMessage(), [
                    'exception_class' => get_class($e),
                ]);
                return response()->json(['message' => 'Gagal menyimpan bukti pembayaran di layanan Cloudinary. Silakan coba lagi.'], 500);
            }

            if (!$uploadedFileUrl) {
                Log::error("URL Cloudinary tidak didapatkan setelah proses unggah untuk pesanan #" . ($pesanan->id ?? 'UNKNOWN') . ".");
                return response()->json(['message' => 'Gagal mendapatkan URL Cloudinary setelah unggah bukti pembayaran.'], 500);
            }

            // 3. Simpan URL Cloudinary ke Database dan Update Status Pesanan
            // Disarankan menggunakan transaksi database jika ada beberapa operasi save
            // DB::beginTransaction();
            try {
                $pesanan->payment_proof_path = $uploadedFileUrl;
                $pesanan->status = 'menunggu_konfirmasi_pembayaran'; // Sesuaikan status ini
                // Update metode pembayaran jika disediakan
                if ($request->has('payment_method')) {
                    $pesanan->metode_pembayaran = $request->payment_method;
                }
                $pesanan->save();

                Log::info("URL Cloudinary untuk bukti bayar pesanan #" . ($pesanan->id ?? 'UNKNOWN') . " berhasil disimpan ke database.");

                // DB::commit(); // Jika menggunakan transaksi

                // 4. Kirim Notifikasi ke Admin Telegram
                $this->sendTelegramNotification($pesanan, $uploadedFileUrl);

                return response()->json([
                    'message' => 'Bukti pembayaran berhasil diunggah dan informasi pesanan diperbarui.',
                    'payment_proof_url' => $uploadedFileUrl
                ], 200);

            } catch (\Exception $e) {
                // DB::rollBack(); // Jika menggunakan transaksi
                Log::error("Gagal menyimpan URL Cloudinary atau update status untuk pesanan #" . ($pesanan->id ?? 'UNKNOWN') . ": " . $e->getMessage(), [
                    'sql_error_code' => method_exists($e, 'getCode') ? $e->getCode() : 'N/A',
                ]);
                // Pertimbangkan untuk menghapus gambar dari Cloudinary jika penyimpanan ke DB gagal
                if (isset($uploadResult) && isset($uploadResult['public_id'])) {
                    try {
                        (new Cloudinary())->uploadApi()->destroy($uploadResult['public_id']);
                        Log::info("Gambar di Cloudinary (public_id: {$uploadResult['public_id']}) dihapus karena gagal simpan ke DB untuk pesanan #" . ($pesanan->id ?? 'UNKNOWN'));
                    } catch (\Exception $cloudinaryDeleteException) {
                        Log::error("Gagal menghapus gambar dari Cloudinary setelah kegagalan DB: " . $cloudinaryDeleteException->getMessage());
                    }
                }
                return response()->json(['message' => 'Gagal memperbarui informasi pesanan setelah unggah bukti pembayaran.'], 500);
            }
        }

        return response()->json(['message' => 'File bukti pembayaran tidak ditemukan dalam permintaan.'], 400);
    }

    /**
     * Mengirim notifikasi ke Telegram.
     *
     * @param Pesanan $pesanan
     * @param string $paymentProofUrl
     * @return void
     */
    protected function sendTelegramNotification(Pesanan $pesanan, string $paymentProofUrl): void
    {
        $botToken = config('services.telegram.bot_token');
        $adminChatId = config('services.telegram.admin_chat_id');

        if (!$botToken || !$adminChatId) {
            Log::warning("Konfigurasi Telegram (token/chat_id) tidak lengkap, notifikasi dilewati untuk pesanan #" . ($pesanan->id ?? 'UNKNOWN') . ".");
            return;
        }

        $customerName = $pesanan->nama_pelanggan ?: ($pesanan->user->name ?? 'Pelanggan');
        $orderId = $pesanan->id ?? 'N/A';
        $totalAmount = $pesanan->total_harga ?? 0;
        $paymentMethod = $pesanan->metode_pembayaran ?? 'transfer';

        // Handle different payment methods for display
        switch ($paymentMethod) {
            case 'qris':
                $paymentMethodText = 'QRIS';
                break;
            case 'cash':
                $paymentMethodText = 'Cash';
                break;
            default:
                $paymentMethodText = 'Transfer Bank';
                break;
        }

        // Opsi 1: Mengirim pesan teks dengan link ke gambar
        $captionTelegram = "🔔 **Bukti Pembayaran Baru Diterima!** 🔔\n\n";
        $captionTelegram .= "🆔 **ID Pesanan:** `{$orderId}`\n";
        $captionTelegram .= "👤 **Pelanggan:** " . e($customerName) . "\n";
        $captionTelegram .= "💰 **Total:** Rp " . number_format($totalAmount, 0, ',', '.') . "\n";
        $captionTelegram .= "💳 **Metode:** {$paymentMethodText}\n";
        $captionTelegram .= "🖼️ **Lihat Bukti:** [Klik Di Sini]({$paymentProofUrl})\n\n";
        $captionTelegram .= "Mohon segera periksa.";

        try {
            $response = Http::timeout(15)->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $adminChatId,
                'text' => $captionTelegram,
                'parse_mode' => 'Markdown', // Hati-hati dengan karakter khusus jika menggunakan Markdown
                'disable_web_page_preview' => false, // Agar link menampilkan preview jika mungkin
            ]);

            if ($response->successful() && $response->json()['ok']) {
                Log::info("Notifikasi Telegram (pesan teks) berhasil dikirim untuk pesanan #{$orderId}.");
            } else {
                Log::error("Gagal mengirim notifikasi Telegram (pesan teks) untuk pesanan #{$orderId}. Respons: " . $response->body());
            }

        } catch (\Exception $e) {
            Log::error("Exception saat mengirim notifikasi Telegram (pesan teks) untuk pesanan #{$orderId}: " . $e->getMessage());
        }

        // Opsi 2: Mengirim foto langsung (Telegram akan men-download dari URL Cloudinary)
        // Anda bisa memilih salah satu opsi, atau bahkan keduanya jika mau.
        // Jika menggunakan sendPhoto, caption mungkin perlu disesuaikan agar tidak terlalu panjang.
        /*
        $photoCaption = "Pesanan #{$orderId} oleh " . e($customerName) . ". Total: Rp " . number_format($totalAmount, 0, ',', '.');
        try {
            $response = Http::timeout(30)->post("https://api.telegram.org/bot{$botToken}/sendPhoto", [
                'chat_id' => $adminChatId,
                'photo'   => $paymentProofUrl,
                'caption' => $photoCaption,
                'parse_mode' => 'Markdown', // Atau HTML
            ]);

            if ($response->successful() && $response->json()['ok']) {
                Log::info("Notifikasi Telegram (foto) berhasil dikirim untuk pesanan #{$orderId}.");
            } else {
                Log::error("Gagal mengirim notifikasi Telegram (foto) untuk pesanan #{$orderId}. Respons: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("Exception saat mengirim notifikasi Telegram (foto) untuk pesanan #{$orderId}: " . $e->getMessage());
        }
        */
    }
}
