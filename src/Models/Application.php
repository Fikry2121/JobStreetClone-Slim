<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Services\Model;

class Application extends Model
{
    public $id_Application;
    public $id_user;
    public $id_job;
    public $title;
    public $created_at;
    public $status_application;
    public $id_profile;
    public $updated_at;




    // Konstruktor
    public function __construct($id_user, $id_profile, $status_application, $id_job, $updated_at)
    {
        parent::__construct();
        $this->id_user = $id_user;
        $this->id_profile = $id_profile;
        $this->status_application = $status_application;
        $this->created_at = date("Y-m-d H:i:s");
        $this->id_profile = date("Y-m-d H:i:s");
        $this->id_job = $id_job;
        $this->updated_at = $updated_at;
    }

    // Membuat koneksi ke database
    private static function getConnection()
    {
        $model = new Model();
        return $model->getDB();
    }

    // Ambil semua lamaran/aplikasi 
    public static function all()
    {
        $db = self::getConnection();
        $stmt = $db->query("SELECT * FROM application");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil halaman berdasarkan ID
    public static function find($id)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM application WHERE id_application = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Menyimpan halaman baru
    public static function createApplication($data)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("INSERT INTO application (id_user, id_profile, created_at, status_application, ) VALUES (:id_user, :id_profile, :status_application, :created_at)");

        $stmt->bindParam(':id_user', $data['id_user']);
        $stmt->bindParam(':id_profile', $data['id_profile']);
        $stmt->bindParam(':status_application', $data['status_application']);
        $stmt->bindParam(':created_at', $data['created_at']);

        $stmt->execute();
        return $db->lastInsertId();
    }

    // Memperbarui aplikasi
    public static function updateApplication($id, $data)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("UPDATE application SET id_user = :id_user, id_profile = :id_profile, id_job = :id_job, status_application = :status_application, updated_at = :updated_at WHERE id_application = :id");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_user', $data['id_user']);
        $stmt->bindParam(':id_job', $data['id_job']);
        $stmt->bindParam(':id_profile', $data['id_profile']);
        $stmt->bindParam(':status_application', $data['status_application']);
        $stmt->bindParam(':updated_at', $data['updated_at']);

        return $stmt->execute();
    }

    // Menghapus applikasi berdasarkan ID
    public static function deleteApplication($id)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("DELETE FROM application WHERE id_application = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Mengambil aplikasi 
    public static function getApplications($id_application)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM application WHERE id_application = :id_application");
        $stmt->bindParam(':id_application', $id_application);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil  berdasarkan ID
    public static function get($id_user)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id_user = :id_user");
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
