<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'session_date',
        'start_time',
        'end_time',
        'status',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
