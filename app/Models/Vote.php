<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['user_id', 'report_id', 'vote_type'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function report() {
        return $this->belongsTo(Report::class);
    }
}