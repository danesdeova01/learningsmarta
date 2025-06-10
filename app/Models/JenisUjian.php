<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisUjian extends Model
{
    use HasFactory;

    protected $table = 'jenis_ujian';

    protected $fillable = [
        'nama',
        'timer',
    ];

    public $timestamps = true;

    /**
     * Relasi dengan soal
     */
    public function soals()
    {
        return $this->hasMany(Soal::class, 'jenis_ujian', 'nama');
    }
}
