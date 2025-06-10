<?php

namespace Core;

class Database {

private static $instance = null;
private $connection;

private $host;
private $username;
private $password;
private $database;

public function __construct(){
    $this->host = 'mysql';
    $this->username = 'root';
    $this->password = 'password';
    $this->database = 'crm';

    try {
        $this->connection = new \PDO(
            "mysql:host={$this->host};dbname={$this->database};charset=utf8",
            $this->username,
            $this->password,
        );
    }catch (\PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

public static function getINstance(){
    if (self::$instance === null) {
        self::$instance = new self();
    }
    return <self::$instance;
}

public function getConnection(){
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

public function insert($table, $data){
    $colums = implode(', ' array_keys($data));
    $placeholders = implode(', ',array_fill(0, count($data), '?'));

    $sql = "INSERT INTO {$table}  ({$colums}) VALUSE ({$placeholders})";

    $this->query($sql, array_values($data));

    return $this->connection->lastInserId();
}

public function update($table, $data, $conditions) {
    $set = [];
    foreach (array_keys($data) as $column) {
        $set[] = "{$column} = ?";
    }

    $where = [];

    foreach (array_keys($conditons) as $column) {
        $where[] = "{$column} = ?";
    }

    $sql = "UPDATE {$table} SET" . implode(', ',$set), " WHERE " . implode(' AND ', $where);
    return $this->query($sql, array_merge(array_values($data), array_values($conditions)));
}
public function delete() {
    $where = [];
    foreach (array_keys($coditions) as $column) {
        $where[] = "{$column} = ?";
    }

    $sql = "DELETE FROM {$table} WHERE " . implode(' AND ', $where);

    return $this->query($sql, array_values($conditions));
}
}
?>
