<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['student', 'course'])->get();
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $students = Student::all();
        $courses = Course::all();
        return view('payments.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'nullable|exists:courses,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:prepaid,regular',
            'payment_date' => 'required|date',
        ]);

        Payment::create($request->all());

        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function edit(Payment $payment)
    {
        $students = Student::all();
        $courses = Course::all();
        return view('payments.edit', compact('payment', 'students', 'courses'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'nullable|exists:courses,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:prepaid,regular',
            'payment_date' => 'required|date',
        ]);

        $payment->update($request->all());

        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil dihapus.');
    }
}
