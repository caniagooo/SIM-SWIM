<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Venue;
use App\Models\CourseMaterial;
use App\Models\Student; // Import model Student
use App\Models\Trainer; // Import model Trainer
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('venue')->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $students = Student::with('user')->get(); // Ambil data murid beserta nama dari tabel users
        $venues = Venue::all(); // Ambil data venue
        $trainers = Trainer::with('user')->get(); // Ambil data pelatih
        $materials = CourseMaterial::all(); // Ambil data materi kursus

        return view('courses.create', compact('students', 'venues', 'trainers', 'materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:private,group,organization',
            'sessions' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'basic_skills' => 'required|string',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Course $course)
    {
        $venues = Venue::all();
        $materials = CourseMaterial::all();
        return view('courses.edit', compact('course', 'venues', 'materials'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'sessions' => 'required|integer|min:1',
            'venue_id' => 'nullable|exists:venues,id',
            'materials' => 'nullable|array',
            'materials.*' => 'exists:course_materials,id',
        ]);

        $course->update($request->except('materials'));

        if ($request->has('materials')) {
            $course->materials()->sync($request->materials);
        } else {
            $course->materials()->detach();
        }

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
