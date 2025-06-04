<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SimulationQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'simulation_id',
        'question_text',
        'question_type', // ENUM: 'multiple_choice', 'essay'
        // 'explanation', // Opsional: penjelasan jawaban
        // 'points', // Opsional: poin untuk pertanyaan ini
    ];

    public function simulation(): BelongsTo
    {
        return $this->belongsTo(Simulation::class);
    }

    public function simulationAnswers(): HasMany
    {
        return $this->hasMany(SimulationAnswer::class);
    }
}