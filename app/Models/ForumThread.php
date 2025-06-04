<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumThread extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Creator of the thread
        'course_id', // Optional: if the thread is specific to a course
        'title',
        'slug', // For SEO friendly URLs, generated from title
        // 'is_pinned', // Optional: to pin important threads
        // 'is_locked', // Optional: to lock threads from further replies
    ];

    protected $casts = [
        'last_reply_at' => 'datetime', // Akan kita update dengan trigger atau observer
    ];

    /**
     * Get the user who created the thread.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the course this thread belongs to (if any).
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get all posts in this thread.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(ForumPost::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get the latest post in this thread.
     */
    public function latestPost(): HasMany // Sebenarnya HasOne tapi untuk latest bisa pakai HasMany + latestOfMany
    {
        return $this->hasMany(ForumPost::class)->latest();
    }

    // Override boot method to generate slug
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($thread) {
            $thread->slug = \Illuminate\Support\Str::slug($thread->title);
            // Pastikan slug unik
            $originalSlug = $thread->slug;
            $count = 1;
            while (static::whereSlug($thread->slug)->exists()) {
                $thread->slug = "{$originalSlug}-{$count}";
                $count++;
            }
        });

        static::updating(function ($thread) {
            if ($thread->isDirty('title')) {
                $thread->slug = \Illuminate\Support\Str::slug($thread->title);
                $originalSlug = $thread->slug;
                $count = 1;
                // Pastikan slug unik, kecuali untuk record saat ini
                while (static::whereSlug($thread->slug)->where('id', '!=', $thread->id)->exists()) {
                    $thread->slug = "{$originalSlug}-{$count}";
                    $count++;
                }
            }
        });
    }
}