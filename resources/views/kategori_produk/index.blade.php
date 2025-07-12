@extends('layouts.app')

@section('content')
    <div class="container py-4 dashboard-breeze-bg">
        <div class="dashboard-breeze-card p-4">
            <h1 class="dashboard-title mb-4 text-dark">Kategori Produk</h1>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="mb-3 text-end">
                <a href="{{ route('kategori-produk.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Kategori</th>
                                    <th>Slug</th>
                                    <th>Deskripsi</th>

                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategoris as $kategori)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $kategori->nama_kategori }}</td>
                                        <td>{{ $kategori->slug }}</td>
                                        <td>{{ $kategori->deskripsi }}</td>

                                        <td>
                                            <a href="{{ route('kategori-produk.edit', $kategori) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('kategori-produk.destroy', $kategori) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada kategori.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @media (max-width: 576px) {
            .table {
                font-size: 0.85rem;
            }
        }
    </style>
@endpush