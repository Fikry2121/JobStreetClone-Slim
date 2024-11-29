<?php

namespace App\Model;

use PDO;

class User extends Model
{
    public $id;
    public $email;
    public $password;
    public $user_location;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public static function validateUserData($data)
    {
        $stmt = $this->db->query("SELECT * FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($data)
    {
        $stmt = $this->db->prepare("INSERT INTO user (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $data['name'], 'email' => $data['email']]);
        return $this->getUserById($this->db->lastInsertId());
    }

    public function updateUser($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE user SET name = :name, email = :email WHERE id = :id");
        $stmt->execute(['name' => $data['name'], 'email' => $data['email'], 'id' => $id]);
        return $this->getUserById($id);
    }

    public static function deleteUser($id)
    {
        $stmt = $this->db->prepare("DELETE FROM user WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
