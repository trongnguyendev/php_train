<?php 

class Database {
    private $host;
    private $db;
    private $user;
    private $pass;
    private $conn;

    public function __construct() {
        $this->host = 'mysql';
        $this->db = 'db_test';
        $this->user = 'root';
        $this->pass = 'password';
        $this->charset = 'utf8mb4';

        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
          }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}