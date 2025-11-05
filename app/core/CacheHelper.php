<?php
class CacheHelper {
    
    /**
     * Проверяет, активен ли кэш для страницы
     */
    public static function isPageCached($url) {
        $cache = new Cache();
        $path = parse_url($url, PHP_URL_PATH);
        $pageKey = 'page_' . md5($path);
        
        return $cache->get($pageKey) !== null;
    }
    
    /**
     * Добавляет параметр no-cache к URL
     */
    public static function addNoCacheParam($url) {
        $separator = (strpos($url, '?') === false) ? '?' : '&';
        return $url . $separator . 'no-cache';
    }
    
    /**
     * Получает информацию о кэше
     */
    public static function getCacheInfo() {
        $cache = new Cache();
        return $cache->getStats();
    }
}