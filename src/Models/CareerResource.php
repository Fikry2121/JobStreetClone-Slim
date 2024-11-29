<?php

namespace App\Models;

use App\Services\Model;
use PDO;

class CareerResource extends Model
{
    public $id_resource;
    public $id_user;
    public $title;
    public $content;
    public $content_type;

    private static function getConnection()
    {
        $model = new Model();
        return $model->getDB();
    }

    public static function getResourceById($id_resource)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM career_resources WHERE id_resource = :id_resource");
        $stmt->execute(['id_resource' => $id_resource]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllResources()
    {
        $db = self::getConnection();
        $stmt = $db->query("SELECT * FROM career_resources");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function createResource($id_user, $title, $content, $content_type)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("INSERT INTO career_resources (id_user, title, content, content_type) VALUES (:id_user, :title, :content, :content_type)");
        $stmt->execute([
            'id_user' => $id_user,
            'title' => $title,
            'content' => $content,
            'content_type' => $content_type
        ]);
        return $db->lastInsertId();
    }

    public static function updateResource($id_resource, $title, $content, $content_type)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("UPDATE career_resources SET title = :title, content = :content, content_type = :content_type WHERE id_resource = :id_resource");
        $stmt->execute([
            'id_resource' => $id_resource,
            'title' => $title,
            'content' => $content,
            'content_type' => $content_type
        ]);
        return $stmt->rowCount();
    }

    public static function deleteResource($id_resource)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("DELETE FROM career_resources WHERE id_resource = :id_resource");
        $stmt->execute(['id_resource' => $id_resource]);
        return $stmt->rowCount();
    }
}

?>