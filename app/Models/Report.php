<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_anonim',
        'nama_pengadu',
        'email_pengadu',
        'telepon_pengadu',
        'nik',
        'judul',
        'isi',
        'kategori_id',
        'wilayah_id',
        'file',
        'lokasi',        // alamat
        'latitude',      // lintang
        'longitude',     // bujur
        'status',
    ];

    protected $casts = [
        'is_anonim' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public const STATUS_DIAJUKAN = 'Diajukan';
    public const STATUS_DIBACA = 'Dibaca';
    public const STATUS_DIRESPON = 'Direspon';
    public const STATUS_SELESAI = 'Selesai';

    public static function getStatuses()
    {
        return [
            self::STATUS_DIAJUKAN,
            self::STATUS_DIBACA,
            self::STATUS_DIRESPON,
            self::STATUS_SELESAI,
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriUmum::class, 'kategori_id');
    }

    public function wilayah()
    {
        return $this->belongsTo(WilayahUmum::class, 'wilayah_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class, 'report_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'report_id');
    }
}
