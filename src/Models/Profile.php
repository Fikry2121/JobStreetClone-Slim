<?php

namespace App\Models;

use PDO;
use App\Services\Model;

class Profile extends Model
{
    public $id_profile;
    public $id_social_link; 
    public $id_user;
    public $profile_pict;
    public $about_you;
    public $banner;

    // Konstruktor
    public function __construct($id_social_link, $id_user, $profile_pict, $about_you, $banner)
    {
        parent::__construct();
        $this->id_social_link = $id_social_link;
        $this->id_user = $id_user;
        $this->profile_pict = $profile_pict;
        $this->about_you = $about_you;
        $this->banner = $banner;
    }

    // Membuat koneksi ke database
    private static function getConnection()
    {
        $model = new Model();
        return $model->getDB();
    }

    // Method untuk mengambil semua data profile
    public static function all()
    {
        $db = self::getConnection();
        $stmt = $db->query("SELECT * FROM profiles");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Menyimpan profil baru
    public static function createProfile($data)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("INSERT INTO profiles (id_social_link, id_user, profile_pict, about_you, banner) 
                            VALUES (:id_social_link, :id_user, :profile_pict, :about_you, :banner)");
        
        $stmt->bindParam(':id_social_link', $data['id_social_link']);
        $stmt->bindParam(':id_user', $data['id_user']);
        $stmt->bindParam(':profile_pict', $data['profile_pict']);
        $stmt->bindParam(':about_you', $data['about_you']);
        $stmt->bindParam(':banner', $data['banner']);

        $stmt->execute();
        return $db->lastInsertId(); // Mengembalikan ID profil yang baru dibuat
    }

    // Memperbarui profil yang ada
    public static function updateProfile($id, $data)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("UPDATE profiles 
                            SET id_social_link = :id_social_link, id_user = :id_user, profile_pict = :profile_pict, 
                            about_you = :about_you, banner = :banner 
                            WHERE id_profile = :id");
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_social_link', $data['id_social_link']);
        $stmt->bindParam(':id_user', $data['id_user']);
        $stmt->bindParam(':profile_pict', $data['profile_pict']);
        $stmt->bindParam(':about_you', $data['about_you']);
        $stmt->bindParam(':banner', $data['banner']);
        
        return $stmt->execute();
    }

    // Menghapus profil berdasarkan ID
    public static function deleteProfile($id)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("DELETE FROM profiles WHERE id_profile = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Mengambil informasi profil berdasarkan ID pengguna
    public static function findByUser($id_user)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM profiles WHERE id_user = :id_user");
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mengambil profil berdasarkan ID
    public static function find($id)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM profiles WHERE id_profile = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mengambil data social link yang terkait dengan profil
    public static function getSocialLink($id_social_link)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM social_links WHERE id_social_link = :id_social_link");
        $stmt->bindParam(':id_social_link', $id_social_link);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mengambil data user yang terkait dengan profil
    public static function getUser($id_user)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id_user = :id_user");
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method untuk menyimpan profil ke database
    public function save()
    {
        $db = self::getConnection();
        $stmt = $db->prepare("INSERT INTO profiles (id_social_link, id_user, profile_pict, about_you, banner) 
                            VALUES (:id_social_link, :id_user, :profile_pict, :about_you, :banner)");
        $stmt->execute([
            'id_social_link' => $this->id_social_link,
            'id_user' => $this->id_user,
            'profile_pict' => $this->profile_pict,
            'about_you' => $this->about_you,
            'banner' => $this->banner
        ]);
    }

    // Method untuk mendapatkan atribut profil
    public function getAttributes()
    {
        return get_object_vars($this);
    }
}
