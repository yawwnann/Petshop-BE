<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @stack('styles')
    <style>
        /* === GLOBAL DASHBOARD & ADMIN STYLES === */
        .dashboard-breeze-bg {
            background-color: #f5f6fa !important;
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .dashboard-breeze-card {
            background: #fff !important;
            border: 1px solid #e0e0e0 !important;
            color: #222 !important;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
            margin-bottom: 2rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .dashboard-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 2.2rem;
            letter-spacing: -0.5px;
        }

        .dashboard-breeze-title {
            color: #222 !important;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .dashboard-breeze-value {
            color: #222 !important;
            font-weight: 700;
            font-size: 2.5rem;
        }

        .dashboard-breeze-list-item {
            background: #f8f9fa !important;
            border: 1px solid #e0e0e0 !important;
            color: #333 !important;
        }

        .dashboard-breeze-list-label {
            color: #333 !important;
            font-size: 1rem;
        }

        .sort-arrow {
            font-size: 0.9em;
            margin-left: 2px;
        }

        .d-flex.gap-2 {
            gap: 0.5rem;
        }

        @media (max-width: 768px) {
            .dashboard-title {
                font-size: 1.5rem;
            }

            .table {
                font-size: 0.95rem;
            }

            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.4rem;
            }
        }

        /* Table & Card */
        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table-light th {
            background: #e9ecef;
            color: #343a40;
            font-weight: 600;
            padding: 1rem;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
        }

        /* Info Items */
        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .info-label {
            min-width: 140px;
            font-weight: 600;
            color: #495057;
        }

        /* Payment Proof Image */
        .bukti-transfer-link {
            display: inline-block;
            border-radius: 12px;
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            transition: box-shadow 0.2s;
        }

        .bukti-transfer-link:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .bukti-transfer-img {
            max-width: 200px;
            max-height: 200px;
            width: 100%;
            height: auto;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            object-fit: cover;
        }

        /* Badge Styling */
        .badge.bg-primary {
            background-color: #0d6efd !important;
            padding: 0.5em 1em;
            font-size: 0.9em;
            border-radius: 6px;
        }

        /* Button Styling */
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .btn-secondary:hover {
            background-color: #5c636a;
            border-color: #5c636a;
        }

        /* Kategori/Produk Table Dark Mode */
        body.dark .container .card,
        body.dark .container .table,
        body.dark .container .table th,
        body.dark .container .table td {
            background: #23272b !important;
            color: #fff !important;
            border-color: #444 !important;
        }

        body.dark .container .table-hover tbody tr:hover {
            background: #2d3238 !important;
        }

        body.dark .container .alert-success {
            background: #1e2a1e !important;
            color: #b6fcb6 !important;
            border-color: #2e4d2e !important;
        }

        body.dark .container .btn-primary {
            background: #375a7f !important;
            border-color: #375a7f !important;
        }

        body.dark .container .btn-warning {
            background: #facc15 !important;
            color: #222 !important;
            border-color: #facc15 !important;
        }

        body.dark .container .btn-danger {
            background: #ef4444 !important;
            border-color: #ef4444 !important;
        }

        /* === END GLOBAL ADMIN STYLES === */
        body.dark {
            background-color: #181a1b !important;
        }

        body.dark .card {
            background-color: #23272b !important;
            color: #fff !important;
            border-color: #23272b !important;
        }

        body.dark .card .card-title,
        body.dark .card .card-text,
        body.dark .text-dark {
            color: #fff !important;
        }

        body.dark .bg-primary {
            background-color: #375a7f !important;
        }

        body.dark .border {
            border-color: #23272b !important;
        }

        body.dark h1,
        body.dark h5,
        body.dark label {
            color: #fff !important;
        }

        body.dark .text-muted {
            color: #fff !important;
        }

        /* Tambahkan aturan lain sesuai kebutuhan */
        #darkModeToggle {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 9999;
        }

        body.dark nav {
            background-color: #23272b !important;
            border-bottom: 1px solid #444 !important;
        }

        body.dark nav .text-gray-900,
        body.dark nav .text-gray-800,
        body.dark nav .text-gray-500 {
            color: #fff !important;
        }

        body.dark nav .bg-white {
            background-color: #23272b !important;
        }

        body.dark .dashboard-breeze-card {
            background: #262b32 !important;
            color: #f3f4f6 !important;
            border-color: #30343a !important;
            box-shadow: 0 4px 16px rgba(20, 20, 20, 0.18);
        }

        body.dark .dashboard-breeze-bg {
            background-color: #23262b !important;
        }

        /* Table dark mode */
        body.dark .table {
            background: #23272b !important;
            color: #f3f4f6 !important;
            border-color: #30343a !important;
        }

        body.dark .table th,
        body.dark .table thead th,
        body.dark .table-light th {
            background: #262b32 !important;
            color: #f3f4f6 !important;
            border-color: #30343a !important;
        }

        body.dark .table td {
            background: #23272b !important;
            color: #f3f4f6 !important;
            border-color: #30343a !important;
        }

        body.dark .table-hover tbody tr:hover {
            background-color: #2d3138 !important;
        }

        /* List group dark mode */
        body.dark .list-group-item {
            background: #23272b !important;
            color: #f8fafc !important;
            border-color: #353a40 !important;
            font-weight: 500;
            box-shadow: 0 1px 4px rgba(20, 20, 20, 0.10);
        }

        body.dark .list-group-item.active {
            background: #375a7f !important;
            color: #fff !important;
            border-color: #375a7f !important;
        }

        body.dark .list-group {
            background: transparent !important;
        }

        body.dark .dashboard-breeze-list-label {
            color: #f8fafc !important;
            font-weight: 600;
            letter-spacing: 0.2px;
        }
    </style>
</head>

<body class="font-sans antialiased">

    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @hasSection('header')
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
    <!-- Bootstrap JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Set mode awal dari localStorage
        if(localStorage.getItem('theme')==='dark') {
            document.body.classList.add('dark');
        } else {
            document.body.classList.remove('dark');
        }

        // Fungsi toggle
        function toggleTheme() {
            document.body.classList.toggle('dark');
            if(document.body.classList.contains('dark')) {
                localStorage.setItem('theme','dark');
            } else {
                localStorage.setItem('theme','light');
            }
        }
    </script>
    @stack('scripts')
</body>

</html>