<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Gunakan style yang sama dengan dashboard */
        :root {
            --primary-color: #63B3ED;
            --primary-hover: #90CDF4;
            --primary-light: #EBF8FF;
            --text-dark: #1A202C;
            --text-light: #718096;
            --bg-light: #EDF2F7;
            --card-bg: #FFFFFF;
            --success: #48BB78;
            --warning: #ECC94B;
            --danger: #F56565;
            --sidebar-bg: #FFFFFF;
        }

        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-light);
            display: flex;
            margin: 0;
            padding: 0;
        }

        /* SIDEBAR STYLE - sama dengan dashboard */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: var(--sidebar-bg);
            color: var(--text-light);
            position: fixed;
            left: 0;
            top: 0;
            padding: 25px 20px;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .sidebar .logo {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .sidebar .logo i {
            font-size: 28px;
            margin-right: 10px;
            color: var(--primary-color);
        }

        .sidebar h2 {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            color: var(--text-dark);
        }

        .sidebar hr {
            border-color: rgba(113, 128, 150, 0.2);
            margin: 20px 0;
        }

        .sidebar .nav-title {
            font-size: 12px;
            letter-spacing: 1px;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .sidebar .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar .nav-menu li {
            margin-bottom: 8px;
        }

        .sidebar .nav-menu a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-menu a i {
            margin-right: 12px;
            font-size: 18px;
            width: 20px;
            text-align: center;
            transition: color 0.3s ease;
        }

        .sidebar .nav-menu a:hover {
            background: var(--primary-light);
            color: var(--text-dark);
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(99, 179, 237, 0.1);
        }

        .sidebar .nav-menu a.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 179, 237, 0.2);
        }

        /* Animasi shimmer untuk menu aktif */
        @keyframes shimmer {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(30deg);
            }
            100% {
                transform: translateX(100%) translateY(100%) rotate(30deg);
            }
        }

        /* Garis indikator untuk menu aktif */
        .sidebar .nav-menu a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 70%;
            background: white;
            border-radius: 0 4px 4px 0;
        }

        /* Efek kilat pada menu aktif */
        .sidebar .nav-menu a.active::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.3) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(30deg);
            animation: shimmer 3s infinite;
        }

        /* Saat menu aktif, ikon berubah menjadi putih */
        .sidebar .nav-menu a.active i {
            color: white !important;
        }

        /* ==== WARNA IKON UNTUK SETIAP MENU ==== */
        .sidebar .nav-menu a .fa-tachometer-alt { color: #4C8BF5; }
        .sidebar .nav-menu a .fa-users { color: #22C55E; }
        .sidebar .nav-menu a .fa-store { color: #F59E0B; }
        .sidebar .nav-menu a .fa-calendar-alt { color: #EC4899; }
        .sidebar .nav-menu a .fa-credit-card { color: #8B5CF6; }
        .sidebar .nav-menu a .fa-chart-bar { color: #F87171; }
        .sidebar .nav-menu a .fa-cog { color: #94A3B8; }
        .sidebar .nav-menu a .fa-sign-out-alt { color: #F56565; }

        /* Menu logout dengan warna merah */
        .sidebar .nav-menu .logout-btn {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            color: #F56565;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            background: transparent;
            border: none;
            width: 100%;
            text-align: left;
        }
        
        .sidebar .nav-menu .logout-btn:hover {
            background: #FED7D7;
            color: #C53030;
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(245, 101, 101, 0.1);
        }
        
        .sidebar .nav-menu .logout-btn i {
            margin-right: 12px;
            font-size: 18px;
            width: 20px;
            text-align: center;
            color: #F56565;
        }
        
        .sidebar .nav-menu .logout-btn:hover i {
            color: #C53030;
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
            flex: 1;
            background-color: var(--bg-light);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .topbar {
            background: white;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 8px rgba(45, 55, 72, 0.1);
            margin-bottom: 1.5rem;
            border-left: 5px solid var(--primary-color);
        }

        .topbar h1 {
            color: var(--primary-color);
            font-size: 28px;
            margin: 0;
            font-weight: 700;
        }

        /* ==== CARD STYLES ==== */
        .card {
            background: var(--card-bg);
            border-radius: 14px;
            padding: 0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            border: none;
            transition: all 0.3s;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .card-header {
            background: var(--card-bg);
            border-bottom: 1px solid #f1f5f9;
            padding: 20px;
            border-radius: 14px 14px 0 0 !important;
        }

        .card-header h5 {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            color: var(--primary-color);
        }

        .card-body {
            padding: 20px;
        }

        .notification-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .notification-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .notification-card.unread {
            background: var(--primary-light);
            border-left-color: var(--primary-color);
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .notification-icon.payment {
            background: #C6F6D5;
            color: var(--success);
        }

        .notification-icon.review {
            background: #FEFCBF;
            color: var(--warning);
        }

        .notification-icon.booking {
            background: #BEE3F8;
            color: var(--primary-color);
        }

        .notification-icon.maintenance {
            background: #FED7D7;
            color: var(--danger);
        }

        .notification-icon.system {
            background: #E9D8FD;
            color: #9F7AEA;
        }

        /* ==== BUTTON STYLES ==== */
        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-outline-danger {
            border-color: var(--danger);
            color: var(--danger);
        }

        .btn-outline-danger:hover {
            background: var(--danger);
            border-color: var(--danger);
            color: white;
        }

        .btn-outline-secondary {
            border-color: var(--text-light);
            color: var(--text-light);
        }

        .btn-outline-secondary:hover {
            background: var(--text-light);
            border-color: var(--text-light);
            color: white;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo">
            <i class="fas fa-volleyball-ball"></i>
            <h2>CariArena</h2>
        </div>
        <hr>
        <div class="nav-title">NAVIGATION</div>
        <ul class="nav-menu">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.pengguna.index') }}"><i class="fas fa-users"></i> Manajemen Pengguna</a></li>
            <li><a href="{{ route('admin.venue.index') }}"><i class="fas fa-store"></i> Manajemen Venue</a></li>
            <li><a href="{{ route('admin.pemesanan.index') }}"><i class="fas fa-calendar-alt"></i> Manajemen Pemesanan</a></li>
            <li><a href="{{ route('admin.transaksi.index') }}"><i class="fas fa-credit-card"></i> Transaksi</a></li>
            <li><a href="{{ route('admin.laporan.index') }}"><i class="fas fa-chart-bar"></i> Laporan</a></li>
            <li><a href="{{ route('admin.pengaturan.index') }}"><i class="fas fa-cog"></i> Pengaturan</a></li>
            <li>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <div class="main-content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand topbar mb-4 static-top">
            <div class="container-fluid">
                <button class="btn btn-link d-lg-none" type="button" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <h1 class="h3 mb-0">🔔 Notifikasi Sistem</h1>
                
                <div class="d-flex align-items-center">
                    <span class="text-muted me-3 d-none d-sm-inline">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </span>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid">
            <!-- TOMBOL KEMBALI KE DASHBOARD -->
            <div class="row mb-4">
                <div class="col-12">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-bell me-2"></i>Semua Notifikasi</h5>
                            <div>
                                <button class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fas fa-check-double me-1"></i>Tandai Semua Sudah Dibaca
                                </button>
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-trash me-1"></i>Hapus Semua
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Data notifikasi akan diisi dari backend -->
                            <div class="notification-card unread">
                                <div class="d-flex align-items-start">
                                    <div class="notification-icon payment">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h6 class="mb-1">Pembayaran Berhasil</h6>
                                            <small class="text-muted">2 jam yang lalu</small>
                                        </div>
                                        <p class="mb-2">Pembayaran untuk booking Lapangan Voli Sentra telah berhasil diproses.</p>
                                        <div class="d-flex">
                                            <button class="btn btn-sm btn-outline-primary me-2">
                                                <i class="fas fa-eye me-1"></i>Lihat Detail
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-check me-1"></i>Tandai Dibaca
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="notification-card">
                                <div class="d-flex align-items-start">
                                    <div class="notification-icon booking">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h6 class="mb-1">Booking Baru</h6>
                                            <small class="text-muted">5 jam yang lalu</small>
                                        </div>
                                        <p class="mb-2">Ahmad Rizki melakukan booking Gor Bulutangkis Merdeka untuk besok.</p>
                                        <div class="d-flex">
                                            <button class="btn btn-sm btn-outline-primary me-2">
                                                <i class="fas fa-eye me-1"></i>Lihat Detail
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-check me-1"></i>Tandai Dibaca
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="notification-card">
                                <div class="d-flex align-items-start">
                                    <div class="notification-icon review">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h6 class="mb-1">Review Baru</h6>
                                            <small class="text-muted">1 hari yang lalu</small>
                                        </div>
                                        <p class="mb-2">Sarah Wijaya memberikan rating 5 bintang untuk Lapangan Futsal Champion.</p>
                                        <div class="d-flex">
                                            <button class="btn btn-sm btn-outline-primary me-2">
                                                <i class="fas fa-eye me-1"></i>Lihat Detail
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-check me-1"></i>Tandai Dibaca
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="notification-card">
                                <div class="d-flex align-items-start">
                                    <div class="notification-icon system">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h6 class="mb-1">Pembaruan Sistem</h6>
                                            <small class="text-muted">2 hari yang lalu</small>
                                        </div>
                                        <p class="mb-2">Sistem telah diperbarui ke versi 2.1.0 dengan berbagai perbaikan bug.</p>
                                        <div class="d-flex">
                                            <button class="btn btn-sm btn-outline-primary me-2">
                                                <i class="fas fa-eye me-1"></i>Lihat Detail
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-check me-1"></i>Tandai Dibaca
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="notification-card">
                                <div class="d-flex align-items-start">
                                    <div class="notification-icon maintenance">
                                        <i class="fas fa-tools"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h6 class="mb-1">Maintenance Jadwal</h6>
                                            <small class="text-muted">3 hari yang lalu</small>
                                        </div>
                                        <p class="mb-2">Lapangan Voli Sentra akan tutup untuk maintenance pada Minggu depan.</p>
                                        <div class="d-flex">
                                            <button class="btn btn-sm btn-outline-primary me-2">
                                                <i class="fas fa-eye me-1"></i>Lihat Detail
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-check me-1"></i>Tandai Dibaca
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar untuk mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
        });

        // Animasi untuk menu sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.sidebar .nav-menu a');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Hapus class active dari semua link
                    navLinks.forEach(l => l.classList.remove('active'));
                    
                    // Tambah class active ke link yang diklik
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>