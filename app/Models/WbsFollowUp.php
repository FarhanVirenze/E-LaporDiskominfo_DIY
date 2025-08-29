<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WbsFollowUp extends Model
{
    protected $table = 'wbs_follow_ups';

    protected $fillable = [
        'report_id',
        'user_id',
        'deskripsi',
        'lampiran',
    ];

    // Relasi ke laporan utama
    public function report()
    {
        return $this->belongsTo(WbsReport::class, 'report_id', 'id');
    }

    // Relasi ke user yang menindaklanjuti
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
