@extends('layouts.app')

@section('content')
    <div class="container py-4 dashboard-breeze-bg">
        <h1 class="dashboard-title mb-4 text-dark dark:text-light">Data Dokter</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card dashboard-breeze-card p-4 mb-4">
            <form class="row g-2 align-items-end" method="get">
                <div class="col-md-4">
                    <label class="form-label text-dark dark:text-light">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Nama, email, STR, dsb">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-dark dark:text-light">Spesialisasi</label>
                    <select name="spesialisasi" class="form-select">
                        <option value="">Semua</option>
                        @foreach($spesialisasiList as $spesialisasi)
                            <option value="{{ $spesialisasi }}" @selected(request('spesialisasi') == $spesialisasi)>
                                {{ $spesialisasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit"><i class="bi bi-search"></i> Filter</button>
                </div>
                <div class="col-md-3 text-end">
                    <a href="{{ route('dokter.create') }}" class="btn btn-success w-100"><i class="bi bi-plus-circle"></i>
                        Tambah Dokter</a>
                </div>
            </form>
        </div>
        <div class="card dashboard-breeze-card p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Spesialisasi</th>
                            <th>No. STR</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dokters as $dokter)
                            <tr>
                                <td class="fw-semibold text-dark dark:text-light">{{ $dokter->nama }}</td>
                                <td>{{ $dokter->email }}</td>
                                <td>{{ $dokter->spesialisasi }}</td>
                                <td>{{ $dokter->no_str }}</td>
                                <td>{{ $dokter->telepon }}</td>
                                <td>{{ $dokter->alamat }}</td>
                                <td class="text-center">
                                    <a href="{{ route('dokter.edit', $dokter) }}" class="btn btn-sm btn-warning"><i
                                            class="bi bi-pencil"></i></a>
                                    <form action="{{ route('dokter.destroy', $dokter) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin hapus dokter ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada data dokter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $dokters->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection