<?php
require_once 'Database.php';

class User {
    private $db;
    private $conn;
    private $table = 'users';

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Lấy danh sách tất cả users
    public function getAllUsers() {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->conn->query($sql);
        
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        
        return $users;
    }

    // Tìm user theo ID (tránh SQL Injection)
    public function findUser($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        
        return null;
    }

    // Tạo user mới
    public function createUser($name, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO {$this->table} (name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("sss", $name, $email, $hashedPassword);
            return $stmt->execute();
        }
        
        return false;
    }

    // Cập nhật user
    public function updateUser($id, $name, $email, $password = null) {
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE {$this->table} SET name = ?, email = ?, password = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssi", $name, $email, $hashedPassword, $id);
        } else {
            $sql = "UPDATE {$this->table} SET name = ?, email = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssi", $name, $email, $id);
        }

        return $stmt->execute();
    }

    // Xóa user
    public function deleteUser($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        
        return false;
    }
}
?>