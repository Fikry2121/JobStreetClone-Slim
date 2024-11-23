<?php

namespace App\Models;

use PDO;
use App\Models\DB;

class Review
{
    private $db;

    public function __construct()
    {
        $this->db = (new DB())->connect();
    }

    public function getAllReviews()
    {
        $sql = "SELECT * FROM reviews";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addReview($order_id, $rating, $review_text)
    {
        $sql = "INSERT INTO reviews (order_id, rating, review_text) VALUES (:order_id, :rating, :review_text)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':review_text', $review_text);
        return $stmt->execute();
    }

    public function deleteReview($id)
    {
        $sql = "DELETE FROM reviews WHERE review_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
