@extends('layouts.app')

@section('content')
    <div class="container py-4 dashboard-breeze-bg">
        <h1 class="dashboard-title mb-4 text-dark dark:text-light">Dashboard</h1>

        <!-- Statistik Cards: 2 baris, 4 kolom -->
        <div class="row g-3 mb-2">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card dashboard-breeze-card h-100 p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="fw-semibold small text-muted mb-1 dark:text-light">Total Pemasukan (Selesai)</div>
                        <div class="fs-2 fw-bold text-dark dark:text-light">Rp
                            {{ number_format($totalPemasukan, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="small mt-2  d-flex align-items-center gap-1">
                        <i class="bi bi-check-circle"></i> Dari pesanan yang sudah selesai
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-3">
                <div class="card dashboard-breeze-card h-100 p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="fw-semibold small text-muted mb-1">Pesanan Baru</div>
                        <div class="fs-1 fw-bold ">{{ $pesananBaru }}</div>
                    </div>
                    <div class="small mt-2  d-flex align-items-center gap-1">
                        <i class="bi bi-hourglass-split"></i> Pesanan belum diproses
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-3">
                <div class="card dashboard-breeze-card h-100 p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="fw-semibold small text-muted mb-1">Pesanan Diproses</div>
                        <div class="fs-1 fw-bold ">{{ $pesananDiproses }}</div>
                    </div>
                    <div class="small mt-2  d-flex align-items-center gap-1">
                        <i class="bi bi-gear"></i> Pesanan sedang disiapkan
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-3">
                <div class="card dashboard-breeze-card h-100 p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="fw-semibold small text-muted mb-1">Pesanan Dikirim</div>
                        <div class="fs-1 fw-bold">{{ $pesananDikirim }}</div>
                    </div>
                    <div class="small mt-2  d-flex align-items-center gap-1">
                        <i class="bi bi-truck"></i> Pesanan dalam pengiriman
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 mb-2">
            <div class="col-6 col-md-3 col-lg-3">
                <div class="card dashboard-breeze-card h-100 p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="fw-semibold small text-muted mb-1">Pesanan Selesai</div>
                        <div class="fs-1 fw-bold ">{{ $pesananSelesai }}</div>
                    </div>
                    <div class="small mt-2  d-flex align-items-center gap-1">
                        <i class="bi bi-check2-circle"></i> Total pesanan selesai
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-3">
                <div class="card dashboard-breeze-card h-100 p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="fw-semibold small text-muted mb-1">Pesanan Batal</div>
                        <div class="fs-1 fw-bold ">{{ $pesananBatal }}</div>
                    </div>
                    <div class="small mt-2  d-flex align-items-center gap-1">
                        <i class="bi bi-x-circle"></i> Pesanan yang dibatalkan
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-3">
                <div class="card dashboard-breeze-card h-100 p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="fw-semibold small text-muted mb-1">Total Produk</div>
                        <div class="fs-1 fw-bold">{{ $totalProduk }}</div>
                    </div>
                    <div class="small mt-2 d-flex align-items-center gap-1">
                        <i class="bi bi-box-seam"></i> Semua produk di katalog
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-3">
                <div class="card dashboard-breeze-card h-100 p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="fw-semibold small text-muted mb-1">Produk Tersedia</div>
                        <div class="fs-1 fw-bold ">{{ $produkTersedia }}</div>
                    </div>
                    <div class="small mt-2  d-flex align-items-center gap-1">
                        <i class="bi bi-check-circle"></i> Produk yang tersedia
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 mb-2">
            <div class="col-6 col-md-4 col-lg-4">
                <div class="card dashboard-breeze-card h-100 p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="fw-semibold small text-muted mb-1">Produk Habis</div>
                        <div class="fs-1 fw-bold ">{{ $produkHabis }}</div>
                    </div>
                    <div class="small mt-2  d-flex align-items-center gap-1">
                        <i class="bi bi-exclamation-octagon"></i> Produk yang stoknya habis
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-4">
                <div class="card dashboard-breeze-card h-100 p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="fw-semibold small text-muted mb-1">Produk Expired</div>
                        <div class="fs-1 fw-bold ">{{ $produkExpired }}</div>
                    </div>
                    <div class="small mt-2  d-flex align-items-center gap-1">
                        <i class="bi bi-exclamation-triangle"></i> Produk yang sudah expired
                    </div>
                </div>
            </div>
        </div>
        <!-- Chart Row -->
        <!-- Ganti chart dengan div untuk ApexCharts -->
        <div class="row g-3 mt-2">
            <div class="col-lg-6">
                <div class="card dashboard-breeze-card h-100 p-4">
                    <h5 class="card-title dashboard-breeze-title mb-4">Total Pemasukan per Bulan <span
                            class="small text-muted">(Status Selesai)</span></h5>
                    <div id="pemasukanBulananApex" style="min-height:320px;"></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card dashboard-breeze-card h-100 p-4">
                    <h5 class="card-title dashboard-breeze-title mb-4">Top 5 Produk Paling Laris <span
                            class="small text-muted">(Status Selesai)</span></h5>
                    <div id="topProdukApex" style="min-height:320px;"></div>
                </div>
            </div>
        </div>
        <!-- Pesanan Terbaru List -->

    </div>
@endsection

@push('scripts')
    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded',function() {
            // Data dari Blade
            const pemasukanBulanan={!! json_encode($pemasukanBulanan) !!};
            const topProduk={!! json_encode($topProduk) !!};

            // Pemasukan Bulanan (Line)
            var optionsPemasukan={
                chart: {type: 'line',height: 320,toolbar: {show: false}},
                series: [{
                    name: 'Total Pemasukan (Rp)',
                    data: pemasukanBulanan.map(item => Number(item.total))
                }],
                xaxis: {
                    categories: pemasukanBulanan.map(item => `${item.bulan}-${item.tahun}`),
                    labels: {style: {colors: '#888'}}
                },
                colors: ['#3b82f6'],
                theme: {mode: document.body.classList.contains('dark')? 'dark':'light'}
            };
            new ApexCharts(document.querySelector("#pemasukanBulananApex"),optionsPemasukan).render();

            // Top Produk (Bar)
            var optionsTopProduk={
                chart: {type: 'bar',height: 320,toolbar: {show: false}},
                series: [{
                    name: 'Jumlah Terjual',
                    data: topProduk.map(item => Number(item.total_terjual))
                }],
                xaxis: {
                    categories: topProduk.map(item => item.nama_produk),
                    labels: {style: {colors: '#888'}}
                },
                colors: ['#facc15'],
                theme: {mode: document.body.classList.contains('dark')? 'dark':'light'}
            };
            new ApexCharts(document.querySelector("#topProdukApex"),optionsTopProduk).render();
        });
    </script>
@endpush