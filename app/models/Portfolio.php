<?php
class Portfolio extends Model {
    protected $table = 'portfolio';

    public function getByCategory($category, $limit = null) {
        $cacheKey = "portfolio_{$category}" . ($limit ? "_$limit" : '');

        if ($cached = $this->cache->get($cacheKey)) {
            return $cached;
        }

        $sql = "SELECT * FROM portfolio WHERE category = ? AND is_active = 1 ORDER BY project_date DESC";
        if ($limit) {
            $sql .= " LIMIT $limit";
            $result = $this->db->fetchAll($sql, [$category]);
        } else {
            $result = $this->db->fetchAll($sql, [$category]);
        }

        $this->cache->set($cacheKey, $result);
        return $result;
    }

    public function getAllActive($limit = 6) {
        $cacheKey = "all_active_portfolio_$limit";

        if ($cached = $this->cache->get($cacheKey)) {
            return $cached;
        }

        $result = $this->db->fetchAll("
            SELECT * FROM portfolio 
            WHERE is_active = 1 
            ORDER BY project_date DESC 
            LIMIT ?
        ", [$limit]);

        $this->cache->set($cacheKey, $result);
        return $result;
    }
}