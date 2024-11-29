<?php

namespace App\Models;

use App\Services\Model;
use PDO;
use PDOException;

class Job extends Model
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



    public static function getJobById($id_job)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM job WHERE id_job = :id_job");
        $stmt->execute(['id_job' => $id_job]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllJobs()
    {
        $db = self::getConnection();
        $stmt = $db->query("SELECT * FROM job");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
