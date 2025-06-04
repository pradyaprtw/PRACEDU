<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModuleProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'module_id',
        'is_completed',
        'last_accessed_at',
        'completed_at', // Tambahkan ini untuk mencatat waktu selesai
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'last_accessed_at' => 'datetime',
        'completed_at' => 'datetime', // Tambahkan cast
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    // Helper untuk mendapatkan user melalui enrollment
    public function user()
    {
        return $this->enrollment->user(); // Asumsi relasi user() ada di Enrollment
    }

    // Helper untuk mendapatkan course melalui enrollment
    public function course()
    {
        return $this->enrollment->course(); // Asumsi relasi course() ada di Enrollment
    }
}
