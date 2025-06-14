<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'file_path', 'subject_id'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}