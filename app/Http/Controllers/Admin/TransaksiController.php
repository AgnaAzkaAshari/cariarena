<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        try {
            $transaksi = Transaksi::latest()->paginate(10);
            $statistik = [
                'total_hari_ini' => Transaksi::whereDate('transaction_date', today())->count(),
                'pendapatan_hari_ini' => Transaksi::whereDate('transaction_date', today())->where('status', 'completed')->sum('amount'),
                'pending_count' => Transaksi::where('status', 'pending')->count(),
                'success_count' => Transaksi::where('status', 'completed')->count(),
            ];
            
            // PERBAIKAN: Gunakan view yang benar - 'admin.transaksi'
            return view('admin.transaksi', compact('transaksi', 'statistik'));
        } catch (\Exception $e) {
            // Debug: Tampilkan error
            dd('Error loading view: ' . $e->getMessage());
        }
    }

    public function filter(Request $request)
    {
        $query = Transaksi::query();
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->metode_pembayaran) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }
        
        if ($request->tanggal_mulai) {
            $query->whereDate('transaction_date', '>=', $request->tanggal_mulai);
        }
        
        if ($request->tanggal_selesai) {
            $query->whereDate('transaction_date', '<=', $request->tanggal_selesai);
        }
        
        $transaksi = $query->latest()->paginate(10);
        
        $statistik = [
            'total_hari_ini' => $transaksi->count(),
            'pendapatan_hari_ini' => $transaksi->where('status', 'completed')->sum('amount'),
            'pending_count' => $transaksi->where('status', 'pending')->count(),
            'success_count' => $transaksi->where('status', 'completed')->count(),
        ];
        
        // PERBAIKAN: Gunakan view yang benar
        return view('admin.transaksi', compact('transaksi', 'statistik'));
    }

    public function show(Transaksi $transaksi)
    {
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'pengguna' => 'required|string',
            'nama_venue' => 'required|string',
            'metode_pembayaran' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,completed,cancelled',
            'transaction_date' => 'required|date',
        ]);

        $transaksi->update($validated);

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function confirmPayment(Transaksi $transaksi)
    {
        $transaksi->update(['status' => 'completed']);
        
        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dikonfirmasi.');
    }

    public function rejectPayment(Transaksi $transaksi)
    {
        $transaksi->update(['status' => 'cancelled']);
        
        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil ditolak.');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}