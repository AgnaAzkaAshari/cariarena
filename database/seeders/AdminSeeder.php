<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Cek apakah admin sudah ada
        if (!Admin::where('email', 'admin@CariArena.com')->exists()) {
            Admin::create([
                'name' => 'Super Admin',
                'email' => 'admin@CariArena.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]);
            echo "Admin user created successfully!\n";
        } else {
            echo "Admin user already exists.\n";
        }
    }
}