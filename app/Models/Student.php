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
        'birth_date',
        'age_group',
        // Kolom lain di tabel students
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Metode untuk menghitung usia
    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->age;
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id');
    }
    
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function sessions()
    {
        return $this->belongsToMany(CourseSession::class, 'course_session_student');
    }
    

    public function materialScores()
    {
        return $this->belongsToMany(CourseMaterial::class, 'course_session_material_student', 'student_id', 'material_id')
                    ->withPivot('score', 'remarks');
    }

    public function getCoursesCountAttribute()
    {
        return $this->courses()->count();
    }

    public function getSessionsCountAttribute()
    {
        return $this->sessions()->count();
    }

    public function sessionMaterialGrades()
    {
        return $this->hasMany(CourseSessionMaterialStudent::class, 'student_id', 'id');
    }

    public function getAgeGroupAttribute()
    {
        $age = \Carbon\Carbon::parse($this->birth_date)->age;
        if ($age < 5) {
            return 'Balita';
        } elseif ($age <= 18) {
            return 'Remaja';
        } else {
            return 'Dewasa';
        }
    }
}