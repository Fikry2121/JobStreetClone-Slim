<?php

namespace App\Controllers;

use App\Models\User;
use Exception;

class UserController
{
    public function createUser($request)
    {
        try {
            $data = json_decode($request->getBody(), true);
            User::createUser($data);
            return ['status' => 'success', 'message' => 'User created successfull.'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getAllUsers()
    {
        $users = User::getAllUsers();
        return ['status' => 'success', 'data' => $users];
    }

    public function getUserById($id)
    {
        $user = User::getUserById($id);
        if ($user) {
            return ['status' => 'success', 'data' => $user];
        } else {
            return ['status' => 'error', 'message' => 'User not found.'];
        }
    }

    public function updateUser($request, $id)
    {
        try {
            $data = json_decode($request->getBody(), true);
            User::updateUser($id, $data);
            return ['status' => 'success', 'message' => 'User updated successfully.'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function deleteUser($id)
    {
        if (User::deleteUser($id)) {
            return ['status' => 'success', 'message' => 'User deleted successfully.'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to delete user.'];
        }
    }
}
