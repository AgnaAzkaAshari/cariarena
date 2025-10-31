@extends('admin.layout.app')

@section('title', 'Manajemen Transaksi')

@section('page-title', '💳 Manajemen Transaksi')

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

<!-- Statistik Transaksi -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <small>Total Transaksi Hari Ini</small>
            <h3>{{ $statistik['total_hari_ini'] ?? 0 }}</h3>
            <small>Transaksi</small>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <small>Pendapatan Hari Ini</small>
            <h3>Rp {{ number_format($statistik['pendapatan_hari_ini'] ?? 0, 0, ',', '.') }}</h3>
            <small>Pendapatan</small>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <small>Menunggu Konfirmasi</small>
            <h3>{{ $statistik['pending_count'] ?? 0 }}</h3>
            <small>Transaksi Pending</small>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <small>Transaksi Berhasil</small>
            <h3>{{ $statistik['success_count'] ?? 0 }}</h3>
            <small>Transaksi Success</small>
        </div>
    </div>
</div>

<!-- Search dan Filter -->
<div class="search-filter">
    <form action="{{ route('admin.transaksi.filter') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select class="form-select" name="status">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Berhasil</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Metode Pembayaran</label>
                <select class="form-select" name="metode_pembayaran">
                    <option value="">Semua Metode</option>
                    <option value="transfer bank" {{ request('metode_pembayaran') == 'transfer bank' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="tunai" {{ request('metode_pembayaran') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date" class="form-control" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary-custom">
                    <i class="fas fa-search me-1"></i>Terapkan Filter
                </button>
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-undo me-1"></i>Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Daftar Transaksi -->
<div class="table-container">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h5>📋 Daftar Transaksi</h5>
        <div>
            <span class="badge bg-light text-dark">
                Total: {{ $transaksi->total() }} transaksi
            </span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Pengguna</th>
                    <th>Venue</th>
                    <th>Metode Pembayaran</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $item)
                    <tr>
                        <td class="fw-bold">{{ $item->transaction_number }}</td>
                        <td>{{ $item->pengguna }}</td>
                        <td>{{ $item->nama_venue }}</td>
                        <td>
                            <span class="payment-method">
                                <i class="fas fa-wallet me-1"></i>
                                {{ $item->metode_pembayaran }}
                            </span>
                        </td>
                        <td class="text-success fw-bold">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                        <td>
                            @if($item->status == 'pending')
                                <span class="badge badge-pending">Menunggu</span>
                            @elseif($item->status == 'completed')
                                <span class="badge badge-success">Berhasil</span>
                            @elseif($item->status == 'cancelled')
                                <span class="badge badge-failed">Dibatalkan</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->transaction_date)->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <!-- Tombol Detail -->
                                <button class="btn btn-info text-white" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#detailTransaksiModal" 
                                        data-transaction-id="{{ $item->id }}"
                                        data-transaction-number="{{ $item->transaction_number }}"
                                        data-pengguna="{{ $item->pengguna }}"
                                        data-venue="{{ $item->nama_venue }}"
                                        data-metode="{{ $item->metode_pembayaran }}"
                                        data-amount="{{ $item->amount }}"
                                        data-status="{{ $item->status }}"
                                        data-date="{{ $item->transaction_date }}">
                                    <i class="fas fa-eye text-white"></i>
                                </button>
                                
                                <!-- Tombol Edit -->
                                <button class="btn btn-warning text-white" title="Edit Transaksi" data-bs-toggle="modal" data-bs-target="#editTransaksiModal"
                                        data-transaction-id="{{ $item->id }}"
                                        data-transaction-number="{{ $item->transaction_number }}"
                                        data-pengguna="{{ $item->pengguna }}"
                                        data-venue="{{ $item->nama_venue }}"
                                        data-metode="{{ $item->metode_pembayaran }}"
                                        data-amount="{{ $item->amount }}"
                                        data-status="{{ $item->status }}"
                                        data-date="{{ $item->transaction_date }}">
                                    <i class="fas fa-edit text-white"></i>
                                </button>
                                
                                <!-- Tombol Hapus -->
                                <form action="{{ route('admin.transaksi.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger text-white" title="Hapus Transaksi" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                        <i class="fas fa-trash text-white"></i>
                                    </button>
                                </form>

                                @if($item->status == 'pending')
                                <!-- Tombol Konfirmasi -->
                                <form action="{{ route('admin.transaksi.confirm', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success text-white" title="Konfirmasi" onclick="return confirm('Apakah Anda yakin ingin mengonfirmasi pembayaran ini?')">
                                        <i class="fas fa-check text-white"></i>
                                    </button>
                                </form>
                                
                                <!-- Tombol Tolak -->
                                <form action="{{ route('admin.transaksi.reject', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger text-white" title="Tolak" onclick="return confirm('Apakah Anda yakin ingin menolak pembayaran ini?')">
                                        <i class="fas fa-times text-white"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="empty-state">
                                <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Tidak ada data transaksi</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($transaksi->hasPages())
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            {{ $transaksi->links() }}
        </ul>
    </nav>
    @endif
</div>

<!-- Modal Detail Transaksi -->
<div class="modal fade" id="detailTransaksiModal" tabindex="-1" aria-labelledby="detailTransaksiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-receipt me-2"></i>Detail Transaksi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="transaction-header">
                    <div class="transaction-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="transaction-info">
                        <h4 id="detailKodeTransaksi">-</h4>
                        <p id="detailTanggal">-</p>
                        <span class="badge" id="detailStatusBadge">-</span>
                    </div>
                </div>
                
                <div class="transaction-detail-item">
                    <div class="transaction-detail-label">Pengguna</div>
                    <div class="transaction-detail-value" id="detailPengguna">-</div>
                </div>
                <div class="transaction-detail-item">
                    <div class="transaction-detail-label">Email</div>
                    <div class="transaction-detail-value" id="detailEmail">-</div>
                </div>
                <div class="transaction-detail-item">
                    <div class="transaction-detail-label">Venue</div>
                    <div class="transaction-detail-value" id="detailVenue">-</div>
                </div>
                <div class="transaction-detail-item">
                    <div class="transaction-detail-label">Metode Pembayaran</div>
                    <div class="transaction-detail-value" id="detailMetode">-</div>
                </div>
                <div class="transaction-detail-item">
                    <div class="transaction-detail-label">Jumlah</div>
                    <div class="transaction-detail-value fw-bold text-success" id="detailJumlah">-</div>
                </div>
                <div class="transaction-detail-item">
                    <div class="transaction-detail-label">Status</div>
                    <div class="transaction-detail-value" id="detailStatus">-</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Transaksi -->
<div class="modal fade" id="editTransaksiModal" tabindex="-1" aria-labelledby="editTransaksiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Transaksi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTransaksiForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editTransactionId" name="id">
                    
                    <div class="mb-3">
                        <label for="editPengguna" class="form-label">Pengguna</label>
                        <input type="text" class="form-control" id="editPengguna" name="pengguna" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editVenue" class="form-label">Venue</label>
                        <input type="text" class="form-control" id="editVenue" name="nama_venue" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editMetode" class="form-label">Metode Pembayaran</label>
                        <select class="form-select" id="editMetode" name="metode_pembayaran" required>
                            <option value="transfer bank">Transfer Bank</option>
                            <option value="tunai">Tunai</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editAmount" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="editAmount" name="amount" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-select" id="editStatus" name="status" required>
                            <option value="pending">Menunggu</option>
                            <option value="completed">Berhasil</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editTanggal" class="form-label">Tanggal Transaksi</label>
                        <input type="datetime-local" class="form-control" id="editTanggal" name="transaction_date" required>
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

    .badge-pending {
        background-color: #FEFCBF;
        color: #D69E2E;
    }

    .badge-success {
        background-color: #C6F6D5;
        color: #38A169;
    }

    .badge-failed {
        background-color: #FED7D7;
        color: #E53E3E;
    }

    .payment-method {
        font-size: 12px;
        background: #EBF8FF;
        color: var(--primary-color);
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 500;
    }

    /* ==== BUTTON STYLES ==== */
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

    .btn-info:hover,
    .btn-warning:hover,
    .btn-danger:hover,
    .btn-success:hover {
        transform: translateY(-1px);
        opacity: 0.9;
    }

    /* ==== TEXT WHITE FOR ICONS ==== */
    .btn-info.text-white,
    .btn-warning.text-white,
    .btn-danger.text-white,
    .btn-success.text-white {
        color: white !important;
    }

    .btn-info .fas,
    .btn-warning .fas,
    .btn-danger .fas,
    .btn-success .fas {
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

    /* ==== MODAL STYLES ==== */
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

    .transaction-detail-item {
        display: flex;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }

    .transaction-detail-label {
        font-weight: 600;
        color: var(--text-dark);
        min-width: 150px;
    }

    .transaction-detail-value {
        color: var(--text-light);
    }

    .transaction-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .transaction-icon {
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

    .transaction-info h4 {
        margin: 0 0 5px 0;
        color: var(--text-dark);
        font-size: 18px;
    }

    .transaction-info p {
        margin: 0;
        color: var(--text-light);
        font-size: 14px;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .transaction-header {
            flex-direction: column;
            text-align: center;
        }
        
        .transaction-icon {
            margin-right: 0;
            margin-bottom: 10px;
        }
        
        .btn-group-sm .btn {
            margin: 1px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk mengisi modal detail
        const detailModal = document.getElementById('detailTransaksiModal');
        detailModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            const transactionNumber = button.getAttribute('data-transaction-number');
            const pengguna = button.getAttribute('data-pengguna');
            const venue = button.getAttribute('data-venue');
            const metode = button.getAttribute('data-metode');
            const amount = button.getAttribute('data-amount');
            const status = button.getAttribute('data-status');
            const date = button.getAttribute('data-date');
            
            // Format tanggal
            const transactionDate = new Date(date);
            const formattedDate = transactionDate.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            // Format jumlah
            const formattedAmount = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
            
            // Isi data ke modal
            document.getElementById('detailKodeTransaksi').textContent = transactionNumber;
            document.getElementById('detailTanggal').textContent = formattedDate;
            document.getElementById('detailPengguna').textContent = pengguna;
            document.getElementById('detailEmail').textContent = pengguna;
            document.getElementById('detailVenue').textContent = venue;
            document.getElementById('detailMetode').textContent = metode;
            document.getElementById('detailJumlah').textContent = formattedAmount;
            
            // Update status
            let statusText = '';
            let statusBadgeClass = '';
            
            if (status === 'pending') {
                statusText = 'Menunggu Konfirmasi';
                statusBadgeClass = 'badge-pending';
            } else if (status === 'completed') {
                statusText = 'Berhasil';
                statusBadgeClass = 'badge-success';
            } else if (status === 'cancelled') {
                statusText = 'Dibatalkan';
                statusBadgeClass = 'badge-failed';
            }
            
            document.getElementById('detailStatus').textContent = statusText;
            
            const statusBadge = document.getElementById('detailStatusBadge');
            statusBadge.className = 'badge ' + statusBadgeClass;
            statusBadge.textContent = statusText;
        });

        // Fungsi untuk mengisi modal edit
        const editModal = document.getElementById('editTransaksiModal');
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            const transactionId = button.getAttribute('data-transaction-id');
            const transactionNumber = button.getAttribute('data-transaction-number');
            const pengguna = button.getAttribute('data-pengguna');
            const venue = button.getAttribute('data-venue');
            const metode = button.getAttribute('data-metode');
            const amount = button.getAttribute('data-amount');
            const status = button.getAttribute('data-status');
            const date = button.getAttribute('data-date');
            
            // Format tanggal untuk input datetime-local
            const transactionDate = new Date(date);
            const formattedDate = transactionDate.toISOString().slice(0, 16);
            
            // Isi data ke form edit
            document.getElementById('editTransactionId').value = transactionId;
            document.getElementById('editPengguna').value = pengguna;
            document.getElementById('editVenue').value = venue;
            document.getElementById('editMetode').value = metode;
            document.getElementById('editAmount').value = amount;
            document.getElementById('editStatus').value = status;
            document.getElementById('editTanggal').value = formattedDate;
            
            // Set action form
            document.getElementById('editTransaksiForm').action = `/admin/transaksi/${transactionId}`;
        });
    });
</script>
@endpush