<?php

namespace App\Services;

use App\Models\User;

class RolePermissionService
{
    public function assignRoleToUser(User $user, string $role)
    {
        $user->assignRole($role);
    }

    public function removeRoleFromUser(User $user, string $role)
    {
        $user->removeRole($role);
    }

    public function givePermissionToUser(User $user, string $permission)
    {
        $user->givePermissionTo($permission);
    }

    public function revokePermissionFromUser(User $user, string $permission)
    {
        $user->revokePermissionTo($permission);
    }
}
