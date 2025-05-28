<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseSession;
use Illuminate\Http\Request;

class CourseSessionController extends Controller
{
    public function index(Course $course)
    {
        $sessions = $course->sessions;
        return view('sessions.index', compact('course', 'sessions'));
    }

    public function create(Course $course)
    {
        return view('sessions.form', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'session_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $course->sessions()->create($request->all());

        return redirect()->route('courses.show', $course->id)->with('success', 'Session created successfully.');
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
        ]);

        $session->update($request->all());

        return redirect()->route('sessions.index', $course->id)->with('success', 'Session updated successfully.');
    }

    public function destroy(Course $course, CourseSession $session)
    {
        $session->delete();

        return redirect()->route('sessions.index', $course->id)->with('success', 'Session deleted successfully.');
    }
}
