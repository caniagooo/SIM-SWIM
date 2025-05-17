<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seeder untuk 1 super admin
        User::create([
            'name'              => 'Jitu Teknologi',
            'email'             => 'admin@jitu.com',
            'password'          => Hash::make('password'),
            'type'              => 'member', // pastikan field 'role' ada di tabel users
        ]);

        // Seeder untuk 10 user biasa dengan nama Indonesia
        $names = [
            'Budi Santoso',
            'Siti Aminah',
            'Agus Prabowo',
            'Dewi Lestari',
            'Rina Marlina',
            'Andi Wijaya',
            'Fitriani Putri',
            'Joko Susilo',
            'Teguh Saputra',
            'Maya Sari'
        ];

        foreach ($names as $index => $name) {
            User::create([
                'name'              => $name,
                'email'             => 'user' . ($index + 1) . '@jitu.com',
                'password'          => Hash::make('password'),
                'type'              => 'member', // pastikan field 'role' ada di tabel users
            ]);
        }
    }
}
