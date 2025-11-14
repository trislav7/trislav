<?php
trait CacheableTrait {
    protected function getCachedPage($cacheKey, $ttl = 3600) {
        $cache = new Cache();
        
        if ($cached = $cache->get($cacheKey)) {
            debug_log("Cache HIT: $cacheKey");
            echo $cached;
            return true;
        }
        
        debug_log("Cache MISS: $cacheKey");
        ob_start();
        return false;
    }
    
    protected function saveToCache($cacheKey, $ttl = 3600) {
        $cache = new Cache();
        $content = ob_get_contents();
        $cache->set($cacheKey, $content, $ttl);
        ob_end_flush();
    }
    
    protected function getPageCacheKey($prefix) {
        return "page_{$prefix}_" . md5($_SERVER['REQUEST_URI']);
    }
}