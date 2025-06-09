<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSession extends Model
{
    use HasFactory;

    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'course_id',
        'trainer_id',
        'session_date',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'session_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    // Relasi ke kursus
    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    public function attendances()
    {
        return $this->hasMany(Attendance::class,'course_id', 'course_session_id', 'id');
    }


    // Relasi ke murid (students)
    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'student_id');
    }

    // Relasi ke pelatih (trainer)
    public function trainers()
    {
        return $this->belongsToMany(Trainer::class, 'course_trainer','course_id', 'trainer_id');
    }

    public function materials()
    {
        return $this->belongsToMany(CourseMaterial::class, 'course_session_materials', 'course_session_id', 'material_id');
    }

    public function materialStudents()
    {
        return $this->hasManyThrough(
            MaterialStudent::class,
            CourseMaterial::class,
            'course_session_id', // Foreign key di tabel course_material
            'material_id',       // Foreign key di tabel material_student
            'id',                // Primary key di tabel course_session
            'id'                 // Primary key di tabel course_material
        );
    }
}


