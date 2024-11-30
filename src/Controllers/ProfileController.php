<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Profile;

class ProfileController
{
    public function createProfile(Request $request, Response $response)
    {
        try {
            $data = $request->getParsedBody();

            if (!isset($data['email']) || !isset($data['password']) || !isset($data['phone'])) {
                throw new \Exception('Data tidak lengkap');
            }

            $profileId = Profile::createProfile($data);

            $response->getBody()->write(json_encode([
                'message' => 'Profile berhasil dibuat',
                'profile_id' => $profileId
            ]));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }

    public function updateProfile(Request $request, Response $response, $args)
    {
        try {
            $id_user = $args['id'];
            $data = $request->getParsedBody();

            if (empty($data)) {
                throw new \Exception('Data tidak lengkap');
            }

            Profile::updateProfile($id_user, $data);

            $response->getBody()->write(json_encode([
                'message' => 'Data profile berhasil diupdate'
            ]));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');

        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }

    public function deleteProfile(Request $request, Response $response, $args)
    {
        try {
            $id_user = $args['id'];
            Profile::deleteProfile($id_user);

            $response->getBody()->write(json_encode([
                'message' => 'Profile berhasil dihapus'
            ]));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }
}