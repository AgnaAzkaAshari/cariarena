<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        try {
            $query = User::query();
            
            // Filter berdasarkan pencarian
            if (request('search')) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . request('search') . '%')
                      ->orWhere('email', 'like', '%' . request('search') . '%')
                      ->orWhere('user_code', 'like', '%' . request('search') . '%');
                });
            }
            
            // Filter berdasarkan role
            if (request('role')) {
                $query->where('role', request('role'));
            }
            
            // Filter berdasarkan status
            if (request('status')) {
                $query->where('status', request('status'));
            }
            
            $users = $query->latest()->paginate(10);
            
            // Statistik
            $statistik = [
                'totalPengguna' => User::count(),
                'penggunaAktif' => User::where('status', 'Aktif')->count(),
                'penggunaBaru' => User::whereMonth('created_at', now()->month)->count(),
                'tingkatKeterlibatan' => 75,
            ];
            
            return view('admin.manajemen_pengguna', compact('users', 'statistik'));
        } catch (\Exception $e) {
            Log::error('Error di UserController@index: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengambil data pengguna.');
        }
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user);
        } catch (\Exception $e) {
            Log::error('Error di UserController@show: ' . $e->getMessage());
            return response()->json(['error' => 'Pengguna tidak ditemukan'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validasi data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'phone' => 'nullable|string|max:20',
                'role' => 'required|in:user,venue',
                'status' => 'required|in:Aktif,Nonaktif,Ditangguhkan',
                'password' => 'required|string|min:6|confirmed',
            ]);

            // Generate kode pengguna otomatis
            $lastUser = User::orderBy('id', 'desc')->first();
            $nextId = $lastUser ? $lastUser->id + 1 : 1;
            $userCode = 'USR' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

            // Buat pengguna baru
            User::create([
                'user_code' => $userCode,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'role' => $validated['role'],
                'status' => $validated['status'],
                'password' => Hash::make($validated['password']),
            ]);

            return redirect()->route('admin.pengguna.index')
                ->with('success', 'Pengguna berhasil ditambahkan!');

        } catch (\Exception $e) {
            Log::error('Error di UserController@store: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Gagal menambah pengguna: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Validasi data
            $validated = $request->validate([
                'user_code' => 'required|string|unique:users,user_code,' . $id,
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'phone' => 'nullable|string|max:20',
                'role' => 'required|in:user,venue',
                'status' => 'required|in:Aktif,Nonaktif,Ditangguhkan',
            ]);

            // Update data pengguna
            $user->update($validated);

            return redirect()->route('admin.pengguna.index')
                ->with('success', 'Pengguna berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error('Error di UserController@update: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui pengguna: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('admin.pengguna.index')
                ->with('success', 'Pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error di UserController@destroy: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }
}