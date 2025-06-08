<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSessionMaterialStudent extends Model
{
    use HasFactory;

    protected $table = 'course_session_material_student';

    protected $fillable = [
        'course_session_id',
        'student_id',
        'material_id',
        'score',
        'remarks',
    ];

    // Relasi ke sesi kursus
    public function session()
    {
        return $this->belongsTo(CourseSession::class, 'course_session_id', 'id');
    }

    // Relasi ke murid
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    // Relasi ke materi
    public function material()
    {
        return $this->belongsTo(CourseMaterial::class, 'material_id', 'id');
    }

    // Relasi ke kursus melalui sesi
    public function course()
    {
        return $this->hasOneThrough(Course::class, CourseSession::class, 'id', 'id', 'course_session_id', 'course_id');
    }
}
