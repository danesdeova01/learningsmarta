<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanReview extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'jawaban_review';

    public function jawaban()
    {
        return $this->belongsTo(Jawaban::class, 'jawaban_id', 'id');
    }
}
