<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_payments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); // Relasi ke tabel courses
            $table->string('invoice_number')->unique(); // Nomor invoice unik
            $table->decimal('amount', 10, 2); // Jumlah pembayaran
            $table->enum('status', ['pending', 'paid', 'failed', 'cancelled', 'refunded'])->default('pending'); // Status pembayaran
            $table->string('payment_method')->nullable(); // Metode pembayaran
            $table->string('transaction_id')->nullable(); // ID transaksi dari gateway pembayaran
            $table->json('gateway_response')->nullable(); // Respons dari gateway pembayaran
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_payments');
    }
}
