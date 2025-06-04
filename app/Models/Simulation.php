<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User; // Pastikan untuk mengimpor model User jika diperlukan
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\SimulationQuestion; // Pastikan untuk mengimpor model SimulationQuestion jika diperlukan


class Simulation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'simulation_type', // ENUM: 'SNBT', 'Mandiri', 'Lainnya'
        'duration_minutes', // Durasi ujian dalam menit
        // 'course_id', // Opsional, jika simulasi terkait kursus tertentu
    ];

    protected $casts = [
        'duration_minutes' => 'integer',
    ];

    public function simulationQuestions(): HasMany
    {
        return $this->hasMany(SimulationQuestion::class);
    }

    public function userSimulationAttempts(): HasMany
    {
        return $this->hasMany(UserSimulationAttempt::class);
    }

    // Jika ingin dikaitkan dengan Course
    // public function course(): BelongsTo
    // {
    //     return $this->belongsTo(Course::class);
    // }
}
