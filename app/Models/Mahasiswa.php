<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'users';

    public $timestamps = true;

    protected $guarded = [];



    protected static function booted(): void
    {
        static::addGlobalScope('mahasiswa', function (Builder $builder) {
            $builder->where('level', 'mahasiswa');
        });
    }


    public function kelas()
    {
        return $this->belongsTo(Kelas::class, "kelas_id");
    }
}
