<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseExpiringNotification extends Notification
{
    use Queueable;

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
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
