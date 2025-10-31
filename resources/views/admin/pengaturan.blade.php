@extends('admin.layout.app')

@section('title', 'Pengaturan - CariArena')
@section('page-title', '⚙ Pengaturan')

@push('styles')
<style>
    /* Additional styles specific to pengaturan page */
    .settings-nav {
        background: var(--card-bg);
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .settings-nav-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .settings-nav-item {
        flex: 1;
        min-width: 150px;
        background: var(--bg-light);
        border: 2px solid transparent;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        color: var(--text-light);
    }

    .settings-nav-item:hover {
        background: var(--primary-light);
        color: var(--primary-color);
        transform: translateY(-2px);
    }

    .settings-nav-item.active {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
        color: white;
        border-color: var(--primary-color);
        box-shadow: 0 4px 12px rgba(99, 179, 237, 0.3);
    }

    /* ==== SETTINGS CONTENT ==== */
    .settings-content {
        background: var(--card-bg);
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .settings-section {
        display: none;
    }

    .settings-section.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 25px;
        color: var(--primary-color);
        border-bottom: 2px solid var(--primary-light);
        padding-bottom: 15px;
    }

    /* ==== FORM STYLES ==== */
    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border: 1.5px solid #E5E7EB;
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(99, 179, 237, 0.1);
    }

    /* ==== BADGE STYLES ==== */
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
        font-weight: 500;
        border-radius: 6px;
    }

    .badge-success {
        background-color: #E8F5E8;
        color: var(--success);
    }

    .badge-warning {
        background-color: #FFF3E0;
        color: var(--warning);
    }

    .badge-danger {
        background-color: #FFEBEE;
        color: var(--danger);
    }

    .badge-info {
        background-color: #E3F2FD;
        color: #1976D2;
    }

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

    /* ==== ACTION BUTTONS ==== */
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    /* ==== CHECKBOX GROUP ==== */
    .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 10px;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background: var(--bg-light);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .checkbox-item:hover {
        background: var(--primary-light);
    }

    /* ==== HELP ITEMS ==== */
    .help-item {
        padding: 20px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .help-item:last-child {
        border-bottom: none;
    }

    .help-question {
        font-weight: 600;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        color: var(--text-dark);
    }

    .help-question i {
        margin-right: 10px;
        color: var(--primary-color);
    }

    .help-answer {
        color: var(--text-light);
        font-size: 14px;
        line-height: 1.5;
        margin-left: 25px;
    }

    /* ==== PREVIEW STYLES ==== */
    .profile-preview {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        margin-bottom: 10px;
    }

    .logo-preview {
        width: 120px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        border-radius: 8px;
        font-size: 18px;
        margin-bottom: 10px;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .settings-nav-container {
            flex-direction: column;
        }
        
        .settings-nav-item {
            min-width: auto;
        }
        
        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
    <!-- Settings Navigation -->
    <div class="settings-nav">
        <div class="settings-nav-container">
            <div class="settings-nav-item active" data-target="profil-akun">
                <i class="fas fa-user me-2"></i>Profil Akun
            </div>
            <div class="settings-nav-item" data-target="pengaturan-sistem">
                <i class="fas fa-cog me-2"></i>Pengaturan Sistem
            </div>
            <div class="settings-nav-item" data-target="manajemen-admin">
                <i class="fas fa-users-cog me-2"></i>Manajemen Admin
            </div>
            <div class="settings-nav-item" data-target="pengaturan-notifikasi">
                <i class="fas fa-bell me-2"></i>Notifikasi
            </div>
            <div class="settings-nav-item" data-target="keamanan-backup">
                <i class="fas fa-shield-alt me-2"></i>Keamanan & Backup
            </div>
            <div class="settings-nav-item" data-target="pusat-bantuan">
                <i class="fas fa-question-circle me-2"></i>Pusat Bantuan
            </div>
        </div>
    </div>

    <!-- Settings Content -->
    <div class="settings-content">
        <!-- Profil Akun Section -->
        <section id="profil-akun" class="settings-section active">
            <h2 class="section-title">👤 Profil Akun</h2>
            
            <div class="row mb-4">
                <div class="col-md-2 text-center">
                    <div class="profile-preview">
                        <i class="fas fa-user"></i>
                    </div>
                    <small class="text-muted">Klik untuk mengubah</small>
                </div>
                <div class="col-md-10">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="Administrator">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="admin">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="admin@cariarena.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control" value="+62 812 3456 7890">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Bio</label>
                <textarea class="form-control" rows="3" placeholder="Tulis deskripsi singkat tentang diri Anda">Administrator utama sistem CariArena</textarea>
            </div>
            
            <div class="action-buttons">
                <button class="btn btn-primary-custom btn-action" id="simpanProfil">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
                <button class="btn btn-secondary-custom btn-action">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
            </div>
        </section>

        <!-- Pengaturan Sistem Section -->
        <section id="pengaturan-sistem" class="settings-section">
            <h2 class="section-title">⚙ Pengaturan Sistem</h2>
            
            <div class="row mb-4">
                <div class="col-md-2 text-center">
                    <div class="logo-preview">
                        CA
                    </div>
                    <small class="text-muted">Logo Aplikasi</small>
                </div>
                <div class="col-md-10">
                    <div class="mb-3">
                        <label class="form-label">Nama Aplikasi</label>
                        <input type="text" class="form-control" value="CariArena">
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Email Admin</label>
                            <input type="email" class="form-control" value="admin@cariarena.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Bahasa Default</label>
                            <select class="form-select">
                                <option value="id" selected>Bahasa Indonesia</option>
                                <option value="en">English</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Zona Waktu</label>
                    <select class="form-select">
                        <option value="WIB" selected>WIB (UTC+7)</option>
                        <option value="WITA">WITA (UTC+8)</option>
                        <option value="WIT">WIT (UTC+9)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Format Tanggal</label>
                    <select class="form-select">
                        <option value="DD/MM/YYYY" selected>DD/MM/YYYY</option>
                        <option value="MM/DD/YYYY">MM/DD/YYYY</option>
                        <option value="YYYY-MM-DD">YYYY-MM-DD</option>
                    </select>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="btn btn-primary-custom btn-action" id="simpanSistem">
                    <i class="fas fa-save me-2"></i>Simpan Pengaturan
                </button>
            </div>
        </section>

        <!-- Manajemen Admin Section -->
        <section id="manajemen-admin" class="settings-section">
            <h2 class="section-title">👥 Manajemen Admin</h2>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" placeholder="Masukkan nama admin">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Masukkan email admin">
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Role</label>
                    <select class="form-select">
                        <option value="super">Super Admin</option>
                        <option value="venue">Admin Venue</option>
                        <option value="content">Admin Konten</option>
                        <option value="report">Admin Laporan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select class="form-select">
                        <option value="active" selected>Aktif</option>
                        <option value="inactive">Nonaktif</option>
                    </select>
                </div>
            </div>
            
            <div class="action-buttons mb-4">
                <button class="btn btn-primary-custom btn-action" id="tambahAdmin">
                    <i class="fas fa-plus me-2"></i>Tambah Admin
                </button>
            </div>
            
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Terakhir Login</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold">Administrator</td>
                                <td>admin@cariarena.com</td>
                                <td><span class="badge badge-info">Super Admin</span></td>
                                <td><span class="badge badge-success">Aktif</span></td>
                                <td>01 Okt 2023, 14:30</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-info" title="Edit" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#hapusAdminModal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Manager Venue</td>
                                <td>venue@cariarena.com</td>
                                <td><span class="badge badge-warning">Admin Venue</span></td>
                                <td><span class="badge badge-success">Aktif</span></td>
                                <td>30 Sep 2023, 09:15</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-info" title="Edit" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#hapusAdminModal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Pengaturan Notifikasi Section -->
        <section id="pengaturan-notifikasi" class="settings-section">
            <h2 class="section-title">🔔 Pengaturan Notifikasi</h2>
            
            <div class="mb-4">
                <h5 class="mb-3">Notifikasi Email</h5>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="email-booking" checked>
                        <label for="email-booking">Booking Baru</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="email-payment" checked>
                        <label for="email-payment">Pembayaran Diterima</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="email-review" checked>
                        <label for="email-review">Ulasan Baru</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="email-report">
                        <label for="email-report">Laporan Bulanan</label>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <h5 class="mb-3">Notifikasi Browser</h5>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="browser-notif" checked>
                        <label for="browser-notif">Aktifkan Notifikasi Browser</label>
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="btn btn-primary-custom btn-action" id="simpanNotifikasi">
                    <i class="fas fa-save me-2"></i>Simpan Pengaturan
                </button>
            </div>
        </section>

        <!-- Keamanan & Backup Section -->
        <section id="keamanan-backup" class="settings-section">
            <h2 class="section-title">🔒 Keamanan & Backup</h2>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Frekuensi Backup</label>
                    <select class="form-select">
                        <option value="daily">Harian</option>
                        <option value="weekly" selected>Mingguan</option>
                        <option value="monthly">Bulanan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Lokasi Backup</label>
                    <select class="form-select">
                        <option value="local" selected>Server Lokal</option>
                        <option value="gdrive">Google Drive</option>
                        <option value="dropbox">Dropbox</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Autentikasi 2-Faktor</label>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="2fa-admin">
                        <label for="2fa-admin">Aktifkan 2FA untuk Admin</label>
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="btn btn-primary-custom btn-action" id="backupSekarang">
                    <i class="fas fa-database me-2"></i>Backup Sekarang
                </button>
                <button class="btn btn-secondary-custom btn-action" id="simpanKeamanan">
                    <i class="fas fa-save me-2"></i>Simpan Pengaturan
                </button>
            </div>
        </section>

        <!-- Pusat Bantuan Section -->
        <section id="pusat-bantuan" class="settings-section">
            <h2 class="section-title">❓ Pusat Bantuan</h2>
            
            <div class="help-item">
                <div class="help-question"><i class="fas fa-question"></i> Bagaimana cara menambah venue baru?</div>
                <div class="help-answer">Pergi ke menu Venues, klik tombol "Tambah Venue", isi form yang tersedia dengan informasi lengkap tentang venue, lalu klik "Simpan".</div>
            </div>
            
            <div class="help-item">
                <div class="help-question"><i class="fas fa-question"></i> Bagaimana mengatur jadwal operasional venue?</div>
                <div class="help-answer">Pilih venue dari daftar, lalu buka tab "Jadwal". Atur hari dan jam operasional sesuai kebutuhan, kemudian simpan perubahan.</div>
            </div>
            
            <div class="help-item">
                <div class="help-question"><i class="fas fa-question"></i> Bagaimana melihat laporan booking?</div>
                <div class="help-answer">Pergi ke menu Laporan untuk melihat ringkasan statistik atau menu Pemesanan untuk detail lengkap setiap booking.</div>
            </div>
            
            <div class="help-item">
                <div class="help-question"><i class="fas fa-question"></i> Bagaimana mengelola ulasan dari pengguna?</div>
                <div class="help-answer">Pergi ke menu Dashboard, scroll ke bagian Ulasan Terbaru untuk melihat dan merespon ulasan dari pengguna.</div>
            </div>
            
            <div class="action-buttons">
                <button class="btn btn-primary-custom btn-action" id="perbaruiFAQ">
                    <i class="fas fa-sync-alt me-2"></i>Perbarui FAQ
                </button>
            </div>
        </section>
    </div>

    <!-- Modal Edit Admin -->
    <div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAdminModalLabel">✏ Edit Admin</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" value="Administrator">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="admin@cariarena.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select">
                            <option value="super" selected>Super Admin</option>
                            <option value="venue">Admin Venue</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary-custom" id="simpanEditAdmin">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Admin -->
    <div class="modal fade" id="hapusAdminModal" tabindex="-1" aria-labelledby="hapusAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusAdminModalLabel">🗑 Hapus Admin</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="text-center mb-3">Apakah Anda yakin ingin menghapus admin ini?</h5>
                    <p class="text-center text-muted">Tindakan ini tidak dapat dibatalkan dan akses admin akan dihapus secara permanen.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="konfirmasiHapusAdmin">Ya, Hapus Admin</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Navigasi antar section settings
        const settingsNavItems = document.querySelectorAll('.settings-nav-item');
        const settingsSections = document.querySelectorAll('.settings-section');
        
        settingsNavItems.forEach(item => {
            item.addEventListener('click', function() {
                const target = this.getAttribute('data-target');
                
                settingsNavItems.forEach(navItem => {
                    navItem.classList.remove('active');
                });
                this.classList.add('active');
                
                settingsSections.forEach(section => {
                    section.classList.remove('active');
                });
                
                document.getElementById(target).classList.add('active');
            });
        });

        // Event listeners untuk tombol
        document.getElementById('simpanProfil').addEventListener('click', function() {
            alert('Profil berhasil disimpan!');
        });

        document.getElementById('simpanSistem').addEventListener('click', function() {
            alert('Pengaturan sistem berhasil disimpan!');
        });

        document.getElementById('tambahAdmin').addEventListener('click', function() {
            alert('Admin baru berhasil ditambahkan!');
        });

        document.getElementById('simpanNotifikasi').addEventListener('click', function() {
            alert('Pengaturan notifikasi berhasil disimpan!');
        });

        document.getElementById('backupSekarang').addEventListener('click', function() {
            alert('Backup sedang diproses...');
        });

        document.getElementById('simpanKeamanan').addEventListener('click', function() {
            alert('Pengaturan keamanan berhasil disimpan!');
        });

        document.getElementById('perbaruiFAQ').addEventListener('click', function() {
            alert('FAQ berhasil diperbarui!');
        });

        document.getElementById('simpanEditAdmin').addEventListener('click', function() {
            alert('Data admin berhasil diperbarui!');
            const modal = bootstrap.Modal.getInstance(document.getElementById('editAdminModal'));
            modal.hide();
        });

        document.getElementById('konfirmasiHapusAdmin').addEventListener('click', function() {
            alert('Admin berhasil dihapus!');
            const modal = bootstrap.Modal.getInstance(document.getElementById('hapusAdminModal'));
            modal.hide();
        });
    });
</script>
@endpush