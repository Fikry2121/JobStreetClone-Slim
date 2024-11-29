<?php

namespace App\Models;

use App\Services\Model;
use PDO;
use PDOException;

class Applications extends Model
{
    public $id_application;
    public $id_user;
    public $id_job;
    public $status_application;

    private static function getConnection()
    {
        $model = new Model();
        return $model->getDB();
    }

    public static function applyForJob($id_user, $id_job)
    {
        try {
            $db = self::getConnection();
            $stmt = $db->prepare("INSERT INTO applications (id_user, id_job, status_application) VALUES (:id_user, :id_job, 'pending')");
            $stmt->execute([
                'id_user' => $id_user,
                'id_job' => $id_job
            ]);
            return ['success' => true, 'message' => 'Application submitted successfully'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function trackApplicationStatus($id_application)
    {
        try {
            $db = self::getConnection();
            $stmt = $db->prepare("SELECT * FROM applications WHERE id_application = :id_application");
            $stmt->execute(['id_application' => $id_application]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function getApplicationsByUser($id_user)
    {
        try {
            $db = self::getConnection();
            $stmt = $db->prepare("SELECT * FROM applications WHERE id_user = :id_user");
            $stmt->execute(['id_user' => $id_user]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}