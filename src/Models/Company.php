<?php

namespace App\Models;

use App\Services\Model;
use PDO;

class Company extends Model
{
    public $id_company;
    public $company_name;
    public $company_location;
    public $company_description;

    private static function getConnection()
    {
        $model = new Model();
        return $model->getDB();
    }

    public static function getAllCompanies()
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM company ORDER BY id_company DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCompanyById($id_company)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM company WHERE id_company = :id_company");
        $stmt->execute(['id_company' => $id_company]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}