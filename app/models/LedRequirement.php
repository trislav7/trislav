<?php
class LedRequirement extends Model {
    protected $table = 'led_requirements';

    public function getByType($type) {
        $cacheKey = "led_requirements_{$type}";

        if ($cached = $this->cache->get($cacheKey)) {
            debug_log("LedRequirement: Cache HIT for {$cacheKey}");
            return $cached;
        }

        debug_log("LedRequirement: Cache MISS for {$cacheKey}");
        $result = $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE type = ? AND is_active = 1 
            ORDER BY sort_order
        ", [$type]);

        $this->cache->set($cacheKey, $result, 10800);
        return $result;
    }

    public function getAllActive() {
        $cacheKey = "all_active_led_requirements";

        if ($cached = $this->cache->get($cacheKey)) {
            debug_log("LedRequirement: Cache HIT for all_active_led_requirements");
            return $cached;
        }

        debug_log("LedRequirement: Cache MISS for all_active_led_requirements");
        $result = $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE is_active = 1 
            ORDER BY type, sort_order
        ");

        $this->cache->set($cacheKey, $result, 10800);
        return $result;
    }

    public function getAll() {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            ORDER BY type, sort_order
        ");
    }
}
?>