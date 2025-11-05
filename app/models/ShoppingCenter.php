<?php
// app/models/ShoppingCenter.php
class ShoppingCenter extends Model {
    protected $table = 'shopping_centers';

    public function getAllActive() {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE is_active = 1 
            ORDER BY COALESCE(order_index, 0), title
        ");
    }

    public function getAll() {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            ORDER BY COALESCE(order_index, 0), title
        ");
    }

    public function toggleStatus($id) {
        $current = $this->find($id);
        $newStatus = $current['is_active'] ? 0 : 1;
        return $this->update($id, ['is_active' => $newStatus]);
    }
}
?>