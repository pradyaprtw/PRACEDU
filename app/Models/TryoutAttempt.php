<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TryoutAttempt extends Model
{
    protected $fillable = ['user_id', 'subtest_id', 'total_questions', 'correct_answers', 'score_percentage'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subtest()
    {
        return $this->belongsTo(Subtest::class);
    }
}
