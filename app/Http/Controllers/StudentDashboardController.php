<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $student = Auth::user()->student()->with([
            'courses.sessions',
            'gradeScores.material',
            'gradeScores.course',
        ])->first();

        // Tab & Paging
        $tab = $request->query('tab', 'materi');
        $materiPage = max(1, (int) $request->query('materi_page', 1));
        $sesiPage = max(1, (int) $request->query('sesi_page', 1));
        $materiPerPage = 5;
        $sesiPerPage = 5;

        // Materi (nilai)
        $materiAll = ($student->gradeScores ?? collect())->sortByDesc('created_at')->values();
        $materiTotal = $materiAll->count();
        $materiData = $materiAll->slice(($materiPage-1)*$materiPerPage, $materiPerPage);

        // Sesi
        $sesiAll = collect();
        foreach(($student->courses ?? collect()) as $course) {
            foreach(($course->sessions ?? collect()) as $session) {
                $sesiAll->push([
                    'course' => $course,
                    'session' => $session
                ]);
            }
        }
        $sesiAll = $sesiAll->sortByDesc(fn($item) => $item['session']->date ?? $item['session']->created_at)->values();
        $sesiTotal = $sesiAll->count();
        $sesiData = $sesiAll->slice(($sesiPage-1)*$sesiPerPage, $sesiPerPage);

        // Pastikan $materiData dan $sesiData selalu collection
        $materiData = $materiData ?? collect();
        $sesiData = $sesiData ?? collect();

        return view('dashboard-murid.dashboard', compact(
            'student', 'tab',
            'materiData', 'materiTotal', 'materiPage', 'materiPerPage',
            'sesiData', 'sesiTotal', 'sesiPage', 'sesiPerPage'
        ));
    }
}