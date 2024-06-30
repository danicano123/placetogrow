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
        $readSitesPermission = Permission::create(['name' => 'read sites']);
        $createSitesPermission = Permission::create(['name' => 'create sites']);
        $editSitesPermission = Permission::create(['name' => 'edit sites']);
        $deleteSitesPermission = Permission::create(['name' => 'delete sites']);

        // Asignar permisos a roles
        $adminRole->givePermissionTo([
            $readUsersPermission,
            $editUsersPermission,
            $deleteUsersPermission,
            $readSitesPermission,
            $createSitesPermission,
            $editSitesPermission,
            $deleteSitesPermission
        ]);

        $userRole->givePermissionTo([
            $readSitesPermission,
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
