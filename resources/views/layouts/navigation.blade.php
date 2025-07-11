<nav class="navbar navbar-expand-lg navbar-light bg-white dark:bg-dark border-bottom py-2 px-3"
    style="min-height:56px;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-dark dark:text-light"
            href="{{ route('dashboard') }}">
            BUANA PETSHOP
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-2">
                <li class="nav-item">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="nav-link px-2 py-1">
                        <i class="bi bi-house-door text-secondary"></i> <span
                            class="d-none d-md-inline">Dashboard</span>
                    </x-nav-link>
                </li>
                <li class="nav-item">
                    <x-nav-link :href="route('produk.index')" :active="request()->routeIs('produk.*')"
                        class="nav-link px-2 py-1">
                        <i class="bi bi-box text-secondary"></i> <span class="d-none d-md-inline">Produk</span>
                    </x-nav-link>
                </li>
                <li class="nav-item">
                    <x-nav-link :href="route('kategori-produk.index')" :active="request()->routeIs('kategori-produk.*')"
                        class="nav-link px-2 py-1">
                        <i class="bi bi-tags text-secondary"></i> <span class="d-none d-md-inline">Kategori</span>
                    </x-nav-link>
                </li>
                <li class="nav-item">
                    <x-nav-link :href="route('pesanan.index')" :active="request()->routeIs('pesanan.*')"
                        class="nav-link px-2 py-1">
                        <i class="bi bi-cart text-secondary"></i> <span class="d-none d-md-inline">Pesanan</span>
                    </x-nav-link>
                </li>
                <li class="nav-item">
                    <x-nav-link :href="route('dokter.index')" :active="request()->routeIs('dokter.*')"
                        class="nav-link px-2 py-1">
                        <i class="bi bi-person-badge text-secondary"></i> <span class="d-none d-md-inline">Dokter</span>
                    </x-nav-link>
                </li>
                <li class="nav-item">
                    <x-nav-link :href="route('konsultasi.index')" :active="request()->routeIs('konsultasi.*')"
                        class="nav-link px-2 py-1">
                        <i class="bi bi-chat-dots text-secondary"></i> <span
                            class="d-none d-md-inline">Konsultasi</span>
                    </x-nav-link>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-link p-0 border-0 theme-toggle" onclick="toggleTheme()" title="Toggle theme">
                    <i class="bi bi-sun-fill sun-icon text-secondary"></i>
                    <i class="bi bi-moon-fill moon-icon text-secondary"></i>
                </button>
                <div class="dropdown">
                    <button class="btn btn-link p-0 border-0 dropdown-toggle d-flex align-items-center" type="button"
                        id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span
                            class="rounded-circle bg-light dark:bg-dark text-dark dark:text-light d-flex align-items-center justify-content-center border"
                            style="width:32px;height:32px;font-weight:600;">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dark:bg-dark dark:border-secondary"
                        aria-labelledby="userDropdown">
                        <li class="px-3 py-2">
                            <div class="fw-semibold text-dark dark:text-light">{{ Auth::user()->name }}</div>
                            <div class="small text-muted">{{ Auth::user()->email }}</div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-dark dark:text-light" href="{{ route('profile.edit') }}"><i
                                    class="bi bi-person text-secondary"></i> Profile</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit"><i
                                        class="bi bi-box-arrow-right"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Navbar Active State */
    .navbar-nav .nav-link.active,
    .navbar-nav .nav-link[aria-current="page"] {
        border-bottom: 2px solid #6c757d;
        color: #212529 !important;
        background: none !important;
    }

    body.dark .navbar-nav .nav-link.active,
    body.dark .navbar-nav .nav-link[aria-current="page"] {
        border-bottom: 2px solid #adb5bd;
        color: #f8f9fa !important;
        background: none !important;
    }

    /* Theme Toggle */
    .theme-toggle .sun-icon {
        display: inline;
    }

    .theme-toggle .moon-icon {
        display: none;
    }

    body.dark .theme-toggle .sun-icon {
        display: none;
    }

    body.dark .theme-toggle .moon-icon {
        display: inline;
    }

    /* Navbar Links */
    .navbar-nav .nav-link {
        font-size: 0.98rem;
        color: #495057;
        transition: all 0.2s ease;
    }

    .navbar-nav .nav-link i {
        font-size: 1.1rem;
        color: #adb5bd !important;
        transition: color 0.2s ease;
    }

    .navbar-nav .nav-link:hover {
        color: #212529 !important;
        background: #f8f9fa !important;
    }

    body.dark .navbar-nav .nav-link:hover {
        color: #f8f9fa !important;
        background: #343a40 !important;
    }

    /* Navbar Brand */
    .navbar-brand {
        font-size: 1.15rem;
        letter-spacing: 0.5px;
        color: #181a1b !important;
    }

    body.dark .navbar-brand {
        color: #f8f9fa !important;
    }

    /* Dropdown */
    .dropdown-menu {
        min-width: 180px;
    }

    body.dark .dropdown-menu {
        background-color: #212529;
        border-color: #495057;
    }

    body.dark .dropdown-item:hover {
        background-color: #343a40;
    }

    /* Dark Mode Text Colors */
    body.dark .navbar-nav .nav-link {
        color: #adb5bd;
    }

    body.dark .navbar-nav .nav-link i {
        color: #6c757d !important;
    }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .navbar-nav .nav-link {
            padding: 0.5rem 1rem;
        }

        .navbar-nav .nav-link i {
            margin-right: 0.5rem;
        }
    }
</style>