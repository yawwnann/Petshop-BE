@extends('layouts.app')

@section('content')
    <div class="container py-4 dashboard-breeze-bg">
        <h1 class="dashboard-title mb-4 text-dark dark:text-light">Data Konsultasi</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card dashboard-breeze-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-dark dark:text-light mb-0">Filter & Pencarian</h5>
                <a href="{{ route('konsultasi.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Tambah Konsultasi
                </a>
            </div>
            <form class="row g-2 align-items-end" method="get">
                <div class="col-md-3">
                    <label class="form-label text-dark dark:text-light">Cari User/Dokter</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Nama user/dokter">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-dark dark:text-light">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="Menunggu" @selected(request('status') == 'Menunggu')>Menunggu</option>
                        <option value="Diterima" @selected(request('status') == 'Diterima')>Diterima</option>
                        <option value="Ditolak" @selected(request('status') == 'Ditolak')>Ditolak</option>
                        <option value="Selesai" @selected(request('status') == 'Selesai')>Selesai</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-dark dark:text-light">Dokter</label>
                    <select name="dokter_id" class="form-select">
                        <option value="">Semua</option>
                        @foreach($dokterList as $dokter)
                            <option value="{{ $dokter->id }}" @selected(request('dokter_id') == $dokter->id)>{{ $dokter->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit"><i class="bi bi-search"></i> Filter</button>
                </div>
            </form>
        </div>
        <div class="card dashboard-breeze-card p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Dokter</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($konsultasis as $konsultasi)
                            <tr>
                                <td>{{ $konsultasi->user->name ?? '-' }}</td>
                                <td>{{ $konsultasi->dokter->nama ?? '-' }}</td>
                                <td>{{ $konsultasi->tanggal }}</td>
                                <td>{{ $konsultasi->waktu }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $konsultasi->status == 'Selesai' ? 'success' : ($konsultasi->status == 'Diterima' ? 'primary' : ($konsultasi->status == 'Ditolak' ? 'danger' : 'warning')) }}">
                                        {{ $konsultasi->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('konsultasi.show', $konsultasi) }}" class="btn btn-sm btn-info"><i
                                            class="bi bi-eye"></i></a>
                                    <a href="{{ route('konsultasi.edit', $konsultasi) }}" class="btn btn-sm btn-warning"><i
                                            class="bi bi-pencil"></i></a>
                                    <form action="{{ route('konsultasi.destroy', $konsultasi) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin hapus konsultasi ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada data konsultasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $konsultasis->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection