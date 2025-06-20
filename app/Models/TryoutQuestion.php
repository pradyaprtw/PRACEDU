<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TryoutQuestion extends Model
{
    protected $fillable = ['subtest_id', 'question_text', 'question_type', 'correct_answer'];

    public function subtest()
    {
        return $this->belongsTo(Subtest::class, 'subtest_id');
    }

    public function answers()
    {
        return $this->hasMany(TryoutAnswer::class, 'tryout_question_id');
    }
}
