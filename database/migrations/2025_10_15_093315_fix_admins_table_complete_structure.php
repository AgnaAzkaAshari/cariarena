<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Tambahkan semua kolom yang diperlukan
            if (!Schema::hasColumn('admins', 'name')) {
                $table->string('name')->after('id');
            }
            
            if (!Schema::hasColumn('admins', 'email')) {
                $table->string('email')->unique()->after('name');
            }
            
            if (!Schema::hasColumn('admins', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }
            
            if (!Schema::hasColumn('admins', 'password')) {
                $table->string('password')->after('email_verified_at');
            }
            
            if (!Schema::hasColumn('admins', 'remember_token')) {
                $table->rememberToken()->after('password');
            }
        });
    }

    public function down(): void
    {
        // Tidak perlu reverse untuk fix migration
    }
};