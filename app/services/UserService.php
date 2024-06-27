<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class UserService
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById($id)
    {
        $user = User::findOrFail($id);
        $user->role = $user->getRoleNames(); // Obtener el rol del usuario
        return $user;
    }

    public function updateUser($id, Request $request)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return $user;
    }
}
