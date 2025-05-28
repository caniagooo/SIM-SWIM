<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseSessionStudentTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_session_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_session_id')->constrained()->onDelete('cascade'); // Relasi ke sesi kursus
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Relasi ke murid
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_session_student');
    }
}
