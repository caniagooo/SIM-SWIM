<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Roles
        $roles = ['Super Admin', 'Admin', 'Pelatih', 'Murid', 'Kepala Organisasi'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Permissions
        $permissions = [
            'manage users',
            'manage venues',
            'manage courses',
            'view students',
            'manage attendance',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign Permissions to Roles
        Role::findByName('Super Admin')->givePermissionTo(Permission::all());
        Role::findByName('Admin')->givePermissionTo(['manage users', 'manage venues', 'manage courses']);
        Role::findByName('Pelatih')->givePermissionTo(['view students', 'manage attendance']);
        Role::findByName('Kepala Organisasi')->givePermissionTo(['view students']);
    }
}