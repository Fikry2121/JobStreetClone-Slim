<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\CompanyReviews;

class CompanyReviewsController
{
    // Mendapatkan semua reviews
    public function getAllReviews(Request $request, Response $response)
    {
        $reviews = CompanyReviews::getAllReviews();
        $response->getBody()->write(json_encode($reviews));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Mendapatkan review berdasarkan ID
    public function getReviewById(Request $request, Response $response, $args)
    {
        $id_review = $args['id'];
        $review = CompanyReviews::getReviewById($id_review);

        if ($review) {
            $response->getBody()->write(json_encode($review));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Review not found']));
            return $response->withStatus(404);
        }

        return $response->withHeader('Content-Type', 'application/json');
    }

    // Membuat review baru
    public function createReview(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $id_company = $data['id_company'] ?? null;
        $id_user = $data['id_user'] ?? null;
        $rating = $data['rating'] ?? null;
        $review_text = $data['review_text'] ?? null;

        if (!$id_company || !$id_user || !$rating || !$review_text) {
            $response->getBody()->write(json_encode(['error' => 'Invalid input data']));
            return $response->withStatus(400);
        }

        $newReviewId = CompanyReviews::createReview($id_company, $id_user, $rating, $review_text);
        $response->getBody()->write(json_encode(['message' => 'Review created', 'id_review' => $newReviewId]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Memperbarui review
    public function updateReview(Request $request, Response $response, $args)
    {
        $id_review = $args['id'];
        $data = $request->getParsedBody();
        $rating = $data['rating'] ?? null;
        $review_text = $data['review_text'] ?? null;

        if (!$rating || !$review_text) {
            $response->getBody()->write(json_encode(['error' => 'Invalid input data']));
            return $response->withStatus(400);
        }

        $rowsUpdated = CompanyReviews::updateReview($id_review, $rating, $review_text);
        if ($rowsUpdated) {
            $response->getBody()->write(json_encode(['message' => 'Review updated']));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Review not found']));
            return $response->withStatus(404);
        }

        return $response->withHeader('Content-Type', 'application/json');
    }

    // Menghapus review
    public function deleteReview(Request $request, Response $response, $args)
    {
        $id_review = $args['id'];
        $rowsDeleted = CompanyReviews::deleteReview($id_review);

        if ($rowsDeleted) {
            $response->getBody()->write(json_encode(['message' => 'Review deleted']));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Review not found']));
            return $response->withStatus(404);
        }

        return $response->withHeader('Content-Type', 'application/json');
    }
}