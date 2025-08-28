<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriUmum extends Model
{
    use HasFactory;
    protected $table = 'kategori_umum';
    protected $fillable = ['nama', 'tipe'];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id_user');
    }
}
