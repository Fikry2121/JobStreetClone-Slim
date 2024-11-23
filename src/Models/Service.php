<?php

namespace App\Models;

use PDO;
use App\Models\DB;

class Service
{
    private $db;

    public function __construct()
    {
        $this->db = (new DB())->connect();
    }

    public function getAllServices()
    {
        $sql = "SELECT * FROM services";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addService($user_id, $category_id, $title, $description, $price)
    {
        $sql = "INSERT INTO services (user_id, category_id, title, description, price) VALUES (:user_id, :category_id, :title, :description, :price)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    public function updateService($id, $title, $description, $price)
    {
        $sql = "UPDATE services SET title = :title, description = :description, price = :price WHERE service_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    public function deleteService($id)
    {
        $sql = "DELETE FROM services WHERE service_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
