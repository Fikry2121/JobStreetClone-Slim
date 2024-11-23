<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Review;

class ReviewController
{
    public function getAllReviews(Request $request, Response $response)
    {
        $review = new Review();
        $data = $review->getAllReviews();

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function addReview(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $user_id = $data['user_id'];
        $service_id = $data['service_id'];
        $rating = $data['rating'];
        $comment = $data['comment'];

        $review = new Review();
        $result = $review->addReview($user_id, $service_id, $rating, $comment);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteReview(Request $request, Response $response, array $args)
    {
        $id = $args['id'];

        $review = new Review();
        $result = $review->deleteReview($id);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
