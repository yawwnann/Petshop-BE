@extends('layouts.app')

@section('content')
    <div class="container py-5 px-4 dashboard-breeze-bg">
        <h1 class="dashboard-title mb-5">Detail Pesanan #{{ $pesanan->id }}</h1>
        <div class="card dashboard-breeze-card mb-5">
            <div class="card-body p-4">
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <strong class="info-label">Nama Pelanggan:</strong>
                            <span class="text-dark">{{ $pesanan->nama_pelanggan }}</span>
                        </div>
                        <div class="info-item mb-3">
                            <strong class="info-label">Nomor WhatsApp:</strong>
                            <span class="text-dark">{{ $pesanan->nomor_whatsapp }}</span>
                        </div>
                        <div class="info-item mb-3">
                            <strong class="info-label">Tanggal Pesanan:</strong>
                            <span
                                class="text-dark">{{ $pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->format('d M Y') : '-' }}</span>
                        </div>
                        <div class="info-item mb-3">
                            <strong class="info-label">Status:</strong>
                            <span class="badge bg-primary">{{ $pesanan->status }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <strong class="info-label">Alamat Pengiriman:</strong>
                            <span class="text-dark">{{ $pesanan->alamat_pengiriman }}</span>
                        </div>
                        <div class="info-item mb-3">
                            <strong class="info-label">Metode Pembayaran:</strong>
                            <span class="text-dark">{{ $pesanan->metode_pembayaran ?? '-' }}</span>
                        </div>
                        <div class="info-item mb-3">
                            <strong class="info-label">Total Harga:</strong>
                            <span
                                class="fw-bold text-success">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <strong class="info-label">Catatan:</strong>
                            <span class="text-dark">{{ $pesanan->catatan ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <strong class="info-label">Catatan Admin:</strong>
                            <span class="text-dark">{{ $pesanan->catatan_admin ?? '-' }}</span>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-12">
                        <strong class="info-label">Bukti Transfer:</strong>
                        @if($pesanan->payment_proof_path)
                            <div class="d-flex justify-content-center align-items-center mt-3">
                                <a href="{{ $pesanan->payment_proof_path }}" target="_blank" class="bukti-transfer-link">
                                    <img src="{{ $pesanan->payment_proof_path }}" alt="Bukti Transfer"
                                        class="bukti-transfer-img">
                                </a>
                            </div>
                        @else
                            <span class="text-muted">Belum ada</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card dashboard-breeze-card">
            <div class="card-body p-4">
                <h5 class="mb-4">Item Pesanan</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Produk</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Harga Satuan</th>
                                <th scope="col">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan->items as $item)
                                <tr>
                                    <td>{{ $item->produk->nama_produk ?? '-' }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>Rp{{ number_format($item->harga_saat_pesanan, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($item->jumlah * $item->harga_saat_pesanan, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('pesanan.index') }}" class="btn btn-secondary mt-4">Kembali</a>
            </div>
        </div>
    </div>
@endsection