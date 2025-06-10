<?php

namespace Core;

abstract class Model {
    protected $db;
    protected $table;

    public function __construct(){
        $this->db = Database::getInstance();
    }

    public function all() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->db->select($sql);
    }

    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->selectOne($sql,[$id]);
    }

    public function create($data) {
        return $this->db->update($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function deldete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function where($column, $value) {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = ?";
        return $this->db->select($sql, [$value]);
    }

    public function whereOne($column, $value) {

        $sql = "SELECT * FROM {$this->table} WHERE {$column} = ?";
        return $this->db->selectOne($sql, [$value]);
    }

    public function count() {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $result =  $this->db->selectOne($sql);
        return $result["count"];
    }
}
?>