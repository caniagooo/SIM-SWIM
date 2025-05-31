<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttendanceStatusToCourseSessionStudentAndTrainer extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambahkan kolom attendance_status di tabel course_session_student
        Schema::table('course_session_student', function (Blueprint $table) {
            $table->enum('attendance_status', ['present', 'absent'])->nullable()->after('student_id');
        });

        // Tambahkan kolom attendance_status di tabel course_session_trainer
        Schema::table('course_session_trainer', function (Blueprint $table) {
            $table->enum('attendance_status', ['present', 'absent'])->nullable()->after('trainer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus kolom attendance_status dari tabel course_session_student
        Schema::table('course_session_student', function (Blueprint $table) {
            $table->dropColumn('attendance_status');
        });

        // Hapus kolom attendance_status dari tabel course_session_trainer
        Schema::table('course_session_trainer', function (Blueprint $table) {
            $table->dropColumn('attendance_status');
        });
    }
};
