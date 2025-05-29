<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_session_id',
        'student_id',
        'trainer_id',
        'status',
    ];

    public function session()
    {
        return $this->belongsTo(CourseSession::class, 'course_session_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id', 'id');
    }
}
