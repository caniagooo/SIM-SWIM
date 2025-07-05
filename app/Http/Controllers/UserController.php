<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updatePassword(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        // Jika user yang login sendiri, wajib isi current_password
        if (auth()->id() == $user->id) {
            $request->validate([
                'current_password' => ['required'],
                'new_password' => ['required', 'min:8', 'confirmed'],
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama salah.'])->with('modal', 'kt_modal_update_password');
            }
        } else {
            // Jika admin, tidak perlu current_password
            $request->validate([
                'new_password' => ['required', 'min:8', 'confirmed'],
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah.')->with('modal', 'kt_modal_update_password');
    }
}