<?php

// app/Models/WbsReport.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WbsReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_anonim',
        'nama_pengadu',
        'email_pengadu',
        'telepon_pengadu',
        'nama_terlapor',
        'wilayah',
        'kategori_pelanggaran',
        'waktu_kejadian',
        'lokasi_kejadian',
        'uraian',
        'lampiran',
        'status',
    ];

    protected $casts = [
        'is_anonim' => 'boolean',
        'waktu_kejadian' => 'datetime',
        'lampiran' => 'array', // auto decode JSON ke array
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
