<?php

namespace App\Models;

use App\Services\Model;
use PDO;

class Application extends Model
{
    public $id_application;
    public $id_job;
    public $status_application;
    public $created_at;

    private static function getConnection()
    {
        $model = new Model();
        return $model->getDB();
    }

    public static function getApplicationById($id_application)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM application WHERE id_application = :id_application");
        $stmt->execute(['id_application' => $id_application]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllApplications()
    {
        $db = self::getConnection();
        $stmt = $db->query("SELECT * FROM application");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function createApplication($id_job, $status_application)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("INSERT INTO application (id_job, status_application, created_at) VALUES (:id_job, :status_application, NOW())");
        $stmt->execute([
            'id_job' => $id_job,
            'status_application' => $status_application
        ]);
        return $db->lastInsertId();
    }

    public static function updateApplicationStatus($id_application, $status_application)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("UPDATE application SET status_application = :status_application WHERE id_application = :id_application");
        $stmt->execute([
            'id_application' => $id_application,
            'status_application' => $status_application
        ]);
        return $stmt->rowCount();
    }

    public static function deleteApplication($id_application)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("DELETE FROM application WHERE id_application = :id_application");
        $stmt->execute(['id_application' => $id_application]);
        return $stmt->rowCount();
    }
}