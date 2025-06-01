<?php
namespace App\Http\Controllers;

use App\Models\CourseSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function store(Request $request, $sessionId)
    {
        $request->validate([
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|in:hadir,tidak hadir,terlambat',
        ]);

        $session = CourseSession::findOrFail($sessionId);

        if (is_array($request->attendance)) {
            foreach ($request->attendance as $studentId => $data) {
                DB::table('attendances')->updateOrInsert(
                    [
                        'course_session_id' => $sessionId,
                        'student_id' => $studentId,
                    ],
                    [
                        'status' => $data['status'],
                        'remarks' => $data['remarks'] ?? null,
                    ]
                );
            }
        } else {
            throw new \Exception('Attendance data is missing or invalid.');
        }

        // Redirect ke halaman detail kursus (tab session)
        return redirect()->route('courses.show', ['courseId' => $session->course_id, 'tab' => 'sessions'])
            ->with('success', 'Attendance saved successfully!');
    }

    public function saveScores(Request $request, $sessionId)
    {
        $session = CourseSession::findOrFail($sessionId);

        foreach ($request->scores as $studentId => $materials) {
            foreach ($materials as $materialId => $data) {
                DB::table('course_session_material_student')->updateOrInsert(
                    [
                        'course_session_id' => $sessionId,
                        'student_id' => $studentId,
                        'material_id' => $materialId,
                    ],
                    [
                        'score' => $data['score'],
                        'remarks' => $data['remarks'] ?? null,
                    ]
                );
            }
        }

        // Redirect ke halaman detail kursus (tab session)
        return redirect()->route('courses.show', ['courseId' => $session->course_id, 'tab' => 'sessions'])
            ->with('success', 'Scores saved successfully!');
    }

    public function show($sessionId)
    {
        // Ambil data sesi beserta relasi yang diperlukan
        $session = CourseSession::with(['course.materials', 'students.user'])->findOrFail($sessionId);

        // Tampilkan view absensi
        return view('attendance.show', compact('session'));
    }

    public function storeScore(Request $request)
    {
        $request->validate([
            'scores.*.*.score' => 'required|in:1,2,3',
            'scores.*.*.remarks' => 'nullable|string',
        ]);

        foreach ($request->scores as $studentId => $materials) {
            foreach ($materials as $materialId => $data) {
                Score::updateOrCreate(
                    ['student_id' => $studentId, 'material_id' => $materialId],
                    ['score' => $data['score'], 'remarks' => $data['remarks']]
                );
            }
        }

        return response()->json(['success' => true, 'student_id' => $request->student_id]);
    }
}