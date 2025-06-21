<?php

namespace Core;

class Database {
    private static $instance = null;
    private $connection;

    private $host;
    private $username;
    private $password;
    private $database;

    private function loadEnv($path) {
        if (!file_exists($path)) return;
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            list($name, $value) = array_map('trim', explode('=', $line, 2));
            if (!array_key_exists($name, $_ENV)) {
                $_ENV[$name] = $value;
            }
        }
    }

    public function __construct() {
        // Load .env file if not loaded
        $envPath = __DIR__ . '/../.env';
        $this->loadEnv($envPath);
        $this->host = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->database = $_ENV['DB_DATABASE'];

        try {
            $this->connection = new \PDO(
                "mysql:host={$this->host};dbname={$this->database};charset=utf8",
                $this->username,
                $this->password,
            );
        } catch (\PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function query($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function select($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function selectOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";

        $this->query($sql, array_values($data));

        return $this->connection->lastInsertId();
    }

    public function update($table, $data, $conditions) {
        $set = [];
        foreach (array_keys($data) as $column) {
            $set[] = "{$column} = ?";
        }

        $where = [];
        foreach (array_keys($conditions) as $column) {
            $where[] = "{$column} = ?";
        }

        $sql = "UPDATE {$table} SET " . implode(', ', $set) . " WHERE " . implode(' AND ', $where);
        return $this->query($sql, array_merge(array_values($data), array_values($conditions)));
    }

    public function delete($table, $conditions) {
        $where = [];
        foreach (array_keys($conditions) as $column) {
            $where[] = "{$column} = ?";
        }

        $sql = "DELETE FROM {$table} WHERE " . implode(' AND ', $where);

        return $this->query($sql, array_values($conditions));
    }
}
?>
