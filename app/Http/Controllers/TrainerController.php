<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        // Cek tipe pendaftaran
        if ($request->register_type === 'new') {
            // Validasi user baru
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'birth_date' => 'nullable|date',
                'gender' => 'nullable|in:pria,wanita',
                'phone' => 'nullable|string|max:30',
                'alamat' => 'nullable|string|max:255',
                'type' => 'required|in:venue,club',
            ]);

            $password = Str::random(8);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'alamat' => $request->alamat,
                'type' => 'member',
            ]);
            // Assign role pelatih
            $user->assignRole('pelatih');
            $user_id = $user->id;
            // Kirim email password ke user jika perlu
        } else {
            // Validasi user existing
            $request->validate([
                'user_id' => 'required|exists:users,id|unique:trainers,user_id',
                'type' => 'required|in:venue,club',
            ]);
            $user = User::find($request->user_id);
            if ($user && !$user->hasRole('pelatih')) {
                $user->assignRole('pelatih');
            }
            $user_id = $user->id;
        }

        Trainer::create([
            'user_id' => $user_id,
            'type' => $request->type,
        ]);

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
        // Pastikan user tetap punya role pelatih
        $user = User::find($request->user_id);
        if ($user && !$user->hasRole('pelatih')) {
            $user->assignRole('pelatih');
        }
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
