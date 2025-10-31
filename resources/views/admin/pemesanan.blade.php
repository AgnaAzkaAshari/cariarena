@extends('admin.layout.app')

@section('title', 'Manajemen Pemesanan')

@section('page-title', '📅 Manajemen Pemesanan')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Statistik Pemesanan -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <small>Total Pemesanan</small>
            <h3>{{ $totalPemesanans ?? 0 }}</h3>
            <small>Semua pemesanan</small>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <small>Pemesanan Aktif</small>
            <h3>{{ $activePemesanans ?? 0 }}</h3>
            <small>Pemesanan aktif hari ini</small>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <small>Menunggu Konfirmasi</small>
            <h3>{{ $pendingPemesanans ?? 0 }}</h3>
            <small>Pemesanan pending</small>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <small>Tingkat Keterlibatan</small>
            <h3>{{ $occupancyRate ?? 0 }}%</h3>
            <small>Rata-rata okupansi venue</small>
        </div>
    </div>
</div>

<!-- Search dan Filter -->
<div class="search-filter">
    <form method="GET" action="{{ route('admin.pemesanan.index') }}">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" name="search" id="searchInput" 
                       placeholder="🔍 Cari pemesanan..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select class="form-select" name="status" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Terkonfirmasi" {{ request('status') == 'Terkonfirmasi' ? 'selected' : '' }}>Terkonfirmasi</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="sport_type" id="sportFilter">
                    <option value="">Semua Olahraga</option>
                    @foreach($sportTypes as $sport)
                        <option value="{{ $sport }}" {{ request('sport_type') == $sport ? 'selected' : '' }}>
                            {{ $sport }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary-custom w-100" id="filterButton">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Daftar Pemesanan -->
<div class="table-container">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h5>📋 Daftar Pemesanan</h5>
        <button class="btn btn-primary-custom btn-action" data-bs-toggle="modal" data-bs-target="#tambahPemesananModal">
            <i class="fas fa-plus me-2"></i>Tambah Pemesanan
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover" id="bookingsTable">
            <thead>
                <tr>
                    <th>Kode Booking</th>
                    <th>Nama Pemesan</th>
                    <th>Venue</th>
                    <th>Jenis Olahraga</th>
                    <th>Tanggal & Waktu</th>
                    <th>Durasi</th>
                    <th>Total Biaya</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="bookingsTableBody">
                @forelse($pemesanans ?? [] as $pemesanan)
                <tr>
                    <td class="fw-bold">{{ $pemesanan->booking_code }}</td>
                    <td>{{ $pemesanan->customer_name }}</td>
                    <td>{{ $pemesanan->venue->name ?? 'Venue tidak ditemukan' }}</td>
                    <td>
                        <span class="badge badge-sport">{{ $pemesanan->sport_type }}</span>
                    </td>
                    <td>
                        <div>{{ \Carbon\Carbon::parse($pemesanan->booking_date)->translatedFormat('d M Y') }}</div>
                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($pemesanan->start_time)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($pemesanan->end_time)->format('H:i') }}
                        </small>
                    </td>
                    <td>{{ $pemesanan->duration }} jam</td>
                    <td class="fw-bold text-success">Rp {{ number_format($pemesanan->total_cost, 0, ',', '.') }}</td>
                    <td>
                        @if($pemesanan->status == 'Terkonfirmasi')
                            <span class="badge badge-confirmed">Terkonfirmasi</span>
                        @elseif($pemesanan->status == 'Menunggu')
                            <span class="badge badge-pending">Menunggu</span>
                        @elseif($pemesanan->status == 'Selesai')
                            <span class="badge badge-completed">Selesai</span>
                        @elseif($pemesanan->status == 'Dibatalkan')
                            <span class="badge badge-cancelled">Dibatalkan</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <!-- Tombol Detail -->
                            <button class="btn btn-info text-white" title="Lihat Detail" data-bs-toggle="modal" 
                                    data-bs-target="#detailPemesananModal" 
                                    data-pemesanan-id="{{ $pemesanan->id }}">
                                <i class="fas fa-eye text-white"></i>
                            </button>
                            
                            <!-- Tombol Edit -->
                            <button class="btn btn-warning text-white" title="Edit" data-bs-toggle="modal" 
                                    data-bs-target="#editPemesananModal" 
                                    data-pemesanan-id="{{ $pemesanan->id }}"
                                    data-customer-name="{{ $pemesanan->customer_name }}"
                                    data-venue-id="{{ $pemesanan->venue_id }}"
                                    data-sport-type="{{ $pemesanan->sport_type }}"
                                    data-booking-date="{{ $pemesanan->booking_date->format('Y-m-d') }}"
                                    data-start-time="{{ \Carbon\Carbon::parse($pemesanan->start_time)->format('H:i') }}"
                                    data-end-time="{{ \Carbon\Carbon::parse($pemesanan->end_time)->format('H:i') }}"
                                    data-total-cost="{{ $pemesanan->total_cost }}"
                                    data-status="{{ $pemesanan->status }}"
                                    data-description="{{ $pemesanan->description }}">
                                <i class="fas fa-edit text-white"></i>
                            </button>
                            
                            <!-- Tombol Hapus -->
                            <button class="btn btn-danger text-white" title="Hapus" data-bs-toggle="modal" 
                                    data-bs-target="#hapusPemesananModal" 
                                    data-pemesanan-id="{{ $pemesanan->id }}"
                                    data-booking-code="{{ $pemesanan->booking_code }}"
                                    data-customer-name="{{ $pemesanan->customer_name }}">
                                <i class="fas fa-trash text-white"></i>
                            </button>

                            @if($pemesanan->status == 'Menunggu')
                            <!-- Tombol Konfirmasi -->
                            <form action="{{ route('admin.pemesanan.confirm', $pemesanan->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success text-white" title="Konfirmasi" 
                                        onclick="return confirm('Apakah Anda yakin ingin mengonfirmasi pemesanan ini?')">
                                    <i class="fas fa-check text-white"></i>
                                </button>
                            </form>
                            
                            <!-- Tombol Tolak/Batalkan -->
                            <form action="{{ route('admin.pemesanan.cancel', $pemesanan->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger text-white" title="Batalkan" 
                                        onclick="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')">
                                    <i class="fas fa-times text-white"></i>
                                </button>
                            </form>
                            @elseif($pemesanan->status == 'Terkonfirmasi')
                            <!-- Tombol Selesaikan -->
                            <form action="{{ route('admin.pemesanan.complete', $pemesanan->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary text-white" title="Selesaikan" 
                                        onclick="return confirm('Apakah Anda yakin ingin menyelesaikan pemesanan ini?')">
                                    <i class="fas fa-flag-checkered text-white"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4">
                        <div class="empty-state">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada data pemesanan</h5>
                            <p class="text-muted">Belum ada pemesanan yang tercatat.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(isset($pemesanans) && $pemesanans->hasPages())
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            {{ $pemesanans->links() }}
        </ul>
    </nav>
    @endif
</div>

<!-- Modal Detail Pemesanan -->
<div class="modal fade" id="detailPemesananModal" tabindex="-1" aria-labelledby="detailPemesananModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailPemesananModalLabel">📋 Detail Pemesanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailModalBody">
                <!-- Content will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pemesanan -->
<div class="modal fade" id="editPemesananModal" tabindex="-1" aria-labelledby="editPemesananModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPemesananModalLabel">✏️ Edit Pemesanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPemesananForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editPemesananId" name="id">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Pemesan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editCustomerName" name="customer_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Venue <span class="text-danger">*</span></label>
                            <select class="form-select" id="editVenueId" name="venue_id" required>
                                <option value="">Pilih Venue</option>
                                @foreach($venues ?? [] as $venue)
                                    <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="editBookingDate" name="booking_date" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="editStartTime" name="start_time" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="editEndTime" name="end_time" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Jenis Olahraga <span class="text-danger">*</span></label>
                            <select class="form-select" id="editSportType" name="sport_type" required>
                                <option value="">Pilih Olahraga</option>
                                @foreach($sportTypes as $sport)
                                    <option value="{{ $sport }}">{{ $sport }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Total Biaya <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="editTotalCost" name="total_cost" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="editStatus" name="status" required>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Terkonfirmasi">Terkonfirmasi</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus Pemesanan -->
<div class="modal fade" id="hapusPemesananModal" tabindex="-1" aria-labelledby="hapusPemesananModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusPemesananModalLabel">🗑️ Hapus Pemesanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                </div>
                <h5 class="text-center mb-3">Apakah Anda yakin ingin menghapus pemesanan ini?</h5>
                <p class="text-center text-muted" id="hapusBookingInfo"></p>
                <p class="text-center text-muted">Tindakan ini tidak dapat dibatalkan dan data pemesanan akan dihapus secara permanen.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="POST" id="deleteBookingForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus Pemesanan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pemesanan -->
<div class="modal fade" id="tambahPemesananModal" tabindex="-1" aria-labelledby="tambahPemesananModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPemesananModalLabel">➕ Tambah Pemesanan Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.pemesanan.store') }}" id="tambahPemesananForm">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Pemesan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="customer_name" required 
                                   placeholder="Masukkan nama pemesan" value="{{ old('customer_name') }}">
                            @error('customer_name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Venue <span class="text-danger">*</span></label>
                            <select class="form-select" name="venue_id" required>
                                <option value="">Pilih Venue</option>
                                @foreach($venues ?? [] as $venue)
                                    <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
                                        {{ $venue->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('venue_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="booking_date" required 
                                   min="{{ date('Y-m-d') }}" value="{{ old('booking_date') }}">
                            @error('booking_date')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" name="start_time" required 
                                   value="{{ old('start_time') }}">
                            @error('start_time')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" name="end_time" required 
                                   value="{{ old('end_time') }}">
                            @error('end_time')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Jenis Olahraga <span class="text-danger">*</span></label>
                            <select class="form-select" name="sport_type" required>
                                <option value="">Pilih Olahraga</option>
                                @foreach($sportTypes as $sport)
                                    <option value="{{ $sport }}" {{ old('sport_type') == $sport ? 'selected' : '' }}>
                                        {{ $sport }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sport_type')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Total Biaya <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="total_cost" required 
                                   placeholder="Masukkan total biaya" value="{{ old('total_cost') }}">
                            @error('total_cost')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="Menunggu" {{ old('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Terkonfirmasi" {{ old('status') == 'Terkonfirmasi' ? 'selected' : '' }}>Terkonfirmasi</option>
                            <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Dibatalkan" {{ old('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" name="description" rows="3" 
                                  placeholder="Masukkan catatan tambahan">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom">Tambah Pemesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* ==== TABLE STYLES ==== */
    .table-container {
        background: var(--card-bg);
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 15px;
        font-weight: 600;
    }

    .table td {
        padding: 12px 15px;
        vertical-align: middle;
        border-color: #f1f5f9;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* ==== BADGE STYLES ==== */
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
        font-weight: 500;
    }

    .badge-confirmed {
        background-color: #E8F5E8;
        color: var(--success);
    }

    .badge-pending {
        background-color: #FFF3E0;
        color: var(--warning);
    }

    .badge-cancelled {
        background-color: #FFEBEE;
        color: var(--danger);
    }

    .badge-completed {
        background-color: #E3F2FD;
        color: #1976D2;
    }

    .badge-sport {
        background-color: #F3E5F5;
        color: #7B1FA2;
    }

    /* ==== BUTTON STYLES ==== */
    .btn-action {
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 0.855rem;
        transition: all 0.3s ease;
        border: 1px solid #E5E7EB;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
        border: none;
        color: white;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 179, 237, 0.3);
    }

    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        margin: 1px;
    }

    /* ==== ACTION BUTTONS ==== */
    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-info:hover,
    .btn-warning:hover,
    .btn-danger:hover,
    .btn-success:hover,
    .btn-primary:hover {
        transform: translateY(-1px);
        opacity: 0.9;
    }

    /* ==== TEXT WHITE FOR ICONS ==== */
    .btn-info.text-white,
    .btn-warning.text-white,
    .btn-danger.text-white,
    .btn-success.text-white,
    .btn-primary.text-white {
        color: white !important;
    }

    .btn-info .fas,
    .btn-warning .fas,
    .btn-danger .fas,
    .btn-success .fas,
    .btn-primary .fas {
        color: white !important;
    }

    /* ==== EMPTY STATE ==== */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--text-light);
        margin-bottom: 1rem;
    }

    /* ==== SEARCH AND FILTER ==== */
    .search-filter {
        background: var(--card-bg);
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .form-control, .form-select {
        border: 1.5px solid #E5E7EB;
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 0.9rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(99, 179, 237, 0.1);
    }

    /* ==== PAGINATION ==== */
    .pagination .page-link {
        border: 1px solid #E5E7EB;
        color: var(--text-dark);
        border-radius: 8px;
        margin: 0 2px;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
        border-color: var(--primary-color);
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
        color: white;
        border-radius: 12px 12px 0 0;
        border-bottom: none;
        padding: 15px 20px;
    }

    .modal-title {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        border-top: 1px solid #f1f5f9;
        padding: 15px 20px;
    }

    .booking-detail-item {
        display: flex;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }

    .booking-detail-label {
        font-weight: 600;
        color: var(--text-dark);
        min-width: 120px;
    }

    .booking-detail-value {
        color: var(--text-light);
    }

    /* Stat Card Styles */
    .stat-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
    }

    .stat-card small {
        color: var(--text-light);
        font-size: 0.8rem;
    }

    .stat-card h3 {
        margin: 10px 0;
        color: var(--primary-color);
        font-weight: 700;
    }

    /* Validation Styles */
    .text-danger.small {
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .form-label .text-danger {
        font-size: 1.2em;
        margin-left: 2px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load detail pemesanan via AJAX
        const detailModal = document.getElementById('detailPemesananModal');
        if (detailModal) {
            detailModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const pemesananId = button.getAttribute('data-pemesanan-id');
                
                // Show loading state
                document.getElementById('detailModalBody').innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memuat data pemesanan...</p>
                    </div>
                `;
                
                fetch(`/admin/pemesanan/${pemesananId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const pemesanan = data.data;
                            document.getElementById('detailModalBody').innerHTML = `
                                <div class="booking-detail-item">
                                    <div class="booking-detail-label">Kode Booking</div>
                                    <div class="booking-detail-value fw-bold">${pemesanan.booking_code}</div>
                                </div>
                                <div class="booking-detail-item">
                                    <div class="booking-detail-label">Nama Pemesan</div>
                                    <div class="booking-detail-value">${pemesanan.customer_name}</div>
                                </div>
                                <div class="booking-detail-item">
                                    <div class="booking-detail-label">Venue</div>
                                    <div class="booking-detail-value">${pemesanan.venue?.name || 'Venue tidak ditemukan'}</div>
                                </div>
                                <div class="booking-detail-item">
                                    <div class="booking-detail-label">Jenis Olahraga</div>
                                    <div class="booking-detail-value">${pemesanan.sport_type}</div>
                                </div>
                                <div class="booking-detail-item">
                                    <div class="booking-detail-label">Tanggal & Waktu</div>
                                    <div class="booking-detail-value">${pemesanan.formatted_date}</div>
                                </div>
                                <div class="booking-detail-item">
                                    <div class="booking-detail-label">Durasi</div>
                                    <div class="booking-detail-value">${pemesanan.duration} jam</div>
                                </div>
                                <div class="booking-detail-item">
                                    <div class="booking-detail-label">Total Biaya</div>
                                    <div class="booking-detail-value fw-bold text-success">Rp ${new Intl.NumberFormat('id-ID').format(pemesanan.total_cost)}</div>
                                </div>
                                <div class="booking-detail-item">
                                    <div class="booking-detail-label">Status</div>
                                    <div class="booking-detail-value">
                                        ${pemesanan.status === 'Terkonfirmasi' ? '<span class="badge badge-confirmed">Terkonfirmasi</span>' : 
                                        pemesanan.status === 'Menunggu' ? '<span class="badge badge-pending">Menunggu</span>' :
                                        pemesanan.status === 'Selesai' ? '<span class="badge badge-completed">Selesai</span>' :
                                        pemesanan.status === 'Dibatalkan' ? '<span class="badge badge-cancelled">Dibatalkan</span>' :
                                        '<span class="badge badge-pending">Menunggu</span>'}
                                    </div>
                                </div>
                                <div class="booking-detail-item">
                                    <div class="booking-detail-label">Catatan</div>
                                    <div class="booking-detail-value">${pemesanan.description || '-'}</div>
                                </div>
                            `;
                        } else {
                            throw new Error(data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('detailModalBody').innerHTML = `
                            <div class="text-center text-danger py-4">
                                <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                                <p>Terjadi kesalahan saat memuat data pemesanan</p>
                                <small>${error.message}</small>
                            </div>
                        `;
                    });
            });
        }

        // Setup modal edit
        const editModal = document.getElementById('editPemesananModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                
                const pemesananId = button.getAttribute('data-pemesanan-id');
                const customerName = button.getAttribute('data-customer-name');
                const venueId = button.getAttribute('data-venue-id');
                const sportType = button.getAttribute('data-sport-type');
                const bookingDate = button.getAttribute('data-booking-date');
                const startTime = button.getAttribute('data-start-time');
                const endTime = button.getAttribute('data-end-time');
                const totalCost = button.getAttribute('data-total-cost');
                const status = button.getAttribute('data-status');
                const description = button.getAttribute('data-description');
                
                // Isi data ke form edit
                document.getElementById('editPemesananId').value = pemesananId;
                document.getElementById('editCustomerName').value = customerName;
                document.getElementById('editVenueId').value = venueId;
                document.getElementById('editSportType').value = sportType;
                document.getElementById('editBookingDate').value = bookingDate;
                document.getElementById('editStartTime').value = startTime;
                document.getElementById('editEndTime').value = endTime;
                document.getElementById('editTotalCost').value = totalCost;
                document.getElementById('editStatus').value = status;
                document.getElementById('editDescription').value = description;
                
                // Set action form
                document.getElementById('editPemesananForm').action = `/admin/pemesanan/${pemesananId}`;
            });
        }

        // Setup delete modal
        const hapusModal = document.getElementById('hapusPemesananModal');
        if (hapusModal) {
            hapusModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const pemesananId = button.getAttribute('data-pemesanan-id');
                const bookingCode = button.getAttribute('data-booking-code');
                const customerName = button.getAttribute('data-customer-name');
                
                document.getElementById('hapusBookingInfo').innerHTML = 
                    `Pemesanan: <strong>${bookingCode}</strong> - ${customerName}`;
                
                document.getElementById('deleteBookingForm').action = `/admin/pemesanan/${pemesananId}`;
            });
        }

        // Real-time search
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#bookingsTableBody tr');
                    
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                }, 300);
            });
        }

        // Auto close alert setelah 5 detik
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Form submission handling untuk edit
        const editForm = document.getElementById('editPemesananForm');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Tutup modal dan refresh halaman
                        bootstrap.Modal.getInstance(editModal).hide();
                        window.location.reload();
                    } else {
                        alert('Gagal memperbarui pemesanan: ' + (data.message || 'Terjadi kesalahan'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui pemesanan');
                });
            });
        }
    });
</script>
@endpush