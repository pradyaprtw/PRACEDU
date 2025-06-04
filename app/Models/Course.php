<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User; // Pastikan untuk mengimpor model User jika diperlukan

class Course extends Model
{
        use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'instructor_id', // Akan kita relasikan dengan model User
        'price',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Mendapatkan user (instruktur) yang memiliki kursus ini.
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function orderItems(): HasMany // Tambahkan ini
    {
        return $this->hasMany(OrderItem::class);
    }

    public function enrollments(): HasMany // Tambahkan ini
    {
        return $this->hasMany(Enrollment::class);
    }

    public function forumThreads(): HasMany // Tambahkan ini
    {
        return $this->hasMany(ForumThread::class);
    }
}
