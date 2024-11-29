<?php

namespace App\Models;

use App\Services\Model;
use PDO;
use PDOException;

class Bookmark extends Model
{
    private static function getConnection()
    {
        $model = new Model();
        return $model->getDB();
    }

    public static function addBookmark($id_users, $id_jobs)
    {
        try {
            $db = self::getConnection();
            $stmt = $db->prepare("INSERT INTO bookmarks (id_users, id_jobs) VALUES (:id_users, :id_jobs)");
            $stmt->execute(['id_users' => $id_users, 'id_jobs' => $id_jobs]);
            return ['success' => true, 'message' => 'Bookmark added successfully'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function removeBookmark($id_bookmark)
    {
        try {
            $db = self::getConnection();
            $stmt = $db->prepare("DELETE FROM bookmarks WHERE id_bookmark = :id_bookmark");
            $stmt->execute(['id_bookmark' => $id_bookmark]);
            return ['success' => true, 'message' => 'Bookmark removed successfully'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function viewBookmark($id_users)
    {
        try {
            $db = self::getConnection();
            $stmt = $db->prepare("SELECT * FROM bookmarks WHERE id_users = :id_users");
            $stmt->execute(['id_users' => $id_users]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
