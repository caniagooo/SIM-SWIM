<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSessionStudent extends Model
{
    use HasFactory;
    protected $table = 'course_session_student';

    protected $fillable = [
        'course_session_id',
        'student_id',
    ];
    public $timestamps = true;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function sessions()
    {
        return $this->belongsTo(CourseSession::class, 'course_session_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}