<?php
class Portfolio extends Model {
    protected $table = 'portfolio';

    public function getByCategory($category, $limit = null) {
        $cacheKey = "portfolio_{$category}" . ($limit ? "_$limit" : '');

        if ($cached = $this->cache->get($cacheKey)) {
            return $cached;
        }


        $sql = "SELECT * FROM portfolio WHERE category = ? AND is_active = 1 ORDER BY project_date DESC";
        $params = [$category];

        if ($limit) {
            $sql .= " LIMIT ?";
            $params[] = (int)$limit;
        }

        $result = $this->db->fetchAll($sql, $params);

        $this->cache->set($cacheKey, $result);
        return $result;
    }

    public function getAllActive($limit = 6) {
        $cacheKey = "all_active_portfolio_$limit";


        if ($cached = $this->cache->get($cacheKey)) {
            return $cached;
        }

        $intLimit = (int)$limit;

        $result = $this->db->fetchAll("
            SELECT * FROM portfolio 
            WHERE is_active = 1 
            ORDER BY project_date DESC 
            LIMIT ?
        ", [$intLimit]);

        $this->cache->set($cacheKey, $result);
        return $result;
    }

    public function getAll() {
        return $this->db->fetchAll("
            SELECT * FROM portfolio 
            ORDER BY project_date DESC
        ");
    }

    public function getForSlider($category, $limit = 4) {
        $cacheKey = "portfolio_slider_{$category}_{$limit}";

        if ($cached = $this->cache->get($cacheKey)) {
            return $cached;
        }


        // 🔥 ИСПРАВЛЕНИЕ: Явно преобразуем лимит в целое число
        $intLimit = (int)$limit;

        $result = $this->db->fetchAll("
        SELECT * FROM portfolio 
        WHERE category = ? AND is_active = 1 
        ORDER BY project_date DESC 
        LIMIT ?
    ", [$category, $intLimit]);

        $this->cache->set($cacheKey, $result);
        return $result;
    }
}