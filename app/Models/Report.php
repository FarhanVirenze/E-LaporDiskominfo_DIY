<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_id',   // <--- Tambahkan ini
        'user_id',
        'admin_id',
        'updated_by',
        'likes',
        'dislikes',
        'is_anonim',
        'is_arsip',      // <--- Tambahkan kolom baru
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
        'is_wbs_admin'
    ];

    protected $casts = [
        'is_anonim' => 'boolean',
        'is_arsip' => 'boolean',    // <--- Tambahkan casting boolean
        'latitude' => 'float',
        'longitude' => 'float',
        'file' => 'array',
    ];

    public const STATUS_DIAJUKAN = 'Diajukan';
    public const STATUS_DIBACA = 'Dibaca';
    public const STATUS_DIRESPON = 'Direspon';
    public const STATUS_SELESAI = 'Selesai';
    public const STATUS_ARSIP = 'Arsip';  // <--- Tambahkan konstanta Arsip

    public static function getStatuses()
    {
        return [
            self::STATUS_DIAJUKAN,
            self::STATUS_DIBACA,
            self::STATUS_DIRESPON,
            self::STATUS_SELESAI,
            self::STATUS_ARSIP, // <--- Tambahkan Arsip
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
        return $this->hasMany(FollowUp::class, 'report_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'report_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id_user');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id_user');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function likedBy($userId)
    {
        return $this->votes()->where('user_id', $userId)->where('vote_type', 'like')->exists();
    }

    public function dislikedBy($userId)
    {
        return $this->votes()->where('user_id', $userId)->where('vote_type', 'dislike')->exists();
    }

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    // (Opsional) Generate tracking_id otomatis jika belum diset
    protected static function booted()
    {
        static::creating(function ($report) {
            if (empty($report->tracking_id)) {
                do {
                    $tanggal = now()->format('dmy'); // 6 digit, misalnya 270725
                    $acak = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT); // 4 digit
                    $report->tracking_id = $tanggal . $acak; // Total 10 digit
                } while (self::where('tracking_id', $report->tracking_id)->exists());
            }

            // Jika is_arsip true → set status Arsip
            if (!isset($report->status)) {
                $report->status = $report->is_arsip ? self::STATUS_ARSIP : self::STATUS_DIAJUKAN;
            }
        });
    }
}
