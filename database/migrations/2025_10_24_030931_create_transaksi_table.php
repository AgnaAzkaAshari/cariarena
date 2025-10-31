<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number', 20)->unique();
            $table->integer('customer_id')->nullable();
            $table->string('pengguna', 100);
            $table->string('nama_venue', 150);
            $table->string('metode_pembayaran', 50);
            $table->decimal('amount', 15, 2);
            $table->date('transaction_date');
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};