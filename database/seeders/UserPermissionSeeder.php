<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['guard_name' => 'web', 'name' => 'dashboard']);
        Permission::create(['guard_name' => 'web', 'name' => 'manage-users']);

        // create roles and assign existing permissions

        $role1 = Role::create(['guard_name' => 'web', 'name' => 'chief']);
        $role1->givePermissionTo('dashboard');
        $role1->givePermissionTo('manage-users');

        $role2 = Role::create(['guard_name' => 'web', 'name' => 'employee']);

        // create user
        $user = User::create([
            'name' => 'Тестовый Начальник',
            'position' => 'Начальник',
            'phone' => 998937731818,
            'phone_verified_at' => now(),
            'password' => 12345,
        ]);
        $user->assignRole($role1);
    }
}
