@extends('layouts.app')

@section('content')
    <div class="container py-4 dashboard-breeze-bg">
        <h1 class="dashboard-title mb-5">Daftar Pesanan</h1>
        <div class="mb-4 d-flex flex-wrap align-items-center gap-2">
            <span class="me-2 fw-semibold">Urutkan:</span>
            <div class="btn-group" role="group">
                @php
                    $sortOptions = [
                        'tanggal_pesanan' => 'Tanggal',
                        'status' => 'Status',
                        'total_harga' => 'Total Harga',
                        'id' => 'ID',
                    ];
                @endphp
                @foreach($sortOptions as $key => $label)
                    <a href="?sort={{ $key }}&order={{ $sort == $key && $order == 'asc' ? 'desc' : 'asc' }}"
                        class="btn btn-outline-primary btn-sm{{ $sort == $key ? ' active' : '' }}">
                        {{ $label }}
                        @if($sort == $key)
                            <span class="sort-arrow">{{ $order == 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
        <div class="card dashboard-breeze-card">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Pelanggan</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Status</th>
                                <th scope="col">Total Harga</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesanans as $pesanan)
                                <tr>
                                    <td class="align-middle">{{ $pesanan->id }}</td>
                                    <td class="align-middle">{{ $pesanan->nama_pelanggan }}</td>
                                    <td class="align-middle">
                                        {{ $pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->format('d M Y') : '-' }}</td>
                                    <td class="align-middle">
                                        @php
                                            $status = strtolower($pesanan->status);
                                            $badgeClass = match (true) {
                                                $status === 'pending' || $status === 'baru' => 'bg-warning text-dark',
                                                $status === 'diproses' => 'bg-info text-white',
                                                $status === 'dikirim' => 'bg-primary text-white',
                                                $status === 'selesai' => 'bg-success text-white',
                                                $status === 'batal' || $status === 'dibatalkan' => 'bg-danger text-white',
                                                $status === 'menunggu konfirmasi' => 'bg-warning text-dark',
                                                default => 'bg-secondary text-white',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} px-3 py-2 fw-semibold"
                                            style="font-size:0.95em;">{{ $pesanan->status }}</span>
                                    </td>
                                    <td class="align-middle fw-bold text-success">
                                        Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex gap-2 flex-wrap justify-content-center">
                                            <a href="{{ route('pesanan.show', $pesanan) }}" class="btn btn-info btn-sm">View</a>
                                            <a href="{{ route('pesanan.edit', $pesanan) }}"
                                                class="btn btn-warning btn-sm text-dark">Edit</a>
                                            <form action="{{ route('pesanan.destroy', $pesanan) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Yakin hapus pesanan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-6 text-muted">Belum ada pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection