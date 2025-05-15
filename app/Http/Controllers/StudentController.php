<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $users = User::doesntHave('student')->get(); // Hanya user tanpa relasi student
        return view('students.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:students,user_id',
            'birth_date' => 'required|date',
            'age_group' => 'required|in:balita,anak-anak,remaja,dewasa',
        ]);

        Student::create($request->all());
        return redirect()->route('students.index')->with('success', 'Murid berhasil ditambahkan.');
    }

    public function edit(Student $student)
    {
        $users = User::all();
        return view('students.edit', compact('student', 'users'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:students,user_id,' . $student->id,
            'birth_date' => 'required|date',
            'age_group' => 'required|in:balita,anak-anak,remaja,dewasa',
        ]);

        $student->update($request->all());
        return redirect()->route('students.index')->with('success', 'Murid berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Murid berhasil dihapus.');
    }

    public function show(Student $student)
    {
        $payments = $student->payments()->with('course')->get(); // Relasi ke pembayaran
        return view('students.show', compact('student', 'payments'));
    }

    public function payments(Student $student)
    {
        $payments = $student->payments()->with('course')->get(); // Ambil data pembayaran murid
        return view('students.payments', compact('student', 'payments'));
    }
}
