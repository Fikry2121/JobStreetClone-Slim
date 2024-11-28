<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Services\Model;

class User extends Model
{
    // Properti untuk data user 
    public $id_user;
    public $username;
    public $email;
    public $password;
    public $phone;


    // Mendapatkan koneksi ke database
    public static function getConnection()
    {
        $model = new Model();
        return $model->getDB();
    }

    // Method untuk mengambil semua data user
    public static function all()
    {
        $model = new Model();
        $db = $model->getDB();
        $stmt = $db->query("SELECT * FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method untuk menemukan user berdasarkan id
    public static function find($id)
    {
        $model = new Model();
        $db = $model->getDB();
        $stmt = $db->prepare("SELECT * FROM user WHERE id_user = :id");
        $stmt->execute(['id' => $id]);

        // Ubah fetch mode menjadi FETCH_OBJ
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return null jika tidak ditemukan
        if (!$userData) {
            return null;
        }

        // Buat instance baru dari User dengan data yang ditemukan
        $user = new self();
        foreach ($userData as $key => $value) {
            if (property_exists($user, $key))
                $user->$key = $value;
        }
        return $user;
    }

    // Method untuk menyimpan user ke database
    public function save()
    {
        $model = new Model();
        $db = $model->getDB();

        if ($this->id_user) {
            // Update user
            $stmt = $db->prepare("UPDATE user SET username = :username, name = :name, email = :email, phone = :phone,  id_user = :id");
            $stmt->execute([
                'username' => $this->username,
                'email' => $this->email,
                'phone' => $this->phone,
                'id' => $this->id_user
            ]);
        } else {
            // Insert user baru
            $stmt = $db->prepare("INSERT INTO user (username, name, email, phone, password) VALUES (:username, :name, :email, :phone, :password, )");
            $stmt->execute([
                'username' => $this->username,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => $this->password,

            ]);
            $this->id_user = $db->lastInsertId();
        }
    }

    // Method untuk menghapus user
    public function delete()
    {
        try {
            $model = new Model();
            $db = $model->getDB();
            $stmt = $db->prepare("DELETE FROM user WHERE id_user = :id");
            $stmt->execute(['id' => $this->id_user]);
            return true;
        } catch (\PDOException $e) {
            throw new \Exception("Gagal menghapus user: " . $e->getMessage());
        }
    }

    // Convert ke array
    public function toArray()
    {
        return [
            'id_user' => $this->id_user,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,

        ];
    }

    // Constructor
    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->id_user = $data['id_user'] ?? null;
            $this->username = $data['username'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->phone = $data['phone'] ?? null;
            $this->password = $data['password'] ?? null;
        }
    }
}
