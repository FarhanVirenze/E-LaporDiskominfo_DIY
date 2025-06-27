<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsiRapat extends Model
{
    use HasFactory;

    // Menyesuaikan primary key tabel jika bukan 'id'
    protected $primaryKey = 'id_rapat';
    public $incrementing = true;
    protected $keyType = 'int';

    // Kolom-kolom yang dapat diisi
    protected $fillable = [
        'id_user',
        'id_agenda',
        'pembahasan',
        'status',
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'id_agenda', 'id_agenda');
    }
}
