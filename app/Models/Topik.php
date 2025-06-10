<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topik extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'matapelajaran_id', 'kelas_id', 'konten', 'file'];

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'matapelajaran_id'); // sesuaikan foreign key jika perlu
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
