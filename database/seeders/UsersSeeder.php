<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

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
        $user = User::updateOrCreate(
            ['email' => 'admin@jitu.com'],
            [
                'name'     => 'Jitu Teknologi',
                'password' => Hash::make('password'),
                'type'     => 'member', // atau 'role' jika field-nya role
            ]
        );

        // Assign role Super Admin
        $user->assignRole('Super Admin');
    }
}
