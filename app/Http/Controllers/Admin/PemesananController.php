<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PemesananController extends Controller
{
    public function index(Request $request)
    {
        try {
            // ✅ FIX: Cek apakah tabel bookings ada
            if (!Schema::hasTable('bookings')) {
                return $this->fallbackView('Tabel bookings belum ada di database. Silakan jalankan migration.');
            }

            $query = Pemesanan::with('venue');
            
            // Search
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('booking_code', 'like', "%{$search}%")
                      ->orWhere('customer_name', 'like', "%{$search}%")
                      ->orWhere('sport_type', 'like', "%{$search}%");
                });
            }
            
            // Filter status
            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }
            
            // Filter sport type
            if ($request->has('sport_type') && !empty($request->sport_type)) {
                $query->where('sport_type', $request->sport_type);
            }
            
            // ✅ FIX: Gunakan paginate dan variabel yang benar
            $pemesanans = $query->latest()->paginate(10);
            
            // ✅ FIX: Perbaiki nama variabel statistik
            try {
                $totalPemesanans = Pemesanan::count();
            } catch (\Exception $e) {
                $totalPemesanans = 0;
            }
            
            try {
                $activePemesanans = Pemesanan::where('status', 'Terkonfirmasi')
                    ->whereDate('booking_date', today())
                    ->count();
            } catch (\Exception $e) {
                $activePemesanans = 0;
            }
            
            try {
                $pendingPemesanans = Pemesanan::where('status', 'Menunggu')->count();
            } catch (\Exception $e) {
                $pendingPemesanans = 0;
            }
            
            // Hitung occupancy rate
            $occupancyRate = 0;
            try {
                $totalSlots = 8; // Asumsi 8 slot per hari
                $bookedSlots = Pemesanan::where('status', 'Terkonfirmasi')
                    ->whereDate('booking_date', '>=', now()->subDays(30))
                    ->sum('duration');
                $occupancyRate = $totalSlots > 0 ? round(($bookedSlots / ($totalSlots * 30)) * 100) : 0;
            } catch (\Exception $e) {
                $occupancyRate = 0;
            }
            
            // ✅ FIX: Jenis olahraga yang tersedia - gunakan data statis jika database kosong
            try {
                $sportTypes = Pemesanan::distinct()->whereNotNull('sport_type')->pluck('sport_type')->toArray();
                // Jika tidak ada data di database, gunakan default
                if (empty($sportTypes)) {
                    $sportTypes = ['Badminton', 'Futsal', 'Soccer', 'Basket'];
                }
            } catch (\Exception $e) {
                $sportTypes = ['Badminton', 'Futsal', 'Soccer', 'Basket'];
            }
            
            // Data venue untuk form tambah
            try {
                // ✅ FIX: Sesuaikan dengan status di model Venue
                $venues = Venue::where('status', 'aktif')->get();
            } catch (\Exception $e) {
                $venues = collect();
            }
            
            return view('admin.pemesanan', compact(
                'pemesanans',
                'totalPemesanans',
                'activePemesanans',
                'pendingPemesanans',
                'occupancyRate',
                'sportTypes',
                'venues'
            ));
            
        } catch (\Exception $e) {
            // Fallback jika ada error
            \Log::error('Error in PemesananController: ' . $e->getMessage());
            return $this->fallbackView('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ✅ FIX: Tambahkan method fallback
    private function fallbackView($errorMessage = null)
    {
        return view('admin.pemesanan', [
            'pemesanans' => \Illuminate\Pagination\LengthAwarePaginator::empty(),
            'totalPemesanans' => 0,
            'activePemesanans' => 0,
            'pendingPemesanans' => 0,
            'occupancyRate' => 0,
            'sportTypes' => ['Badminton', 'Futsal', 'Soccer', 'Basket'],
            'venues' => collect(),
            'error' => $errorMessage
        ]);
    }

public function store(Request $request)
{
    $request->validate([
        'customer_name' => 'required|string|max:255',
        'venue_id' => 'required|exists:venues,id',
        'sport_type' => 'required|string|max:255',
        'booking_date' => 'required|date|after_or_equal:today',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
        'total_cost' => 'required|numeric|min:1000',
        'status' => 'required|in:Menunggu,Terkonfirmasi,Selesai,Dibatalkan',
        'description' => 'nullable|string|max:500'
    ], [
        'customer_name.required' => 'Nama pemesan wajib diisi',
        'venue_id.required' => 'Venue wajib dipilih',
        'sport_type.required' => 'Jenis olahraga wajib dipilih',
        'booking_date.required' => 'Tanggal booking wajib diisi',
        'booking_date.after_or_equal' => 'Tanggal booking tidak boleh kurang dari hari ini',
        'start_time.required' => 'Waktu mulai wajib diisi',
        'end_time.required' => 'Waktu selesai wajib diisi',
        'end_time.after' => 'Waktu selesai harus setelah waktu mulai',
        'total_cost.required' => 'Total biaya wajib diisi',
        'total_cost.min' => 'Total biaya minimal Rp 1.000',
        'status.required' => 'Status wajib dipilih'
    ]);
    
    // Hitung durasi
    $start = \Carbon\Carbon::parse($request->start_time);
    $end = \Carbon\Carbon::parse($request->end_time);
    $duration = $start->diffInHours($end);
    
    // Validasi durasi
    if ($duration <= 0) {
        return redirect()->back()
            ->with('error', 'Durasi booking harus lebih dari 0 jam')
            ->withInput();
    }
    
    // Generate booking code
    $bookingCode = 'BK' . date('YmdHis') . rand(100, 999);
    
    try {
        Pemesanan::create([
            'booking_code' => $bookingCode,
            'customer_name' => $request->customer_name,
            'venue_id' => $request->venue_id,
            'sport_type' => $request->sport_type,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration' => $duration,
            'total_cost' => $request->total_cost,
            'status' => $request->status,
            'description' => $request->description
        ]);
        
        return redirect()->route('admin.pemesanan.index')
            ->with('success', 'Pemesanan berhasil ditambahkan!');
            
    } catch (\Exception $e) {
        \Log::error('Error storing pemesanan: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'Gagal menambahkan pemesanan: ' . $e->getMessage())
            ->withInput();
    }
}
    
    public function show($id)
    {
        try {
            $pemesanan = Pemesanan::with('venue')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'booking_code' => $pemesanan->booking_code,
                    'customer_name' => $pemesanan->customer_name,
                    'venue' => $pemesanan->venue,
                    'sport_type' => $pemesanan->sport_type,
                    'formatted_date' => $pemesanan->formatted_date,
                    'duration' => $pemesanan->duration,
                    'total_cost' => $pemesanan->total_cost,
                    'status' => $pemesanan->status,
                    'description' => $pemesanan->description
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error showing pemesanan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Pemesanan tidak ditemukan'
            ], 404);
        }
    }
    
    public function edit($id)
    {
        try {
            $pemesanan = Pemesanan::findOrFail($id);
            $venues = Venue::where('status', 'aktif')->get();
            
            // ✅ FIX: Gunakan sport types yang sama dengan index
            $sportTypes = Pemesanan::distinct()->whereNotNull('sport_type')->pluck('sport_type')->toArray();
            if (empty($sportTypes)) {
                $sportTypes = ['Badminton', 'Futsal', 'Soccer', 'Basket'];
            }
            
            return view('admin.pemesanan.edit', compact('pemesanan', 'venues', 'sportTypes'));
        } catch (\Exception $e) {
            \Log::error('Error editing pemesanan: ' . $e->getMessage());
            abort(404, 'Pemesanan tidak ditemukan');
        }
    }
    
    public function update(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'venue_id' => 'required|exists:venues,id',
            'sport_type' => 'required|string|max:255',
            'booking_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'total_cost' => 'required|numeric|min:0',
            'status' => 'required|in:Menunggu,Terkonfirmasi,Selesai,Dibatalkan',
            'description' => 'nullable|string'
        ]);
        
        // Hitung durasi
        $start = \Carbon\Carbon::parse($request->start_time);
        $end = \Carbon\Carbon::parse($request->end_time);
        $duration = $start->diffInHours($end);
        
        try {
            $pemesanan->update([
                'customer_name' => $request->customer_name,
                'venue_id' => $request->venue_id,
                'sport_type' => $request->sport_type,
                'booking_date' => $request->booking_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'duration' => $duration,
                'total_cost' => $request->total_cost,
                'status' => $request->status,
                'description' => $request->description
            ]);
            
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Pemesanan berhasil diperbarui!']);
            }
            
            return redirect()->route('admin.pemesanan.index')
                ->with('success', 'Pemesanan berhasil diperbarui!');
                
        } catch (\Exception $e) {
            \Log::error('Error updating pemesanan: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui pemesanan: ' . $e->getMessage()]);
            }
            
            return redirect()->back()
                ->with('error', 'Gagal memperbarui pemesanan: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    public function destroy($id)
    {
        try {
            $pemesanan = Pemesanan::findOrFail($id);
            $pemesanan->delete();
            
            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Pemesanan berhasil dihapus!']);
            }
            
            return redirect()->route('admin.pemesanan.index')
                ->with('success', 'Pemesanan berhasil dihapus!');
                
        } catch (\Exception $e) {
            \Log::error('Error deleting pemesanan: ' . $e->getMessage());
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus pemesanan: ' . $e->getMessage()]);
            }
            
            return redirect()->back()
                ->with('error', 'Gagal menghapus pemesanan: ' . $e->getMessage());
        }
    }

    // ✅ FIX: Tambahkan method untuk konfirmasi pemesanan
    public function confirm($id)
    {
        try {
            $pemesanan = Pemesanan::findOrFail($id);
            $pemesanan->update(['status' => 'Terkonfirmasi']);
            
            return redirect()->route('admin.pemesanan.index')
                ->with('success', 'Pemesanan berhasil dikonfirmasi!');
                
        } catch (\Exception $e) {
            \Log::error('Error confirming pemesanan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal mengonfirmasi pemesanan: ' . $e->getMessage());
        }
    }

    // ✅ FIX: Tambahkan method untuk batalkan pemesanan
    public function cancel($id)
    {
        try {
            $pemesanan = Pemesanan::findOrFail($id);
            $pemesanan->update(['status' => 'Dibatalkan']);
            
            return redirect()->route('admin.pemesanan.index')
                ->with('success', 'Pemesanan berhasil dibatalkan!');
                
        } catch (\Exception $e) {
            \Log::error('Error cancelling pemesanan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal membatalkan pemesanan: ' . $e->getMessage());
        }
    }

    // ✅ FIX: Tambahkan method untuk selesaikan pemesanan
    public function complete($id)
    {
        try {
            $pemesanan = Pemesanan::findOrFail($id);
            $pemesanan->update(['status' => 'Selesai']);
            
            return redirect()->route('admin.pemesanan.index')
                ->with('success', 'Pemesanan berhasil diselesaikan!');
                
        } catch (\Exception $e) {
            \Log::error('Error completing pemesanan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menyelesaikan pemesanan: ' . $e->getMessage());
        }
    }
}