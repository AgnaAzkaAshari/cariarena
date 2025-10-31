<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    // ✅ FIX: Tambahkan fillable properties
    protected $fillable = [
        'name',
        'location', 
        'sport_type',
        'facilities',
        'price_per_hour',
        'status',
        'description',
        'rating'
    ];

    protected $casts = [
        'price_per_hour' => 'decimal:2',
        'rating' => 'decimal:1'
    ];

    // ✅ FIX: Definisikan nilai status yang valid
    public const STATUS_ACTIVE = 'aktif';
    public const STATUS_MAINTENANCE = 'perawatan';
    public const STATUS_INACTIVE = 'nonaktif';

    // ✅ FIX: Method untuk mendapatkan daftar status
    public static function getStatusOptions()
    {
        return [
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_MAINTENANCE => 'Perawatan',
            self::STATUS_INACTIVE => 'Nonaktif'
        ];
    }

    // ✅ FIX: Tambahkan method untuk handle status badge dengan benar
    public function getStatusBadgeAttribute()
    {
        $statuses = [
            self::STATUS_ACTIVE => ['class' => 'badge badge-success', 'text' => 'Aktif'],
            self::STATUS_MAINTENANCE => ['class' => 'badge badge-warning', 'text' => 'Perawatan'],
            self::STATUS_INACTIVE => ['class' => 'badge badge-danger', 'text' => 'Nonaktif']
        ];

        return $statuses[$this->status] ?? $statuses[self::STATUS_INACTIVE];
    }

    // ✅ FIX: Method untuk mengecek status
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isUnderMaintenance()
    {
        return $this->status === self::STATUS_MAINTENANCE;
    }

    public function isInactive()
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    // ✅ FIX: Scope query untuk status tertentu
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeMaintenance($query)
    {
        return $query->where('status', self::STATUS_MAINTENANCE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    // ✅ FIX: Relasi dengan pemesanan
    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class);
    }

    // ✅ FIX: Accessor untuk format harga
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price_per_hour, 0, ',', '.') . '/jam';
    }

    // ✅ FIX: Accessor untuk fasilitas sebagai array
    public function getFacilitiesArrayAttribute()
    {
        if (empty($this->facilities)) {
            return [];
        }
        
        return explode(',', $this->facilities);
    }

    // ✅ FIX: Method untuk update status
    public function markAsActive()
    {
        $this->update(['status' => self::STATUS_ACTIVE]);
    }

    public function markAsMaintenance()
    {
        $this->update(['status' => self::STATUS_MAINTENANCE]);
    }

    public function markAsInactive()
    {
        $this->update(['status' => self::STATUS_INACTIVE]);
    }

    // ✅ FIX: Validation rules untuk create/update
    public static function getValidationRules($venueId = null)
    {
        return [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'sport_type' => 'required|string|max:100',
            'facilities' => 'nullable|string',
            'price_per_hour' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,perawatan,nonaktif',
            'description' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5'
        ];
    }
}