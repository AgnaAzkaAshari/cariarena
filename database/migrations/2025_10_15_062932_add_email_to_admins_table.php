<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Tambahkan email jika belum ada
            if (!Schema::hasColumn('admins', 'email')) {
                $table->string('email')->unique()->after('id');
            }

            // Tambahkan password jika belum ada
            if (!Schema::hasColumn('admins', 'password')) {
                $table->string('password')->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Hanya drop jika kolom ada
            if (Schema::hasColumn('admins', 'email')) {
                $table->dropColumn('email');
            }

            if (Schema::hasColumn('admins', 'password')) {
                $table->dropColumn('password');
            }
        });
    }
};
