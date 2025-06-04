<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_title',
        'event_description',
        'start_time',
        'end_time',
        'reminder_time', // Kapan pengingat akan dikirim
        // 'is_recurring', // Opsional: jika ingin jadwal berulang
        // 'recurring_type', // Opsional: daily, weekly, monthly
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'reminder_time' => 'datetime',
        // 'is_recurring' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}