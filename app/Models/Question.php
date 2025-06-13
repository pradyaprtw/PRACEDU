<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question_text', 'options', 'correct_answer', 'exam_id'];

    protected $casts = [
        'options' => 'array', // Otomatis cast kolom JSON ke array
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
