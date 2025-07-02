<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'age_group',
        // Kolom lain di tabel students
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Usia diambil dari user
    public function getAgeAttribute()
    {
        return $this->user && $this->user->birth_date
            ? Carbon::parse($this->user->birth_date)->age
            : null;
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id');
    }
    
    public function coursePayments()
    {
        return $this->hasManyThrough(
            \App\Models\CoursePayment::class,
            \App\Models\Course::class,
            'id', // Foreign key on courses table...
            'course_id', // Foreign key on course_payments table...
            'id', // Local key on students table...
            'id'  // Local key on courses table...
        );
    }

    public function sessions()
    {
        return $this->belongsToMany(CourseSession::class, 'course_session_student');
    }
    
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id', 'id');
    }

    public function gradeScores()
    {
        return $this->hasMany(StudentGrade::class, 'student_id', 'id');
    }
    public function getGradesAttribute()
    {
        return $this->gradeScores()->pluck('score', 'material_id');
    }

    public function getCoursesCountAttribute()
    {
        return $this->courses()->count();
    }

    public function getSessionsCountAttribute()
    {
        return $this->sessions()->count();
    }
    public function getAttendancesCountAttribute()
    {
        return $this->attendances()->count();
    }

    // Kelompok usia berdasarkan birth_date user
    public function getAgeGroupAttribute()
    {
        if ($this->user && $this->user->birth_date) {
            $age = Carbon::parse($this->user->birth_date)->age;
            if ($age < 5) {
                return 'Balita';
            } elseif ($age < 12) {
                return 'Anak-anak';
            } elseif ($age < 18) {
                return 'Remaja';
            } else {
                return 'Dewasa';
            }
        }
        return null;
    }
    
    public function gradeFor($materialId)
    {
        // Menggunakan accessor grades (sudah ada)
        return $this->grades[$materialId] ?? null;
    }

    // Jika ingin remarks juga:
    public function remarksFor($materialId)
    {
        $grade = $this->gradeScores()->where('material_id', $materialId)->first();
        return $grade ? $grade->remarks : null;
    }
}