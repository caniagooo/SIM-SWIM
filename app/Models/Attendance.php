<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'course_session_id',
        'student_id',
        'status',
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

    // Relasi ke kursus melalui sesi
    public function course()
    {
        return $this->hasOneThrough(Course::class, CourseSession::class, 'id', 'id', 'course_session_id', 'course_id');

    }
}