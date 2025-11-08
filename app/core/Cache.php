<?php
class Cache {
    private $cacheDir;
    private $defaultTtl = 3600; // 1 час

    public function __construct() {
        $this->cacheDir = ROOT_PATH . '/temp/cache';
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    public function get($key) {
        $file = $this->getCacheFile($key);

        if (!file_exists($file)) {
            CacheMonitor::logOperation('get', $key, false);
            return null;
        }

        $data = unserialize(file_get_contents($file));

        if (time() > $data['expires']) {
            unlink($file);
            CacheMonitor::logOperation('get', $key, false);
            return null;
        }

        CacheMonitor::logOperation('get', $key, true);
        return $data['value'];
    }

    public function set($key, $value, $ttl = null) {
        if ($ttl === null) {
            $ttl = $this->defaultTtl;
        }

        $file = $this->getCacheFile($key);
        $data = [
            'value' => $value,
            'expires' => time() + $ttl
        ];

        CacheMonitor::logOperation('set', $key);
        file_put_contents($file, serialize($data), LOCK_EX);
        return true;
    }

    public function delete($key) {
        $file = $this->getCacheFile($key);
        CacheMonitor::logOperation('delete', $key);
        if (file_exists($file)) {
            return unlink($file);
        }
        return false;
    }

    /**
     * Очищает кэш по шаблону ключа
     */
    public function clearByPattern($pattern) {
        $files = glob($this->cacheDir . '/*.cache');
        $deleted = 0;
        
        foreach ($files as $file) {
            $filename = basename($file, '.cache');
            // Если ключ содержит шаблон - удаляем
            if (strpos($filename, $pattern) !== false || $pattern === 'all') {
                if (unlink($file)) {
                    $deleted++;
                }
            }
        }
        
        return $deleted;
    }

    /**
     * Полностью очищает весь кэш
     */
    public function clearAll() {
        $files = glob($this->cacheDir . '/*.cache');
        $deleted = 0;
        
        foreach ($files as $file) {
            if (unlink($file)) {
                $deleted++;
            }
        }
        
        return $deleted;
    }

    /**
     * Получает все ключи кэша
     */
    public function getAllKeys() {
        $files = glob($this->cacheDir . '/*.cache');
        $keys = [];
        
        foreach ($files as $file) {
            $keys[] = basename($file, '.cache');
        }
        
        return $keys;
    }

    /**
     * Получает статистику кэша
     */
    public function getStats() {
        $files = glob($this->cacheDir . '/*.cache');
        $totalSize = 0;
        $activeKeys = 0;
        $expiredKeys = 0;
        
        foreach ($files as $file) {
            $size = filesize($file);
            $totalSize += $size;
            
            $data = unserialize(file_get_contents($file));
            if (time() > $data['expires']) {
                $expiredKeys++;
            } else {
                $activeKeys++;
            }
        }
        
        return [
            'total_files' => count($files),
            'active_keys' => $activeKeys,
            'expired_keys' => $expiredKeys,
            'total_size' => $this->formatBytes($totalSize)
        ];
    }

    private function getCacheFile($key) {
        $safeKey = preg_replace('/[^a-zA-Z0-9_-]/', '_', $key);
        return $this->cacheDir . '/' . $safeKey . '.cache';
    }

    private function formatBytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}