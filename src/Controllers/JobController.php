<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Job;

class JobController
{
    public function getAllJobs(Request $request, Response $response)
    {
        $jobs = Job::getAllJobs();
        $response->getBody()->write(json_encode($jobs));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getJobById(Request $request, Response $response, $args)
    {
        $id_job = $args['id'];
        $jobs = Job::getJobById($id_job);
        if ($jobs) {
            $response->getBody()->write(json_encode($jobs));
        } else {
            $response->getBody()->write(json_encode(['error' => 'jobs not found']));
            return $response->withStatus(404);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }
}
