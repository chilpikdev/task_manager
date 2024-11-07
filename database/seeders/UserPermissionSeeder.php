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
            'name' => 'Суражатдин',
            'position' => 'Начальник',
            'birthday' => '1987-01-01',
            'phone' => 998975005121,
            'phone_verified_at' => now(),
            'password' => 'Dm4Q9ppI9qDq',
        ]);

        $user->assignRole($role1);

        $user2 = User::create([
            'name' => 'Сотрудник',
            'position' => 'Сотрудник',
            'birthday' => '1987-01-01',
            'phone' => 998906539033,
            'phone_verified_at' => now(),
            'password' => 'j8S93SmjGfP1',
        ]);

        $user2->assignRole($role2);
    }
}
