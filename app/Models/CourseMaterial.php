<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['level', 'name', 'estimated_sessions', 'minimum_score'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_course_material');
    }
}
