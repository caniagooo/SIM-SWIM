<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Tambahkan kolom baru ke tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->date('birth_date')->nullable()->after('email');
            $table->string('phone')->nullable()->after('birth_date');
            $table->enum('gender', ['pria', 'wanita'])->nullable()->after('phone');
            $table->string('alamat')->nullable()->after('gender');
            $table->unsignedBigInteger('kelurahan_id')->nullable()->after('alamat');
        });

        // 2. Copy data birth_date dari students ke users
        DB::statement('
            UPDATE users
            INNER JOIN students ON students.user_id = users.id
            SET users.birth_date = students.birth_date
            WHERE students.birth_date IS NOT NULL
        ');

        // 3. Hapus kolom birth_date dari tabel students
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('birth_date');
        });

        // attendances
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('course_session_id');
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('trainer_id')->nullable();
            $table->enum('status', ['hadir', 'tidak hadir', 'terlambat'])->default('hadir');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('course_session_id')->references('id')->on('course_sessions')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('trainer_id')->references('id')->on('trainers')->onDelete('cascade');
        });
    }

    public function down()
    {
        // 1. Tambahkan kembali kolom birth_date ke students
        Schema::table('students', function (Blueprint $table) {
            $table->date('birth_date')->nullable()->after('user_id');
        });

        // 2. Copy data birth_date dari users ke students
        DB::statement('
            UPDATE students
            INNER JOIN users ON students.user_id = users.id
            SET students.birth_date = users.birth_date
            WHERE users.birth_date IS NOT NULL
        ');

        // 3. Hapus kolom dari users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['birth_date', 'phone', 'gender', 'alamat', 'kelurahan_id']);
        });
    }
};