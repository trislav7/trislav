<?php
class CacheMonitor {
    private static $stats = [
        'hits' => 0,
        'misses' => 0,
        'operations' => []
    ];
    
    /**
     * Логирует операцию кэша
     */
    public static function logOperation($type, $key, $hit = null) {
        $operation = [
            'timestamp' => microtime(true),
            'type' => $type,
            'key' => $key,
            'hit' => $hit
        ];
        
        self::$stats['operations'][] = $operation;
        
        if ($type === 'get') {
            if ($hit) {
                self::$stats['hits']++;
            } else {
                self::$stats['misses']++;
            }
        }
        
        // Ограничиваем размер лога
        if (count(self::$stats['operations']) > 1000) {
            array_shift(self::$stats['operations']);
        }
    }
    
    /**
     * Получает статистику hit/miss ratio
     */
    public static function getStats() {
        $total = self::$stats['hits'] + self::$stats['misses'];
        $ratio = $total > 0 ? (self::$stats['hits'] / $total) * 100 : 0;
        
        return [
            'hits' => self::$stats['hits'],
            'misses' => self::$stats['misses'],
            'total_operations' => $total,
            'hit_ratio' => round($ratio, 2) . '%',
            'recent_operations' => array_slice(self::$stats['operations'], -10) // последние 10 операций
        ];
    }
    
    /**
     * Сбрасывает статистику
     */
    public static function resetStats() {
        self::$stats = [
            'hits' => 0,
            'misses' => 0,
            'operations' => []
        ];
    }
}
?>