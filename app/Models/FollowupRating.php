<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowupRating extends Model
{
    use HasFactory;

    protected $table = 'followup_ratings';

    protected $fillable = [
        'followup_id',
        'user_id',
        'rating',
        'komentar',
    ];

    /**
     * Relasi ke FollowUp
     */
    public function followup()
    {
        return $this->belongsTo(FollowUp::class, 'followup_id', 'id');
    }

    /**
     * Relasi ke User (pemberi rating)
     * user_id → users.id_user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
