@extends('layouts.app')

@section('content')
    <div class="container py-4 dashboard-breeze-bg">
        <h1 class="dashboard-title mb-4">{{ $produk->exists ? 'Edit' : 'Tambah' }} Produk</h1>
        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data"
                    action="{{ $produk->exists ? route('produk.update', $produk) : route('produk.store') }}">
                    @csrf
                    @if($produk->exists)
                        @method('PUT')
                    @endif
                    <div class="mb-3">
                        <label for="kategori_produk_id" class="form-label">Kategori</label>
                        <select name="kategori_produk_id" id="kategori_produk_id"
                            class="form-select @error('kategori_produk_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ old('kategori_produk_id', $produk->kategori_produk_id) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_produk_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk"
                            class="form-control @error('nama_produk') is-invalid @enderror"
                            value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                        @error('nama_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                            value="{{ old('slug', $produk->slug) }}">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi"
                            class="form-control @error('deskripsi') is-invalid @enderror"
                            rows="3">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                        @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" name="harga" id="harga"
                                class="form-control @error('harga') is-invalid @enderror"
                                value="{{ old('harga', $produk->harga) }}" required>
                            @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" name="stok" id="stok"
                                class="form-control @error('stok') is-invalid @enderror"
                                value="{{ old('stok', $produk->stok) }}" required>
                            @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="status_ketersediaan" class="form-label">Status Ketersediaan</label>
                            <select name="status_ketersediaan" id="status_ketersediaan"
                                class="form-select @error('status_ketersediaan') is-invalid @enderror" required>
                                <option value="Tersedia"
                                    {{ old('status_ketersediaan', $produk->status_ketersediaan) == 'Tersedia' ? 'selected' : '' }}>
                                    Tersedia</option>
                                <option value="Habis"
                                    {{ old('status_ketersediaan', $produk->status_ketersediaan) == 'Habis' ? 'selected' : '' }}>
                                    Habis</option>
                            </select>
                            @error('status_ketersediaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="gambar_utama" class="form-label">Gambar Utama</label>
                        <input type="file" name="gambar_utama" id="gambar_utama"
                            class="form-control @error('gambar_utama') is-invalid @enderror" accept="image/*">
                        @error('gambar_utama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if($produk->gambar_utama_url)
                            <div class="mt-2">
                                <img src="{{ $produk->gambar_utama_url }}" alt="Gambar Produk"
                                    style="max-width: 180px; max-height: 180px; border-radius: 8px;">
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="merk" class="form-label">Merk</label>
                            <input type="text" name="merk" id="merk"
                                class="form-control @error('merk') is-invalid @enderror"
                                value="{{ old('merk', $produk->merk) }}">
                            @error('merk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="berat_volume" class="form-label">Berat/Volume</label>
                            <input type="text" name="berat_volume" id="berat_volume"
                                class="form-control @error('berat_volume') is-invalid @enderror"
                                value="{{ old('berat_volume', $produk->berat_volume) }}">
                            @error('berat_volume')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="expired" class="form-label">Expired</label>
                            <input type="date" name="expired" id="expired"
                                class="form-control @error('expired') is-invalid @enderror"
                                value="{{ old('expired', $produk->expired) }}">
                            @error('expired')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">{{ $produk->exists ? 'Update' : 'Simpan' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded',function() {
            const namaInput=document.getElementById('nama_produk');
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
@endsection