@extends('layouts.app')

@section('content')
    <div class="container py-4 dashboard-breeze-bg">
        <h1 class="dashboard-title mb-4">Produk</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="mb-3 text-end">
            <a href="{{ route('produk.create') }}" class="btn btn-primary">+ Tambah Produk</a>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kategori</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Slug</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Merk</th>
                            <th>Berat/Volume</th>
                            <th>Expired</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produks as $produk)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $produk->kategoriProduk->nama_kategori ?? '-' }}</td>
                                <td>
                                    @if($produk->gambar_utama_url)
                                        <img src="{{ $produk->gambar_utama_url }}" alt="Gambar"
                                            style="max-width: 60px; max-height: 60px; border-radius: 6px;">
                                    @endif
                                </td>
                                <td>{{ $produk->nama_produk }}</td>
                                <td>{{ $produk->slug }}</td>
                                <td>Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                                <td>{{ $produk->stok }}</td>
                                <td>{{ $produk->status_ketersediaan }}</td>
                                <td>{{ $produk->merk }}</td>
                                <td>{{ $produk->berat_volume }}</td>
                                <td>{{ $produk->expired }}</td>
                                <td>
                                    <a href="{{ route('produk.edit', $produk) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('produk.destroy', $produk) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">Belum ada produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection