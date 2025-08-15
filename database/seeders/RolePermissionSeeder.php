<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // List Permission
        $permissions = [
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'view items',
            'create items',
            'edit items',
            'delete items',
            'manage users',
            'manage roles',
        ];

        // Buat permission
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat role Admin & User
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign permission ke role
        $adminRole->givePermissionTo($permissions);

        $userRole->givePermissionTo([
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'view items',
            'create items',
            'edit items',
            'delete items',
        ]);

        // Buat akun Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        // Buat akun User
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User',
                'password' => Hash::make('password'),
            ]
        );
        $user->assignRole('user');
    }
}
