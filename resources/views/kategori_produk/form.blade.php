@extends('layouts.app')

@section('content')
    <div class="container py-4 dashboard-breeze-bg">
        <h1 class="dashboard-title mb-4">{{ $kategori->exists ? 'Edit' : 'Tambah' }} Kategori Produk</h1>
        <div class="card">
            <div class="card-body">
                <form method="POST"
                    action="{{ $kategori->exists ? route('kategori-produk.update', $kategori) : route('kategori-produk.store') }}">
                    @csrf
                    @if($kategori->exists)
                        @method('PUT')
                    @endif
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori"
                            class="form-control @error('nama_kategori') is-invalid @enderror"
                            value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                        @error('nama_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                            value="{{ old('slug', $kategori->slug) }}">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi"
                            class="form-control @error('deskripsi') is-invalid @enderror"
                            rows="3">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                        @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded',function() {
                            const namaInput=document.getElementById('nama_kategori');
                            const slugInput=document.getElementById('slug');
                            if(namaInput&&slugInput) {
                                namaInput.addEventListener('blur',function() {
                                    if(!slugInput.value) {
                                        let slug=namaInput.value.toLowerCase()
                                            .replace(/[^a-z0-9\s-]/g,'')
                                            .replace(/\s+/g,'-')
                                            .replace(/-+/g,'-');
                                        slugInput.value=slug;
                                    }
                                });
                            }
                        });
                    </script>
                    <div class="text-end">
                        <a href="{{ route('kategori-produk.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">{{ $kategori->exists ? 'Update' : 'Simpan' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection