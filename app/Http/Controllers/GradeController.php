<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseSessionMaterialStudent;
use App\Models\Course;
use App\Models\Student;

class GradeController extends Controller
{
    public function store(Request $request, Course $course, Student $student)
    {
        // Validasi input
        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'nullable|numeric|min:1|max:5', // Penilaian 1-5
        ]);

        // Simpan atau perbarui nilai untuk setiap materi
        foreach ($request->grades as $materialId => $score) {
            CourseSessionMaterialStudent::updateOrCreate(
                [
                    'course_session_id' => $course->sessions->first()->id, // Ambil sesi pertama (atau sesuaikan logika)
                    'student_id' => $student->id,
                    'material_id' => $materialId,
                ],
                [
                    'score' => $score,
                    'remarks' => $request->remarks[$materialId] ?? null,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Penilaian berhasil disimpan.',
        ]);
    }
}
