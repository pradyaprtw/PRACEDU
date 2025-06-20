<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TryoutPackage extends Model
{
    protected $fillable = ['name', 'description'];

    public function subtests()
    {
        return $this->hasMany(Subtest::class, 'package_id');
    }
}
