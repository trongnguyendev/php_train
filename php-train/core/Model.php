<?php

namespace Core;

abstract class Model {
    protected $db;
    protected $table;
    protected $fk;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getTable() {
        return $this->table;
    }

    public function getFk() {
        return $this->fk;
    }

    public function all() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->db->select($sql);
    }

    public function allWidth($tableRelation, $fk, $columnSelection = []) {
        $columnStr = implode (',', $columnSelection);
        $sql = "SELECT {$columnStr} FROM {$this->table} INNER JOIN {$tableRelation} ON {$tableRelation}.id = {$this->table}.{$fk}";
        return $this->db->select($sql);
    }
    

    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->selectOne($sql, [$id]);
    }

    public function create($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function where($column, $value) {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} LIKE ?";
        return $this->db->select($sql, ['%' . $value . '%']);
    }

    public function whereOne($column, $value) {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = ?";
        return $this->db->selectOne($sql, [$value]);
    }

    public function count() {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $result = $this->db->selectOne($sql);
        return $result['count'];
    }
}
?>