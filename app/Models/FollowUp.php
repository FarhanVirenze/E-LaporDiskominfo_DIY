<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;

    protected $table = 'follow_ups';

    protected $fillable = [
        'report_id',
        'user_id',
        'pesan',
        'file',
    ];

    /**
     * Relasi ke Report (aduan)
     */
    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id', 'id');
    }

    /**
     * Relasi ke User (pembuat follow up)
     * user_id → users.id_user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    /**
     * Relasi ke Rating
     * Satu followup bisa punya banyak rating
     */
    public function ratings()
    {
        return $this->hasMany(FollowupRating::class, 'followup_id', 'id');
    }

    /**
     * Hitung rata-rata rating followup
     */
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    /**
     * Ambil rating milik user tertentu
     */
    public function userRating($userId)
    {
        return $this->ratings()->where('user_id', $userId)->first();
    }
}
