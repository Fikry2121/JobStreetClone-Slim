<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Services\Model;

class SocialLink extends Model
{
    public $id_social_link;
    public $id_user;
    public $platform;
    public $url;

    // Konstruktor
    public function __construct($id_user, $platform, $url)
    {
        parent::__construct();
        $this->id_user = $id_user;
        $this->platform = $platform;
        $this->url = $url;
    }

    // Membuat koneksi ke database
    private static function getConnection()
    {
        $model = new Model();
        return $model->getDB();
    }

    // Menambahkan Social Link baru
    public static function addSocialLink($data)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("INSERT INTO social_links (id_user, platform, url) 
                            VALUES (:id_user, :platform, :url)");

        $stmt->bindParam(':id_user', $data['id_user']);
        $stmt->bindParam(':platform', $data['platform']);
        $stmt->bindParam(':url', $data['url']);
        
        $stmt->execute();
        return $db->lastInsertId(); // Mengembalikan ID social link yang baru dibuat
    }

    // Memperbarui Social Link yang ada
    public static function updateSocialLink($id, $data)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("UPDATE social_links 
                            SET platform = :platform, url = :url 
                            WHERE id_social_link = :id");
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':platform', $data['platform']);
        $stmt->bindParam(':url', $data['url']);
        
        return $stmt->execute();
    }

    // Menghapus Social Link berdasarkan ID
    public static function removeSocialLink($id)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("DELETE FROM social_links WHERE id_social_link = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Mengambil semua Social Link untuk pengguna
    public static function getByUser($id_user)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM social_links WHERE id_user = :id_user");
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil Social Link berdasarkan ID
    public static function find($id)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM social_links WHERE id_social_link = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
