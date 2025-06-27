<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_agenda'; // WAJIB agar relasi ke isi_rapats berhasil
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_user',
        'id_ruangan',
        'nm_agenda',
        'tanggal',
        'waktu',
        'deskripsi',
        'status',
        'approved_by',
        'approved_at',
        'id_pic'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function isiRapats()
    {
        return $this->hasMany(IsiRapat::class, 'id_agenda', 'id_agenda');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id_user');
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'id_pic', 'id_user');
    }
}
