@extends('admin.layout.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Statistik Utama -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <small>Total Pengguna</small>
                <h3>{{ number_format($totalPengguna) }}</h3>
                <small>Pengguna terdaftar</small>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <small>Total Venue</small>
                <h3>{{ number_format($totalVenue) }}</h3>
                <small>Lapangan tersedia</small>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <small>Total Pemesanan</small>
                <h3>{{ number_format($totalPemesanan) }}</h3>
                <small class="{{ $peningkatanPemesanan >= 0 ? 'change-positive' : 'change-negative' }}">
                    {{ $peningkatanPemesanan >= 0 ? '+' : '' }}{{ $peningkatanPemesanan }}% dari kemarin
                </small>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <small>Tingkat Okupansi</small>
                <h3>{{ $tingkatOkupansi }}%</h3>
                <small class="change-positive">+5% bulan ini</small>
            </div>
        </div>
    </div>

    <!-- 4 Sub Menu Utama dengan Tinggi Sama -->
    <div class="row equal-height-row">
        <!-- Kolom Kiri -->
        <div class="col-xl-8 col-lg-12">
            <div class="row equal-height-row">
                <!-- Pemesanan Terbaru -->
                <div class="col-12 main-content-section">
                    <div class="dashboard-section">
                        <div class="section-header d-flex justify-content-between align-items-center">
                            <h5>📅 Booking Terbaru</h5>
                            <a href="{{ route('admin.pemesanan.index') }}" class="lihat-semua-btn">
                                Lihat Semua <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="section-body">
                            @forelse($pemesananTerbaru as $pemesanan)
                            <div class="booking-item">
                                <div class="booking-info">
                                    <strong>
                                        @if(isset($pemesanan->nama_pemesan))
                                            {{ $pemesanan->nama_pemesan }}
                                        @else
                                            Customer
                                        @endif
                                    </strong>
                                    <p>
                                        Venue #{{ $pemesanan->venue_id ?? 'N/A' }}
                                        — 
                                        @if(isset($pemesanan->waktu_mulai))
                                            {{ \Carbon\Carbon::parse($pemesanan->waktu_mulai)->format('d M Y H:i') }}
                                        @else
                                            N/A
                                        @endif
                                        –
                                        @if(isset($pemesanan->waktu_selesai))
                                            {{ \Carbon\Carbon::parse($pemesanan->waktu_selesai)->format('H:i') }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <!-- GUNAKAN TOTAL_COST -->
                                    @if(isset($pemesanan->total_cost) && $pemesanan->total_cost > 0)
                                        <strong>Rp {{ number_format($pemesanan->total_cost) }}</strong>
                                    @else
                                        <strong>-</strong>
                                    @endif
                                    <div class="status {{ in_array($pemesanan->status, ['confirmed', 'terkonfirmasi', 'selesai', 'Terkonfirmasi']) ? 'confirmed' : 'pending' }}">
                                        @if($pemesanan->status == 'confirmed' || $pemesanan->status == 'terkonfirmasi' || $pemesanan->status == 'Terkonfirmasi')
                                            Terkonfirmasi
                                        @elseif($pemesanan->status == 'pending' || $pemesanan->status == 'menunggu' || $pemesanan->status == 'Menunggu')
                                            Menunggu
                                        @elseif($pemesanan->status == 'selesai')
                                            Selesai
                                        @elseif($pemesanan->status == 'dibatalkan')
                                            Dibatalkan
                                        @else
                                            {{ $pemesanan->status ?? 'Unknown' }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                <p>Tidak ada pemesanan terbaru</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Di bagian Venue Populer -->
                <div class="col-12 main-content-section">
                    <div class="dashboard-section">
                        <div class="section-header d-flex justify-content-between align-items-center">
                            <h5>🏆 Venue Populer</h5>
                            <a href="{{ route('admin.venue.index') }}" class="lihat-semua-btn">
                                Lihat Semua <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="section-body">
                            @forelse($venuePopuler as $venue)
                            <div class="venue-item">
                                <div>
                                    <strong>{{ $venue->nama ?? 'Nama tidak tersedia' }}</strong>
                                    <p class="mb-0 text-muted small">
                                        {{ $venue->kategori ?? 'Umum' }} 
                                        @if(isset($venue->fasilitas) && !empty($venue->fasilitas))
                                            • {{ Str::limit($venue->fasilitas, 30) }}
                                        @endif
                                    </p>
                                </div>
                                <div class="text-end">
                                    <strong>{{ $venue->total_pemesanan ?? 0 }}x dipesan</strong>
                                    <div class="small">
                                        <i class="fas fa-star text-warning"></i> 
                                        {{ $venue->rating ?? '4.5' }}
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-store-slash fa-2x mb-2"></i>
                                <p>Tidak ada data venue</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="col-xl-4 col-lg-12">
            <div class="row equal-height-row">
                <!-- Notifikasi Terbaru -->
                <div class="col-12 main-content-section">
                    <div class="dashboard-section">
                        <div class="section-header d-flex justify-content-between align-items-center">
                            <h5>🔔 Notifikasi</h5>
                            <a href="{{ route('admin.dashboard.notifikasi') }}" class="lihat-semua-btn">
                                Lihat Semua <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="section-body">
                            @foreach($notifikasiTerbaru as $notif)
                            <div class="notification-item d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas {{ $notif['icon'] }} {{ $notif['color'] }} me-2 mt-1"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-1">{{ $notif['title'] }}</h6>
                                    <p class="mb-0 text-muted small">{{ $notif['message'] }}</p>
                                    <small class="text-muted">{{ $notif['time'] }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Statistik Minggu Ini -->
                <div class="col-12 main-content-section">
                    <div class="dashboard-section">
                        <div class="section-header d-flex justify-content-between align-items-center">
                            <h5>📊 Statistik Minggu Ini</h5>
                            <a href="{{ route('admin.laporan.index') }}" class="lihat-semua-btn">
                                Lihat Semua <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="section-body">
                            <div class="stat-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted small">Total Booking</span>
                                </div>
                                <div class="text-end">
                                    <span class="stat-value text-primary">{{ $statistikMingguIni['pemesanan'] }}</span>
                                    <small class="{{ $statistikMingguIni['peningkatan_pemesanan'] >= 0 ? 'change-positive' : 'change-negative' }} ms-1">
                                        <i class="fas fa-arrow-{{ $statistikMingguIni['peningkatan_pemesanan'] >= 0 ? 'up' : 'down' }} me-1"></i>
                                        {{ $statistikMingguIni['peningkatan_pemesanan'] >= 0 ? '+' : '' }}{{ $statistikMingguIni['peningkatan_pemesanan'] }}%
                                    </small>
                                </div>
                            </div>
                            <div class="stat-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted small">Pendapatan</span>
                                </div>
                                <div class="text-end">
                                    <span class="stat-value text-success">Rp {{ number_format($statistikMingguIni['pendapatan']) }}</span>
                                    <small class="{{ $statistikMingguIni['peningkatan_pendapatan'] >= 0 ? 'change-positive' : 'change-negative' }} ms-1">
                                        <i class="fas fa-arrow-{{ $statistikMingguIni['peningkatan_pendapatan'] >= 0 ? 'up' : 'down' }} me-1"></i>
                                        {{ $statistikMingguIni['peningkatan_pendapatan'] >= 0 ? '+' : '' }}{{ $statistikMingguIni['peningkatan_pendapatan'] }}%
                                    </small>
                                </div>
                            </div>
                            <div class="stat-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted small">Okupansi</span>
                                </div>
                                <div class="text-end">
                                    <span class="stat-value text-warning">{{ $statistikMingguIni['okupansi'] }}%</span>
                                    <small class="change-positive ms-1">
                                        <i class="fas fa-arrow-up me-1"></i>+{{ $statistikMingguIni['peningkatan_okupansi'] }}%
                                    </small>
                                </div>
                            </div>
                            <div class="stat-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted small">Pengguna Baru</span>
                                </div>
                                <div class="text-end">
                                    <span class="stat-value text-info">{{ $statistikMingguIni['pengguna_baru'] }}</span>
                                    <small class="{{ $statistikMingguIni['peningkatan_pengguna'] >= 0 ? 'change-positive' : 'change-negative' }} ms-1">
                                        <i class="fas fa-arrow-{{ $statistikMingguIni['peningkatan_pengguna'] >= 0 ? 'up' : 'down' }} me-1"></i>
                                        {{ $statistikMingguIni['peningkatan_pengguna'] >= 0 ? '+' : '' }}{{ $statistikMingguIni['peningkatan_pengguna'] }}%
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection