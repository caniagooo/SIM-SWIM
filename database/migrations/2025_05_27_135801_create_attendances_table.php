<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_session_id')->constrained()->onDelete('cascade'); // Relasi ke sesi kursus
            $table->foreignId('student_id')->nullable()->constrained()->onDelete('cascade'); // Kehadiran murid
            $table->foreignId('trainer_id')->nullable()->constrained()->onDelete('cascade'); // Kehadiran pelatih
            $table->enum('status', ['present', 'absent', 'late'])->default('present'); // Status kehadiran
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
