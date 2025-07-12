@extends('layouts.app')

@section('content')
    <div class="container py-4 dashboard-breeze-bg">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="dashboard-title text-dark dark:text-light mb-1">Detail Konsultasi</h1>
                <p class="text-muted mb-0">ID: {{ $konsultasi->id }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('konsultasi.edit', $konsultasi->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i> Edit
                </a>
                <a href="{{ route('konsultasi.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row g-4">
            <!-- Informasi Konsultasi -->
            <div class="col-lg-8">
                <div class="card dashboard-breeze-card h-100">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h5 class="card-title text-dark dark:text-light mb-0">
                            <i class="bi bi-clipboard-data me-2"></i>Informasi Konsultasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="form-label text-muted fw-semibold">Tanggal Konsultasi</label>
                                    <div class="info-value text-dark dark:text-light">
                                        <i class="bi bi-calendar3 me-2 text-primary"></i>
                                        {{ \Carbon\Carbon::parse($konsultasi->tanggal)->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="form-label text-muted fw-semibold">Waktu</label>
                                    <div class="info-value text-dark dark:text-light">
                                        <i class="bi bi-clock me-2 text-primary"></i>
                                        {{ $konsultasi->waktu }} WIB
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="form-label text-muted fw-semibold">Status</label>
                                    <div class="info-value">
                                        <span
                                            class="badge fs-6 px-3 py-2 bg-{{ $konsultasi->status == 'Selesai' ? 'success' : ($konsultasi->status == 'Diterima' ? 'primary' : ($konsultasi->status == 'Ditolak' ? 'danger' : 'warning')) }}">
                                            <i
                                                class="bi bi-{{ $konsultasi->status == 'Selesai' ? 'check-circle' : ($konsultasi->status == 'Diterima' ? 'check' : ($konsultasi->status == 'Ditolak' ? 'x-circle' : 'clock')) }} me-1"></i>
                                            {{ $konsultasi->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="form-label text-muted fw-semibold">Terakhir Diperbarui</label>
                                    <div class="info-value text-dark dark:text-light">
                                        <i class="bi bi-arrow-clockwise me-2 text-primary"></i>
                                        {{ $konsultasi->updated_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Pasien & Dokter -->
            <div class="col-lg-4">
                <div class="card dashboard-breeze-card h-100">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h5 class="card-title text-dark dark:text-light mb-0">
                            <i class="bi bi-people me-2"></i>Informasi Pasien & Dokter
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Pasien -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="bi bi-person me-2"></i>Pasien
                            </h6>
                            <div class="info-item mb-2">
                                <label class="form-label text-muted fw-semibold small">Nama</label>
                                <div class="info-value text-dark dark:text-light">
                                    {{ $konsultasi->user->name ?? '-' }}
                                </div>
                            </div>
                            <div class="info-item">
                                <label class="form-label text-muted fw-semibold small">Email</label>
                                <div class="info-value text-dark dark:text-light">
                                    {{ $konsultasi->user->email ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <!-- Dokter -->
                        <div>
                            <h6 class="text-success mb-3">
                                <i class="bi bi-person-badge me-2"></i>Dokter
                            </h6>
                            <div class="info-item mb-2">
                                <label class="form-label text-muted fw-semibold small">Nama</label>
                                <div class="info-value text-dark dark:text-light">
                                    {{ $konsultasi->dokter->nama ?? '-' }}
                                </div>
                            </div>
                            <div class="info-item mb-2">
                                <label class="form-label text-muted fw-semibold small">Spesialisasi</label>
                                <div class="info-value text-dark dark:text-light">
                                    <span class="badge bg-info text-dark">
                                        {{ $konsultasi->dokter->spesialisasi ?? '-' }}
                                    </span>
                                </div>
                            </div>
                            <div class="info-item">
                                <label class="form-label text-muted fw-semibold small">No. Telepon</label>
                                <div class="info-value text-dark dark:text-light">
                                    <i class="bi bi-telephone me-2"></i>
                                    {{ $konsultasi->dokter->no_telepon ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keluhan Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card dashboard-breeze-card">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h5 class="card-title text-dark dark:text-light mb-0">
                            <i class="bi bi-chat-square-text me-2"></i>Keluhan Pasien
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="bg-light dark:bg-dark rounded-3 p-4 border-start border-primary border-4">
                            <p class="text-dark dark:text-light mb-0 lh-lg">
                                {{ $konsultasi->keluhan }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card dashboard-breeze-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                <small>
                                    <i class="bi bi-info-circle me-1"></i>
                                    Dibuat pada: {{ $konsultasi->created_at->format('d M Y, H:i') }}
                                </small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('konsultasi.edit', $konsultasi->id) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil me-1"></i> Edit Konsultasi
                                </a>
                                <form action="{{ route('konsultasi.destroy', $konsultasi->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus konsultasi ini?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .info-item {
            margin-bottom: 1rem;
        }

        .info-item .form-label {
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 500;
            padding: 0.5rem 0;
        }

        .card-header {
            padding: 1.25rem 1.25rem 0.75rem;
        }

        .badge.fs-6 {
            font-size: 0.875rem !important;
        }

        .border-start {
            border-left-width: 4px !important;
        }

        .lh-lg {
            line-height: 1.75;
        }
    </style>
@endsection