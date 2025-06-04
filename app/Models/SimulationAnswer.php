<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SimulationAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'simulation_question_id',
        'answer_text',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function simulationQuestion(): BelongsTo
    {
        return $this->belongsTo(SimulationQuestion::class);
    }
}