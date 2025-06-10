<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kelas_id',
        'slug',
    ];

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_matapelajaran', 'matapelajaran_id', 'kelas_id');

    }
    public function topiks()
{
    return $this->hasMany(Topik::class,  'matapelajaran_id');
}
}
