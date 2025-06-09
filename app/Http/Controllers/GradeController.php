<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentGrade;
use App\Models\Course;
use App\Models\Student;

class GradeController extends Controller
{


    /**
     * Simpan atau perbarui penilaian untuk murid dalam kursus tertentu.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request, Course $course, Student $student)
    {
        $request->validate([
            'grades' => 'required|array',
            'grades.*.score' => 'nullable|numeric|min:1|max:5',
            'grades.*.material_id' => 'required|exists:course_materials,id',
            'remarks' => 'nullable|array',
            'remarks.*' => 'nullable|string|max:255',
        ]);

        foreach ($request->grades as $materialId => $data) {
            StudentGrade::updateOrCreate(
                [
                    'course_id' => $course->id, // Gunakan course_id sebagai referensi utama
                    'student_id' => $student->id,
                    'material_id' => $materialId,
                ],
                [
                    'score' => $data['score'] ?? null,
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
