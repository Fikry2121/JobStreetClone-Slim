<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Profile;

class ProfileController
{
    // Mendapatkan semua data profile
    public function getAllProfiles(Request $request, Response $response)
    {
        try {
            $profiles = Profile::all();
            $response->getBody()->write(json_encode($profiles));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $response->withStatus(500);
        }
    }

    // Mendapatkan profile berdasarkan ID
    public function getProfileById(Request $request, Response $response, $args)
    {
        try {
            $id = $args['id'];
            $profile = Profile::find($id);

            if (!$profile) {
                $response->getBody()->write(json_encode([
                    'error' => 'Profile tidak ditemukan'
                ]));
                return $response->withStatus(404);
            }

            $response->getBody()->write(json_encode($profile));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $response->withStatus(500);
        }
    }

    // Membuat profile baru
    public function createProfile(Request $request, Response $response)
    {
        try {
            $data = $request->getParsedBody();

            // Validasi data yang diperlukan
            if (!isset($data['id_user']) || !isset($data['id_social_link']) || 
                !isset($data['profile_pict']) || !isset($data['about_you']) ||
                !isset($data['banner'])) {
                throw new \Exception('Data tidak lengkap');
            }

            $profile = new Profile(
                $data['id_social_link'],
                $data['id_user'],
                $data['profile_pict'],
                $data['about_you'],
                $data['banner']
            );
            $profile->save();

            $response->getBody()->write(json_encode([
                'message' => 'Profile berhasil dibuat',
                'profile' => $profile->getAttributes()
            ]));
            return $response->withStatus(201);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $response->withStatus(400);
        }
    }

    // Mengupdate data profile
    public function updateProfile(Request $request, Response $response, $args)
    {
        try {
            $id = $args['id'];
            $data = $request->getParsedBody();
            
            $profile = Profile::find($id);
            if (!$profile) {
                throw new \Exception('Profile tidak ditemukan');
            }

            // Update data profile
            $updateData = $profile; // Gunakan data profile yang ada sebagai dasar
            
            // Hanya update field yang dikirim dalam request
            if (isset($data['id_social_link'])) {
                $updateData['id_social_link'] = $data['id_social_link'];
            }
            if (isset($data['id_user'])) {
                $updateData['id_user'] = $data['id_user']; 
            }
            if (isset($data['profile_pict'])) {
                $updateData['profile_pict'] = $data['profile_pict'];
            }
            if (isset($data['about_you'])) {
                $updateData['about_you'] = $data['about_you'];
            }
            if (isset($data['banner'])) {
                $updateData['banner'] = $data['banner'];
            }

            // Simpan perubahan
            Profile::updateProfile($id, $updateData);

            $updatedProfile = Profile::find($id);
            $responseData = [
                'status' => 'success',
                'message' => 'Data profile berhasil diupdate',
                'data' => $updatedProfile
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
                ->withStatus(400);
        }
    }

    // Menghapus profile
    public function deleteProfile(Request $request, Response $response, $args)
    {
        try {
            $id = $args['id'];
            $profile = Profile::find($id);
            
            if (!$profile) {
                throw new \Exception('Profile tidak ditemukan');
            }

            Profile::deleteProfile($id);

            $response->getBody()->write(json_encode([
                'message' => 'Profile berhasil dihapus'
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
