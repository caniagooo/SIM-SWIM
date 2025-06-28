<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'specialization'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_trainer', 'trainer_id', 'course_id');
    }
    
    public function sessions()
    {
        return $this->hasMany(CourseSession::class, 'trainer_id');
    }
    
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Ambil data profil dari user
    public function getNameAttribute()
    {
        return $this->user?->name;
    }

    public function getEmailAttribute()
    {
        return $this->user?->email;
    }

    public function getPhoneAttribute()
    {
        return $this->user?->phone;
    }

    public function getGenderAttribute()
    {
        return $this->user?->gender;
    }

    public function getAlamatAttribute()
    {
        return $this->user?->alamat;
    }

    public function getKelurahanIdAttribute()
    {
        return $this->user?->kelurahan_id;
    }

    public function getBirthDateAttribute()
    {
        return $this->user?->birth_date;
    }

    public function getAgeAttribute()
    {
        return $this->user && $this->user->birth_date
            ? Carbon::parse($this->user->birth_date)->age
            : null;
    }


}