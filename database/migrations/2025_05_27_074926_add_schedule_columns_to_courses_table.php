<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScheduleColumnsToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('price'); // Tanggal mulai course
            $table->integer('duration_days')->nullable()->after('start_date'); // Durasi masa berlaku dalam hari
            $table->integer('max_sessions')->nullable()->after('duration_days'); // Jumlah maksimal pertemuan
            $table->date('valid_until')->nullable()->after('max_sessions'); // Tanggal akhir masa berlaku
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'duration_days', 'max_sessions', 'valid_until']);
        });
    }
};
