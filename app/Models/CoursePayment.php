<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'invoice_number',
        'amount',
        'status',
        'payment_method',
        'transaction_id',
        'gateway_response',
        'notes',
    ];

    protected $casts = [
        'gateway_response' => 'array', // Cast JSON ke array
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}