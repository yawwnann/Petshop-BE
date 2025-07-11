@extends('layouts.app')

@section('content')
    <div class="container py-4 dashboard-breeze-bg">
        <h1 class="dashboard-title mb-4 text-dark dark:text-light">Tambah Dokter</h1>
        <div class="card dashboard-breeze-card p-4">
            <form method="POST" action="{{ route('dokter.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-dark dark:text-light">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                            class="form-control @error('nama') is-invalid @enderror" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark dark:text-light">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark dark:text-light">Spesialisasi</label>
                        <input type="text" name="spesialisasi" value="{{ old('spesialisasi') }}"
                            class="form-control @error('spesialisasi') is-invalid @enderror" required>
                        @error('spesialisasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark dark:text-light">No. STR</label>
                        <input type="text" name="no_str" value="{{ old('no_str') }}"
                            class="form-control @error('no_str') is-invalid @enderror" required>
                        @error('no_str')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark dark:text-light">Telepon</label>
                        <input type="text" name="telepon" value="{{ old('telepon') }}"
                            class="form-control @error('telepon') is-invalid @enderror" required>
                        @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label text-dark dark:text-light">Alamat</label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                            required>{{ old('alamat') }}</textarea>
                        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Simpan</button>
                    <a href="{{ route('dokter.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection