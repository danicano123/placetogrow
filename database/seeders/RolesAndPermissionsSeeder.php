<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Crear permisos
        $readUsersPermission = Permission::create(['name' => 'read users']);
        $editUsersPermission = Permission::create(['name' => 'edit users']);
        $deleteUsersPermission = Permission::create(['name' => 'delete users']);
        $readMicrositesPermission = Permission::create(['name' => 'read microsites']);
        $createMicrositesPermission = Permission::create(['name' => 'create microsites']);
        $editMicrositesPermission = Permission::create(['name' => 'edit microsites']);
        $deleteMicrositesPermission = Permission::create(['name' => 'delete microsites']);

        // Asignar permisos a roles
        $adminRole->givePermissionTo([
            $readUsersPermission,
            $editUsersPermission,
            $deleteUsersPermission,
            $readMicrositesPermission,
            $createMicrositesPermission,
            $editMicrositesPermission,
            $deleteMicrositesPermission
        ]);

        $userRole->givePermissionTo([
            $readMicrositesPermission,
        ]);

        // Crear usuario y asignarle el rol de admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);

        $admin->assignRole($adminRole);
    }
}
