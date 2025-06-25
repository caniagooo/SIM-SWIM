<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::with('user')->get();
        return view('trainers.index', compact('trainers'));
    }

    public function create()
    {
        $users = User::doesntHave('trainer')->get(); // Hanya user tanpa relasi trainer
        return view('trainers.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:trainers,user_id',
            'type' => 'required|in:venue,club',
        ]);

        Trainer::create($request->all());
        return redirect()->route('trainers.index')->with('success', 'Trainer berhasil ditambahkan.');
    }

    public function edit(Trainer $trainer)
    {
        $users = User::all();
        return view('trainers.edit', compact('trainer', 'users'));
    }

    public function update(Request $request, Trainer $trainer)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:trainers,user_id,' . $trainer->id,
            'type' => 'required|in:venue,club',
        ]);

        $trainer->update($request->all());
        return redirect()->route('trainers.index')->with('success', 'Trainer berhasil diperbarui.');
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();
        return redirect()->route('trainers.index')->with('success', 'Trainer berhasil dihapus.');
    }

    public function show($id)
    {
        // Ambil trainer + relasi
        $trainer = Trainer::with([
            'user', 
            'courses.sessions', 
            'courses.venue', 
            'courses.students'
        ])->findOrFail($id);

        // Ambil daftar sesi dari view
        $sessions = DB::table('trainer_sessions_view')
            ->where('trainer_id', $trainer->id)
            ->orderBy('session_date')
            ->get();

        return view('trainers.show', compact('trainer', 'sessions'));
    }

    
}
