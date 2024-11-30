<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Application;

class ApplicationController
{
    public function getAllApplications(Request $request, Response $response)
    {
        $applications = Application::getAllApplications();
        $response->getBody()->write(json_encode($applications));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getApplicationById(Request $request, Response $response, $args)
    {
        $id_application = $args['id'];
        $application = Application::getApplicationById($id_application);
        if ($application) {
            $response->getBody()->write(json_encode($application));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Application not found']));
            return $response->withStatus(404);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function createApplication(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $id_job = $data['id_job'];
        $status_application = $data['status_application'];
        $id_application = Application::createApplication($id_job, $status_application);
        $response->getBody()->write(json_encode(['id_application' => $id_application]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateApplicationStatus(Request $request, Response $response, $args)
    {
        $id_application = $args['id'];
        $data = $request->getParsedBody();
        $status_application = $data['status_application'];
        $updatedRows = Application::updateApplicationStatus($id_application, $status_application);
        $response->getBody()->write(json_encode(['updated_rows' => $updatedRows]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteApplication(Request $request, Response $response, $args)
    {
        $id_application = $args['id'];
        $deletedRows = Application::deleteApplication($id_application);
        $response->getBody()->write(json_encode(['deleted_rows' => $deletedRows]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}