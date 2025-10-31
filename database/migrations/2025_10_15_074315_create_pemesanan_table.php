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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->string('customer_name');
            $table->foreignId('venue_id')->constrained()->onDelete('cascade');
            $table->string('sport_type');
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration');
            $table->decimal('total_cost', 12, 2);
            $table->enum('status', ['Menunggu', 'Terkonfirmasi', 'Selesai', 'Dibatalkan'])->default('Menunggu');
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Index untuk pencarian
            $table->index(['booking_date', 'status']);
            $table->index('customer_name');
            $table->index('sport_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};