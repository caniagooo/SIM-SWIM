<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil user.
     */
    public function show()
    {
        $user = Auth::user();

        if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
            return view('pages.apps.user-management.users.show', compact('user'));
        } elseif ($user->hasRole('Murid')) {
            return view('pages.apps.students.show', compact('user'));
        } elseif ($user->hasRole('Pelatih')) {
            return view('pages.apps.trainers.show', compact('user'));
        } else {
            abort(403, 'Role tidak dikenali.');
        }
    }

    /**
     * Update data profil user.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Redirect sesuai role
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
            return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
        } elseif ($user->hasRole('Murid')) {
            return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
        } elseif ($user->hasRole('Pelatih')) {
            return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
        } else {
            abort(403, 'Role tidak dikenali.');
        }
    }
}