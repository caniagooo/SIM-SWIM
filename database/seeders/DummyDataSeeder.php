<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Venue;
use App\Models\Course;
use App\Models\Trainer;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        // Create Users
        $users = User::factory()->count(10)->create();

        // Assign Roles
        $users->each(function ($user, $index) {
            if ($index === 0) {
                $user->assignRole('Super Admin');
            } elseif ($index <= 2) {
                $user->assignRole('Admin');
            } elseif ($index <= 5) {
                $user->assignRole('Pelatih');
            } else {
                $user->assignRole('Murid');
            }
        });

        // Create Venues
        $venues = Venue::factory()->count(3)->create();

        // Create Courses
        $courses = Course::factory()->count(5)->create();

        // Assign Courses to Venues
        $courses->each(function ($course) use ($venues) {
            $course->update(['venue_id' => $venues->random()->id]); // Perbaikan di sini
        });

        // Create Trainers
        $trainers = Trainer::factory()->count(3)->create();

        // Assign Trainers to Courses
        $trainers->each(function ($trainer) use ($courses) {
            $trainer->courses()->attach($courses->random(2)->pluck('id')); // Relasi many-to-many
        });

        // Create Students
        $students = Student::factory()->count(5)->create();

        // Assign Students to Courses
        $students->each(function ($student) use ($courses) {
            $student->courses()->attach($courses->random(2)->pluck('id')); // Relasi many-to-many
        });
    }
}
