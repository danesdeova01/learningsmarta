<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'konten',
        'matapelajaran_id',
        'kelas_id',
        'file',
        'due_date',
    ];

    public function jawabans()
    {
        return $this->hasMany('App\Models\Jawaban');
    }

    public function matapelajaran()
    {
        return $this->belongsTo('App\Models\MataPelajaran');
    }
   
    public function kelas()
{
    return $this->belongsTo('App\Models\Kelas');
}

}
