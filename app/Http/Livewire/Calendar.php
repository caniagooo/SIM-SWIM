<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CourseSession;

class Calendar extends Component
{
    public $selectedDate;
    public $events = [];
    public $timeSlots = []; // Inisialisasi variabel timeSlots
    public $summary = [];

    public function mount()
    {
        // Ambil data sesi dari database
        $sessions = CourseSession::with(['course.students', 'course.trainers'])->get();

        // Format data untuk kalender
        $this->events = $sessions->map(function ($session) {
            return [
                'title' => $session->course->name,
                'date' => $session->session_date,
                'start_time' => $session->start_time,
                'end_time' => $session->end_time,
                'students' => $session->course->students->count(),
                'trainers' => $session->course->trainers->pluck('name')->join(', ')
            ];
        })->toArray();
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;

        // Filter events berdasarkan tanggal yang dipilih
        $filteredEvents = collect($this->events)->filter(function ($event) use ($date) {
            return $event['date'] === $date;
        });

        // Update time slots
        $this->timeSlots = $filteredEvents->map(function ($event) {
            return $event['start_time'] . ' - ' . $event['end_time'];
        })->toArray();

        // Update summary
        $this->summary = $filteredEvents->map(function ($event) {
            return [
                'course' => $event['title'],
                'students' => $event['students'],
                'trainers' => $event['trainers']
            ];
        })->first();
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}