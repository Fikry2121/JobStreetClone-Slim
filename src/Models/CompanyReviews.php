<?php

namespace App\Models;

use App\Services\Model;
use PDO;

class CompanyReviews extends Model
{
    public $id_review;
    public $id_company;
    public $id_user;
    public $rating;
    public $review_text;
    public $review_date;

    private static function getConnection()
    {
        $model = new Model();
        return $model->getDB();
    }

    // Mendapatkan semua review
    public static function getAllReviews()
    {
        $db = self::getConnection();
        $stmt = $db->query("SELECT * FROM company_reviews");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mendapatkan review berdasarkan ID
    public static function getReviewById($id_review)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM company_reviews WHERE id_review = :id_review");
        $stmt->execute(['id_review' => $id_review]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Membuat review baru
    public static function createReview($id_company, $id_user, $rating, $review_text)
    {
        $db = self::getConnection();
        $stmt = $db->prepare(
            "INSERT INTO company_reviews (id_company, id_user, rating, review_text, review_date) 
             VALUES (:id_company, :id_user, :rating, :review_text, NOW())"
        );

        $stmt->execute([
            'id_company' => $id_company,
            'id_user' => $id_user,
            'rating' => $rating,
            'review_text' => $review_text
        ]);

        return $db->lastInsertId();
    }

    // Memperbarui review berdasarkan ID
    public static function updateReview($id_review, $rating, $review_text)
    {
        $db = self::getConnection();
        $stmt = $db->prepare(
            "UPDATE company_reviews 
             SET rating = :rating, review_text = :review_text 
             WHERE id_review = :id_review"
        );

        $stmt->execute([
            'id_review' => $id_review,
            'rating' => $rating,
            'review_text' => $review_text
        ]);

        return $stmt->rowCount();
    }

    // Menghapus review berdasarkan ID
    public static function deleteReview($id_review)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("DELETE FROM company_reviews WHERE id_review = :id_review");
        $stmt->execute(['id_review' => $id_review]);
        return $stmt->rowCount();
    }
}