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

    public function store(Request $request, $courseId, $studentId)
    {
        $course = \App\Models\Course::findOrFail($courseId);
        $student = \App\Models\Student::findOrFail($studentId);

        $materials = $course->materials; // relasi materi kursus

        foreach ($materials as $material) {
            $score = $request->input("grades.{$material->id}.score");
            $remarks = $request->input("grades.{$material->id}.remarks");

            if ($score !== null || $remarks) {
                \App\Models\StudentGrade::updateOrCreate(
                    [
                        'course_id' => $course->id,
                        'student_id' => $student->id,
                        'material_id' => $material->id,
                    ],
                    [
                        'score' => $score,
                        'remarks' => $remarks,
                    ]
                );
            }
        }

        return back()->with('success', 'Penilaian berhasil disimpan.');
    }
}
