<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CourseMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_course_material', 'course_material_id', 'course_id');
    }

    public function grades()
    {
        return $this->hasMany(StudentGrade::class, 'material_id');
    }

    public static function createFromRequest(Request $request)
    {
        return self::create([
            'name' => $request->input('name'),
        ]);
    }
    public static function updateFromRequest(CourseMaterial $material, Request $request)
    {
        $material->update([
            'name' => $request->input('name'),
        ]);
        return $material;
    }
    public static function deleteMaterial(CourseMaterial $material)
    {
        $material->delete();
    }
}
