<?php
class TrislavGroupProject extends Model {
    protected $table = 'trislav_group_projects';

    public function getAllActive() {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE is_active = 1 
            ORDER BY order_index
        ");
    }

    public function toggleStatus($id) {
        $current = $this->find($id);
        $newStatus = $current['is_active'] ? 0 : 1;
        return $this->update($id, ['is_active' => $newStatus]);
    }
}
?>