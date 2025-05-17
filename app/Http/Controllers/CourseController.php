<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Venue;
use App\Models\CourseMaterial;
use App\Models\Student; // Import model Student
use App\Models\Trainer; // Import model Trainer
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Import Log facade

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['venue', 'trainers', 'students', 'materials'])->get();
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
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:private,group',
            'sessions' => 'required|integer|min:1',
            'venue_id' => 'required|exists:venues,id',
            'price' => 'required|numeric|min:0',
            'basic_skills' => 'nullable|string',
            'students' => 'required|array', // Harus berupa array
            'students.*' => 'exists:students,id', // Setiap elemen harus ada di tabel students
            'materials' => 'nullable|array', // Bisa kosong
            'materials.*' => 'exists:course_materials,id', // Setiap elemen harus ada di tabel course_materials
            'trainers' => 'required|array', // Harus berupa array
            'trainers.*' => 'exists:trainers,id', // Setiap elemen harus ada di tabel trainers
        ]);

        // Simpan data course ke database
        $course = Course::create([
            'name' => $validatedData['name'],
            'type' => $validatedData['type'],
            'sessions' => $validatedData['sessions'],
            'venue_id' => $validatedData['venue_id'],
            'price' => $validatedData['price'],
            'basic_skills' => $validatedData['basic_skills'] ?? null,
        ]);

        // Simpan relasi ke tabel pivot
        $course->students()->sync($validatedData['students']);
        $course->materials()->sync($validatedData['materials'] ?? []); // Kosongkan jika tidak ada materi
        $course->trainers()->sync($validatedData['trainers']);

        // Redirect ke halaman index dengan pesan sukses
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
            'venue_id' => 'required|exists:venues,id',
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
