<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_code',
        'name',
        'email',
        'phone',
        'role',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Tabel yang terkait dengan model
     */
    protected $table = 'users';

    /**
     * Primary key yang terkait dengan tabel
     */
    protected $primaryKey = 'id';

    /**
     * Scope untuk pengguna aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Aktif');
    }

    /**
     * Scope untuk pengguna berdasarkan role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Cek apakah pengguna aktif
     */
    public function isActive()
    {
        return $this->status === 'Aktif';
    }

    /**
     * Cek apakah pengguna venue
     */
    public function isVenue()
    {
        return $this->role === 'Venue';
    }

    /**
     * Format tanggal bergabung
     */
    public function getTanggalBergabungAttribute()
    {
        return $this->created_at->format('d M Y');
    }
}