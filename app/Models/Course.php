<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'sessions'];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function trainers()
    {
        return $this->belongsToMany(Trainer::class, 'course_trainer');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student');
    }
}