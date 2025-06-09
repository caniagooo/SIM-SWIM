<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGrade extends Model
{
    use HasFactory;

    protected $table = 'student_grades';

    protected $fillable = [
        'course_id',
        'material_id',
        'student_id',
        'score',
        'remarks',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function material()
    {
        return $this->belongsTo(CourseMaterial::class, 'material_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
