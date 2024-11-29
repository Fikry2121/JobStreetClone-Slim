<?php

namespace App\Models;

use PDO;
use App\Services\Model;

class User extends Model
{
    public $id;
    public $email;
    public $password;
    public $user_location;

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

        if (empty($data['password']) || strlen($data['password']) < 8) {
            $errors[] = 'Password is required and must be at least 8 characters.';
        }

        if (empty($data['user_location'])) {
            $errors[] = 'User location is required.';
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
        $stmt = $db->prepare("INSERT INTO user (email, password, user_location) VALUES (:email, :password, :user_location)");
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $stmt->bindParam(':user_location', $data['user_location']);
        return $stmt->execute();
    }

    public static function getAllUsers()
    {
        $db = self::getConnection();
        $stmt = $db->query("SELECT * FROM user");
        return $stmt->fetchAll();
    }

    public static function getUserById($id)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function updateUser($id, $data)
    {
        $errors = self::validateUserData($data);
        if (!empty($errors)) {
            throw new \Exception(implode(", ", $errors));
        }

        $db = self::getConnection();
        $stmt = $db->prepare("UPDATE user SET email = :email, password = :password, user_location = :user_location WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $stmt->bindParam(':user_location', $data['user_location']);
        return $stmt->execute();
    }

    public static function deleteUser($id)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("DELETE FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
