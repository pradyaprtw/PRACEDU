<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'sub_category_id'];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
