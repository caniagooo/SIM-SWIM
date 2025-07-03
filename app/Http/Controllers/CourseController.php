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
        $allCourses = Course::with(['venue', 'trainers.user', 'students.user', 'payment', 'sessions'])->get();

        $query = Course::query();

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->filled('trainer_id')) {
            $query->whereHas('trainers', function($q) use ($request) {
                $q->where('trainers.id', $request->trainer_id);
            });
        }

        if ($request->filled('venue_id')) {
            $query->where('venue_id', $request->venue_id);
        }

        if ($request->filled('status')) {
            $now = now();
            $query->with(['payment', 'sessions']);
            $query->where(function($q) use ($request, $now) {
                if ($request->status == 'active') {
                    $q->whereHas('payment', function($q2) {
                        $q2->where('status', 'paid');
                    })
                    ->where('valid_until', '>=', $now)
                    ->whereRaw('(SELECT COUNT(*) FROM course_sessions WHERE course_sessions.course_id = courses.id AND course_sessions.status = "completed") < max_sessions');
                } elseif ($request->status == 'expired') {
                    $q->where(function($q2) use ($now) {
                        $q2->where('valid_until', '<', $now)
                        ->orWhereRaw('(SELECT COUNT(*) FROM course_sessions WHERE course_sessions.course_id = courses.id AND course_sessions.status = "completed") >= max_sessions');
                    });
                } elseif ($request->status == 'unpaid') {
                    $q->whereHas('payment', function($q2) {
                        $q2->where('status', 'pending');
                    });
                }
            });
        }

        $query->orderBy('created_at', 'desc');

        $courses = $query->with(['venue', 'trainers.user', 'students.user', 'payment', 'sessions'])->paginate(5)->withQueryString();
        $allTrainers = Trainer::with('user')->get();
        $allMaterials = CourseMaterial::all();

        // === LOGIC UNTUK CARD KURSUS ===
        $cards = $courses->map(function($course) {
            $payment = $course->payment;
            $isPending = $payment && $payment->status === 'pending';
            $isPaid = $payment && $payment->status === 'paid';
            $sessions = $course->sessions ?? collect();
            $sessionsCompleted = $sessions->where('status', 'completed')->count() ?? 0;

            $now = now();
            $isExpired = $now->greaterThan($course->valid_until);
            $maxSessionReached = $course->max_sessions ? ($sessionsCompleted >= $course->max_sessions) : false;

            $isActive = false;
            $statusText = '';
            $statusClass = '';
            if ($payment && $payment->status === 'paid' && !$isExpired && !$maxSessionReached) {
                $isActive = true;
                $statusText = 'Aktif';
                $statusClass = 'badge-light-success';
            } elseif ($isExpired || $maxSessionReached) {
                $statusText = 'Expired';
                $statusClass = 'badge-light-danger';
            } else {
                $statusText = 'Unpaid';
                $statusClass = 'badge-light-warning';
            }

            $start = $course->start_date;
            $end = $course->valid_until;
            $totalDays = $start->diffInDays($end) ?: 1;
            $elapsedDays = $start->lte($now) ? $start->diffInDays(min($now, $end)) : 0;
            $progress = min(100, max(0, round(($elapsedDays / $totalDays) * 100)));

            if ($now->gt($end)) {
                $progressBg = 'background-color: rgba(255,76,81,0.15);';
                $progressBarBg = 'background: #F1416C; color: #fff;';
            } elseif ($progress >= 1) {
                $progressBg = 'background-color: rgba(80,205,137,0.15);';
                $progressBarBg = 'background: #50CD89; color: #fff;';
            } else {
                $progressBg = 'background-color: rgba(0,158,247,0.15);';
                $progressBarBg = 'background: #009EF7; color: #fff;';
            }

            $maxAvatars = 3;
            $students = $course->students->take($maxAvatars);
            $studentNames = $course->students->pluck('user.name')->implode(', ');
            $isGroup = $course->type === 'group';

            // Sessions siap pakai untuk modal
            $sessionsSorted = ($course->sessions ?? collect())->sortBy('date')->values();

            return [
                'course' => $course,
                'payment' => $payment,
                'isPending' => $isPending,
                'isPaid' => $isPaid,
                'sessionsCompleted' => $sessionsCompleted,
                'isExpired' => $isExpired,
                'maxSessionReached' => $maxSessionReached,
                'isActive' => $isActive,
                'statusText' => $statusText,
                'statusClass' => $statusClass,
                'progress' => $progress,
                'progressBg' => $progressBg,
                'progressBarBg' => $progressBarBg,
                'maxAvatars' => $maxAvatars,
                'students' => $students,
                'studentNames' => $studentNames,
                'isGroup' => $isGroup,
                'sessions' => $sessionsSorted, // <-- Tambahkan ini!
            ];
        });

        // Hitung statistik untuk filter badge
        $countTotal = $allCourses->count();
        $countActive = $allCourses->filter(function($c) {
            return optional($c->payment)->status === 'paid'
                && now()->lte($c->valid_until)
                && (!$c->max_sessions || ($c->sessions ?? collect())->where('status','completed')->count() < $c->max_sessions);
        })->count();
        $countExpired = $allCourses->filter(function($c) {
            return optional($c->payment)->status === 'paid'
                && (now()->gt($c->valid_until)
                    || ($c->max_sessions && ($c->sessions ?? collect())->where('status','completed')->count() >= $c->max_sessions));
        })->count();
        $countUnpaid = $allCourses->filter(function($c) {
            return optional($c->payment)->status === 'pending';
        })->count();

        // Tentukan label dan badge class
        $status = request('status');
        if ($status == 'active') {
            $statusLabel = 'Aktif';
            $statusCount = $countActive;
            $statusBadgeClass = 'bg-success';
        } elseif ($status == 'expired') {
            $statusLabel = 'Expired';
            $statusCount = $countExpired;
            $statusBadgeClass = 'bg-danger';
        } elseif ($status == 'unpaid') {
            $statusLabel = 'Unpaid';
            $statusCount = $countUnpaid;
            $statusBadgeClass = 'bg-warning text-dark';
        } else {
            $statusLabel = 'Total';
            $statusCount = $countTotal;
            $statusBadgeClass = 'bg-light text-dark';
        }

        // Untuk filter venue di advanced filter
        $uniqueVenues = $courses->pluck('venue')->unique('id')->filter();

        return view('courses.index', [
            'courses' => $courses,
            'allCourses' => $allCourses,
            'allTrainers' => $allTrainers,
            'allMaterials' => $allMaterials,
            'cards' => $cards,
            'countTotal' => $countTotal,
            'countActive' => $countActive,
            'countExpired' => $countExpired,
            'countUnpaid' => $countUnpaid,
            'statusLabel' => $statusLabel,
            'statusCount' => $statusCount,
            'statusBadgeClass' => $statusBadgeClass,
            'uniqueVenues' => $uniqueVenues,
        ]);
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
        \Log::info('Course store called', $request->all());
        $validatedData = $request->validate([
            'type' => 'required|in:private,group',
            'venue_id' => 'required|exists:venues,id',
            'start_date' => 'required|date',
            'duration_days' => 'required|integer|min:1',
            'max_sessions' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'basic_skills' => 'nullable|string|max:1000',
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
            // 'payment_status' => 'required|in:pending,paid', // HAPUS dari validasi request!
            // 'payment_method' => 'nullable|in:cash,bank_transfer,credit_card',
        ]);
        \Log::info('Course validation passed');

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
        \Log::info('Course created', ['id' => $course->id]);
        // Redirect ke halaman index kursus
        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function show($courseId, Request $request)
    {
        $course = Course::with([
            'students.user',
            'materials',
            'trainers.user',
            'venue',
            'payment'
        ])->findOrFail($courseId);

        // Ambil sessions langsung dari tabel, pastikan up-to-date
        $sessions = \App\Models\CourseSession::where('course_id', $course->id)
            ->orderBy('session_date')
            ->orderBy('start_time')
            ->get();

        // Tab aktif
        $activeTab = $request->get('tab', 'students');

        // Info cards
        $startDate = $course->start_date ? $course->start_date->translatedFormat('d M Y') : 'N/A';
        $endDate = $course->valid_until ? $course->valid_until->translatedFormat('d M Y') : 'N/A';
        $sessionsCompleted = $sessions->where('status', 'completed')->count();
        $maxSessions = $course->max_sessions ?? 'N/A';

        // Pelatih
        $trainers = $course->trainers;

        // Students
        $students = $course->students;

        // Materials
        $materials = $course->materials;

        // Basic skills (array)
        $basicSkills = is_array($course->basic_skills)
            ? $course->basic_skills
            : (empty($course->basic_skills) ? [] : explode(',', $course->basic_skills));

        // Summary materi
        $totalEstimatedSessions = $materials->sum('estimated_sessions');
        $averageMinScore = $materials->count() > 0
            ? number_format($materials->avg('minimum_score'), 1)
            : '-';

        // Payment status
        $paymentStatus = $course->payment->status ?? 'unpaid';
        $isPaid = in_array(strtolower($paymentStatus), ['lunas', 'paid']);

        // Tab list
        $tabList = [
            'students' => ['icon' => 'bi-people', 'label' => 'Peserta'],
            'sessions' => ['icon' => 'bi-calendar-check', 'label' => 'Sesi'],
            'materials' => ['icon' => 'bi-journal-bookmark', 'label' => 'Materi'],
        ];

        return view('courses.show', compact(
            'course', 'activeTab', 'startDate', 'endDate', 'sessionsCompleted', 'maxSessions',
            'trainers', 'students', 'sessions', 'materials', 'basicSkills',
            'totalEstimatedSessions', 'averageMinScore', 'paymentStatus', 'isPaid', 'tabList'
        ));
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

public function ajaxIndex(Request $request)
{
    // dd($request->all());
    $query = Course::query();

    if ($request->has('type') && $request->type) {
        $query->where('type', $request->type);
    }

       // Filter by trainer
    if ($request->filled('trainer_id')) {
        $query->whereHas('trainers', function($q) use ($request) {
            $q->where('trainers.id', $request->trainer_id);
        });
    }

    // Filter by venue
    if ($request->filled('venue_id')) {
        $query->where('venue_id', $request->venue_id);
    }

    // Filter by status
    if ($request->filled('status')) {
        $now = now();
        $query->with(['payment', 'sessions']);
        $query->where(function($q) use ($request, $now) {
            if ($request->status == 'active') {
                $q->whereHas('payment', function($q2) {
                    $q2->where('status', 'paid');
                })
                ->where('valid_until', '>=', $now)
                ->whereRaw('(SELECT COUNT(*) FROM course_sessions WHERE course_sessions.course_id = courses.id AND course_sessions.status = "completed") < max_sessions');
            } elseif ($request->status == 'expired') {
                $q->where(function($q2) use ($now) {
                    $q2->where('valid_until', '<', $now)
                    ->orWhereRaw('(SELECT COUNT(*) FROM course_sessions WHERE course_sessions.course_id = courses.id AND course_sessions.status = "completed") >= max_sessions');
                });
            } elseif ($request->status == 'unpaid') {
                $q->whereHas('payment', function($q2) {
                    $q2->where('status', 'pending');
                });
            }
        });
    }



    // Tambahkan orderBy di sini
    $query->orderBy('created_at', 'desc');

    $courses = $query->with(['venue', 'trainers.user', 'students.user', 'payment', 'sessions'])->paginate(5)->withQueryString();
    $allTrainers = Trainer::with('user')->get();
    $allMaterials = CourseMaterial::all();

        $cards = $courses->map(function($course) {
        $payment = $course->payment;
        $isPending = $payment && $payment->status === 'pending';
        $isPaid = $payment && $payment->status === 'paid';
        $sessions = $course->sessions ?? collect();
        $sessionsCompleted = $sessions->where('status', 'completed')->count();

        $now = now();
        $isExpired = $now->greaterThan($course->valid_until);
        $maxSessionReached = $course->max_sessions ? ($sessionsCompleted >= $course->max_sessions) : false;

        $isActive = false;
        $statusText = '';
        $statusClass = '';
        if ($payment && $payment->status === 'paid' && !$isExpired && !$maxSessionReached) {
            $isActive = true;
            $statusText = 'Aktif';
            $statusClass = 'badge-light-success';
        } elseif ($isExpired || $maxSessionReached) {
            $statusText = 'Expired';
            $statusClass = 'badge-light-danger';
        } else {
            $statusText = 'Unpaid';
            $statusClass = 'badge-light-warning';
        }

        $start = $course->start_date;
        $end = $course->valid_until;
        $totalDays = $start->diffInDays($end) ?: 1;
        $elapsedDays = $start->lte($now) ? $start->diffInDays(min($now, $end)) : 0;
        $progress = min(100, max(0, round(($elapsedDays / $totalDays) * 100)));

        if ($now->gt($end)) {
            $progressBg = 'background-color: rgba(255,76,81,0.15);';
            $progressBarBg = 'background: #F1416C; color: #fff;';
        } elseif ($progress >= 1) {
            $progressBg = 'background-color: rgba(80,205,137,0.15);';
            $progressBarBg = 'background: #50CD89; color: #fff;';
        } else {
            $progressBg = 'background-color: rgba(0,158,247,0.15);';
            $progressBarBg = 'background: #009EF7; color: #fff;';
        }

        $maxAvatars = 3;
        $students = $course->students->take($maxAvatars);
        $studentNames = $course->students->pluck('user.name')->implode(', ');
        $isGroup = $course->type === 'group';

        // Sessions siap pakai untuk modal
        $sessionsSorted = ($course->sessions ?? collect())->sortBy('date')->values();

        return [
            'course' => $course,
            'payment' => $payment,
            'isPending' => $isPending,
            'isPaid' => $isPaid,
            'sessionsCompleted' => $sessionsCompleted,
            'isExpired' => $isExpired,
            'maxSessionReached' => $maxSessionReached,
            'isActive' => $isActive,
            'statusText' => $statusText,
            'statusClass' => $statusClass,
            'progress' => $progress,
            'progressBg' => $progressBg,
            'progressBarBg' => $progressBarBg,
            'maxAvatars' => $maxAvatars,
            'students' => $students,
            'studentNames' => $studentNames,
            'isGroup' => $isGroup,
            'sessions' => $sessionsSorted, // <-- untuk modal
        ];
    });

    return view('courses.partials.course-list', compact('cards', 'allTrainers', 'allMaterials'))->render();
}
}
