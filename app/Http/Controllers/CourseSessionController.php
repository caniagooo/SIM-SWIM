<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseSession;
use Illuminate\Http\Request;

class CourseSessionController extends Controller
{
    public function index(Course $course)
    {
        $sessions = $course->sessions()->get();
        return view('sessions.index', compact('course', 'sessions'));
    }

    public function create(Course $course)
    {
        return view('sessions.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'session_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $session = $course->sessions()->create([
            'session_date' => $request->session_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'scheduled',
        ]);

        $session->session_date_formatted = \Carbon\Carbon::parse($session->session_date)->translatedFormat('l, d F Y');

        return response()->json([
            'success' => true,
            'data' => $session,
        ]);
    }

    public function edit(Course $course, CourseSession $session)
    {
        return view('sessions.form', compact('course', 'session'));
    }

    public function update(Request $request, Course $course, CourseSession $session)
    {
        $request->validate([
            'session_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Hanya boleh reschedule jika status masih 'scheduled'
        if ($session->status !== 'scheduled') {
        return response()->json(['message' => 'Sesi yang sudah completed tidak dapat di-reschedule.'], 403);
        }

        $session->update([
            'session_date' => $request->session_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'rescheduled',
        ]);

        $session->session_date_formatted = \Carbon\Carbon::parse($session->session_date)->translatedFormat('l, d F Y');

        return response()->json([
            'success' => true,
            'data' => $session,
        ]);
    }

    public function destroy(Course $course, CourseSession $session)
    {
        $session->delete();

        return response()->json([
            'success' => true,
            'message' => 'Session deleted successfully.',
        ]);
    }
}