<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Category;

class CategoryController
{
    public function getAllCategories(Request $request, Response $response)
    {
        $category = new Category();
        $data = $category->getAllCategories();

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function addCategory(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $name = $data['name'];
        $description = $data['description'];

        $category = new Category();
        $result = $category->addCategory($name, $description);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateCategory(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $name = $data['name'];
        $description = $data['description'];

        $category = new Category();
        $result = $category->updateCategory($id, $name, $description);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteCategory(Request $request, Response $response, array $args)
    {
        $id = $args['id'];

        $category = new Category();
        $result = $category->deleteCategory($id);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
