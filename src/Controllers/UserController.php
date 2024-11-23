<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\User;

class UserController
{
    public function getAllUsers(Request $request, Response $response)
    {
        $user = new User();
        $data = $user->getAllUsers();

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function addUser(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $role = $data['role'];
        $profile = $data['profile'];

        $user = new User();
        $result = $user->addUser($name, $email, $password, $role, $profile);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateUser(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $name = $data['name'];
        $email = $data['email'];
        $role = $data['role'];
        $profile = $data['profile'];

        $user = new User();
        $result = $user->updateUser($id, $name, $email, $role, $profile);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteUser(Request $request, Response $response, array $args)
    {
        $id = $args['id'];

        $user = new User();
        $result = $user->deleteUser($id);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
