<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Applications;

class ApplicationsController
{
    // Melamar pekerjaan
    public function applyForJob(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $result = Applications::applyForJob($data['id_user'], $data['id_job']);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Melacak status lamaran berdasarkan ID
    public function trackApplicationStatus(Request $request, Response $response, $args)
    {
        $id_application = $args['id'];
        $result = Applications::trackApplicationStatus($id_application);
        if ($result) {
            $response->getBody()->write(json_encode($result));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Application not found']));
            return $response->withStatus(404);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Mendapatkan semua lamaran berdasarkan pengguna
    public function getApplicationsByUser(Request $request, Response $response, $args)
    {
        $id_user = $args['id'];
        $result = Applications::getApplicationsByUser($id_user);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }
}