<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Service;

class ServiceController
{
    public function getAllServices(Request $request, Response $response)
    {
        $service = new Service();
        $data = $service->getAllServices();

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function addService(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $user_id = $data['user_id'];
        $category_id = $data['category_id'];
        $title = $data['title'];
        $description = $data['description'];
        $price = $data['price'];

        $service = new Service();
        $result = $service->addService($user_id, $category_id, $title, $description, $price);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateService(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $title = $data['title'];
        $description = $data['description'];
        $price = $data['price'];

        $service = new Service();
        $result = $service->updateService($id, $title, $description, $price);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteService(Request $request, Response $response, array $args)
    {
        $id = $args['id'];

        $service = new Service();
        $result = $service->deleteService($id);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
