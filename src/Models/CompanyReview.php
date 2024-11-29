<?php

namespace App\Models;

use App\Services\Model;
use PDO;

class CompanyReview extends Model
{
    public $id_review;
    public $id_user;
    public $id_company;
    public $rating;
    public $review_text;
    public $job_position;
    public $employment_status;
    public $created_at;
    public $updated_at;

    private static function getConnection()
    {
        $model = new Model();
        return $model->getDB();
    }

    // Menambahkan ulasan baru
    public static function createReview($data)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("
            INSERT INTO company_review (id_user, id_company, rating, review_text, job_position, employment_status, created_at, updated_at)
            VALUES (:id_user, :id_company, :rating, :review_text, :job_position, :employment_status,  :created_at, :updated_at
        ");
        return $stmt->execute($data);
    }

    // Mengambil semua ulasan berdasarkan ID perusahaan
    public static function getReviewsByCompany($id_company)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM company_review WHERE id_company = :id_company ORDER BY created_at DESC");
        $stmt->execute(['id_company' => $id_company]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil ulasan berdasarkan ID ulasan
    public static function getReviewById($id_review)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM company_review WHERE id_review = :id_review");
        $stmt->execute(['id_review' => $id_review]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Memperbarui ulasan
    public static function updateReview($id_review, $data)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("
            UPDATE company_review 
            SET rating = :rating, review_text = :review_text, job_position = :job_position, employment_status = :employment_status, updated_at = updated_at
            WHERE id_review = :id_review
        ");
        return $stmt->execute(array_merge($data, ['id_review' => $id_review]));
    }

    // Menghapus ulasan
    public static function deleteReview($id_review)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("DELETE FROM company_review WHERE id_review = :id_review");
        return $stmt->execute(['id_review' => $id_review]);
    }
}
