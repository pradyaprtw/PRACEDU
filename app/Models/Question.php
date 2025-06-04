<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question_text',
        'question_type', // ENUM: 'multiple_choice', 'essay', dll.
    ];

    protected $casts = [
        'answers' => 'array', // Jika menggunakan Repeater dan menyimpan jawaban di sini
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the answers for the multiple choice question.
     */
    public function answers(): HasMany
    {
        // Ini jika Anda membuat model Answer terpisah
        return $this->hasMany(Answer::class);
    }
}
