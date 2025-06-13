<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExamAnswer extends Model
{
    use HasFactory;
    
    // Non-incrementing primary key jika diperlukan, tapi biasanya tidak
    // public $incrementing = false;
    
    protected $fillable = ['user_exam_attempt_id', 'question_id', 'user_answer'];

    public function attempt()
    {
        return $this->belongsTo(UserExamAttempt::class, 'user_exam_attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}