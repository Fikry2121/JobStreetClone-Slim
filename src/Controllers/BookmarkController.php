<?php

namespace App\Controllers;

use App\Models\Bookmark;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BookmarkController
{
    // Menambahkan bookmarks
    public function addBookmark(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $id_user = $data['id_user'] ?? null;
        $id_job = $data['id_job'] ?? null;

        if (!$id_user || !$id_job) {
            $response->getBody()->write(json_encode(['success' => false, 'message' => 'Invalid input data']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $result = Bookmark::addBookmark($id_user, $id_job);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Menghapus bookmark
    public function removeBookmark(Request $request, Response $response, array $args)
    {
        $id_bookmark = $args['id'] ?? null;

        if (!$id_bookmark) {
            $response->getBody()->write(json_encode(['success' => false, 'message' => 'Invalid bookmark ID']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $result = Bookmark::removeBookmark($id_bookmark);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Melihat semua bookmark milik pengguna tertent
    public function viewBookmark(Request $request, Response $response, array $args)
    {
        $id_bookmark = $args['id'] ?? null;

        if (!$id_bookmark) {
            $response->getBody()->write(json_encode(['success' => false, 'message' => 'Invalid user ID']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $result = Bookmark::viewBookmark($id_bookmark);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
