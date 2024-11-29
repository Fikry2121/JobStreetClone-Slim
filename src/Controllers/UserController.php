<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Model\User as UserModel;
use App\Services\Model as DatabaseService;

class UserController
{
    private $userModel;

    public function __construct()
    {
        // Menggunakan DatabaseService untuk mendapatkan koneksi database
        $dbService = new DatabaseService();
        $this->userModel = new UserModel($dbService->getDB());
    }

    public function getAllUsers(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $users = $this->userModel->getAllUsers();
        $response->getBody()->write(json_encode($users));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getUserById(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $id = (int)$args['id'];
        $user = $this->userModel->getUserById($id);

        if (!$user) {
            return $response->withStatus(404);
        }

        $response->getBody()->write(json_encode($user));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function createUser(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $data = json_decode($request->getBody()->getContents(), true);
        $newUser = $this->userModel->createUser($data);

        $response->getBody()->write(json_encode($newUser));
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }

    public function updateUser(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $id = (int)$args['id'];
        $data = json_decode($request->getBody()->getContents(), true);
        $user = $this->userModel->getUserById($id);

        if (!$user) {
            return $response->withStatus(404);
        }

        $updatedUser = $this->userModel->updateUser($id, $data);
        $response->getBody()->write(json_encode($updatedUser));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteUser(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $id = (int)$args['id'];
        $user = $this->userModel->getUserById($id);

        if (!$user) {
            return $response->withStatus(404);
        }

        $this->userModel->deleteUser($id);
        return $response->withStatus(204); // No Content
    }
}
