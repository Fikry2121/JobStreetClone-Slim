<?php
namespace App\Controllers;

use App\Models\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function getUser(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $userId = $args['id'];
        try {
            $user = $this->userModel->getUserById($userId);
            if (!$user) {
                return $this->json($response, ['message' => 'User not found'], 404);
            }
            return $this->json($response, $user, 200);
        } catch (\Exception $e) {
            return $this->json($response, ['error' => $e->getMessage()], 400);
        }
    }

    public function getAllUsers(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $users = $this->userModel->getAllUsers();
        return $this->json($response, $users, 200);
    }

    public function createUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getParsedBody();
        try {
            $userId = $this->userModel->createUser($data['email'], $data['password'], $data['phone']);
            return $this->json($response, ['id_user' => $userId], 201);
        } catch (\Exception $e) {
            return $this->json($response, ['error' => $e->getMessage()], 400);
        }
    }

    public function updateUser(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $userId = $args['id'];
        $data = $request->getParsedBody();
        try {
            $updatedRows = $this->userModel->updateUser($userId, $data['email'], $data['phone']);
            if ($updatedRows === 0) {
                return $this->json($response, ['message' => 'No changes made or user not found'], 404);
            }
            return $this->json($response, ['message' => 'User updated successfully'], 200);
        } catch (\Exception $e) {
            return $this->json($response, ['error' => $e->getMessage()], 400);
        }
    }

    public function deleteUser(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $userId = $args['id'];
        try {
            $deletedRows = $this->userModel->deleteUser($userId);
            if ($deletedRows === 0) {
                return $this->json($response, ['message' => 'User not found'], 404);
            }
            return $this->json($response, ['message' => 'User deleted successfully'], 200);
        } catch (\Exception $e) {
            return $this->json($response, ['error' => $e->getMessage()], 400);
        }
    }

    private function json(ResponseInterface $response, $data, int $status = 200): ResponseInterface
    {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
