<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\JobPost;

class JobPostController
{
    public function getAllJobs(Request $request, Response $response)
    {
        $jobs = JobPost::getAllJobs();
        $response->getBody()->write(json_encode($jobs));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getJobById(Request $request, Response $response, $args)
    {
        $id_job = $args['id'];
        $jobs = JobPost::getJobById($id_job);
        if ($jobs) {
            $response->getBody()->write(json_encode($jobs));
        } else {
            $response->getBody()->write(json_encode(['error' => 'jobs not found']));
            return $response->withStatus(404);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function createJob(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $id_job = JobPost::createJob(
            $data['id_job'],
            $data['job_type'],
            $data['job_description'],
            $data['job_location'],
            $data['status']
        );
        $response->getBody()->write(json_encode(['id_job' => $id_job, 'message' => 'job created successfully']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function updateJob(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();

        try {
            // Cari block yang akan diupdate
            $jobs = JobPost::getJobById($id);
            if (!$jobs) {
                $response->getBody()->write(json_encode([
                    "message" => "job tidak ditemukan"
                ]));
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }

            // Gunakan data block yang ada sebagai dasar
            $updateData = $jobs;

            // Update hanya field yang dikirim dalam request
            if (isset($data['id_job'])) {
                $updateData['id_job'] = $data['id_job'];
            }
            if (isset($data['job_type'])) {
                $updateData['job_type'] = $data['job_type'];
            }
            if (isset($data['job_description'])) {
                $updateData['job_description'] = $data['job_description'];
            }
            if (isset($data['job_location'])) {
                $updateData['job_location'] = $data['job_location'];
            }
            if (isset($data['status'])) {
                $updateData['status'] = $data['status'];
            }

            $result = JobPost::updateJob(
                $id,
                $updateData['id_job'],
                $updateData['job_type'],
                $updateData['job_description'],
                $updateData['job_location'],
                $updateData['status']
            );

            if ($result) {
                // Ambil data yang sudah diupdate
                $updatedjob = JobPost::getJobById($id);
                $response->getBody()->write(json_encode([
                    "message" => "Job berhasil diupdate",
                    "data" => $updatedjob
                ]));
            } else {
                $response->getBody()->write(json_encode([
                    "message" => "Gagal mengupdate job"
                ]));
            }
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\PDOException $e) {
            $response->getBody()->write(json_encode([
                "error" => $e->getMessage()
            ]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function deleteJob(Request $request, Response $response, $args)
    {
        $id_job = $args['id'];
        $deleted = JobPost::deleteJob($id_job);
        if ($deleted) {
            $response->getBody()->write(json_encode(['message' => 'job deleted successfully']));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Failed to delete job']));
            return $response->withStatus(400);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }
}
