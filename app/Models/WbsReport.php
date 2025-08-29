<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WbsReport extends Model
{
    use HasFactory;

    protected $table = 'wbs_reports';
    protected $primaryKey = 'id';

    protected $fillable = [
        'tracking_id',
        'user_id',
        'is_anonim',
        'nama_pengadu',
        'email_pengadu',
        'telepon_pengadu',
        'nama_terlapor',
        'wilayah_id',
        'kategori_id',
        'waktu_kejadian',
        'lokasi_kejadian',
        'uraian',
        'lampiran',
        'status',
    ];

    protected $casts = [
        'lampiran' => 'array',
        'is_anonim' => 'boolean',
        'waktu_kejadian' => 'datetime',
    ];

    public static function getStatuses(): array
    {
        return ['Diajukan', 'Dibaca', 'Direspon', 'Selesai'];
    }
    /**
     * Generate tracking_id otomatis saat create.
     */
    protected static function booted()
    {
        static::creating(function ($report) {
            if (empty($report->tracking_id)) {
                $report->tracking_id = strtoupper(Str::random(10));
            }
        });
    }

    /**
     * Relasi ke User (pelapor).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    /**
     * Relasi ke Wilayah.
     */
    public function wilayah()
    {
        return $this->belongsTo(WilayahUmum::class, 'wilayah_id');
    }

    /**
     * Relasi ke Kategori.
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriUmum::class, 'kategori_id');
    }

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function followUps()
    {
        return $this->hasMany(\App\Models\WbsFollowUp::class, 'report_id');
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\WbsComment::class, 'report_id');
    }


}
