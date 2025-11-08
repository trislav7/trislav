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

    public function getActiveWithDiscount() {
        $cacheKey = "active_tariffs_with_discount";

        if ($cached = $this->cache->get($cacheKey)) {
            return $cached;
        }

        $result = $this->db->fetchAll("
            SELECT *,
                   CASE 
                     WHEN old_price IS NOT NULL AND old_price > price 
                     THEN ROUND(((old_price - price) / old_price) * 100)
                     ELSE NULL 
                   END as discount_percent
            FROM tariffs 
            WHERE is_active = 1 
            ORDER BY price
        ");

        $this->cache->set($cacheKey, $result);
        return $result;
    }
}