<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayah';
    protected $fillable = ['nama'];

    public function wbsReports()
    {
        return $this->hasMany(WbsReport::class);
    }
}
