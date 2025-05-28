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
        // Validasi data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:private,group',
            'venue_id' => 'required|exists:venues,id',
            'start_date' => 'required|date|after_or_equal:today',
            'duration_days' => 'required|integer|min:1',
            'max_sessions' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
            'trainers' => 'required|array',
            'trainers.*' => 'exists:trainers,id',
        ]);

        // Simpan kursus
        $course = Course::create($validatedData);

        // Hubungkan murid dan pelatih
        $course->students()->sync($validatedData['students']);
        $course->trainers()->sync($validatedData['trainers']);

        // Generate jadwal sesi otomatis
        $startDate = Carbon::parse($validatedData['start_date']);
        $sessions = $validatedData['max_sessions'];
        $duration = $validatedData['duration_days'];

        for ($i = 0; $i < $sessions; $i++) {
            $sessionDate = $startDate->copy()->addDays($i * floor($duration / $sessions));
            $course->sessions()->create([
                'session_date' => $sessionDate,
                'start_time' => '10:00:00', // Default waktu mulai
                'end_time' => '12:00:00',  // Default waktu selesai
                'status' => 'scheduled',
            ]);
        }

        return redirect()->route('courses.index')->with('success', 'Course created successfully with sessions.');
    }

    public function show(Course $course)
    {
        // Muat relasi sessions sebagai koleksi
        $course->load(['sessions', 'students.user', 'materials', 'trainers.user']);
        
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $course->load(['students', 'trainers']);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'max_sessions' => 'required|integer|min:1',
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
