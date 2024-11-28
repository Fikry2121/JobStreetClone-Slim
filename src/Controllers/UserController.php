<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\User;

class UserController
{
    // Mendapatkan semua data user
    public function getAllUsers(Request $request, Response $response)
    {
        try {
            $users = User::all();
            $response->getBody()->write(json_encode($users));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $response->withStatus(500);
        }
    }

    // Mendapatkan user berdasarkan ID
    public function getUserById(Request $request, Response $response, $args)
    {
        try {
            $id = $args['id'];
            $user = User::find($id);

            if (!$user) {
                $response->getBody()->write(json_encode([
                    'error' => 'User tidak ditemukan'
                ]));
                return $response->withStatus(404);
            }

            $response->getBody()->write(json_encode($user->toArray()));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $response->withStatus(500);
        }
    }

    // Membuat user baru
    public function createUser(Request $request, Response $response)
    {
        try {
            $data = $request->getParsedBody();

            // Validasi data yang diperlukan
            if (
                !isset($data['username']) ||
                !isset($data['email']) || !isset($data['phone']) ||
                !isset($data['password'])
            ) {
                throw new \Exception('Data tidak lengkap');
            }

            $user = new User($data);
            $user->save();

            $response->getBody()->write(json_encode([
                'message' => 'User berhasil dibuat',
                'user' => $user->toArray()
            ]));
            return $response->withStatus(201);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $response->withStatus(400);
        }
    }

    // Mengupdate data user
    public function updateUser(Request $request, Response $response, $args)
    {
        try {
            $id = $args['id'];
            // Ambil data dari form-data
            $data = $request->getParsedBody();

            // Logging untuk debug
            error_log('Request Data: ' . json_encode($data));

            $user = User::find($id);
            if (!$user) {
                throw new \Exception('User tidak ditemukan');
            }

            // Catat data sebelum update
            error_log('Data sebelum update: ' . json_encode($user->toArray()));

            // Update data user
            if (isset($data['username'])) {
                $user->username = $data['username'];
            }


            if (isset($data['email'])) {
                $user->email = $data['email'];
            }
            if (isset($data['phone'])) {
                $user->phone = $data['phone'];
            }

            // Simpan perubahan
            $user->save();

            // Catat data setelah update
            error_log('Data setelah update: ' . json_encode($user->toArray()));

            $responseData = [
                'status' => 'success',
                'message' => 'Data user berhasil diupdate',
                'data' => $user->toArray()
            ];

            $response->getBody()->write(json_encode($responseData));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        } catch (\Exception $e) {
            error_log('Error updating user: ' . $e->getMessage());
            $responseData = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];

            $response->getBody()->write(json_encode($responseData));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }
    }

    // Menghapus user
    public function deleteUser(Request $request, Response $response, $args)
    {
        try {
            $id = $args['id'];
            $user = User::find($id);

            if (!$user) {
                throw new \Exception('User tidak ditemukan');
            }

            $user->delete();

            $response->getBody()->write(json_encode([
                'message' => 'User berhasil dihapus'
            ]));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $response->withStatus(400);
        }
    }
}
