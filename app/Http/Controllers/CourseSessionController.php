<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseSession;
use Illuminate\Http\Request;

class CourseSessionController extends Controller
{
    public function index(Course $course)
    {
        $sessions = $course->sessions()->get(); // Ambil semua sesi yang terkait dengan kursus
        return view('sessions.index', compact('course', 'sessions'));
    }

    public function create(Course $course)
    {
        return view('sessions.create', compact('course'));
    }

    public function store(Request $request, $courseId)
    {
        $request->validate([
            'session_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $session = CourseSession::create([
            'course_id' => $courseId,
            'session_date' => $request->session_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'scheduled', // Default status
        ]);

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
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'status' => 'required|in:scheduled,completed,canceled',
        ]);
        
        
        $session = CourseSession::findOrFail($session->id);
        $session->update([
                'session_date' => $request->session_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'data' => $session,
        ]);
    }

    public function destroy(Course $course, CourseSession $session)
    {
        $session->delete();

        return redirect()->route('courses.show', $course->id)->with('success', 'Session deleted successfully.');
    }
}