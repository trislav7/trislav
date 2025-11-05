<?php
class CacheMiddleware {
    
    public static function handle() {
        // Если есть параметр no-cache, очищаем кэш для этой страницы
        if (isset($_GET['no-cache'])) {
            self::clearCacheForCurrentPage();
            
            // Редирект без параметра no-cache чтобы избежать цикла
            $cleanUrl = self::getCleanUrl();
            header('Location: ' . $cleanUrl);
            exit;
        }
    }
    
    private static function clearCacheForCurrentPage() {
        $cache = new Cache();
        $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Определяем тип страницы
        $pageType = self::detectPageType($requestPath);
        
        // Очищаем кэш для этого типа страницы
        self::clearRelevantCache($cache, $pageType, $requestPath);
        
        // Также очищаем общие ключи
        self::clearGeneralCache($cache);
    }
    
    private static function detectPageType($path) {
        $path = strtolower($path);
        
        if ($path === '/' || $path === '/index.php') return 'home';
        if (strpos($path, '/led') === 0) return 'led';
        if (strpos($path, '/trislav-group') === 0) return 'trislav_group';
        if (strpos($path, '/btl') === 0) return 'btl';
        if (strpos($path, '/video') === 0) return 'video';
        if (strpos($path, '/contact') === 0) return 'contact';
        return 'other';
    }
    
    private static function clearRelevantCache($cache, $pageType, $pagePath) {
        // Базовый ключ страницы
        $pageKey = 'page_' . md5($pagePath);
        $cache->delete($pageKey);
        
        // Ключи в зависимости от типа страницы
        $keysToDelete = [];
        
        switch ($pageType) {
            case 'home':
                $keysToDelete = [
                    'all_active_services',
                    'all_active_portfolio',
                    'all_active_portfolio_6',
                    'active_tariffs',
                    'all_active_projects',
                    'all_active_clients',
                    'all_active_reviews',
                    'all_active_advantages'
                ];
                break;
                
            case 'led':
                $keysToDelete = [
                    'services_led',
                    'portfolio_led',
                    'all_active_led_advantages',
                    'active_tariffs'
                ];
                // Очищаем все преимущества LED
                $cache->clearByPattern('led_advantages');
                break;
                
            case 'trislav_group':
                $keysToDelete = [
                    'all_active_trislav_projects',
                    'all_active_trislav_clients',
                    'all_active_trislav_reviews',
                    'all_active_trislav_advantages'
                ];
                // Очищаем все связанное с Трислав Групп
                $cache->clearByPattern('trislav');
                break;
                
            default:
                // Для других страниц очищаем только общий кэш
                $keysToDelete = ['all_active_services', 'all_active_portfolio'];
                break;
        }
        
        // Удаляем конкретные ключи
        foreach ($keysToDelete as $key) {
            $cache->delete($key);
        }
        
        // Очищаем по шаблону для этого типа страницы
        $cache->clearByPattern($pageType);
    }
    
    private static function clearGeneralCache($cache) {
        // Очищаем часто используемые общие ключи
        $generalKeys = [
            'site_settings',
            'all_settings'
        ];
        
        foreach ($generalKeys as $key) {
            $cache->delete($key);
        }
    }
    
    private static function getCleanUrl() {
        $url = $_SERVER['REQUEST_URI'];
        
        // Удаляем параметр no-cache из URL
        $url = preg_replace('/([?&])no-cache(&|$)/', '$1', $url);
        $url = rtrim($url, '?&');
        
        // Если остался только ?, убираем его
        if (substr($url, -1) === '?') {
            $url = substr($url, 0, -1);
        }
        
        return $url ?: '/';
    }
}