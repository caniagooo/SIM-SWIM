<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Trainer;
use App\Models\CourseSession;
use App\Models\Attendance;
use App\Models\Venue;
use App\Models\CourseMaterial;
use App\Models\CoursePayment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Summary data
        $overview = (object) [
            'active_courses' => DB::table('active_courses')->count(),
            'total_students' => DB::table('students')->count(),
            'total_trainers' => DB::table('trainers')->count(),
            'total_unpaid' => DB::table('course_payments')->where('status', 'pending')->sum('amount'), 
            // Jumlahkan max_sessions dari table courses
            'total_unscheduled_sessions' => DB::table('courses')->sum('max_sessions') - DB::table('course_sessions')->whereNotNull('session_date')->count()
        ];

        // Top 5 Active Courses (with avatar info)
        $activeCourses = DB::table('active_courses')->limit(5)->get();

        // Kalender Event List
        $calendarEvents = DB::table('course_sessions as cs')
            ->join('courses as c', 'c.id', '=', 'cs.course_id')
            ->select('cs.session_date as start', 'c.name as title')
            ->whereDate('cs.session_date', '>=', now())
            ->orderBy('cs.session_date')
            ->get();

        // Ambil jadwal sesi (misal ambil 10 sesi terdekat)
        $sessionSchedules = \App\Models\CourseSession::with(['course'])
            ->orderBy('session_date', 'asc')
            ->where('session_date', '>=', now())
            ->limit(10)
            ->get()
            ->map(function($session) {
                return (object)[
                    'session_date' => $session->session_date,
                    'course_name'  => $session->course->name ?? '-',
                    'status'       => $session->status ?? '-',
                ];
            });

        return view('dashboard.index', compact('overview', 'activeCourses', 'calendarEvents', 'sessionSchedules'));
    }
}
