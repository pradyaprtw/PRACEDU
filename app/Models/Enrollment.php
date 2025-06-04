<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'order_id', // Opsional, untuk melacak dari order mana enrollment ini berasal
        'enrolled_at',
        'progress_percentage',
        'completed_at',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
        'progress_percentage' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class)->nullable();
    }

    public function userModuleProgresses(): HasMany // Tambahkan ini
    {
        return $this->hasMany(UserModuleProgress::class);
    }
}

