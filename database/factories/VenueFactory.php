<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VenueFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'ownership' => $this->faker->randomElement(['club', 'third_party', 'private']),
            'address' => $this->faker->address,
        ];
    }
}