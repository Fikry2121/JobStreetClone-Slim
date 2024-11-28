<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\User;

class LoginController
{
    public function login(Request $request, Response $response)
    {
        try {
            $data = $request->getParsedBody();

            // Validasi data yang diperlukan
            if (!isset($data['email']) || !isset($data['password'])) {
                throw new \Exception('Email dan password diperlukan');
            }

            // Cek user berdasarkan email menggunakan query database
            $db = User::getConnection();
            $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $data['email']]);
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$user) {
                throw new \Exception('Email tidak ditemukan');
            }

            // Verifikasi password
            if (!password_verify($data['password'], $user['password'])) {
                throw new \Exception('Password salah');
            }

            // Hapus password dari response
            unset($user['password']);

            $responseData = [
                'status' => 'success',
                'message' => 'Login berhasil',
                'data' => $user
            ];

            $response->getBody()->write(json_encode($responseData));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        } catch (\Exception $e) {
            $responseData = [
                'status' => 'error', 
                'message' => $e->getMessage()
            ];

            $response->getBody()->write(json_encode($responseData));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401);
        }
    }
}
