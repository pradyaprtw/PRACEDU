<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'youtube_url', 'subject_id'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}