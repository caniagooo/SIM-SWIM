<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_materials', function (Blueprint $table) {
            $table->id();
            $table->string('level'); // Level materi (Beginner, Intermediate, Advanced)
            $table->string('name'); // Nama materi
            $table->integer('estimated_sessions'); // Estimasi sesi
            $table->integer('minimum_score'); // Skor minimal
            $table->timestamps();
        });

        // Tabel pivot untuk relasi many-to-many dengan Course
        Schema::create('course_course_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_material_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_course_material');
        Schema::dropIfExists('course_materials');
    }
};
