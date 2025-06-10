<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    protected $table = 'hasil_ujian';

    protected $fillable = [
        'user_id',
        'matapelajaran_id',
        'jenis_ujian',
        'jumlah_soal',
        'jawaban_benar',
        'nilai',
        'tanggal_ujian',
    ];

    protected $casts = [
        'tanggal_ujian' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function matapelajaran()
    {
        return $this->belongsTo(\App\Models\Matapelajaran::class);
    }
}
