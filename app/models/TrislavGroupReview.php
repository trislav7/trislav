<?php
class TrislavGroupReview extends Model {
    protected $table = 'trislav_group_reviews';

    public function getAllActive() {
        $cacheKey = "all_active_trislav_reviews";

        if ($cached = $this->cache->get($cacheKey)) {
            
            return $cached;
        }

        
        $result = $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE is_active = 1 
            ORDER BY order_index
        ");

        $this->cache->set($cacheKey, $result, 7200);
        return $result;
    }

    public function toggleStatus($id) {
        $current = $this->find($id);
        $newStatus = $current['is_active'] ? 0 : 1;
        return $this->update($id, ['is_active' => $newStatus]);
    }
}
?>