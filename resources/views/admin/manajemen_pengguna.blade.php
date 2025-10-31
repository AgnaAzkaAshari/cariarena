@extends('admin.layout.app')

@section('title', 'Manajemen Pengguna - CariArena')
@section('page-title', '👥 Manajemen Pengguna')

@push('styles')
<style>
    /* Additional styles specific to manajemen pengguna page */
    .table-responsive {
        border-radius: 10px;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 15px;
        font-weight: 600;
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-color: #f1f5f9;
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
    }

    .badge-success {
        background-color: var(--success);
    }

    .badge-warning {
        background-color: var(--warning);
        color: #212529;
    }

    .badge-danger {
        background-color: var(--danger);
    }

    .badge-user {
        background-color: #E3F2FD;
        color: #1976D2;
    }

    .badge-venue {
        background-color: #E8F5E8;
        color: #388E3C;
    }

    .badge-active {
        background-color: #E8F5E8;
        color: var(--success);
    }

    .badge-inactive {
        background-color: #FFF3E0;
        color: var(--warning);
    }

    .badge-suspended {
        background-color: #FFEBEE;
        color: var(--danger);
    }

    /* Filter Section */
    .filter-card {
        background: var(--card-bg);
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        margin-bottom: 24px;
    }

    .form-control, .form-select {
        border: 1.5px solid #E5E7EB;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 0.9rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(99, 179, 237, 0.1);
    }

    /* Tombol Aksi */
    .btn-group-sm .btn {
        padding: 0.4rem 0.6rem;
        font-size: 0.75rem;
        margin: 1px;
        border: none;
    }

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

    .btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    /* Pastikan ikon berwarna putih */
    .btn-info.text-white .fas,
    .btn-warning.text-white .fas,
    .btn-danger.text-white .fas,
    .btn-info.text-white i,
    .btn-warning.text-white i,
    .btn-danger.text-white i {
        color: white !important;
    }

    /* Hover effect */
    .btn-group-sm .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
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

    .user-detail-item {
        display: flex;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }

    .user-detail-label {
        font-weight: 600;
        color: var(--text-dark);
        min-width: 120px;
    }

    .user-detail-value {
        color: var(--text-light);
    }

    .user-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        margin-right: 15px;
    }

    .user-profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .user-profile-info h4 {
        margin: 0 0 5px 0;
        color: var(--text-dark);
        font-size: 18px;
    }

    .user-profile-info p {
        margin: 0;
        color: var(--text-light);
        font-size: 14px;
    }

    /* Pagination */
    .pagination .page-link {
        border: 1px solid #E5E7EB;
        color: var(--text-dark);
        border-radius: 6px;
        margin: 0 2px;
        font-size: 0.85rem;
        padding: 6px 12px;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
        border-color: var(--primary-color);
    }
</style>
@endpush

@section('content')
    <!-- Statistik Pengguna -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <small>Total Pengguna</small>
                <h3>{{ number_format($totalPengguna ?? 0) }}</h3>
                <small>Semua pengguna terdaftar</small>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <small>Pengguna Aktif</small>
                <h3>{{ number_format($penggunaAktif ?? 0) }}</h3>
                <small>Aktif dalam 30 hari terakhir</small>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <small>Pengguna Baru</small>
                <h3>{{ number_format($penggunaBaru ?? 0) }}</h3>
                <small>Bulan ini</small>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <small>Tingkat Keterlibatan</small>
                <h3>{{ $tingkatKeterlibatan ?? 0 }}%</h3>
                <small>Rata-rata aktivitas pengguna</small>
            </div>
        </div>
    </div>

    <!-- Search dan Filter -->
    <div class="filter-card">
        <div class="section-header d-flex justify-content-between align-items-center">
            <h5>🔍 Filter Pengguna</h5>
        </div>
        <div class="section-body">
            <form method="GET" action="{{ route('admin.pengguna.index') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="searchInput" name="search" placeholder="Cari pengguna..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="roleFilter" name="role">
                            <option value="">Semua Peran</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Pengguna</option>
                            <option value="venue" {{ request('role') == 'Venue' ? 'selected' : '' }}>Venue</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="statusFilter" name="status">
                            <option value="">Semua Status</option>
                            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="Ditangguhkan" {{ request('status') == 'Ditangguhkan' ? 'selected' : '' }}>Ditangguhkan</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="lihat-semua-btn w-100" id="filterButton">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Pengguna -->
    <div class="dashboard-section">
        <div class="section-header d-flex justify-content-between align-items-center">
            <h5>📋 Daftar Pengguna</h5>
            <button class="lihat-semua-btn" data-bs-toggle="modal" data-bs-target="#tambahPenggunaModal">
                <i class="fas fa-plus me-2"></i>Tambah Pengguna
            </button>
        </div>
        <div class="section-body">
            <div class="table-responsive">
                <table class="table table-hover" id="usersTable">
                    <thead>
                        <tr>
                            <th>Kode Pengguna</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Peran</th>
                            <th>Status</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        @foreach($users as $user)
                        <tr>
                            <td class="fw-bold">{{ $user->user_code }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>
                                @if($user->role === 'user')
                                    <span class="badge badge-user">Pengguna</span>
                                @elseif($user->role === 'Venue')
                                    <span class="badge badge-venue">Venue</span>
                                @endif
                            </td>
                            <td>
                                @if($user->status === 'Aktif')
                                    <span class="badge badge-active">Aktif</span>
                                @elseif($user->status === 'Nonaktif')
                                    <span class="badge badge-inactive">Nonaktif</span>
                                @elseif($user->status === 'Ditangguhkan')
                                    <span class="badge badge-suspended">Ditangguhkan</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <!-- Tombol Detail -->
                                    <button class="btn btn-info text-white" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#detailPenggunaModal" data-user-id="{{ $user->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-warning text-white" title="Edit" data-bs-toggle="modal" data-bs-target="#editPenggunaModal" data-user-id="{{ $user->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <!-- Tombol Hapus -->
                                    <button class="btn btn-danger text-white" title="Hapus" data-bs-toggle="modal" data-bs-target="#hapusPenggunaModal" data-user-id="{{ $user->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                {{ $users->links() }}
            </nav>
        </div>
    </div>

    <!-- Modal Detail Pengguna -->
    <div class="modal fade" id="detailPenggunaModal" tabindex="-1" aria-labelledby="detailPenggunaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailPenggunaModalLabel">👤 Detail Pengguna</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="user-profile-header">
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-profile-info">
                            <h4 id="detailNama">-</h4>
                            <p id="detailEmail">-</p>
                            <span class="badge badge-user" id="detailPeran">-</span>
                            <span class="badge badge-active ms-2" id="detailStatus">-</span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="user-detail-item">
                                <div class="user-detail-label">Kode Pengguna</div>
                                <div class="user-detail-value" id="detailKode">-</div>
                            </div>
                            <div class="user-detail-item">
                                <div class="user-detail-label">Telepon</div>
                                <div class="user-detail-value" id="detailTelepon">-</div>
                            </div>
                            <div class="user-detail-item">
                                <div class="user-detail-label">Bergabung</div>
                                <div class="user-detail-value" id="detailBergabung">-</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="user-detail-item">
                                <div class="user-detail-label">Terakhir Diperbarui</div>
                                <div class="user-detail-value" id="detailDiperbarui">-</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#editPenggunaModal" data-bs-dismiss="modal">Edit Pengguna</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pengguna -->
    <div class="modal fade" id="editPenggunaModal" tabindex="-1" aria-labelledby="editPenggunaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPenggunaModalLabel">✏ Edit Pengguna</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST" action="{{ route('admin.pengguna.update', ':id') }}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Kode Pengguna</label>
                                <input type="text" class="form-control" id="editKode" name="user_code" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="editNama" name="name" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telepon</label>
                                <input type="tel" class="form-control" id="editTelepon" name="phone">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Peran</label>
                                <select class="form-select" id="editPeran" name="role" required>
                                    <option value="user">Pengguna</option>
                                    <option value="venue">Venue</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="editStatus" name="status" required>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                    <option value="Ditangguhkan">Ditangguhkan</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary-custom" id="simpanEdit">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Pengguna -->
    <div class="modal fade" id="hapusPenggunaModal" tabindex="-1" aria-labelledby="hapusPenggunaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusPenggunaModalLabel">🗑 Hapus Pengguna</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="text-center mb-3">Apakah Anda yakin ingin menghapus pengguna ini?</h5>
                    <p class="text-center text-muted" id="hapusUserInfo">Pengguna: <strong>-</strong> (-)</p>
                    <p class="text-center text-muted">Tindakan ini tidak dapat dibatalkan dan semua data pengguna akan dihapus secara permanen.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteUserForm" method="POST" action="{{ route('admin.pengguna.destroy', ':id') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="konfirmasiHapus">Ya, Hapus Pengguna</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="tambahPenggunaModal" tabindex="-1" aria-labelledby="tambahPenggunaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPenggunaModalLabel">➕ Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="tambahUserForm" method="POST" action="{{ route('admin.pengguna.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <small><i class="fas fa-info-circle"></i> Kode pengguna akan digenerate otomatis oleh sistem.</small>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tambahNama" name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Masukkan nama lengkap" required>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="tambahEmail" name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Masukkan alamat email" required>
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Telepon</label>
                            <input type="tel" class="form-control" id="tambahTelepon" name="phone" 
                                   value="{{ old('phone') }}" 
                                   placeholder="Masukkan nomor telepon">
                            @error('phone')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Peran <span class="text-danger">*</span></label>
                            <select class="form-select" id="tambahPeran" name="role" required>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Pengguna</option>
                                <option value="venue" {{ old('role') == 'venue' ? 'selected' : '' }}>Venue</option>
                            </select>
                            @error('role')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="tambahStatus" name="status" required>
                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                <option value="Ditangguhkan" {{ old('status') == 'Ditangguhkan' ? 'selected' : '' }}>Ditangguhkan</option>
                            </select>
                            @error('status')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="tambahPassword" name="password" 
                                   placeholder="Masukkan password (minimal 6 karakter)" required minlength="6">
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="tambahKonfirmasiPassword" 
                                   name="password_confirmation" 
                                   placeholder="Konfirmasi password" required minlength="6">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-plus me-2"></i>Tambah Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Fungsi untuk menampilkan pesan error
        function showError(message) {
            alert('Error: ' + message);
        }

        // Validasi form tambah pengguna
        document.getElementById('tambahUserForm').addEventListener('submit', function(e) {
            const password = document.getElementById('tambahPassword').value;
            const confirmPassword = document.getElementById('tambahKonfirmasiPassword').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                showError('Password dan konfirmasi password tidak cocok!');
                return false;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                showError('Password harus minimal 6 karakter!');
                return false;
            }
        });

        // Handle modal detail
        const detailModal = document.getElementById('detailPenggunaModal');
        detailModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            
            fetch(`/admin/pengguna/${userId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Gagal mengambil data');
                return response.json();
            })
            .then(user => {
                // Isi data ke modal detail
                document.getElementById('detailNama').textContent = user.name;
                document.getElementById('detailEmail').textContent = user.email;
                document.getElementById('detailKode').textContent = user.user_code;
                document.getElementById('detailTelepon').textContent = user.phone || '-';
                document.getElementById('detailBergabung').textContent = new Date(user.created_at).toLocaleDateString('id-ID');
                document.getElementById('detailDiperbarui').textContent = new Date(user.updated_at).toLocaleDateString('id-ID');
                
                // Set badge
                const peranBadge = document.getElementById('detailPeran');
                peranBadge.className = 'badge ' + (user.role === 'user' ? 'badge-user' : 'badge-venue');
                peranBadge.textContent = user.role === 'user' ? 'Pengguna' : 'Venue';
                
                const statusBadge = document.getElementById('detailStatus');
                statusBadge.className = 'badge ms-2 ' + 
                    (user.status === 'Aktif' ? 'badge-active' : 
                     user.status === 'Nonaktif' ? 'badge-inactive' : 'badge-suspended');
                statusBadge.textContent = user.status;
            })
            .catch(error => {
                console.error('Error:', error);
                showError('Gagal memuat data pengguna');
            });
        });

        // Handle modal edit
        const editModal = document.getElementById('editPenggunaModal');
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            
            fetch(`/admin/pengguna/${userId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Gagal mengambil data');
                return response.json();
            })
            .then(user => {
                // Isi data ke form edit
                document.getElementById('editUserId').value = user.id;
                document.getElementById('editKode').value = user.user_code;
                document.getElementById('editNama').value = user.name;
                document.getElementById('editEmail').value = user.email;
                document.getElementById('editTelepon').value = user.phone || '';
                document.getElementById('editPeran').value = user.role;
                document.getElementById('editStatus').value = user.status;
                
                // Set action form
                document.getElementById('editUserForm').action = `/admin/pengguna/${user.id}`;
            })
            .catch(error => {
                console.error('Error:', error);
                showError('Gagal memuat data pengguna');
            });
        });

        // Auto-submit filter
        document.getElementById('searchInput').addEventListener('input', function() {
            document.getElementById('filterForm').submit();
        });

        document.getElementById('roleFilter').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        document.getElementById('statusFilter').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
</script>
@endpush