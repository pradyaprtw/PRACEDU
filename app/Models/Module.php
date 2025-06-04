<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Database\Eloquent\Relations\HasMany;  
use App\Models\Course; 


class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'module_type', // ENUM: 'video', 'pdf', 'text'
        'content_url', // Untuk video URL atau path file PDF
        'text_content', // Untuk konten teks langsung
        'order_in_course',
    ];

    protected $casts = [
        'order_in_course' => 'integer',
    ];

    /**
     * Mendapatkan kursus yang memiliki modul ini.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function userModuleProgresses(): HasMany // Tambahkan ini
    {
        return $this->hasMany(UserModuleProgress::class);
    }
}
