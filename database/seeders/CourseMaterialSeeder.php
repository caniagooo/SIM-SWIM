<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseMaterial;

class CourseMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            // Beginner Level Materials
            [
                'level' => 'Beginner',
                'name' => 'Introduction to Swimming',
                'estimated_sessions' => 2,
                'minimum_score' => 50,
            ],
            [
                'level' => 'Beginner',
                'name' => 'Basic Floating Techniques',
                'estimated_sessions' => 3,
                'minimum_score' => 60,
            ],
            [
                'level' => 'Beginner',
                'name' => 'Breathing Techniques',
                'estimated_sessions' => 2,
                'minimum_score' => 55,
            ],

            // Intermediate Level Materials
            [
                'level' => 'Intermediate',
                'name' => 'Freestyle Swimming',
                'estimated_sessions' => 4,
                'minimum_score' => 70,
            ],
            [
                'level' => 'Intermediate',
                'name' => 'Backstroke Techniques',
                'estimated_sessions' => 4,
                'minimum_score' => 75,
            ],
            [
                'level' => 'Intermediate',
                'name' => 'Treading Water',
                'estimated_sessions' => 3,
                'minimum_score' => 65,
            ],

            // Advanced Level Materials
            [
                'level' => 'Advanced',
                'name' => 'Butterfly Stroke',
                'estimated_sessions' => 5,
                'minimum_score' => 80,
            ],
            [
                'level' => 'Advanced',
                'name' => 'Competitive Swimming Techniques',
                'estimated_sessions' => 6,
                'minimum_score' => 85,
            ],
            [
                'level' => 'Advanced',
                'name' => 'Endurance Training',
                'estimated_sessions' => 5,
                'minimum_score' => 90,
            ],
        ];

        foreach ($materials as $material) {
            CourseMaterial::create($material);
        }
    }
}
