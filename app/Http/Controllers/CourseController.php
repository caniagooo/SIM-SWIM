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
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal
use App\Models\CourseSession; // Import model CourseSession
use App\Models\Attendance; // Import model Attendance
use app\Models\Payment; // Import model Payment

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query();

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        $courses = $query->with(['venue', 'trainers.user', 'students.user'])->get();

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
        $validatedData = $request->validate([
            'type' => 'required|in:private,group',
            'venue_id' => 'required|exists:venues,id',
            'start_date' => 'required|date|after_or_equal:today',
            'valid_until' => 'required|date|after_or_equal:start_date',
            'duration_days' => 'required|integer|min:1',
            'max_sessions' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'basic_skills' => 'nullable|string|max:1000',
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
            'trainers' => 'required|array',
            'trainers.*' => 'exists:trainers,id',
            'materials' => 'nullable|array',
            'materials.*' => 'exists:course_materials,id',
        ]);

        // Generate nama kursus otomatis
        $typeCode = $validatedData['type'] === 'private' ? 'PRV' : 'GRP';
        $year = Carbon::now()->year;
        $sequence = Course::where('type', $validatedData['type'])
            ->whereYear('created_at', $year)
            ->count() + 1; // Hitung jumlah kursus untuk tipe dan tahun ini
        $courseName = sprintf('%03d/%s/%d', $sequence, $typeCode, $year);

        // Tambahkan nama kursus ke data yang divalidasi
        $validatedData['name'] = $courseName;

        // Simpan kursus
        $course = Course::create($validatedData);

        // Hubungkan murid dan pelatih
        $course->students()->sync($validatedData['students']);
        $course->trainers()->sync($validatedData['trainers']);
        if ($request->has('materials')) {
            $course->materials()->sync($validatedData['materials']);
        }

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $course->load(['sessions', 'students.user', 'trainers.user']); // Pastikan sessions dimuat
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $course->load(['students', 'trainers']);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'max_sessions' => 'required|integer|min:1',
            'venue_id' => 'required|exists:venues,id',
            'valid_until' => 'required|date|after_or_equal:start_date', // Validasi valid_until
            'basic_skills' => 'nullable|string|max:1000', // Validasi basic_skills
            'materials' => 'nullable|array',
            'materials.*' => 'exists:course_materials,id',
        ]);

        $course->update($validatedData);

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
