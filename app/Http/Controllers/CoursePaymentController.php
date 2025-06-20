<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CoursePaymentController extends Controller
{
    /**
     * Create a new invoice for a course.
     */
    public function createInvoice($courseId)
    {
        $course = Course::findOrFail($courseId);

        $payment = CoursePayment::create([
            'course_id' => $course->id,
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'amount' => $course->price,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Invoice created successfully.', 'payment' => $payment]);
    }

    /**
     * Process a payment.
     */
    public function processPayment(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);
        $payment = $course->payment;

        if (!$payment) {
            return response()->json(['message' => 'Payment record not found.'], 404);
        }

        // Cek jika sudah paid
        if ($payment->status === 'paid') {
            return response()->json(['message' => 'Kursus sudah dibayar.'], 400);
        }

        // Cek jika kursus expired
        if (now()->gt($course->valid_until)) {
            return response()->json(['message' => 'Kursus sudah expired.'], 400);
        }

        $validatedData = $request->validate([
            'payment_method' => 'required|in:cash,bank_transfer,credit_card',
        ]);

        $payment->update([
            'payment_method' => $validatedData['payment_method'],
            'status' => 'paid',
        ]);

        return response()->json(['message' => 'Payment processed successfully.']);
    }

    /**
     * Get the status of a payment.
     */
    public function paymentStatus($paymentId)
    {
        $payment = CoursePayment::findOrFail($paymentId);

        return response()->json(['payment' => $payment]);
    }

    /**
     * Display the specified payment.
     */
    public function show($paymentId)
    {
        $payment = CoursePayment::findOrFail($paymentId);

        return view('payments.show', compact('payment'));
    }

    public function invoice(Course $course)
    {
        $payment = $course->payment;
        if (!$payment) {
            $payment = $course->payment()->create([
                'invoice_number' => 'INV-' . strtoupper(uniqid()),
                'amount' => $course->price,
                'status' => 'pending',
            ]);
        }
        return response()->json([
            'invoice_number' => $payment->invoice_number,
            'amount' => $payment->amount,
            'status' => $payment->status,
            'course_name' => $course->name,
            'start_date' => $course->start_date ? $course->start_date->format('d M Y') : '-',
            'valid_until' => $course->valid_until ? $course->valid_until->format('d M Y') : '-',
            'max_sessions' => $course->max_sessions,
        ]);
    }

    public function process(Request $request, Course $course)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,bank_transfer,credit_card',
        ]);

        $payment = $course->payment;
        if (!$payment) {
            return response()->json(['message' => 'Invoice not found.'], 404);
        }

        // Cek jika sudah paid
        if ($payment->status === 'paid') {
            return response()->json(['message' => 'Kursus sudah dibayar.'], 400);
        }

        // Cek jika kursus expired
        if (now()->gt($course->valid_until)) {
            return response()->json(['message' => 'Kursus sudah expired.'], 400);
        }

        $payment->status = 'paid';
        $payment->payment_method = $request->payment_method;
        $payment->save();

        return response()->json(['message' => 'Payment successful!']);
    }
}