<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function matapelajarans()
    {
        return $this->belongsToMany(MataPelajaran::class, 'kelas_matapelajaran', 'kelas_id', 'matapelajaran_id');
    }
    protected $table = 'kelas'; // pastikan nama tabel benar

    public function siswa()
    {
        return $this->hasMany(\App\Models\User::class, 'kelas_id', 'id')
            ->where('level', 'mahasiswa');
    }



    public function materis()
    {
        return $this->hasMany(Topik::class, "kelas_id", "id");
    }
}