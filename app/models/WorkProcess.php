<?php
// app/models/WorkProcess.php
class WorkProcess extends Model {
    protected $table = 'work_processes';

    public function getAllActive() {
        $cacheKey = "all_active_work_processes";

        if ($cached = $this->cache->get($cacheKey)) {
            debug_log("WorkProcess: Cache HIT for all_active_work_processes");
            return $cached;
        }

        debug_log("WorkProcess: Cache MISS for all_active_work_processes");
        $result = $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE is_active = 1 
            ORDER BY step_order
        ");

        $this->cache->set($cacheKey, $result, 10800); // 3 часа
        return $result;
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