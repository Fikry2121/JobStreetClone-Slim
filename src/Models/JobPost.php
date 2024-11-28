<?php

namespace App\Models;

use App\Services\Model;
use PDO;
use PDOException;

class JobPost extends Model
{
    public $id_job;
    public $id_company;
    public $job_type;
    public $job_description;
    public $job_location;
    public $status;

    private static function getConnection()
    {
        $model = new Model();
        return $model->getDB();
    }

    public static function createJob($id_company, $job_type, $job_description, $job_location, $status)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("
            INSERT INTO blocks (id_company, job_type, job_description, job_location, status)
            VALUES (:id_company, :job_type, :job_description, :job_location, :status)
        ");
        $stmt->execute([
            'id_company' => $id_company,
            'job_type' => $job_type,
            'job_description' => $job_description,
            'job_location' => $job_location,
            'status' => $status
        ]);
        return $db->lastInsertId();
    }

    public static function updateJob($id_job, $id_company, $job_type, $job_description, $job_location, $status)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("
            UPDATE J
            SET id_company = :id_company, job_type = :job_type, job_description = :job_description, job_location = :job_location, status = :status
            WHERE id_job = :id_job
        ");
        return $stmt->execute([
            'id_company' => $id_company,
            'job_type' => $job_type,
            'job_description' => $job_description,
            'job_location' => $job_location,
            'status' => $status,
            'id_job' => $id_job
        ]);
    }

    public static function deleteJob($id_job)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("DELETE FROM Job_post WHERE id_job = :id_job");
        return $stmt->execute(['id_job' => $id_job]);
    }

    public static function getJobById($id_job)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM Job_post WHERE id_job = :id_job");
        $stmt->execute(['id_job' => $id_job]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllJobs()
    {
        $db = self::getConnection();
        $stmt = $db->query("SELECT * FROM Job_post");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
