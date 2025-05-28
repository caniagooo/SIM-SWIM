<?php
namespace App\Http\Controllers;

use App\Models\CourseSession;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(CourseSession $session)
    {
        $attendances = $session->attendances()->with(['student.user', 'trainer.user'])->get();
        return view('attendances.index', compact('session', 'attendances'));
    }

    public function store(Request $request, CourseSession $session)
    {
        $request->validate([
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
            'trainers' => 'nullable|array',
            'trainers.*' => 'exists:trainers,id',
        ]);

        // Simpan kehadiran murid
        if ($request->has('students')) {
            foreach ($request->students as $studentId) {
                $session->attendances()->updateOrCreate(
                    ['student_id' => $studentId],
                    ['status' => 'present']
                );
            }
        }

        // Simpan kehadiran pelatih
        if ($request->has('trainers')) {
            foreach ($request->trainers as $trainerId) {
                $session->attendances()->updateOrCreate(
                    ['trainer_id' => $trainerId],
                    ['status' => 'present']
                );
            }
        }

        return redirect()->route('courses.show', $session->course_id)->with('success', 'Attendance saved successfully.');
    }
}