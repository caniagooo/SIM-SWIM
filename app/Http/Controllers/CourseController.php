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
use App\Models\CoursePayment; // Import model Course Payment

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query();

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Tambahkan orderBy di sini
        $query->orderBy('created_at', 'desc');

        $courses = $query->with(['venue', 'trainers.user', 'students.user', 'payment'])->get();
        $allTrainers = \App\Models\Trainer::all();
        $allMaterials = \App\Models\CourseMaterial::all();

        return view('courses.index', compact('courses', 'allTrainers', 'allMaterials'));
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
            'duration_days' => 'required|integer|min:1',
            'max_sessions' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'basic_skills' => 'nullable|string|max:1000',
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
            // 'payment_status' => 'required|in:pending,paid', // HAPUS dari validasi request!
            // 'payment_method' => 'nullable|in:cash,bank_transfer,credit_card',
        ]);

        // Hitung end date berdasarkan start date dan duration_days
        $startDate = \Carbon\Carbon::parse($validatedData['start_date']);
        $validatedData['valid_until'] = $startDate->copy()->addDays((int) $validatedData['duration_days']);

        // Generate nama kursus otomatis
        $typeCode = $validatedData['type'] === 'private' ? 'PRV' : 'GRP';
        $year = now()->year;
        $sequence = \App\Models\Course::where('type', $validatedData['type'])
            ->whereYear('created_at', $year)
            ->count() + 1;
        $courseName = sprintf('%03d/%s/%d', $sequence, $typeCode, $year);

        $validatedData['name'] = $courseName;

        // Simpan kursus
        $course = \App\Models\Course::create($validatedData);

        // Hubungkan murid
        $course->students()->sync($validatedData['students']);

        // Buat invoice pembayaran dengan status pending
        if ($validatedData['price'] > 0) {
            $payment = $course->payment()->create([
                'invoice_number' => 'INV-' . strtoupper(uniqid()),
                'amount' => $validatedData['price'],
                'status' => 'pending', // SET DEFAULT
                'payment_method' => null,
            ]);
        }

        // Redirect ke halaman index kursus
        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function show($courseId, Request $request)
    {
        $course = Course::with(['sessions', 'sessions.attendances','students.user','materials',])->findOrFail($courseId);
        $activeTab = $request->get('tab', 'overview'); // Default tab adalah 'overview'

        return view('courses.show', compact('course', 'activeTab'));
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $venues = Venue::all(); // Pastikan model Venue sudah di-import
        $students = Student::all();
        $materials = CourseMaterial::all();
        $trainers = Trainer::all();

        return view('courses.edit', compact('course', 'venues', 'students', 'materials', 'trainers'));
    }

    public function update(Request $request, Course $course)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'max_sessions' => 'required|integer|min:1',
            'venue_id' => 'required|exists:venues,id',
            'valid_until' => 'required|date|after_or_equal:start_date',
            'basic_skills' => 'nullable|string|max:1000',
            'materials' => 'nullable|array',
            'materials.*' => 'exists:course_materials,id',
            'price' => 'required|numeric|min:0', // Validasi harga
        ]);

        $course->update($validatedData);

        if ($request->has('materials')) {
            $course->materials()->sync($request->materials);
        } else {
            $course->materials()->detach();
        }

        // Perbarui invoice pembayaran jika harga berubah
        if ($course->payment) {
            $course->payment->update([
                'amount' => $validatedData['price'],
            ]);
        }

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    public function assign(Request $request, Course $course)
    {
    $request->validate([
        'trainers' => 'nullable|array',
        'trainers.*' => 'exists:trainers,id',
        'materials' => 'nullable|array',
        'materials.*' => 'exists:course_materials,id',
    ]);

    // Hanya sync jika field dikirim dari form
    if ($request->has('trainers')) {
        $course->trainers()->sync($request->input('trainers', []));
    }
    if ($request->has('materials')) {
        $course->materials()->sync($request->input('materials', []));
    }

    return response()->json([
        'success' => true,
        'message' => 'Data berhasil disimpan.',
        'trainers' => $course->trainers->map(function($t) {
            return [
                'name' => $t->user->name,
                'photo' => $t->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png'),
            ];
        }),
        'materials_count' => $course->materials->count(),
    ]);
}
}
