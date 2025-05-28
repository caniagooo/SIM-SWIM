<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Jadwalkan tugas untuk dijalankan setiap hari pada pukul 00:00
        $schedule->call(function () {
            // Ambil semua course yang akan berakhir dalam 3 hari
            $courses = \App\Models\Course::where('valid_until', '<=', now()->addDays(3))
                ->where('valid_until', '>=', now())
                ->get();

            foreach ($courses as $course) {
                // Kirim notifikasi ke murid yang terdaftar di course
                foreach ($course->students as $student) {
                    $student->notify(new \App\Notifications\CourseExpiringNotification($course));
                }
            }
        })->dailyAt('00:00'); // Jalankan setiap hari pada pukul 00:00
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
