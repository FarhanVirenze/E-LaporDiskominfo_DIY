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

    // ✅ Tambahkan nik dan nomor_telepon ke fillable
    protected $fillable = ['name', 'email', 'password', 'role', 'nik', 'nomor_telepon'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'user_id');
    }

    public function wbsReports(): HasMany
    {
        return $this->hasMany(WbsReport::class, 'user_id');
    }
}
