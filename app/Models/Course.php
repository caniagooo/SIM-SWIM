<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'price',
        'basic_skills',
        'start_date',
        'duration_days',
        'max_sessions',
        'valid_until',
        'venue_id',
    ];

    protected $casts = [
        'start_date' => 'date', // Konversi ke Carbon instance
        'valid_until' => 'date', // Konversi ke Carbon instance
    ];

    // Relasi ke murid (many-to-many)
    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student','course_id', 'student_id');
    }

    // Relasi ke materi (many-to-many)
    public function materials()
    {
        return $this->belongsToMany(CourseMaterial::class, 'course_course_material', 'course_id', 'course_material_id');
    }

    // Relasi ke pelatih (many-to-many)
    public function trainers()
    {
        return $this->belongsToMany(Trainer::class, 'course_trainer', 'course_id', 'trainer_id');
    }

    // Relasi ke venue (one-to-many)
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    // Relasi ke pembayaran (one-to-many)
    public function payment()   
    {
        return $this->hasOne(CoursePayment::class, 'course_id', );
    }



    // Relasi ke sesi (one-to-many)
    public function sessions()
    {
        return $this->hasMany(CourseSession::class, 'course_id', 'id');
    }

    public function isValid()
    {
        $today = Carbon::today();

        // Periksa apakah tanggal hari ini masih dalam masa berlaku
        $isWithinDate = $today->lte(Carbon::parse($this->valid_until));

        // Periksa apakah jumlah sesi yang dilakukan belum melebihi batas
        $isWithinSessions = $this->sessions_completed < $this->max_sessions;

        return $isWithinDate && $isWithinSessions;
    }
}