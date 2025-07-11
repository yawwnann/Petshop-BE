@extends('layouts.app')

@section('content')
    <div class="container py-4 px-5 dashboard-breeze-bg">
        <h1 class="dashboard-title mb-4">Edit Pesanan #{{ $pesanan->id }}</h1>
        <div class="card dashboard-breeze-card">
            <div class="card-body">
                <form action="{{ route('pesanan.update', $pesanan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" class="form-control"
                            value="{{ old('nama_pelanggan', $pesanan->nama_pelanggan) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor WhatsApp</label>
                        <input type="text" name="nomor_whatsapp" class="form-control"
                            value="{{ old('nomor_whatsapp', $pesanan->nomor_whatsapp) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Pengiriman</label>
                        <textarea name="alamat_pengiriman" class="form-control"
                            required>{{ old('alamat_pengiriman', $pesanan->alamat_pengiriman) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            @foreach(['pending', 'Baru', 'Diproses', 'Dikirim', 'Selesai', 'Batal'] as $status)
                                <option value="{{ $status }}" @if(old('status', $pesanan->status) == $status) selected @endif>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Harga</label>
                        <input type="number" name="total_harga" class="form-control"
                            value="{{ old('total_harga', $pesanan->total_harga) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <input type="text" name="metode_pembayaran" class="form-control"
                            value="{{ old('metode_pembayaran', $pesanan->metode_pembayaran) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control">{{ old('catatan', $pesanan->catatan) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Admin</label>
                        <textarea name="catatan_admin"
                            class="form-control">{{ old('catatan_admin', $pesanan->catatan_admin) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection