<?php

namespace App\Models;

use App\Services\Model;
use PDO;

class Notification extends Model
{
    public $id_notification;
    public $id_user;
    public $id_application;
    public $notification_text;
    public $created_at;

    private static function getConnection()
    {
        $model = new Model();
        return $model->getDB();
    }

    public static function getAllNotifications()
    {
        $db = self::getConnection();
        $stmt = $db->query("SELECT * FROM notification");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getNotificationById($id_notification)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM notification WHERE id_notificiation = :id_notification");
        $stmt->execute(['id_notification' => $id_notification]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function createNotification($id_user, $id_application, $notification_text)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("INSERT INTO notification (id_user, id_application, notification_text, created_at) VALUES (:id_user, :id_application, :notification_text, NOW())");
        $stmt->execute([
            'id_user' => $id_user,
            'id_application' => $id_application,
            'notification_text' => $notification_text
        ]);
        return $db->lastInsertId();
    }

    public static function deleteNotification($id_notification)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("DELETE FROM notification WHERE id_notification = :id_notification");
        $stmt->execute(['id_notification' => $id_notification]);
        return $stmt->rowCount();
    }
}
