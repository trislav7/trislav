<?php
class Tariff extends Model {
    protected $table = 'tariffs';

    public function getActive() {
        $cacheKey = "active_tariffs";

        if ($cached = $this->cache->get($cacheKey)) {
            return $cached;
        }

        $result = $this->db->fetchAll("
            SELECT * FROM tariffs 
            WHERE is_active = 1 
            ORDER BY price
        ");

        $this->cache->set($cacheKey, $result);
        return $result;
    }
}