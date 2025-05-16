<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'venue_id',
        'trainer_id', // Pelatih utama
        'sessions',
        'price',
        'basic_skills',
    ];

    // Relasi ke pelatih utama
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }

    // Relasi ke pelatih tambahan (jika ada tabel pivot)
    public function additionalTrainers()
    {
        return $this->belongsToMany(Trainer::class, 'course_trainer', 'course_id', 'trainer_id');
    }

    // Relasi ke venue
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }
}