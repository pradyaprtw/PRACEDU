<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserQuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'attempted_at',
        'answers_submitted', // JSON atau TEXT untuk menyimpan jawaban siswa
    ];

    protected $casts = [
        'attempted_at' => 'datetime',
        'score' => 'float',
        'answers_submitted' => 'array', // Casting ke array jika disimpan sebagai JSON
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}