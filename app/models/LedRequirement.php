<?php
class LedRequirement extends Model {
    protected $table = 'led_requirements';

    public function getByType($type) {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE type = ? AND is_active = 1 
            ORDER BY sort_order
        ", [$type]);
    }

    public function getAllActive() {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE is_active = 1 
            ORDER BY type, sort_order
        ");
    }

    public function getAll() {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            ORDER BY type, sort_order
        ");
    }
}
?>