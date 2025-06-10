<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function tugas()
    {
        return $this->belongsTo('App\Models\Tugas');
    }

    public function review()
    {
        return $this->hasOne(JawabanReview::class, 'jawaban_id');
    }
}
