<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\ProjectBrief;

class ProjectBriefController
{
    public function getAllProjectBriefs(Request $request, Response $response)
    {
        $projectBrief = new ProjectBrief();
        $data = $projectBrief->getAllProjectBriefs();

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function addProjectBrief(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $user_id = $data['user_id'];
        $description = $data['description'];
        $deadline = $data['deadline'];

        $projectBrief = new ProjectBrief();
        $result = $projectBrief->addProjectBrief($user_id, $description, $deadline);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateProjectBrief(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $description = $data['description'];
        $deadline = $data['deadline'];

        $projectBrief = new ProjectBrief();
        $result = $projectBrief->updateProjectBrief($id, $description, $deadline);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteProjectBrief(Request $request, Response $response, array $args)
    {
        $id = $args['id'];

        $projectBrief = new ProjectBrief();
        $result = $projectBrief->deleteProjectBrief($id);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
