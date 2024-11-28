<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Application;
use App\Models\User;
use App\Models\Block;

class ApplicationController
{
    // Mengambil semua halaman
    public function getAllApplication(Request $request, Response $response)
    {
        // Simulasi mengambil data dari database
        $applications = Application::all(); // Asumsi Anda sudah menambahkan method all() di model Page untuk mengambil semua page

        $response->getBody()->write(json_encode($applications));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Mengambil halaman berdasarkan ID
    public function getApplicationById(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $application = Application::find($id); // Asumsi Anda sudah menambahkan method find() di model Page

        if ($application) {
            $response->getBody()->write(json_encode($application->toArray()));
        } else {
            $response->getBody()->write(json_encode(["message" => "application not found"]));
        }

        return $response->withHeader('Content-Type', 'application/json');
    }

                // Update hanya field yang dikirim dalam request
            if (isset($data['id_user'])) {
                $updateData['id_user'] = $data['id_user'];
            }
            if (isset($data['id_profile'])) {
                $updateData['id_profile'] = $data['id_profile'];
            }
            if (isset($data['title'])) {
                $updateData['title'] = $data['title'];
            }

            // Tambahkan updated_at
            $updateData['updated_at'] = date('Y-m-d H:i:s');

            $result = Page::updatePage($id, $updateData);
            
            if ($result > 0) {
                // Ambil data yang sudah diupdate
                $updatedPage = Page::find($id);
                $response->getBody()->write(json_encode([
                    "message" => "Page berhasil diupdate",
                    "data" => $updatedPage
                ]));
            } else {
                $response->getBody()->write(json_encode([
                    "message" => "Gagal mengupdate page"
                ]));
            }
            return $response->withHeader('Content-Type', 'application/json');

        } catch (\PDOException $e) {
            $response->getBody()->write(json_encode([
                "message" => $e->getMessage()
            ]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    // Menghapus halaman berdasarkan ID
    public function deletePage(Request $request, Response $response, $args)
    {
        $id = $args['id'];

        try {
            $result = Page::deletePage($id);
            if ($result > 0) {
                $response->getBody()->write(json_encode(["status" => "success", "message" => "Page deleted successfully"]));
            } else {
                $response->getBody()->write(json_encode(["status" => "error", "message" => "Page not found"]));
            }
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\PDOException $e) {
            $response->getBody()->write(json_encode(["status" => "error", "message" => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    // Mengambil Blocks yang terkait dengan halaman
    public function getBlocksByPage(Request $request, Response $response, $args)
    {
        $id_page = $args['id'];

        // Ambil semua block yang terkait dengan halaman ini
        $blocks = Page::getBlocks($id_page);
        $response->getBody()->write(json_encode($blocks));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Mengambil User yang memiliki halaman
    public function getUserByPage(Request $request, Response $response, $args)
    {
        $id_user = $args['id'];

        // Ambil User terkait dengan halaman ini
        $user = Page::getUser($id_user);
        $response->getBody()->write(json_encode($user));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
