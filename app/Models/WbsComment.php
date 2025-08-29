<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WbsComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'user_id',
        'pesan',
        'file',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id_user');
    }

    /**
     * Relasi ke FollowUp
     */
    public function report()
    {
        return $this->belongsTo(\App\Models\WbsReport::class, 'report_id', 'id');
    }

}
