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
        Permission::create(['guard_name' => 'web', 'name' => 'statistics']);
        Permission::create(['guard_name' => 'web', 'name' => 'manage-users']);

        // create roles and assign existing permissions
        $role1 = Role::create(['guard_name' => 'web', 'name' => 'chief']);
        $role1->givePermissionTo('statistics');
        $role1->givePermissionTo('manage-users');

        $role2 = Role::create(['guard_name' => 'web', 'name' => 'employee']);

        // create users
        $user = User::create([
            'name' => 'Тестовый начальник',
            'position' => 'Начальник',
            'birthday' => '1995-12-09',
            'phone' => 998937731818,
            'phone_verified_at' => now(),
            'password' => 12345,
        ]);

        $user->assignRole($role1);

        $user2 = User::create([
            'name' => 'Тестовый сотрудник',
            'position' => 'Сотрудник',
            'birthday' => '1995-12-09',
            'phone' => 998907006808,
            'phone_verified_at' => now(),
            'password' => 12345,
        ]);

        $user2->assignRole($role2);
    }
}
