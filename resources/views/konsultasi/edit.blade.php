@extends('layouts.app')

@section('content')
    <div class="container py-4 dashboard-breeze-bg">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="dashboard-title text-dark dark:text-light">Edit Konsultasi</h1>
            <a href="{{ route('konsultasi.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card dashboard-breeze-card p-4">
            <form action="{{ route('konsultasi.update', $konsultasi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="user_id" class="form-label text-dark dark:text-light">User</label>
                        <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror"
                            required>
                            <option value="">Pilih User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $konsultasi->user_id) == $user->id ? 'selected' : '' }}>
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
                                <option value="{{ $dokter->id }}"
                                    {{ old('dokter_id', $konsultasi->dokter_id) == $dokter->id ? 'selected' : '' }}>
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
                            class="form-control @error('tanggal') is-invalid @enderror"
                            value="{{ old('tanggal', $konsultasi->tanggal) }}" required>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="waktu" class="form-label text-dark dark:text-light">Waktu</label>
                        <input type="time" name="waktu" id="waktu" class="form-control @error('waktu') is-invalid @enderror"
                            value="{{ old('waktu', $konsultasi->waktu) }}" required>
                        @error('waktu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label text-dark dark:text-light">Catatan</label>
                    <textarea name="catatan" id="catatan" rows="4"
                        class="form-control @error('catatan') is-invalid @enderror"
                        placeholder="Masukkan catatan/keluhan pasien..."
                        required>{{ old('catatan', $konsultasi->catatan) }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label text-dark dark:text-light">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="">Pilih Status</option>
                        <option value="pending" {{ old('status', $konsultasi->status) == 'pending' ? 'selected' : '' }}>
                            Pending</option>
                        <option value="diterima" {{ old('status', $konsultasi->status) == 'diterima' ? 'selected' : '' }}>
                            Diterima</option>
                        <option value="ditolak" {{ old('status', $konsultasi->status) == 'ditolak' ? 'selected' : '' }}>
                            Ditolak</option>
                        <option value="selesai" {{ old('status', $konsultasi->status) == 'selesai' ? 'selected' : '' }}>
                            Selesai</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="hasil_konsultasi" class="form-label text-dark dark:text-light">Hasil Konsultasi</label>
                    <textarea name="hasil_konsultasi" id="hasil_konsultasi" rows="4"
                        class="form-control @error('hasil_konsultasi') is-invalid @enderror"
                        placeholder="Masukkan hasil konsultasi...">{{ old('hasil_konsultasi', $konsultasi->hasil_konsultasi) }}</textarea>
                    @error('hasil_konsultasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('konsultasi.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Wajibkan hasil_konsultasi jika status selesai
        document.addEventListener('DOMContentLoaded',function() {
            const statusSelect=document.getElementById('status');
            const hasilTextarea=document.getElementById('hasil_konsultasi');
            function checkStatus() {
                if(statusSelect.value==='selesai') {
                    hasilTextarea.setAttribute('required','required');
                } else {
                    hasilTextarea.removeAttribute('required');
                }
            }
            statusSelect.addEventListener('change',checkStatus);
            checkStatus(); // initial
        });
    </script>
@endsection