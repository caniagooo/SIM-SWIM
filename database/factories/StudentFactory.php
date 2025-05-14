<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'birth_date' => $this->faker->date(),
            'age_group' => $this->faker->randomElement(['balita', 'anak-anak', 'remaja', 'dewasa']),
        ];
    }
}