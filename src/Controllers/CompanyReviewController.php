<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\CompanyReview;

class CompanyReviewController
{
    // Menambahkan ulasan baru
    public function createReview(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $result = CompanyReview::createReview([
            'id_user' => $data['id_user'],
            'id_company' => $data['id_company'],
            'rating' => $data['rating'],
            'review_text' => $data['review_text'],
            'job_position' => $data['job_position'],
            'employment_status' => $data['employment_status'],
            'created_at' => $data['created_at']

        ]);

        if ($result) {
            $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Review created successfully']));
        } else {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Failed to create review']));
        }

        return $response->withHeader('Content-Type', 'application/json');
    }

    // Mengambil semua ulasan berdasarkan ID perusahaan
    public function getReviewsByCompany(Request $request, Response $response, $args)
    {
        $id_company = $args['id_company'];
        $reviews = CompanyReview::getReviewsByCompany($id_company);

        if ($reviews) {
            $response->getBody()->write(json_encode($reviews));
        } else {
            $response->getBody()->write(json_encode(['message' => 'No reviews found']));
        }

        return $response->withHeader('Content-Type', 'application/json');
    }

    // Mengambil ulasan berdasarkan ID ulasan
    public function getReviewById(Request $request, Response $response, $args)
    {
        $id_review = $args['id_review'];
        $review = CompanyReview::getReviewById($id_review);

        if ($review) {
            $response->getBody()->write(json_encode($review));
        } else {
            $response->getBody()->write(json_encode(['message' => 'Review not found']));
        }

        return $response->withHeader('Content-Type', 'application/json');
    }

    // Memperbarui ulasan
    public function updateReview(Request $request, Response $response, $args)
    {
        $id_review = $args['id_review'];
        $data = $request->getParsedBody();

        $result = CompanyReview::updateReview($id_review, [
            'rating' => $data['rating'],
            'review_text' => $data['review_text'],
            'job_position' => $data['job_position'],
            'employment_status' => $data['employment_status']
        ]);

        if ($result) {
            $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Review updated successfully']));
        } else {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Failed to update review']));
        }

        return $response->withHeader('Content-Type', 'application/json');
    }

    // Menghapus ulasan
    public function deleteReview(Request $request, Response $response, $args)
    {
        $id_review = $args['id_review'];

        $result = CompanyReview::deleteReview($id_review);

        if ($result) {
            $response->getBody()->write(json_encode(['status' => 'success', 'message' => 'Review deleted successfully']));
        } else {
            $response->getBody()->write(json_encode(['status' => 'error', 'message' => 'Failed to delete review']));
        }

        return $response->withHeader('Content-Type', 'application/json');
    }
}
