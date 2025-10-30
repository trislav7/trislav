<?php
class Model {
    protected $db;
    protected $cache;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->cache = new Cache();
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY id DESC");
    }

    public function find($id) {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function create($data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $this->db->query(
            "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)",
            array_values($data)
        );

        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $setClause = implode(', ', array_map(function($col) {
            return "$col = ?";
        }, array_keys($data)));

        $values = array_values($data);
        $values[] = $id;

        return $this->db->query(
            "UPDATE {$this->table} SET $setClause WHERE id = ?",
            $values
        );
    }

    public function where($conditions, $params = []) {
        $whereClause = implode(' AND ', array_map(function($col) {
            return "$col = ?";
        }, array_keys($conditions)));

        return $this->db->fetchAll(
            "SELECT * FROM {$this->table} WHERE $whereClause ORDER BY id DESC",
            array_values($conditions)
        );
    }
}