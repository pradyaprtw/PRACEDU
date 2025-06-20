<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtest extends Model
{
    protected $fillable = ['package_id', 'name', 'total_questions', 'duration_minutes'];

    public function tryoutQuestions()
    {
        return $this->hasMany(TryoutQuestion::class, 'subtest_id');
    }

    public function answers()
    {
        return $this->hasMany(TryoutAnswer::class);
    }

    public function package()
    {
        return $this->belongsTo(TryoutPackage::class, 'package_id');
    }
}
