@extends('admin.layout.app')

@section('title', 'Laporan - CariArena')
@section('page-title', '📊 Laporan dan Analitik')

@push('styles')
<style>
    /* Additional styles specific to laporan page */
    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
    }

    .table {
        margin-bottom: 0;
        width: 100%;
    }

    .table thead th {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 15px;
        font-weight: 600;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-color: #f1f5f9;
        white-space: nowrap;
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

    /* Chart Container */
    .chart-container {
        position: relative;
        height: 300px;
    }

    /* Filter Section */
    .filter-card {
        background: var(--card-bg);
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        margin-bottom: 24px;
    }

    /* Style untuk input tanggal yang tersembunyi */
    .date-inputs {
        display: none;
    }
    
    .date-inputs.active {
        display: block;
    }
    
    /* Filter row yang lebih kompak */
    .filter-row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: flex-end;
    }
    
    .filter-group {
        flex: 1;
        min-width: 150px;
    }
    
    /* Button group untuk export */
    .export-buttons {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }
    
    /* Perbaikan untuk header laporan */
    .laporan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .laporan-controls {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    /* Perbaikan untuk tabel agar lebih responsif */
    .table-container {
        overflow-x: auto;
        width: 100%;
    }
    
    /* Status badge yang lebih konsisten */
    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    /* Perbaikan untuk kolom aksi */
    .action-cell {
        white-space: nowrap;
        width: 1%;
    }
</style>
@endpush

@section('content')
    <!-- Filter Section -->
    <div class="filter-card">
        <div class="section-header d-flex justify-content-between align-items-center">
            <h5>🔍 Filter Laporan</h5>
        </div>
        <div class="section-body">
            <div class="filter-row">
                <div class="filter-group">
                    <label class="form-label">Periode</label>
                    <select class="form-select" id="periode">
                        <option value="hari-ini">Hari Ini</option>
                        <option value="minggu-ini" selected>Minggu Ini</option>
                        <option value="bulan-ini">Bulan Ini</option>
                        <option value="tahun-ini">Tahun Ini</option>
                        <option value="custom">Kustom</option>
                    </select>
                </div>
                <div class="filter-group date-inputs" id="customDateInputs">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" id="dariTanggal">
                </div>
                <div class="filter-group date-inputs" id="customDateInputs">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="sampaiTanggal">
                </div>
                <div class="filter-group">
                    <label class="form-label">Jenis Laporan</label>
                    <select class="form-select" id="jenisLaporan">
                        <option value="semua" selected>Semua Laporan</option>
                        <option value="booking">Booking</option>
                        <option value="pendapatan">Pendapatan</option>
                        <option value="venue">Venue</option>
                        <option value="pengguna">Pengguna</option>
                    </select>
                </div>
                <div class="filter-group">
                    <button class="lihat-semua-btn w-100" id="generateLaporan">
                        <i class="fas fa-sync-alt me-1"></i>Generate Laporan
                    </button>
                </div>
                <div class="filter-group">
                    <button class="btn btn-outline-secondary w-100" id="resetFilter">
                        <i class="fas fa-undo me-1"></i>Reset Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <small>Total Booking</small>
                <h3>{{ number_format($totalPemesanan ?? 1250) }}</h3>
                <small>Booking terdaftar</small>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <small>Total Pendapatan</small>
                <h3>Rp {{ number_format($totalPendapatan ?? 125000000) }}</h3>
                <small class="text-success">+12% dari bulan lalu</small>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <small>Rata-rata Booking/Hari</small>
                <h3>{{ $rataBookingPerHari ?? 42 }}</h3>
                <small class="text-success">+5% dari minggu lalu</small>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <small>Venue Terpopuler</small>
                <h3>{{ $venueTerpopuler ?? 'Lapangan Voli Sentra' }}</h3>
                <small>{{ $jumlahPemesananVenue ?? 45 }}x dipesan bulan ini</small>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <!-- Revenue Chart -->
        <div class="col-md-8">
            <div class="dashboard-section">
                <div class="section-header d-flex justify-content-between align-items-center">
                    <h5>📈 Pendapatan Bulanan</h5>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-primary active" data-period="bulanan">Bulanan</button>
                        <button type="button" class="btn btn-outline-primary" data-period="mingguan">Mingguan</button>
                    </div>
                </div>
                <div class="section-body">
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Venue Distribution Chart -->
        <div class="col-md-4">
            <div class="dashboard-section">
                <div class="section-header">
                    <h5>🥧 Distribusi Booking per Venue</h5>
                </div>
                <div class="section-body">
                    <div class="chart-container">
                        <canvas id="venueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan List -->
    <div class="dashboard-section">
        <div class="section-header">
            <div class="laporan-header">
                <h5>📋 Detail Laporan Booking</h5>
                <div class="laporan-controls">
                    <div class="export-buttons">
                        <button type="button" class="btn btn-outline-danger" id="exportPdf">
                            <i class="fas fa-file-pdf me-1"></i>PDF
                        </button>
                        <button type="button" class="btn btn-outline-success" id="exportExcel">
                            <i class="fas fa-file-excel me-1"></i>Excel
                        </button>
                    </div>
                    <input type="text" id="search-laporan" class="form-control form-control-sm" placeholder="Cari laporan...">
                    <select id="filter-venue" class="form-select form-select-sm">
                        <option value="">Semua Venue</option>
                        <option value="voli">Lapangan Voli Sentra</option>
                        <option value="bulutangkis">Gor Bulutangkis Merdeka</option>
                        <option value="futsal">Lapangan Futsal Champion</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-striped" id="laporanTable">
                        <thead>
                            <tr>
                                <th>Kode Booking</th>
                                <th>Nama Pemesan</th>
                                <th>Venue</th>
                                <th>Tanggal Booking</th>
                                <th>Durasi</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="action-cell">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>BK001</strong></td>
                                <td>Ahmad Santoso</td>
                                <td>Lapangan Voli Sentra</td>
                                <td>15 Mar 2023 14:00</td>
                                <td>2 jam</td>
                                <td>Rp 150.000</td>
                                <td><span class="badge badge-success">Selesai</span></td>
                                <td class="action-cell">
                                    <button class="btn btn-info btn-sm view-detail" data-id="1" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>BK002</strong></td>
                                <td>Budi Pratama</td>
                                <td>Gor Bulutangkis Merdeka</td>
                                <td>15 Mar 2023 18:00</td>
                                <td>3 jam</td>
                                <td>Rp 200.000</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                                <td class="action-cell">
                                    <button class="btn btn-info btn-sm view-detail" data-id="2" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>BK003</strong></td>
                                <td>Cici Amelia</td>
                                <td>Lapangan Futsal Champion</td>
                                <td>14 Mar 2023 19:00</td>
                                <td>2 jam</td>
                                <td>Rp 180.000</td>
                                <td><span class="badge badge-success">Selesai</span></td>
                                <td class="action-cell">
                                    <button class="btn btn-info btn-sm view-detail" data-id="3" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Detail content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="printDetail">Cetak</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Charts
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const venueCtx = document.getElementById('venueChart').getContext('2d');

        const revenueChart = new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pendapatan (Juta Rp)',
                    data: [12, 19, 15, 17, 22, 25, 28, 26, 24, 30, 32, 35],
                    backgroundColor: 'rgba(99, 179, 237, 0.6)',
                    borderColor: 'rgba(99, 179, 237, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const venueChart = new Chart(venueCtx, {
            type: 'doughnut',
            data: {
                labels: ['Lapangan Voli', 'Gor Bulutangkis', 'Lapangan Futsal', 'Kolam Renang', 'Lapangan Basket'],
                datasets: [{
                    data: [30, 25, 15, 20, 10],
                    backgroundColor: [
                        'rgba(99, 179, 237, 0.6)',
                        'rgba(34, 197, 94, 0.6)',
                        'rgba(59, 130, 246, 0.6)',
                        'rgba(245, 158, 11, 0.6)',
                        'rgba(139, 92, 246, 0.6)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Toggle date inputs based on period selection
        const periodeSelect = document.getElementById('periode');
        const dateInputs = document.querySelectorAll('.date-inputs');
        
        function toggleDateInputs() {
            if (periodeSelect.value === 'custom') {
                dateInputs.forEach(input => input.classList.add('active'));
            } else {
                dateInputs.forEach(input => input.classList.remove('active'));
            }
        }
        
        periodeSelect.addEventListener('change', toggleDateInputs);
        toggleDateInputs(); // Initialize on page load

        // Search and Filter functionality
        const searchInput = document.getElementById('search-laporan');
        const filterVenue = document.getElementById('filter-venue');
        const table = document.getElementById('laporanTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        function filterLaporan() {
            const searchTerm = searchInput.value.toLowerCase();
            const venueFilter = filterVenue.value;

            for (let row of rows) {
                const kode = row.cells[0].textContent.toLowerCase();
                const nama = row.cells[1].textContent.toLowerCase();
                const venue = row.cells[2].textContent.toLowerCase();

                const matchesSearch = kode.includes(searchTerm) || nama.includes(searchTerm);
                const matchesVenue = !venueFilter || venue.includes(venueFilter.toLowerCase());

                row.style.display = matchesSearch && matchesVenue ? '' : 'none';
            }
        }

        searchInput.addEventListener('input', filterLaporan);
        filterVenue.addEventListener('change', filterLaporan);

        // Chart period toggle
        const periodButtons = document.querySelectorAll('[data-period]');
        periodButtons.forEach(button => {
            button.addEventListener('click', function() {
                periodButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // In real application, this would update the chart data
                console.log('Switching to:', this.dataset.period);
            });
        });

        // Export buttons
        document.getElementById('exportPdf').addEventListener('click', function() {
            alert('Fitur export PDF akan diimplementasikan');
        });

        document.getElementById('exportExcel').addEventListener('click', function() {
            alert('Fitur export Excel akan diimplementasikan');
        });

        // Generate Laporan
        document.getElementById('generateLaporan').addEventListener('click', function() {
            const periode = document.getElementById('periode').value;
            const jenisLaporan = document.getElementById('jenisLaporan').value;
            
            alert(`Generating laporan untuk periode: ${periode}, jenis: ${jenisLaporan}`);
            // In real application, this would make an API call to generate report
        });

        // Reset Filter
        document.getElementById('resetFilter').addEventListener('click', function() {
            document.getElementById('periode').value = 'minggu-ini';
            document.getElementById('jenisLaporan').value = 'semua';
            document.getElementById('dariTanggal').value = '';
            document.getElementById('sampaiTanggal').value = '';
            searchInput.value = '';
            filterVenue.value = '';
            filterLaporan();
            toggleDateInputs();
        });

        // View Detail
        const viewButtons = document.querySelectorAll('.view-detail');
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));

        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                // In real application, this would fetch detail data from server
                document.getElementById('modalBody').innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Informasi Booking</h6>
                            <p><strong>Kode Booking:</strong> BK${id.toString().padStart(3, '0')}</p>
                            <p><strong>Nama Pemesan:</strong> John Doe</p>
                            <p><strong>Venue:</strong> Lapangan Voli Sentra</p>
                            <p><strong>Tanggal:</strong> 15 Mar 2023 14:00</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Detail Pembayaran</h6>
                            <p><strong>Total:</strong> Rp 150.000</p>
                            <p><strong>Status:</strong> <span class="badge badge-success">Selesai</span></p>
                            <p><strong>Metode Bayar:</strong> Transfer Bank</p>
                            <p><strong>Waktu Bayar:</strong> 15 Mar 2023 13:45</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Rincian Biaya</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td>Biaya Sewa Venue (2 jam)</td>
                                    <td>Rp 120.000</td>
                                </tr>
                                <tr>
                                    <td>Biaya Layanan</td>
                                    <td>Rp 20.000</td>
                                </tr>
                                <tr>
                                    <td>Pajak</td>
                                    <td>Rp 10.000</td>
                                </tr>
                                <tr class="table-active">
                                    <td><strong>Total</strong></td>
                                    <td><strong>Rp 150.000</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                `;
                modal.show();
            });
        });

        // Print Detail
        document.getElementById('printDetail').addEventListener('click', function() {
            window.print();
        });
    });
</script>
@endpush