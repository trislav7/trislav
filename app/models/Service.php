<?php
class Service extends Model {
    protected $table = 'services';


    public function getWithFullDataByCategory($category) {
        return $this->db->fetchAll("
            SELECT * FROM services 
            WHERE category = ? AND is_active = 1 
            ORDER BY order_index
        ", [$category]);
    }

    public function getActiveByCategory($category) {
        $cacheKey = "services_{$category}";

        if ($cached = $this->cache->get($cacheKey)) {
            return $cached;
        }

        $result = $this->db->fetchAll("
            SELECT * FROM services 
            WHERE category = ? AND is_active = 1 
            ORDER BY order_index
        ", [$category]);

        $this->cache->set($cacheKey, $result);
        return $result;
    }

    public function getAllActive() {
        $cacheKey = "all_active_services";

        if ($cached = $this->cache->get($cacheKey)) {
            return $cached;
        }

        $result = $this->db->fetchAll("
            SELECT * FROM services 
            WHERE is_active = 1 
            ORDER BY category, order_index
        ");

        $this->cache->set($cacheKey, $result);
        return $result;
    }
}