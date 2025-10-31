<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Venue;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Utama
        $totalPengguna = User::count();
        $totalVenue = Venue::count();
        $totalPemesanan = Pemesanan::count();
        
        // Hitung peningkatan pemesanan dari kemarin
        $pemesananKemarin = Pemesanan::whereDate('created_at', Carbon::yesterday())->count();
        $pemesananHariIni = Pemesanan::whereDate('created_at', Carbon::today())->count();
        $peningkatanPemesanan = $pemesananKemarin > 0 ? 
            round((($pemesananHariIni - $pemesananKemarin) / $pemesananKemarin) * 100, 1) : 0;

        // Hitung tingkat okupansi
        $tingkatOkupansi = $this->calculateOccupancyRate();

        // Pemesanan Terbaru (5 terbaru)
        $pemesananTerbaru = Pemesanan::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Venue Populer
        $venuePopuler = $this->getPopularVenues();

        // Notifikasi Terbaru
        $notifikasiTerbaru = $this->getNotifications();

        // Statistik Minggu Ini
        $statistikMingguIni = $this->getWeeklyStats();

        return view('admin.dashboard', compact(
            'totalPengguna',
            'totalVenue',
            'totalPemesanan',
            'peningkatanPemesanan',
            'tingkatOkupansi',
            'pemesananTerbaru',
            'venuePopuler',
            'notifikasiTerbaru',
            'statistikMingguIni'
        ));
    }

    private function calculateOccupancyRate()
    {
        try {
            // Hitung okupansi berdasarkan jumlah pemesanan aktif hari ini
            $totalVenues = Venue::count();
            $pemesananHariIni = Pemesanan::whereDate('waktu_mulai', Carbon::today())
                ->whereIn('status', ['confirmed', 'terkonfirmasi', 'pending', 'menunggu'])
                ->count();
            
            // Asumsi setiap venue bisa menerima 5 pemesanan per hari
            $totalSlot = $totalVenues * 5;
            return $totalSlot > 0 ? round(($pemesananHariIni / $totalSlot) * 100, 1) : 0;
            
        } catch (\Exception $e) {
            return 65; // Default value jika ada error
        }
    }

    private function getPopularVenues()
    {
        try {
            // Hitung venue populer berdasarkan jumlah pemesanan menggunakan query manual
            $venuePopuler = DB::table('venues')
                ->leftJoin('bookings', 'venues.id', '=', 'bookings.venue_id')
                ->select('venues.*', DB::raw('COUNT(bookings.id) as total_pemesanan'))
                ->groupBy('venues.id')
                ->orderBy('total_pemesanan', 'desc')
                ->take(5)
                ->get();

            return $venuePopuler;
        } catch (\Exception $e) {
            // Fallback: ambil 5 venue terbaru jika query error
            return Venue::orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function ($venue) {
                    $venue->total_pemesanan = 0;
                    return $venue;
                });
        }
    }

    private function getWeeklyStats()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        $pemesananMingguIni = Pemesanan::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $pemesananMingguLalu = Pemesanan::whereBetween('created_at', [
            $startOfWeek->copy()->subWeek(), 
            $endOfWeek->copy()->subWeek()
        ])->count();
        
        $peningkatanPemesanan = $pemesananMingguLalu > 0 ? 
            round((($pemesananMingguIni - $pemesananMingguLalu) / $pemesananMingguLalu) * 100, 1) : 0;

        // Hitung pendapatan - GUNAKAN TOTAL_COST
        $pendapatanMingguIni = $this->calculateWeeklyRevenue($startOfWeek, $endOfWeek);
        $pendapatanMingguLalu = $this->calculateWeeklyRevenue(
            $startOfWeek->copy()->subWeek(), 
            $endOfWeek->copy()->subWeek()
        );
        
        $peningkatanPendapatan = $pendapatanMingguLalu > 0 ? 
            round((($pendapatanMingguIni - $pendapatanMingguLalu) / $pendapatanMingguLalu) * 100, 1) : 0;

        return [
            'pemesanan' => $pemesananMingguIni,
            'peningkatan_pemesanan' => $peningkatanPemesanan,
            'pendapatan' => $pendapatanMingguIni,
            'peningkatan_pendapatan' => $peningkatanPendapatan,
            'okupansi' => $this->calculateOccupancyRate(),
            'peningkatan_okupansi' => 5, // Contoh statis
            'pengguna_baru' => User::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count(),
            'peningkatan_pengguna' => 12 // Contoh statis
        ];
    }

    private function calculateWeeklyRevenue($startDate, $endDate)
    {
        try {
            // Coba dari tabel transaksi dulu
            if (class_exists(Transaksi::class)) {
                $revenue = Transaksi::whereBetween('created_at', [$startDate, $endDate])
                    ->where('status', 'success')
                    ->sum('jumlah');
                
                if ($revenue > 0) {
                    return $revenue;
                }
            }
        } catch (\Exception $e) {
            // Continue to fallback
        }

        // GUNAKAN TOTAL_COST dari tabel bookings
        try {
            return Pemesanan::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['confirmed', 'terkonfirmasi', 'selesai', 'Terkonfirmasi'])
                ->sum('total_cost') ?? 0;
        } catch (\Exception $e) {
            // Jika gagal, gunakan estimasi
            $jumlahPemesanan = Pemesanan::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['confirmed', 'terkonfirmasi', 'selesai', 'Terkonfirmasi'])
                ->count();
            
            return $jumlahPemesanan * 150000; // Rp 150.000 per pemesanan
        }
    }

    private function getNotifications()
    {
        return [
            [
                'icon' => 'fa-calendar-check',
                'color' => 'text-success',
                'title' => 'Booking Baru',
                'message' => 'User123 membooking Lapangan Futsal A',
                'time' => '5 menit lalu'
            ],
            [
                'icon' => 'fa-money-bill-wave',
                'color' => 'text-primary',
                'title' => 'Pembayaran Diterima',
                'message' => 'Pembayaran untuk booking #0012 telah diterima',
                'time' => '1 jam lalu'
            ],
            [
                'icon' => 'fa-star',
                'color' => 'text-warning',
                'title' => 'Rating Baru',
                'message' => 'Lapangan Basket B mendapat rating 5 bintang',
                'time' => '2 jam lalu'
            ]
        ];
    }
}