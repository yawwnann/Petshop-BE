@extends('layouts.app')

@section('content')
    <div class="container py-4 dashboard-breeze-bg">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="dashboard-title text-dark dark:text-light">Detail Konsultasi</h1>
            <div class="d-flex gap-2">
                <a href="{{ route('konsultasi.edit', $konsultasi->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('konsultasi.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card dashboard-breeze-card p-4">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-dark dark:text-light mb-3">Informasi Konsultasi</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted" style="width: 150px;">ID Konsultasi</td>
                            <td class="text-dark dark:text-light">: {{ $konsultasi->id }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tanggal</td>
                            <td class="text-dark dark:text-light">: {{ $konsultasi->tanggal }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Waktu</td>
                            <td class="text-dark dark:text-light">: {{ $konsultasi->waktu }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td>
                                <span
                                    class="badge bg-{{ $konsultasi->status == 'Selesai' ? 'success' : ($konsultasi->status == 'Diterima' ? 'primary' : ($konsultasi->status == 'Ditolak' ? 'danger' : 'warning')) }}">
                                    {{ $konsultasi->status }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Dibuat</td>
                            <td class="text-dark dark:text-light">: {{ $konsultasi->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Diperbarui</td>
                            <td class="text-dark dark:text-light">: {{ $konsultasi->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <h5 class="text-dark dark:text-light mb-3">Informasi Pasien & Dokter</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted" style="width: 150px;">Nama Pasien</td>
                            <td class="text-dark dark:text-light">: {{ $konsultasi->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email Pasien</td>
                            <td class="text-dark dark:text-light">: {{ $konsultasi->user->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Nama Dokter</td>
                            <td class="text-dark dark:text-light">: {{ $konsultasi->dokter->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Spesialisasi</td>
                            <td class="text-dark dark:text-light">: {{ $konsultasi->dokter->spesialisasi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">No. Telepon</td>
                            <td class="text-dark dark:text-light">: {{ $konsultasi->dokter->no_telepon ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <h5 class="text-dark dark:text-light mb-3">Keluhan</h5>
                <div class="card bg-light dark:bg-dark border">
                    <div class="card-body">
                        <p class="text-dark dark:text-light mb-0">{{ $konsultasi->keluhan }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
                <form action="{{ route('konsultasi.destroy', $konsultasi->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus konsultasi ini?')" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection