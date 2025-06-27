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

    protected $fillable = ['name', 'nidn', 'email', 'password', 'role', 'jabatan'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi ke agenda yang dibuat user
    public function agendas(): HasMany
    {
        return $this->hasMany(Agenda::class, 'id_user');
    }

    // Relasi ke isi rapat yang ditulis user
    public function isiRapats(): HasMany
    {
        return $this->hasMany(IsiRapat::class, 'id_user');
    }

    // Relasi ke notifikasi untuk user
    public function notifs(): HasMany
    {
        return $this->hasMany(Notif::class, 'id_user');
    }

    // Relasi ke agenda yang disetujui oleh user ini (jika dia pimpinan atau admin)
    public function approvedAgendas(): HasMany
    {
        return $this->hasMany(Agenda::class, 'approved_by');
    }
}
