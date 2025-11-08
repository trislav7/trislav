<?php
class Model {
    protected $db;
    protected $cache;
    protected $table;
    protected $cacheManager;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->cache = new Cache();
        $this->cacheManager = new CacheManager();
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY id DESC");
    }

    public function find($id) {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function create($data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $this->db->query(
            "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)",
            array_values($data)
        );

        $id = $this->db->lastInsertId();
        
        // Автоматически очищаем кэш после создания
        $this->clearRelevantCache();
        
        return $id;
    }

    public function update($id, $data) {
        $setClause = implode(', ', array_map(function($col) {
            return "$col = ?";
        }, array_keys($data)));

        $values = array_values($data);
        $values[] = $id;

        $result = $this->db->query(
            "UPDATE {$this->table} SET $setClause WHERE id = ?",
            $values
        );
        
        // Автоматически очищаем кэш после обновления
        $this->clearRelevantCache();
        
        return $result;
    }

    public function delete($id) {
        $result = $this->db->query(
            "DELETE FROM {$this->table} WHERE id = ?",
            [$id]
        );
        
        // Автоматически очищаем кэш после удаления
        $this->clearRelevantCache();
        
        return $result;
    }

    public function where($conditions, $params = []) {
        $whereClause = implode(' AND ', array_map(function($col) {
            return "$col = ?";
        }, array_keys($conditions)));

        return $this->db->fetchAll(
            "SELECT * FROM {$this->table} WHERE $whereClause ORDER BY id DESC",
            array_values($conditions)
        );
    }
    
    /**
     * Автоматически очищает релевантный кэш в зависимости от модели
     */
    protected function clearRelevantCache() {
        $modelName = get_class($this);
        debug_log("Model: Clearing relevant cache for " . $modelName);
        
        switch ($modelName) {
            case 'Service':
                $this->cacheManager->clearServicesCache();
                break;
                
            case 'Tariff':
                $this->cacheManager->clearTariffsCache();
                break;
                
            case 'Portfolio':
                $this->cacheManager->clearPortfolioCache();
                break;
                
            case 'TrislavGroupProject':
            case 'TrislavGroupClient':
            case 'TrislavGroupReview':
                $this->cacheManager->clearTrislavGroupCache();
                break;
                
            case 'WorkProcess':
                $this->cacheManager->clearWorkProcessCache();
                break;
                
            case 'SiteSetting':
                $this->cacheManager->clearSettingsCache();
                break;
                
            case 'ShoppingCenter':
                $this->cacheManager->clearShoppingCentersCache();
                break;
                
            default:
                // Для неизвестных моделей очищаем весь кэш
                $this->cacheManager->clearAllCache();
                break;
        }
    }
}