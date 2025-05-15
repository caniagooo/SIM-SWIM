<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Relasi ke murid
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('set null'); // Relasi ke kursus
            $table->decimal('amount', 10, 2); // Jumlah pembayaran
            $table->enum('type', ['prepaid', 'regular']); // Jenis pembayaran
            $table->date('payment_date'); // Tanggal pembayaran
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
