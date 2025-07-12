@extends('layouts.app')

@section('content')
    <div class="container py-4 dashboard-breeze-bg">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="dashboard-title text-dark dark:text-light">Tambah Konsultasi</h1>
            <a href="{{ route('konsultasi.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card dashboard-breeze-card p-4">
            <form action="{{ route('konsultasi.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="user_id" class="form-label text-dark dark:text-light">User</label>
                        <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror"
                            required>
                            <option value="">Pilih User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="dokter_id" class="form-label text-dark dark:text-light">Dokter</label>
                        <select name="dokter_id" id="dokter_id" class="form-select @error('dokter_id') is-invalid @enderror"
                            required>
                            <option value="">Pilih Dokter</option>
                            @foreach($dokters as $dokter)
                                <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                    {{ $dokter->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('dokter_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal" class="form-label text-dark dark:text-light">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal"
                            class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}"
                            required>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="waktu" class="form-label text-dark dark:text-light">Waktu</label>
                        <input type="time" name="waktu" id="waktu" class="form-control @error('waktu') is-invalid @enderror"
                            value="{{ old('waktu') }}" required>
                        @error('waktu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label text-dark dark:text-light">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="">Pilih Status</option>
                        <option value="Menunggu" {{ old('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Diterima" {{ old('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value=" Ditolak" {{ old('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label text-dark dark:text-light">Catatan</label>
                    <textarea name="catatan" id="catatan" rows="4"
                        class="form-control @error('catatan') is-invalid @enderror"
                        placeholder="Masukkan catatan/keluhan pasien..." required>{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="hasil_konsultasi" class="form-label text-dark dark:text-light">Hasil Konsultasi</label>
                    <textarea name="hasil_konsultasi" id="hasil_konsultasi" rows="4"
                        class="form-control @error('hasil_konsultasi') is-invalid @enderror"
                        placeholder="Masukkan hasil konsultasi...">{{ old('hasil_konsultasi') }}</textarea>
                    @error('hasil_konsultasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>



                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('konsultasi.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection