<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    // ✅ FIX: Sesuaikan dengan nama tabel di database
    protected $table = 'bookings';
    
    protected $fillable = [
        'booking_code',
        'customer_name',
        'venue_id',
        'sport_type',
        'booking_date',
        'start_time',
        'end_time',
        'duration',
        'total_cost',
        'status',
        'description'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'total_cost' => 'decimal:2',
        'duration' => 'integer'
    ];

    // ✅ FIX: Tambahkan default values
    protected $attributes = [
        'status' => 'Menunggu, Terkonfirmasi, Selesai, DIbatalkan',
        'sport_type' => 'Futsal, Soccer, Badminton, Basket'
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    // Accessor untuk formatted_date
    public function getFormattedDateAttribute()
    {
        return \Carbon\Carbon::parse($this->booking_date)->translatedFormat('d M Y') . ' ' . 
               \Carbon\Carbon::parse($this->start_time)->format('H:i') . ' - ' . 
               \Carbon\Carbon::parse($this->end_time)->format('H:i');
    }

    // Scope untuk filter status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk search
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('booking_code', 'like', "%{$search}%")
              ->orWhere('customer_name', 'like', "%{$search}%")
              ->orWhere('sport_type', 'like', "%{$search}%")
              ->orWhereHas('venue', function($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              });
        });
    }

    // ✅ FIX: Tambahkan accessor untuk status badge
    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'Menunggu' => 'badge-pending',
            'Terkonfirmasi' => 'badge-confirmed',
            'Selesai' => 'badge-completed',
            'Dibatalkan' => 'badge-cancelled'
        ];

        return $statuses[$this->status] ?? 'badge-pending';
    }
}