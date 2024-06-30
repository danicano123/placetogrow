<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class RolePermissionService
{
    public function assignRoleToUser(User $user, string $role)
    {
        try {
            $user->assignRole($role);
        } catch (\Exception $e) {
            Log::error('Error assigning role: ' . $e->getMessage());
            throw new \Exception('Error assigning role');
        }
    }

    public function removeRoleFromUser(User $user, string $role)
    {
        try {
            $user->removeRole($role);
        } catch (\Exception $e) {
            Log::error('Error removing role: ' . $e->getMessage());
            throw new \Exception('Error removing role');
        }
    }

    public function givePermissionToUser(User $user, string $permission)
    {
        try {
            $user->givePermissionTo($permission);
        } catch (\Exception $e) {
            Log::error('Error giving permission: ' . $e->getMessage());
            throw new \Exception('Error giving permission');
        }
    }

    public function revokePermissionFromUser(User $user, string $permission)
    {
        try {
            $user->revokePermissionTo($permission);
        } catch (\Exception $e) {
            Log::error('Error revoking permission: ' . $e->getMessage());
            throw new \Exception('Error revoking permission');
        }
    }

    public function showUserRole(User $user): string
    {
        try {
            return $user->getRoleNames()->first(); // Assuming a user has only one role
        } catch (\Exception $e) {
            Log::error('Error fetching user role: ' . $e->getMessage());
            throw new \Exception('Error fetching user role');
        }
    }
}
