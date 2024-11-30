<?php
//namespace
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

    public static function addBookmark($id_user, $id_job)
    {
        try {
            $db = self::getConnection();
            $stmt = $db->prepare("INSERT INTO bookmark (id_user, id_job) VALUES (:id_user, :id_job)");
            $stmt->execute(['id_user' => $id_user, 'id_job' => $id_job]);
            return ['success' => true, 'message' => 'Bookmark added successfully'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function removeBookmark($id_bookmark)
    {
        try {
            $db = self::getConnection();
            $stmt = $db->prepare("DELETE FROM bookmark WHERE id_bookmark = :id_bookmark");
            $stmt->execute(['id_bookmark' => $id_bookmark]);
            return ['success' => true, 'message' => 'Bookmark removed successfully'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function viewBookmark($id_bookmark)
    {
        try {
            $db = self::getConnection();
            $stmt = $db->prepare("SELECT * FROM bookmark WHERE id_bookmark = :id_bookmark");
            $stmt->execute(['id_bookmark' => $id_bookmark]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
