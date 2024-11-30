<?php

namespace App\Models;

use PDO;
use App\Services\Model;

class Profile extends Model
{
    public $id_user;
    public $email;
    public $password;
    public $phone;

    public function __construct($email, $password, $phone)
    {
        parent::__construct();
        $this->email = $email;
        $this->password = $password;
        $this->phone = $phone;
    }

    private static function getConnection()
    {
        $model = new Model();
        return $model->getDB();
    }

    public static function createProfile($data)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("INSERT INTO profiles (email, password, phone) 
                            VALUES (:email, :password, :phone)");

        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':phone', $data['phone']);

        $stmt->execute();
        return $db->lastInsertId();
    }

    public static function updateProfile($id_user, $data)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("UPDATE profiles 
                            SET email = :email, password = :password, phone = :phone 
                            WHERE id_user = :id_user");

        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':phone', $data['phone']);
        
        return $stmt->execute();
    }

    public static function deleteProfile($id_user)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("DELETE FROM profiles WHERE id_user = :id_user");
        $stmt->bindParam(':id_user', $id_user);
        return $stmt->execute();
    }
}