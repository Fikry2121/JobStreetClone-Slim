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
            return ['status' => 'success', 'message' => 'User created successfully.'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getAllUsers()
    {
        $users = User::getAllUsers();
        return ['status' => 'success', 'data' => $users];
    }

    public function getUserById($request, $response, $args)
    {
        $id = $args['id']; // Mengambil ID dari args
        $user = User::getUserById($id);
        if ($user) {
            return $response->withJson(['status' => 'success', 'data' => $user], 200);
        } else {
            return $response->withJson(['status' => 'error', 'message' => 'User not found.'], 404);
        }
    }

    public function updateUser($request, $response, $args)
    {
        $id = $args['id']; // Mengambil ID dari args
        try {
            $data = json_decode($request->getBody(), true);
            User::updateUser($id, $data);
            return $response->withJson(['status' => 'success', 'message' => 'User updated successfully.'], 200);
        } catch (Exception $e) {
            return $response->withJson(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteUser($request, $response, $args)
    {
        $id = $args['id']; // Mengambil ID dari args
        if (User::deleteUser($id)) {
            return $response->withJson(['status' => 'success', 'message' => 'User deleted successfully.'], 200);
        } else {
            return $response->withJson(['status' => 'error', 'message' => 'Failed to delete user.'], 500);
        }
    }
}
