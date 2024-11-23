<?php

namespace App\Models;

use PDO;

class DB
{
    private $host = '127.0.0.1';
    private $user = 'root';
    private $pass = 'root';
    private $dbname = 'sribu_db';
    private $dbport = 8889; // Pastikan port sesuai dengan MAMP

    public function connect()
    {
        // Menambahkan port ke dalam string DSN
        $conn_str = "mysql:host=$this->host;port=$this->dbport;dbname=$this->dbname";
        $conn = new PDO($conn_str, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}
