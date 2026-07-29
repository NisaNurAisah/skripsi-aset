<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistem Inventaris Aset Desa')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
        * { font-family: 'Poppins', sans-serif; }
        body { background-color: #f0f2f5; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a5f3f 0%, #0d3d28 100%);
            color: #fff;
        }
        .sidebar h5 { color: #fff !important; }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.75);
            padding: 11px 16px;
            border-radius: 8px;
            margin-bottom: 4px;
            font-size: 14.5px;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
        }
        .sidebar .nav-link:hover { background-color: rgba(255,255,255,0.08); color: #fff; }
        .sidebar .nav-link.active { background-color: rgba(255,255,255,0.12); color: #fff; border-left: 3px solid #4ade80; }
        .sidebar .nav-link.text-danger { color: #ff8080 !important; }
        .sidebar .submenu .nav-link { font-size: 13.5px; padding: 9px 16px 9px 32px; }
        .sidebar .nav-link .bi-chevron-down { transition: transform 0.2s ease; font-size: 12px; }
        .sidebar .nav-link[aria-expanded="true"] .bi-chevron-down { transform: rotate(180deg); }
        .topbar { background-color: #ffffff; border-bottom: 1px solid #e5e7eb; }
        .stat-card { border: none; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: box-shadow 0.2s ease; }
        .stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.09); }
        h3.fw-bold { color: #1a2e22; letter-spacing: -0.3px; }
        h6.fw-bold { color: #1a2e22; }
        .btn-success { background-color: #1a5f3f; border-color: #1a5f3f; border-radius: 8px; font-weight: 500; }
        .btn-success:hover { background-color: #0d3d28; border-color: #0d3d28; }
        .btn-outline-success { color: #1a5f3f; border-color: #1a5f3f; border-radius: 8px; }
        .btn-outline-success:hover { background-color: #1a5f3f; border-color: #1a5f3f; }
        .btn-outline-primary, .btn-outline-secondary, .btn-outline-danger { border-radius: 8px; }
        .badge { font-weight: 500; padding: 6px 10px; border-radius: 6px; }
        .table thead th { background-color: #f8f9fa; font-size: 13px; text-transform: uppercase; letter-spacing: 0.4px; color: #6b7280; border-bottom: 2px solid #e5e7eb; }
        .table td { font-size: 14.5px; vertical-align: middle; }
        .form-control, .form-select { border-radius: 8px; border-color: #d1d5db; }
        .form-control:focus, .form-select:focus { border-color: #1a5f3f; box-shadow: 0 0 0 0.2rem rgba(26,95,63,0.15); }
    </style>
</head>
<body>

@if(session('id_pengguna'))
    <div class="d-flex">
        <div class="sidebar p-3" style="width:260px;">
            <h5 class="mb-4 text-success fw-bold">Inventaris Desa</h5>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard"><i class="bi bi-grid me-2"></i>Dashboard</a>

                @if(session('role') == 'Admin')
                <a class="nav-link {{ request()->is('data-pengguna*') ? 'active' : '' }}" href="/data-pengguna"><i class="bi bi-people me-2"></i>Data Pengguna</a>

                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#submenuAsetDesa" role="button" aria-expanded="{{ request()->is('data-aset-desa*') ? 'true' : 'false' }}">
                    <span><i class="bi bi-geo-alt me-2"></i>Kelola Data Aset</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse submenu {{ request()->is('data-aset-desa*') ? 'show' : '' }}" id="submenuAsetDesa">
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request('kategori') == 'tanah' ? 'active' : '' }}" href="/data-aset-desa?kategori=tanah">Tanah</a>
                        <a class="nav-link {{ request('kategori') == 'kendaraan-bangunan' ? 'active' : '' }}" href="/data-aset-desa?kategori=kendaraan-bangunan">Kendaraan dan Bangunan</a>
                        <a class="nav-link {{ request('kategori') == 'jalan-irigasi' ? 'active' : '' }}" href="/data-aset-desa?kategori=jalan-irigasi">Jalan dan Irigasi</a>
                    </nav>
                </div>
                @endif

                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#submenuInventaris" role="button" aria-expanded="{{ request()->is('data-aset*','data-latih*','klasifikasi*','perbaikan*','penghapusan*','pembelian*') ? 'true' : 'false' }}">
                    <span><i class="bi bi-box me-2"></i>Kelola Data Inventaris</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse submenu {{ request()->is('data-aset*','data-latih*','klasifikasi*','perbaikan*','penghapusan*','pembelian*') ? 'show' : '' }}" id="submenuInventaris">
                    <nav class="nav flex-column">
                        @if(session('role') == 'Admin')
                        <a class="nav-link {{ request()->is('data-aset*') ? 'active' : '' }}" href="/data-aset">Data Inventaris</a>
                        <a class="nav-link {{ request()->is('data-latih*') ? 'active' : '' }}" href="/data-latih">Data Latih KNN</a>
                        <a class="nav-link {{ request()->is('klasifikasi*') ? 'active' : '' }}" href="/klasifikasi">Klasifikasi Kondisi</a>
                        @endif
                        <a class="nav-link {{ request()->is('perbaikan*') ? 'active' : '' }}" href="/perbaikan">Perbaikan Inventaris</a>
                        <a class="nav-link {{ request()->is('penghapusan*') ? 'active' : '' }}" href="/penghapusan">Penghapusan Inventaris</a>
                        @if(session('role') == 'Admin')
                        <a class="nav-link {{ request()->is('pembelian*') ? 'active' : '' }}" href="/pembelian">Kelola Data Pembelian</a>
                        @endif
                    </nav>
                </div>

                <a class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}" href="/laporan"><i class="bi bi-file-earmark-text me-2"></i>Lihat Laporan Inventaris</a>

                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="nav-link border-0 bg-transparent text-danger w-100 text-start" onclick="return confirm('Yakin ingin logout?')"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                </form>
            </nav>
        </div>

        <div class="flex-grow-1">
            <div class="topbar d-flex justify-content-end align-items-center p-3">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-2 fs-5"></i> {{ session('nama_pengguna') }} ({{ session('role') }})
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/profile"><i class="bi bi-person-gear me-2"></i>Profil Saya</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Yakin ingin logout?')"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="container-fluid p-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
@else
    @yield('content')
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>