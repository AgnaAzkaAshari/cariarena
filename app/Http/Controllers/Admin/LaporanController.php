<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $data = [
            'totalBookings' => 150,
            'totalPendapatan' => 42500000,
            'rataRataBooking' => 5,
            'venueTerpopuler' => 'Grand Ballroom',
            'venues' => ['Grand Ballroom', 'Convention Hall', 'Sunrise Hall', 'Ocean View', 'Mountain Resort'],
            'laporan' => [
                [
                    'id' => 1,
                    'kode_booking' => 'BK001',
                    'nama_pemesan' => 'John Doe',
                    'venue' => 'Grand Ballroom',
                    'tanggal_pemesanan' => '2024-01-15 14:00:00',
                    'durasi' => 4,
                    'total' => 2500000,
                    'status' => 'completed'
                ],
                [
                    'id' => 2,
                    'kode_booking' => 'BK002',
                    'nama_pemesan' => 'Jane Smith',
                    'venue' => 'Convention Hall',
                    'tanggal_pemesanan' => '2024-01-16 10:00:00',
                    'durasi' => 6,
                    'total' => 3800000,
                    'status' => 'pending'
                ],
            ]
        ];

        return view('admin.laporan', $data);
    }
}