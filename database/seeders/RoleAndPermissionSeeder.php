<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //team managers
        Permission::create(['name' => 'create task']);
        Permission::create(['name' => 'edit task']);
        Permission::create(['name' => 'meetings']);
        Permission::create(['name' => 'delete task']);
        // team member
        Permission::create(['name' => 'team']);
        Permission::create(['name' => 'projects']);
        Permission::create(['name' => 'profiles']);
        // admin
        Permission::create(['name' => 'assign roles and permissions']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'view teams']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(['assign roles and permissions', 'view users', 'view teams']);

        $normalUser = Role::create(['name' => 'normalUser']);
        $normalUser->givePermissionTo(['create task', 'edit task', 'delete task']);

        $teamUser = Role::create(['name' => 'teamUser']);
        $teamUser->givePermissionTo(['team', 'projects', 'profiles']);

        $teamManager = Role::create(['name' => 'teamManager']);
        $teamManager->givePermissionTo(['create task', 'edit task', 'meetings', 'delete task', 'team', 'projects', 'profiles', 'projects']);
    }
}
