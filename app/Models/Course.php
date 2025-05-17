<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'sessions',
        'price',
        'basic_skills',
        'venue_id',
    ];

    // Relasi ke murid (many-to-many)
    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student');
    }

    // Relasi ke materi (many-to-many)
    public function materials()
    {
        return $this->belongsToMany(CourseMaterial::class, 'course_course_material');
    }

    // Relasi ke pelatih (many-to-many)
    public function trainers()
    {
        return $this->belongsToMany(Trainer::class, 'course_trainer');
    }

    // Relasi ke venue (one-to-many)
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }
}