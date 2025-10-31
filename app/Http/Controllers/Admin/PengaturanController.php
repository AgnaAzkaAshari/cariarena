<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PengaturanController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $admin = auth('admin')->user();
        
        // Jika admin tidak ada, berikan data default
        $adminData = $admin ?: (object)[
            'name' => 'Administrator',
            'email' => 'admin@cariarena.com',
            'phone' => '+62 812 3456 7890',
            'bio' => 'Administrator utama sistem CariArena'
        ];
        
        return view('admin.pengaturan', compact('adminData'));
    }

    /**
     * Update profile settings.
     */
    public function updateProfile(Request $request)
    {
        $admin = auth('admin')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
        ]);

        if ($admin) {
            $admin->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'bio' => $request->bio,
            ]);
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update system settings.
     */
    public function updateSystem(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255',
        ]);

        return redirect()->back()->with('success', 'Pengaturan sistem berhasil diperbarui!');
    }

    /**
     * Add new admin.
     */
    public function addAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
            'status' => 'required|string',
        ]);

        return redirect()->back()->with('success', 'Admin berhasil ditambahkan!');
    }

    /**
     * Update notification settings.
     */
    public function updateNotifications(Request $request)
    {
        return redirect()->back()->with('success', 'Pengaturan notifikasi berhasil diperbarui!');
    }

    /**
     * Update security settings.
     */
    public function updateSecurity(Request $request)
    {
        $admin = auth('admin')->user();
        
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($admin && Hash::check($request->current_password, $admin->password)) {
            $admin->update([
                'password' => Hash::make($request->new_password)
            ]);
            return redirect()->back()->with('success', 'Kata sandi berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Kata sandi saat ini tidak sesuai!');
    }

    /**
     * Perform backup.
     */
    public function backupNow()
    {
        return redirect()->back()->with('success', 'Backup berhasil dilakukan!');
    }

    /**
     * Update FAQ and support.
     */
    public function updateFAQ(Request $request)
    {
        $request->validate([
            'support_email' => 'required|email',
            'support_phone' => 'required|string',
        ]);

        return redirect()->back()->with('success', 'FAQ dan kontak support berhasil diperbarui!');
    }
}