<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TryoutPackageAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'total_questions',
        'correct_answers',
        'score_percentage'
    ];    
}
