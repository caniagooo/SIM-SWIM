<?php
namespace App\Http\Controllers;

use App\Models\CourseSession;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{

    /**
     * Tampilkan halaman absensi untuk sesi kursus tertentu.
     *
     * @param int $sessionId
     * @return \Illuminate\View\View
     */
    public function show($sessionId)
    {
        // Ambil data sesi beserta relasi yang diperlukan
        $session = CourseSession::with(['course.materials', 'students.user'])->findOrFail($sessionId);

        // Tampilkan view absensi
        return view('attendance.show', compact('session'));
    }
    /**
     * Simpan data absensi untuk sesi kursus.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveAttendance(Request $request)
    {
        // Ambil course_session_id dari request
        $sessionId = $request->input('course_session_id');

        // Log untuk memastikan sessionId yang benar
        logger('Session ID from Request:', [$sessionId]);

        $session = CourseSession::with('course')->findOrFail($sessionId);

        foreach ($request->attendance as $studentId => $data) {
            // Log untuk setiap murid yang diproses
            logger('Processing Attendance for Student ID:', [$studentId]);
            logger('Attendance Data:', $data);

            // Simpan atau perbarui data absensi
            Attendance::updateOrCreate(
                [
                    'course_id' => $session->course_id,
                    'course_session_id' => $sessionId,
                    'student_id' => $studentId,
                ],
                [
                    'status' => $data['status'],
                    'remarks' => $data['remarks'] ?? null,
                ]
            );

            // Log setelah data absensi disimpan
            logger('Attendance Saved for Student ID:', [$studentId]);
        }

        // Perbarui status sesi menjadi 'completed'
        $session->update(['status' => 'completed']);

        // Log setelah status sesi diperbarui
        logger('Session Status Updated to Completed for Session ID:', [$sessionId]);

        return response()->json([
            'success' => true,
            'message' => 'Attendance saved successfully.',
        ]);
    }
}