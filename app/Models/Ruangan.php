<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_ruangan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['nm_ruangan', 'lokasi', 'kapasitas'];

    public function agendas() {
        return $this->hasMany(Agenda::class, 'id_ruangan');
    }
}
