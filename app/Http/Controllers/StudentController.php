<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\StudentGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\CourseSession;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $users = User::doesntHave('student')->where('type', 'member')->get(); // Hanya user member tanpa relasi student
        return view('students.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id|unique:students,user_id',
            'name' => 'required_without:user_id|max:255',
            'email' => 'required_without:user_id|email|unique:users,email',
            'birth_date' => 'nullable|date',
            'gender' => 'required_without:user_id|in:pria,wanita',
            'phone' => 'nullable',
            'alamat' => 'nullable',
            'kelurahan_id' => 'nullable|exists:kelurahans,id',
        ]);

        // Tentukan birth_date untuk age_group
        $birth_date = $request->birth_date;
        if ($request->user_id) {
            $user = User::find($request->user_id);
            $birth_date = $user->birth_date;
        }
        $age_group = null;
        if ($birth_date) {
            $age = \Carbon\Carbon::parse($birth_date)->age;
            if ($age < 5) $age_group = 'balita';
            elseif ($age < 12) $age_group = 'anak-anak';
            elseif ($age < 18) $age_group = 'remaja';
            else $age_group = 'dewasa';
        }

        // Jika user_id tidak dipilih, buat user baru
        if (!$request->user_id) {
            $password = Str::random(8);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'alamat' => $request->alamat,
                'kelurahan_id' => $request->kelurahan_id,
                'type' => 'member',
            ]);
            $user->assignRole('murid');
            $user_id = $user->id;
            // Kirim email password ke user di sini jika diinginkan
        } else {
            $user_id = $request->user_id;
            $user = User::find($user_id);
            if ($user && !$user->hasRole('murid')) {
                $user->assignRole('murid');
        }
    }

        Student::create([
            'user_id' => $user_id,
            'age_group' => $age_group,
        ]);

        return redirect()->route('students.index')->with('success', 'Murid berhasil ditambahkan.');
    }

    public function edit(Student $student)
    {
        $users = User::doesntHave('student')->orWhere('id', $student->user_id)->where('type', 'member')->get();
        return view('students.edit', compact('student', 'users'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:students,user_id,' . $student->id,
            'birth_date' => 'required|date',
            'gender' => 'required|in:pria,wanita',
            'phone' => 'nullable',
            'alamat' => 'nullable',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Tambahkan validasi avatar
        ]);

        // Update data user terkait
        $user = User::find($request->user_id);

        // Handle upload avatar jika ada
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarPath = $avatar->store('avatars', 'public');
            $user->profile_photo_path = $avatarPath;
        }

        $user->update([
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'alamat' => $request->alamat,
            // 'profile_photo_path' => $user->profile_photo_path, // Sudah di-set di atas jika ada avatar baru
        ]);

        // Hitung ulang age_group
        $age_group = null;
        if ($request->birth_date) {
            $age = \Carbon\Carbon::parse($request->birth_date)->age;
            if ($age < 5) $age_group = 'balita';
            elseif ($age < 12) $age_group = 'anak-anak';
            elseif ($age < 18) $age_group = 'remaja';
            else $age_group = 'dewasa';
        }

        $student->update([
            'user_id' => $request->user_id,
            'age_group' => $age_group,
        ]);

        return redirect()->route('students.index')->with('success', 'Murid berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Murid berhasil dihapus.');
    }

    public function show(Student $student)
    {
        $student->load([
            'gradeScores.material',
            'gradeScores.course'
        ]);
        
        $payments = $student->coursePayments()->with('course')->get();
        return view('students.show', compact('student', 'payments'));
    }

    public function payments(Student $student)
    {
        $payments = $student->payments()->with('course')->get();
        return view('students.payments', compact('student', 'payments'));
    }
}
