<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PeopleSeeder extends Seeder
{
    public function run()
    {
        // Seeder 10 pelatih
        $coaches = [
            'Dedi Gunawan',
            'Sri Wahyuni',
            'Hendra Saputra',
            'Lilis Suryani',
            'Rizky Ramadhan',
            'Yuni Astuti',
            'Fajar Nugroho',
            'Dian Permata',
            'Bayu Pratama',
            'Mega Sari'
        ];

        foreach ($coaches as $i => $name) {
            User::create([
                'name' => $name,
                'email' => 'pelatih' . ($i + 1) . '@jitu.com',
                'password' => Hash::make('password'),
                'type' => 'coach', // pastikan field 'type' atau 'role' sesuai
            ]);
        }

        // Seeder 13 murid
        $students = [
            'Ayu Lestari',
            'Rian Firmansyah',
            'Putri Amelia',
            'Dimas Saputra',
            'Salsa Oktaviani',
            'Galih Prakoso',
            'Nadia Rahma',
            'Rafi Maulana',
            'Intan Permatasari',
            'Yoga Pratama',
            'Citra Dewi',
            'Fauzan Hidayat',
            'Melati Ayu'
        ];

        foreach ($students as $i => $name) {
            User::create([
                'name' => $name,
                'email' => 'murid' . ($i + 1) . '@jitu.com',
                'password' => Hash::make('password'),
                'type' => 'student', // pastikan field 'type' atau 'role' sesuai
            ]);
        }
    }
}