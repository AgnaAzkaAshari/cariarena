@extends('admin.layout.app')

@section('title', 'Manajemen Venue')

@section('page-title', '🏢 Manajemen Venue')

@push('styles')
<style>
    /* ==== WARNA UNTUK SETIAP MENU ==== */
    :root {
        --dashboard-color: #4C8BF5;
        --pengguna-color: #22C55E;
        --venue-color: #F59E0B;
        --pemesanan-color: #EC4899;
        --transaksi-color: #8B5CF6;
        --laporan-color: #4C8BF5;
        --pengaturan-color: #94A3B8;
        --logout-color: #EF4444;
    }

    /* ==== SUB-MENU STYLES ==== */
    .nav-submenu {
        list-style: none;
        padding: 0;
        margin: 0;
        display: none;
        background-color: var(--primary-light);
        border-radius: 0 0 8px 8px;
        overflow: hidden;
        margin-top: -8px;
        padding-top: 8px;
    }

    .nav-submenu li {
        margin: 0;
    }

    .nav-submenu a {
        display: flex;
        align-items: center;
        padding: 10px 15px 10px 45px;
        border-radius: 0;
        color: var(--text-light);
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .nav-submenu a:hover {
        background-color: rgba(99, 179, 237, 0.1);
        color: var(--text-dark);
    }

    .nav-submenu a.active {
        background-color: rgba(99, 179, 237, 0.2);
        color: var(--primary-color);
        font-weight: 500;
    }

    .nav-submenu a i {
        margin-right: 10px;
        font-size: 14px;
        width: 16px;
        text-align: center;
    }

    /* Ikon chevron di menu venue */
    #venueMenuToggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #venueMenuIcon {
        font-size: 12px;
        transition: transform 0.3s ease;
    }

    /* ==== TABLE STYLES ==== */
    .table-container {
        background: var(--card-bg);
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        animation: fadeIn 0.6s ease-out;
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: var(--text-dark);
        border-bottom: 2px solid #e9ecef;
        padding: 12px 15px;
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
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
    }

    .badge-active {
        background-color: #E8F5E8;
        color: var(--success);
    }

    .badge-maintenance {
        background-color: #FFF3E0;
        color: var(--warning);
    }

    .badge-inactive {
        background-color: #FFEBEE;
        color: var(--danger);
    }

    .badge-sport {
        background-color: #E3F2FD;
        color: #1976D2;
    }

    /* ==== BUTTON STYLES ==== */
    .btn-action {
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        border: 1px solid #E5E7EB;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
        border: none;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 179, 237, 0.3);
    }

    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
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

    .btn-info:hover,
    .btn-warning:hover,
    .btn-danger:hover {
        transform: translateY(-1px);
        opacity: 0.9;
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
        animation: fadeIn 0.6s ease-out;
    }

    .form-control {
        border: 1.5px solid #E5E7EB;
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 0.9rem;
    }

    .form-control:focus {
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

    /* ==== MODAL STYLES ==== */
    .modal-content {
        border-radius: 14px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        animation: fadeIn 0.3s ease-out;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
        color: white;
        border-radius: 14px 14px 0 0;
        border-bottom: none;
        padding: 20px 25px;
    }

    .modal-header .btn-close {
        filter: invert(1);
    }

    .modal-body {
        padding: 25px;
    }

    .modal-footer {
        border-top: 1px solid #f1f5f9;
        padding: 20px 25px;
        border-radius: 0 0 14px 14px;
    }

    /* Modal konfirmasi hapus khusus */
    .modal-hapus .modal-content {
        max-width: 450px;
    }
    
    .modal-hapus .modal-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
    }
    
    .modal-hapus .modal-body {
        text-align: center;
        padding: 30px;
    }
    
    .modal-hapus .modal-footer {
        justify-content: center;
        gap: 15px;
    }
    
    .modal-hapus .btn-batal {
        background-color: #718096;
        border-color: #718096;
        color: white;
    }
    
    .modal-hapus .btn-hapus {
        background: linear-gradient(135deg, var(--logout-color) 0%, #F87171 100%);
        border: none;
        color: white;
    }

    .modal-hapus .btn-hapus:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Loading state untuk button */
    .btn-loading {
        position: relative;
        color: transparent;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        width: 18px;
        height: 18px;
        top: 50%;
        left: 50%;
        margin-left: -9px;
        margin-top: -9px;
        border: 2px solid #ffffff;
        border-radius: 50%;
        border-right-color: transparent;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
</style>
@endpush

@section('content')
<!-- Notifikasi -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Statistik Venue -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <small>Total Venue</small>
            <h3 id="totalVenue">{{ $totalVenue ?? 0 }}</h3>
            <small>Semua venue terdaftar</small>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <small>Venue Aktif</small>
            <h3 id="venueAktif">{{ $venueAktif ?? 0 }}</h3>
            <small>Venue yang beroperasi</small>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <small>Dalam Perawatan</small>
            <h3 id="venuePerawatan">{{ $venuePerawatan ?? 0 }}</h3>
            <small>Venue sedang maintenance</small>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <small>Tingkat Pemanfaatan</small>
            <h3>{{ $tingkatPemanfaatan ?? 0 }}%</h3>
            <small>Rata-rata okupansi</small>
        </div>
    </div>
</div>

<!-- Search dan Filter -->
<div class="search-filter">
    <form id="searchForm" action="{{ route('admin.venue.index') }}" method="GET">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" name="search" placeholder="🔍 Cari venue..." 
                       value="{{ request('search') }}" id="searchInput">
            </div>
            <div class="col-md-3">
                <select class="form-control" name="status" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'Active' ? 'selected' : '' }}>Aktif</option>
                    <option value="maintenance" {{ request('status') == 'Maintenance' ? 'selected' : '' }}>Perawatan</option>
                    <option value="inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control" name="jenis_olahraga" id="sportFilter">
                    <option value="">Semua Olahraga</option>
                    <option value="Futsal" {{ request('sport_type') == 'Futsal' ? 'selected' : '' }}>Futsal</option>
                    <option value="Basket" {{ request('sport_type') == 'Basket' ? 'selected' : '' }}>Basket</option>
                    <option value="Badminton" {{ request('sport_type') == 'Badminton' ? 'selected' : '' }}>Badminton</option>
                    <option value="Soccer" {{ request('sport_type') == 'Soccer' ? 'selected' : '' }}>Soccer</option>
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

<!-- Daftar Venue -->
<div class="table-container">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h5>📋 Daftar Venue</h5>
        <button class="btn btn-primary-custom btn-action" data-bs-toggle="modal" data-bs-target="#tambahVenueModal">
            <i class="fas fa-plus me-2"></i>Tambah Venue
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover" id="venueTable">
            <thead>
                <tr>
                    <th>Nama Venue</th>
                    <th>Lokasi</th>
                    <th>Jenis Olahraga</th>
                    <th>Fasilitas</th>
                    <th>Harga/Jam</th>
                    <th>Status</th>
                    <th>Rating</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="venueTableBody">
                @forelse($venues ?? [] as $venue)
                    <tr>
                        <td class="fw-bold">{{ $venue->name }}</td>
                        <td>{{ Str::limit($venue->location, 30) }}</td>
                        <td>
                            <span class="badge badge-sport">{{ $venue->sport_type }}</span>
                        </td>
                        <td>{{ Str::limit($venue->facilities, 30) }}</td>
                        <td class="fw-bold text-success">Rp {{ number_format($venue->price_per_hour, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge badge-{{ $venue->status == 'active' ? 'active' : ($venue->status == 'maintenance' ? 'maintenance' : 'inactive') }}">
                                {{ $venue->status == 'active' ? 'Aktif' : ($venue->status == 'maintenance' ? 'Perawatan' : 'Nonaktif') }}
                            </span>
                        </td>
                        <td>
                            <i class="fas fa-star text-warning"></i> {{ $venue->rating ?? '0.0' }}
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-info" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#detailVenueModal" onclick="showDetailModal({{ $venue->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editVenueModal" onclick="showEditModal({{ $venue->id }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#hapusVenueModal" onclick="showHapusModal({{ $venue->id }}, '{{ $venue->name }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="empty-state">
                                <i class="fas fa-store fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak ada venue ditemukan</h5>
                                <p class="text-muted">Mulai dengan menambahkan venue baru.</p>
                                <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#tambahVenueModal">
                                    <i class="fas fa-plus me-2"></i>Tambah Venue Pertama
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(isset($venues) && $venues->hasPages())
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
                {{ $venues->links() }}
            </ul>
        </nav>
    @endif
</div>

<!-- Modal Tambah Venue -->
<div class="modal fade" id="tambahVenueModal" tabindex="-1" aria-labelledby="tambahVenueModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahVenueModalLabel">
                    <i class="fas fa-plus me-2"></i>Tambah Venue Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.venue.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Venue <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Masukkan nama venue" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="location" placeholder="Masukkan alamat venue" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Olahraga <span class="text-danger">*</span></label>
                                <select class="form-control" name="sport_type" required>
                                    <option value="">Pilih Jenis Olahraga</option>
                                    <option value="Futsal">Futsal</option>
                                    <option value="Basket">Basket</option>
                                    <option value="Badminton">Badminton</option>
                                    <option value="Soccer">Soccer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fasilitas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="facilities" placeholder="Masukkan fasilitas (contoh: Parkir, Kamar Mandi, Kantin)" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga per Jam <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="price_per_hour" placeholder="Masukkan harga" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" required>
                                    <option value="active">Aktif</option>
                                    <option value="maintenance">Perawatan</option>
                                    <option value="inactive">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Deskripsi venue..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <input type="number" class="form-control" name="rating" placeholder="Masukkan rating (0-5)" min="0" max="5" step="0.1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save me-2"></i>Simpan Venue
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Venue -->
<div class="modal fade" id="editVenueModal" tabindex="-1" aria-labelledby="editVenueModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVenueModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Venue
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editVenueForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Venue <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editName" name="name" placeholder="Masukkan nama venue" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editLocation" name="location" placeholder="Masukkan alamat venue" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Olahraga <span class="text-danger">*</span></label>
                                <select class="form-control" id="editSportType" name="sport_type" required>
                                    <option value="">Pilih Jenis Olahraga</option>
                                    <option value="Futsal">Futsal</option>
                                    <option value="Basket">Basket</option>
                                    <option value="Badminton">Badminton</option>
                                    <option value="Soccer">Soccer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fasilitas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editFacilities" name="facilities" placeholder="Masukkan fasilitas" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga per Jam <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="editPrice" name="price_per_hour" placeholder="Masukkan harga" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="editStatus" name="status" required>
                                    <option value="active">Aktif</option>
                                    <option value="maintenance">Perawatan</option>
                                    <option value="inactive">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="3" placeholder="Deskripsi venue..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <input type="number" class="form-control" id="editRating" name="rating" placeholder="Masukkan rating (0-5)" min="0" max="5" step="0.1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Venue -->
<div class="modal fade" id="detailVenueModal" tabindex="-1" aria-labelledby="detailVenueModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailVenueModalLabel">
                    <i class="fas fa-info-circle me-2"></i>Detail Venue
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detailContent">
                    <!-- Detail content akan diisi oleh JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Venue -->
<div class="modal fade modal-hapus" id="hapusVenueModal" tabindex="-1" aria-labelledby="hapusVenueModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusVenueModalLabel">
                    <i class="fas fa-trash me-2"></i>Hapus Venue
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                </div>
                <h4 class="text-center mb-3">Apakah Anda yakin ingin menghapus venue ini?</h4>
                <p class="text-center mb-4" id="hapusVenueInfo">
                    <!-- Informasi venue yang akan dihapus -->
                </p>
                <p class="text-center text-muted">
                    Tindakan ini tidak dapat dibatalkan dan semua data venue akan dihapus secara permanen.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-batal" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-hapus">Ya, Hapus Venue</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle submenu venue
    document.addEventListener('DOMContentLoaded', function() {
        const venueMenuToggle = document.getElementById('venueMenuToggle');
        if (venueMenuToggle) {
            venueMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                const submenu = document.getElementById('venueSubmenu');
                const icon = document.getElementById('venueMenuIcon');
                
                if (submenu.style.display === 'block') {
                    submenu.style.display = 'none';
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                } else {
                    submenu.style.display = 'block';
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                }
            });

            // Buka submenu venue secara default karena menu aktif
            const submenu = document.getElementById('venueSubmenu');
            const icon = document.getElementById('venueMenuIcon');
            submenu.style.display = 'block';
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        }
    });

    // Fungsi untuk menampilkan modal edit
    function showEditModal(venueId) {
        console.log('🔄 Memuat data venue untuk edit, ID:', venueId);
        
        // Show loading state
        const editForm = document.getElementById('editVenueForm');
        const submitBtn = editForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memuat...';
        submitBtn.disabled = true;

        // Fetch data venue dari server
        fetch(`/admin/venue/${venueId}/edit`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(venue => {
                console.log('✅ Data venue berhasil dimuat:', venue);
                
                // Isi form edit dengan data venue
                document.getElementById('editName').value = venue.name || '';
                document.getElementById('editLocation').value = venue.location || '';
                document.getElementById('editSportType').value = venue.sport_type || '';
                document.getElementById('editFacilities').value = venue.facilities || '';
                document.getElementById('editPrice').value = venue.price_per_hour || '';
                document.getElementById('editStatus').value = venue.status || 'active';
                document.getElementById('editDescription').value = venue.description || '';
                document.getElementById('editRating').value = venue.rating || '0.0';
                
                // Set action form edit
                document.getElementById('editVenueForm').action = `/admin/venue/${venueId}`;
                
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                console.log('✅ Form edit berhasil diisi');
            })
            .catch(error => {
                console.error('❌ Error memuat data venue:', error);
                
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                // Show error message
                alert('❌ Gagal memuat data venue untuk edit: ' + error.message);
            });
    }

    // Fungsi untuk menampilkan modal detail
    function showDetailModal(venueId) {
        console.log('🔄 Memuat detail venue, ID:', venueId);
        
        const detailContent = document.getElementById('detailContent');
        detailContent.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Memuat...</span>
                </div>
                <p class="mt-2">Memuat data venue...</p>
            </div>
        `;

        // Fetch data venue dari server
        fetch(`/admin/venue/${venueId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(venue => {
                console.log('✅ Data detail venue berhasil dimuat:', venue);
                
                // Penyesuaian status badge
                const statusText = venue.status === 'active' ? 'Aktif' : 
                                venue.status === 'maintenance' ? 'Perawatan' : 'Nonaktif';
                const statusClass = venue.status === 'active' ? 'active' : 
                                venue.status === 'maintenance' ? 'maintenance' : 'inactive';
                
                detailContent.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold">${venue.name}</h6>
                            <p><strong>Lokasi:</strong> ${venue.location}</p>
                            <p><strong>Jenis Olahraga:</strong> ${venue.sport_type}</p>
                            <p><strong>Fasilitas:</strong> ${venue.facilities}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Harga per Jam:</strong> Rp ${new Intl.NumberFormat('id-ID').format(venue.price_per_hour)}</p>
                            <p><strong>Status:</strong> <span class="badge badge-${statusClass}">${statusText}</span></p>
                            <p><strong>Rating:</strong> <i class="fas fa-star text-warning"></i> ${venue.rating || '0.0'}/5.0</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p><strong>Deskripsi:</strong></p>
                            <p>${venue.description || 'Tidak ada deskripsi'}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p><strong>Dibuat pada:</strong> ${new Date(venue.created_at).toLocaleDateString('id-ID')}</p>
                            <p><strong>Diperbarui pada:</strong> ${new Date(venue.updated_at).toLocaleDateString('id-ID')}</p>
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                console.error('❌ Error memuat detail venue:', error);
                detailContent.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Gagal memuat data venue!</strong><br>
                        Error: ${error.message}
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btn-primary" onclick="showDetailModal(${venueId})">
                            <i class="fas fa-redo me-2"></i>Coba Lagi
                        </button>
                    </div>
                `;
            });
    }

    // Fungsi untuk menampilkan modal konfirmasi hapus
    function showHapusModal(venueId, venueName) {
        console.log('🗑️ Menampilkan modal hapus untuk:', venueName, 'ID:', venueId);
        
        const hapusVenueInfo = document.getElementById('hapusVenueInfo');
        const deleteForm = document.getElementById('deleteForm');
        
        // Isi informasi venue yang akan dihapus
        hapusVenueInfo.innerHTML = `
            <strong>"${venueName}"</strong><br>
            <small class="text-muted">ID: ${venueId}</small>
        `;
        
        // Set action form delete
        deleteForm.action = `/admin/venue/${venueId}`;
    }

    // Handle form submission dengan feedback visual
    document.addEventListener('DOMContentLoaded', function() {
        // Handle form tambah venue
        const tambahForm = document.querySelector('#tambahVenueModal form');
        if (tambahForm) {
            tambahForm.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;
                
                console.log('📤 Mengirim form tambah venue...');
            });
        }

        // Handle form edit venue
        const editForm = document.getElementById('editVenueForm');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                // Validasi form
                const name = document.getElementById('editName').value;
                const location = document.getElementById('editLocation').value;
                const sportType = document.getElementById('editSportType').value;
                const facilities = document.getElementById('editFacilities').value;
                const price = document.getElementById('editPrice').value;
                
                if (!name || !location || !sportType || !facilities || !price) {
                    e.preventDefault();
                    alert('❌ Harap isi semua field yang wajib diisi!');
                    return;
                }
                
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;
                
                console.log('📤 Mengirim form edit venue...');
            });
        }

        // Handle form delete venue
        const deleteForm = document.getElementById('deleteForm');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...';
                submitBtn.disabled = true;
                
                console.log('📤 Mengirim form hapus venue...');
            });
        }
    });

    // Auto-hide alerts setelah 5 detik
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            try {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            } catch (e) {
                console.log('Tidak bisa menutup alert:', e);
            }
        });
    }, 5000);

    // Real-time search dengan debounce
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                console.log('🔍 Melakukan pencarian:', this.value);
                document.getElementById('searchForm').submit();
            }, 500);
        });
    }
</script>
@endpush