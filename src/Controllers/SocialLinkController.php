<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\SocialLink;

class SocialLinkController
{
    // Mengambil semua social link
    public function getAllSocialLinks(Request $request, Response $response)
    {
        try {
            $db = new SocialLink(null, null, null);
            $stmt = $db->getDB()->prepare("SELECT * FROM social_links");
            $stmt->execute();
            $socialLinks = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $response->getBody()->write(json_encode([
                'success' => true,
                'data' => $socialLinks,
                'message' => 'Berhasil mengambil semua data social link'
            ]));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ]));
            return $response->withHeader('Content-Type', 'application/json')
                           ->withStatus(500);
        }
    }

    public function getSocialLinkById(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $socialLink = new SocialLink($id, 1, ['platform' => 'Twitter', 'url' => 'https://twitter.com/user']);

        $response->getBody()->write(json_encode($socialLink));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function createSocialLink(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        
        try {
            // Validasi data yang diterima
            if (!isset($data['id_user']) || !isset($data['platform']) || !isset($data['url'])) {
                throw new \Exception('Data tidak lengkap. id_user, platform, dan url harus diisi');
            }

            // Persiapkan data
            $socialLinkData = [
                'id_user' => (int)$data['id_user'], // Pastikan id_user adalah integer
                'platform' => $data['platform'], // Ambil platform dari nested url object
                'url' => $data['url'] // Ambil url dari nested url object
            ];

            // Gunakan method static dari model SocialLink untuk menambah data
            $newSocialLinkId = SocialLink::addSocialLink($socialLinkData);

            // Buat instance SocialLink untuk response
            $socialLink = new SocialLink(
                $socialLinkData['id_user'],
                $socialLinkData['platform'],
                $socialLinkData['url']
            );
            
            $socialLink->id_social_link = $newSocialLinkId;

            $response->getBody()->write(json_encode([
                'success' => true,
                'data' => $socialLink,
                'message' => 'Social link berhasil dibuat'
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);

        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }

    public function updateSocialLink(Request $request, Response $response, $args)
    {
        try {
            $id = $args['id'];
            $data = $request->getParsedBody();

            // Validasi apakah data yang akan diupdate ada
            if (empty($data)) {
                throw new \Exception('Tidak ada data yang diupdate');
            }

            // Persiapkan data yang akan diupdate
            $updateData = [];
            if (isset($data['platform'])) {
                $updateData['platform'] = $data['platform'];
            }
            if (isset($data['url'])) {
                $updateData['url'] = $data['url'];
            }

            // Update social link
            SocialLink::updateSocialLink($id, $updateData);

            $response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Social link berhasil diupdate',
                'data' => $updateData
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }
    }

    public function deleteSocialLink(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $socialLink = new SocialLink($id, null, null);

        $response->getBody()->write(json_encode($socialLink));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
