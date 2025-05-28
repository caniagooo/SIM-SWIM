<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseSessionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // Relasi ke tabel courses
            $table->date('session_date'); // Tanggal sesi
            $table->time('start_time'); // Waktu mulai sesi
            $table->time('end_time'); // Waktu selesai sesi
            $table->string('status')->default('scheduled'); // Status sesi (scheduled, completed, canceled)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_sessions');
    }
};
