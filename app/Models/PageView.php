<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $table = 'views'; // tabel views
    public $timestamps = false;

    protected $fillable = [
        'viewable_type',
        'viewable_id',
        'visitor',      // hash gabungan
        'ip_address',   // ip asli
        'user_agent',   // user agent asli
        'collection',
        'viewed_at',
    ];
}
