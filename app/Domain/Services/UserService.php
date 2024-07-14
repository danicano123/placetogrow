<?php

namespace App\Domain\Services;

use App\Domain\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function getAllUsers()
    {
        try {
            return User::all();
        } catch (\Exception $e) {
            Log::error('Error fetching all users: ' . $e->getMessage());
        }
    }

    public function getUserById($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->role = $user->getRoleNames()->first(); // Obtener el rol del usuario
            return $user;
        } catch (\Exception $e) {
            Log::error('Error fetching user by ID: ' . $e->getMessage());
        }
    }

    public function updateUser($id, Request $request)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->all());
            return $user;
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
        }
    }
}
