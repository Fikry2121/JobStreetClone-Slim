<?php


namespace App\Services;


header('Content-Type: application/json; charset=utf-8');


use PDO;
use PDOException;


class Model
{
    protected $db;


    public function __construct()
    {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=pboooo", 'root', 'root');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db = $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }


    public function getDB()
    {
        return $this->db;
    }
}
