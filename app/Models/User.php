<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login_at',
        'last_login_ip',
        'profile_photo_path',
        'type',
        'birth_date',
        'phone',
        'gender',
        'alamat',
        'kelurahan_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'birth_date' => 'date',
    ];

    public function getProfilePhotoUrlAttribute()
    {
        if (!$this->profile_photo_path) {
            return asset('assets/media/avatars/default-avatar.png');
        }
        return asset('storage/' . $this->profile_photo_path);
     
    }

    
    public function trainer()
    {
        return $this->hasOne(Trainer::class, 'user_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function getAvatarAttribute()
    {
        return $this->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png');
    }

   

}