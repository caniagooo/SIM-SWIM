<?php
namespace App\Http\Controllers;

use App\Models\CourseSession;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(CourseSession $session)
    {
        $attendances = $session->attendances()->get();
        return view('attendances.index', compact('session', 'attendances'));
    }

    public function store(Request $request, CourseSession $session)
    {
        $validated = $request->validate([
            'student_id' => 'nullable|exists:students,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'status' => 'required|in:present,late,absent',
        ]);

        $session->attendances()->create($validated);
        return redirect()->route('attendances.index', $session->id)->with('success', 'Attendance recorded successfully.');
    }

    public function update(Request $request, CourseSession $session, Attendance $attendance)
    {
        $validated = $request->validate([
            'status' => 'required|in:present,late,absent',
        ]);

        $attendance->update($validated);
        return redirect()->route('attendances.index', $session->id)->with('success', 'Attendance updated successfully.');
    }

    public function destroy(CourseSession $session, Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendances.index', $session->id)->with('success', 'Attendance deleted successfully.');
    }
}