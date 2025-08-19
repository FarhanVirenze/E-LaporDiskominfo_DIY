<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Kolom yang bisa diisi mass-assignment
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nik',
        'nomor_telepon',
        'foto',        // foto internal upload user
        'google_id',   // id akun google
        'avatar',      // avatar dari google
        'email_verified_at', 
        'remember_token',    
    ];

    /**
     * Kolom yang disembunyikan ketika serialisasi
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting kolom ke tipe tertentu
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke laporan aduan
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'user_id', 'id_user');
    }

    /**
     * Relasi ke laporan WBS
     */
    public function wbsReports(): HasMany
    {
        return $this->hasMany(WbsReport::class, 'user_id', 'id_user');
    }

    /**
     * Relasi ke kategori umum (khusus admin)
     */
    public function kategori(): HasMany
    {
        return $this->hasMany(KategoriUmum::class, 'admin_id', 'id_user');
    }
}
