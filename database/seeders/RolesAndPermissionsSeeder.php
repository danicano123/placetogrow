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
        $editUsersPermission = Permission::create(['name' => 'edit users']);
        $deleteUsersPermission = Permission::create(['name' => 'delete users']);
        $createSitesPermission = Permission::create(['name' => 'create sites']);
        $editSitesPermission = Permission::create(['name' => 'edit sites']);
        $deleteSitesPermission = Permission::create(['name' => 'delete sites']);

        // Crear usuario y asignarle rol y permisos
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);

        $admin->assignRole($adminRole);
        $admin->givePermissionTo([$createSitesPermission, $editSitesPermission, $deleteSitesPermission, $editUsersPermission, $deleteUsersPermission]);
    }
}
