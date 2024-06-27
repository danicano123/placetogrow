<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\RolePermissionService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $rolePermissionService;

    public function __construct(UserService $userService, RolePermissionService $rolePermissionService)
    {
        $this->userService = $userService;
        $this->rolePermissionService = $rolePermissionService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return response()->json(compact('users'), 200);
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        return response()->json(compact('user'), 200);
    }

    public function update(Request $request, $id)
    {
        $user = $this->userService->updateUser($id, $request);
        return response()->json(compact('user'), 200);
    }

    public function assignRole(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $this->rolePermissionService->assignRoleToUser($user, $request->input('role'));
        return response()->json(['message' => 'Role assigned successfully.'], 200);
    }

    public function removeRole(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $this->rolePermissionService->removeRoleFromUser($user, $request->input('role'));
        return response()->json(['message' => 'Role removed successfully.'], 200);
    }

    public function givePermission(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $this->rolePermissionService->givePermissionToUser($user, $request->input('permission'));
        return response()->json(['message' => 'Permission given successfully.'], 200);
    }

    public function revokePermission(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $this->rolePermissionService->revokePermissionFromUser($user, $request->input('permission'));
        return response()->json(['message' => 'Permission revoked successfully.'], 200);
    }
}
