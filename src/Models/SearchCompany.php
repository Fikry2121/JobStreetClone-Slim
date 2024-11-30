<?php

namespace App\Models;

use PDO;
use App\Services\Model;

class Company
{
    private $db;

    public function __construct()
    {
        $this->db = self::getConnection();
    }

    private static function getConnection()
    {
        $model = new Model();
        return $model->getDB();
    }

    public function getCompanyByName($company_name)
    {
        // Menggunakan LIKE untuk mencari nama perusahaan yang mirip
        $stmt = $this->db->prepare("SELECT id_company, company_name, company_location, company_description FROM company WHERE LOWER(company_name) LIKE LOWER(:company_name)");
        $stmt->execute(['company_name' => "%$company_name%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
