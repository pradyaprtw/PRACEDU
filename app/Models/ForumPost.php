<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'user_id', // User who wrote the post
        'content',
        // 'parent_post_id', // Optional: for threaded replies
    ];

    /**
     * Get the thread this post belongs to.
     */
    public function thread(): BelongsTo
    {
        return $this->belongsTo(ForumThread::class);
    }

    /**
     * Get the user who wrote this post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Update last_reply_at on parent thread when a post is created or deleted
    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            $post->thread->update(['last_reply_at' => now()]);
        });

        static::deleted(function ($post) {
            // Update last_reply_at to the latest post in the thread, or thread's created_at if no posts left
            $latestPostInThread = $post->thread->posts()->latest()->first();
            $post->thread->update([
                'last_reply_at' => $latestPostInThread ? $latestPostInThread->created_at : $post->thread->created_at
            ]);
        });
    }
}