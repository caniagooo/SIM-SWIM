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

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'course_session_id', 'id');
    }
}
