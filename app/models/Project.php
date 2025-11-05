<?php
class Project extends Model {
    protected $table = 'projects';

    public function getAllActive() {
        return $this->db->fetchAll("
            SELECT * FROM projects 
            WHERE is_active = 1 
            ORDER BY order_index
        ");
    }

    public function getByCode($code) {
        return $this->db->fetch("
            SELECT * FROM projects 
            WHERE code = ? AND is_active = 1
        ", [$code]);
    }

    public function getWithServices() {
        return $this->db->fetchAll("
            SELECT * FROM projects 
            WHERE is_active = 1 AND has_services = 1 
            ORDER BY order_index
        ");
    }
}