<?php

namespace App\Controllers;

use App\Models\Bookmark;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BookmarkController
{
    public function addBookmark($id_users, $id_jobs, Response $response)
{
    $result = Bookmark::addBookmark($id_users, $id_jobs);
    $response->getBody()->write(json_encode($result));
    return $response->withHeader('Content-Type', 'application/json');
}
// Menghapus bookmark
public function removeBookmark(Request $request, Response $response, array $args)
{
    $id_bookmark = $args['id'];
    $result = Bookmark::removeBookmark($id_bookmark);
    $response->getBody()->write(json_encode($result));
    return $response->withHeader('Content-Type', 'application/json');
}

// Melihat semua bookmark milik pengguna tertentu
public function viewBookmark(Request $request, Response $response, array $args)
{
    $id_users = $args['id'];
    $result = Bookmark::viewBookmark($id_users);
    $response->getBody()->write(json_encode($result));
    return $response->withHeader('Content-Type', 'application/json');
}
}