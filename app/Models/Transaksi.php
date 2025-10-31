<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Jika nama tabel berbeda dengan nama model
    protected $table = 'transactions';

    protected $fillable = [
        'transaction_number',
        'pengguna',
        'nama_venue', 
        'metode_pembayaran',
        'amount',
        'status',
        'transaction_date'
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'amount' => 'decimal:2'
    ];
}