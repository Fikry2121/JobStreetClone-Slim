<?php

namespace App\Models;

use PDO;
use App\Models\DB;

class Company
{
    private $db;

    public function __construct()
    {
        $this->db = (new DB())->connect();
    }

    public function getAllCompany()
    {
        $sql = "SELECT * FROM companys";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addCompany($id_company, $company_name, $company_location, $company_description)
    {
        $sql = "INSERT INTO companys (id_company, company_name, company_location, company_description) VALUES (:id_company, :company_name, :company_location, :company_description)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_company', $id_company);
        $stmt->bindParam(':company_name', $company_name);
        $stmt->bindParam(':company_location', $company_location);
        $stmt->bindParam(':company_description', $company_description);
        return $stmt->execute();
    }

    public function deleteCompany($id)
    {
        $sql = "DELETE FROM reviews WHERE review_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
