<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function matapelajaran()
    {
        // Relasi ke mata pelajaran via matapelajaran_id
        return $this->belongsTo(MataPelajaran::class, 'matapelajaran_id');
    }
}
