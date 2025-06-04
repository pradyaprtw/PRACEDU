<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSimulationAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'simulation_id',
        'score',
        'attempted_at',
        'answers_submitted', // JSON atau TEXT untuk menyimpan jawaban siswa
        'time_spent_seconds', // Opsional: waktu yang dihabiskan siswa
    ];

    protected $casts = [
        'attempted_at' => 'datetime',
        'score' => 'float',
        'answers_submitted' => 'array', // Casting ke array jika disimpan sebagai JSON
        'time_spent_seconds' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function simulation(): BelongsTo
    {
        return $this->belongsTo(Simulation::class);
    }
}