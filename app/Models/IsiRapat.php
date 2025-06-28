<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsiRapat extends Model
{
    use HasFactory;

    protected $table = 'isi_rapats'; // pastikan nama tabel sesuai
    protected $primaryKey = 'id_rapat';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_user',
        'id_agenda',
        'pembahasan',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'id_agenda');
    }
}
