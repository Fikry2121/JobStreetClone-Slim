<?php

namespace App\Models;

use PDO;
use App\Models\DB;

class Order
{
    private $db;

    public function __construct()
    {
        $this->db = (new DB())->connect();
    }

    public function getAllOrders()
    {
        $sql = "SELECT * FROM orders";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addOrder($user_id, $service_id, $status, $total_price)
    {
        $sql = "INSERT INTO orders (user_id, service_id, status, total_price) VALUES (:user_id, :service_id, :status, :total_price)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':service_id', $service_id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':total_price', $total_price);
        return $stmt->execute();
    }

    public function updateOrder($id, $status, $complete_date)
    {
        $sql = "UPDATE orders SET status = :status, complete_date = :complete_date WHERE order_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':complete_date', $complete_date);
        return $stmt->execute();
    }

    public function deleteOrder($id)
    {
        $sql = "DELETE FROM orders WHERE order_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
