<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Notification;

class NotificationController
{
    public function getAllNotifications(Request $request, Response $response)
    {
        $notifications = Notification::getAllNotifications();
        $response->getBody()->write(json_encode($notifications));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getNotificationById(Request $request, Response $response, $args)
    {
        $id_notification = $args['id'];
        $notification = Notification::getNotificationById($id_notification);
        if ($notification) {
            $response->getBody()->write(json_encode($notification));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Notification not found']));
            return $response->withStatus(404);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function createNotification(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $id_user = $data['id_user'];
        $id_application = $data['id_application'];
        $notification_text = $data['notification_text'];

        $id_notif = Notification::createNotification($id_user, $id_application, $notification_text);
        $response->getBody()->write(json_encode(['id_notif' => $id_notif]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteNotification(Request $request, Response $response, $args)
    {
        $id_notification = $args['id'];
        $deletedRows = Notification::deleteNotification($id_notification);
        $response->getBody()->write(json_encode(['deleted_rows' => $deletedRows]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
