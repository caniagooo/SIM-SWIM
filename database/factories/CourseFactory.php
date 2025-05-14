<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['private', 'group', 'organization']),
            'sessions' => $this->faker->numberBetween(1, 10),
        ];
    }
}