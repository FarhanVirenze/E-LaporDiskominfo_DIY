<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_notif';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_user',
        'jenis_notif',
        'keterangan',
        'status',
        'tanggal',
        'waktu'
    ];

    /**
     * Relasi ke pengguna (user) yang menerima notifikasi
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
