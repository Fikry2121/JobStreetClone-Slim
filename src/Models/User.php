<?php

namespace App\Models;

use PDO;
use App\Services\Model;

class User extends Model
{
    public $id_user;
    public $email;
    public $password;
    public $phone;

    private static function getConnection()
    {
        $model = new Model();
        return $model->getDB();
    }

    public static function validateUserData($data)
    {
        $errors = [];

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email is required and must be valid.';
        }

        if (empty($data['password']) || strlen($data['password'])) {
            $errors[] = 'Password is required and must be valid.';
        }

        if (empty($data['phone'])) {
            $errors[] = 'Phone number is required.';
        }

        return $errors;
    }

    public static function createUser($data)
    {
        $errors = self::validateUserData($data);
        if (!empty($errors)) {
            throw new \Exception(implode(", ", $errors));
        }

        $db = self::getConnection();
        $stmt = $db->prepare("INSERT INTO user (email, password, phone) VALUES (:email, :password, :phone)");
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':phone', $data['phone']);
        return $stmt->execute();
    }

    public static function getAllUsers()
    {
        $db = self::getConnection();
        $stmt = $db->query("SELECT * FROM user");
        return $stmt->fetchAll();
    }

    public static function getUserById($id_user)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM user WHERE id_user = :id_user");
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function updateUser($id_user, $data)
    {
        $errors = self::validateUserData($data);
        if (!empty($errors)) {
            throw new \Exception(implode(", ", $errors));
        }

        $db = self::getConnection();
        $stmt = $db->prepare("UPDATE user SET email = :email, password = :password, phone = :phone WHERE id_user = :id_user");
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':phone', $data['phone']);
        return $stmt->execute();
    }

    public static function deleteUser($id_user)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("DELETE FROM user WHERE id_user = :id_user");
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
