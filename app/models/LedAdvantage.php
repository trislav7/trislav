<?php
class LedAdvantage extends Model {
    protected $table = 'led_advantages';

    public function getAllActive() {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE is_active = 1 
            ORDER BY sort_order
        ");
    }

    public function getAll() {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            ORDER BY sort_order
        ");
    }

    // НОВЫЕ МЕТОДЫ ДЛЯ РАБОТЫ С КАТЕГОРИЯМИ
    public function getByCategory($category) {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE category = ? 
            ORDER BY sort_order
        ", [$category]);
    }

    public function getActiveByCategory($category) {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE category = ? AND is_active = 1 
            ORDER BY sort_order
        ", [$category]);
    }
}
?>