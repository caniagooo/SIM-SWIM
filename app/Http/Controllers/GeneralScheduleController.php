<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseSession;
use App\Models\Course;
use App\Models\Attendance;
use App\Models\Trainer;
use App\Models\Student;
use App\Models\Venue;
use App\Exports\SessionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class GeneralScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = CourseSession::with('course');

        if ($request->filled('course')) {
            $query->where('course_id', $request->course);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('session_date', $request->date);
        }

        $sessions = $query->get();
        $courses = Course::all(); // Untuk dropdown filter kursus

        return view('general-schedule.index', compact('sessions', 'courses'));
    }

    public function export(Request $request)
    {
        $query = CourseSession::with('course');

        if ($request->filled('course')) {
            $query->where('course_id', $request->course);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('session_date', $request->date);
        }

        $sessions = $query->get();

        return Excel::download(new SessionsExport($sessions), 'sessions.xlsx');
    }

    public function exportPdf()
    {
        $sessions = CourseSession::with('course')->get(); // Ambil semua sesi dengan relasi kursus

        $pdf = Pdf::loadView('exports.sessions-pdf', compact('sessions'));
        return $pdf->download('general_schedule.pdf');
    }
}
