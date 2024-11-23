<?php

namespace App\Models;

use PDO;
use App\Models\DB;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = (new DB())->connect();
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addUser($name, $email, $password, $role, $profile)
    {
        $sql = "INSERT INTO users (name, email, password, role, profile) VALUES (:name, :email, :password, :role, :profile)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':profile', $profile);
        return $stmt->execute();
    }

    public function updateUser($id, $name, $email, $role, $profile)
    {
        $sql = "UPDATE users SET name = :name, email = :email, role = :role, profile = :profile WHERE user_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':profile', $profile);
        return $stmt->execute();
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE user_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
