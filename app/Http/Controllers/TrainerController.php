<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\User;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::with('user')->get();
        return view('trainers.index', compact('trainers'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('roles')->get(); // Hanya user tanpa role
        return view('trainers.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:venue,club',
        ]);

        Trainer::create($request->all());
        return redirect()->route('trainers.index')->with('success', 'Trainer created successfully.');
    }

    public function edit(Trainer $trainer)
    {
        $users = User::all();
        return view('trainers.edit', compact('trainer', 'users'));
    }

    public function update(Request $request, Trainer $trainer)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:venue,club',
        ]);

        $trainer->update($request->all());
        return redirect()->route('trainers.index')->with('success', 'Trainer updated successfully.');
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();
        return redirect()->route('trainers.index')->with('success', 'Trainer deleted successfully.');
    }
}
