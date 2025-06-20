<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TryoutAnswer extends Model
{
    protected $fillable = ['tryout_question_id', 'option_label', 'answer_text', 'is_correct'];

    public function question()
    {
        return $this->belongsTo(TryoutQuestion::class, 'tryout_question_id');
    }
}
