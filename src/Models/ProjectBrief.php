<?php

namespace App\Models;

use PDO;
use App\Models\DB;

class ProjectBrief
{
    private $db;

    public function __construct()
    {
        $this->db = (new DB())->connect();
    }

    public function getAllProjectBriefs()
    {
        $sql = "SELECT * FROM project_briefs";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addProjectBrief($order_id, $brief_details, $attachment)
    {
        $sql = "INSERT INTO project_briefs (order_id, brief_details, attachment) VALUES (:order_id, :brief_details, :attachment)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':brief_details', $brief_details);
        $stmt->bindParam(':attachment', $attachment);
        return $stmt->execute();
    }

    public function updateProjectBrief($id, $brief_details, $attachment)
    {
        $sql = "UPDATE project_briefs SET brief_details = :brief_details, attachment = :attachment WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':brief_details', $brief_details);
        $stmt->bindParam(':attachment', $attachment);
        return $stmt->execute();
    }

    public function deleteProjectBrief($id)
    {
        $sql = "DELETE FROM project_briefs WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
