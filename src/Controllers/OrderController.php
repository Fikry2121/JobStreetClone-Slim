<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Order;

class OrderController
{
    public function getAllOrders(Request $request, Response $response)
    {
        $order = new Order();
        $data = $order->getAllOrders();

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function addOrder(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $user_id = $data['user_id'];
        $service_id = $data['service_id'];
        $status = $data['status'];
        $total_price = $data['total_price'];

        $order = new Order();
        $result = $order->addOrder($user_id, $service_id, $status, $total_price);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateOrder(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $status = $data['status'];
        $complete_date = $data['complete_date'];

        $order = new Order();
        $result = $order->updateOrder($id, $status, $complete_date);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteOrder(Request $request, Response $response, array $args)
    {
        $id = $args['id'];

        $order = new Order();
        $result = $order->deleteOrder($id);

        $response->getBody()->write(json_encode(['success' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
