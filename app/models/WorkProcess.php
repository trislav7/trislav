<?php
// app/models/WorkProcess.php
class WorkProcess extends Model {
    protected $table = 'work_processes';

    public function getAllActive() {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE is_active = 1 
            ORDER BY step_order
        ");
    }

    public function getAll() {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            ORDER BY step_order
        ");
    }

    public function toggleStatus($id) {
        $current = $this->find($id);
        $newStatus = $current['is_active'] ? 0 : 1;
        return $this->update($id, ['is_active' => $newStatus]);
    }
}
?>