<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'ownership', 'address'];

    public function courses()
    {
        return $this->hasMany(Course::class, 'venue_id');
    }
}