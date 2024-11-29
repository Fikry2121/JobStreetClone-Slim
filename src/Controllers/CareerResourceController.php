<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\CareerResource;

class CareerResourceController
{
    public function getAllResources(Request $request, Response $response)
    {
        $resources = CareerResource::getAllResources();
        $response->getBody()->write(json_encode($resources));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getResourceById(Request $request, Response $response, $args)
    {
        $id_resource = $args['id'];
        $resource = CareerResource::getResourceById($id_resource);

        if ($resource) {
            $response->getBody()->write(json_encode($resource));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Resource not found']));
            return $response->withStatus(404);
        }

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function createResource(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $id_user = $data['id_user'] ?? null;
        $title = $data['title'] ?? null;
        $content = $data['content'] ?? null;
        $content_type = $data['content_type'] ?? null;

        if (!$id_user || !$title || !$content || !$content_type) {
            $response->getBody()->write(json_encode(['error' => 'Invalid input data']));
            return $response->withStatus(400);
        }

        $newResourceId = CareerResource::createResource($id_user, $title, $content, $content_type);
        $response->getBody()->write(json_encode(['message' => 'Resource created', 'id_resource' => $newResourceId]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateResource(Request $request, Response $response, $args)
    {
        $id_resource = $args['id'];
        $data = $request->getParsedBody();
        $title = $data['title'] ?? null;
        $content = $data['content'] ?? null;
        $content_type = $data['content_type'] ?? null;

        if (!$title || !$content || !$content_type) {
            $response->getBody()->write(json_encode(['error' => 'Invalid input data']));
            return $response->withStatus(400);
        }

        $rowsUpdated = CareerResource::updateResource($id_resource, $title, $content, $content_type);
        if ($rowsUpdated) {
            $response->getBody()->write(json_encode(['message' => 'Resource updated']));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Resource not found']));
            return $response->withStatus(404);
        }

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteResource(Request $request, Response $response, $args)
    {
        $id_resource = $args['id'];
        $rowsDeleted = CareerResource::deleteResource($id_resource);

        if ($rowsDeleted) {
            $response->getBody()->write(json_encode(['message' => 'Resource deleted']));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Resource not found']));
            return $response->withStatus(404);
        }

        return $response->withHeader('Content-Type', 'application/json');
    }
}