<?php
namespace App\Models;

use PDO;
use App\Services\Model;

class User
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

    public function getUserById($id)
    {
        // Validasi input
        if (empty($id) || !is_numeric($id)) {
            throw new \InvalidArgumentException("Invalid user ID.");
        }

        $stmt = $this->db->prepare("SELECT id_user, email, phone FROM user WHERE id_user = :id_user");
        $stmt->bindValue(':id_user', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers()
    {
        $stmt = $this->db->query("SELECT id_user, email, phone FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($email, $password, $phone)
    {
        // Validasi input
        if (empty($email) || empty($password) || empty($phone)) {
            throw new \InvalidArgumentException("Email, password, and phone are required.");
        }

        $stmt = $this->db->prepare("INSERT INTO user (email, password, phone) VALUES (:email, :password, :phone)");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR); // Hash password
        $stmt->bindValue(':phone', $phone, PDO::PARAM_INT);
        $stmt->execute();

        return $this->db->lastInsertId();
    }

    public function updateUser($id, $email, $phone)
    {
        // Validasi input
        if (empty($id) || !is_numeric($id)) {
            throw new \InvalidArgumentException("Invalid user ID.");
        }

        $stmt = $this->db->prepare("UPDATE user SET email = :email, phone = :phone WHERE id_user = :id_user");
        $stmt->bindValue(':id_user', $id, PDO::PARAM_INT);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $phone, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function deleteUser($id)
    {
        // Validasi input
        if (empty($id) || !is_numeric($id)) {
            throw new \InvalidArgumentException("Invalid user ID.");
        }

        $stmt = $this->db->prepare("DELETE FROM user WHERE id_user = :id_user");
        $stmt->bindValue(':id_user', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }
}
