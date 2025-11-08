<?php
class CacheManager {
    private $cache;
    
    public function __construct() {
        $this->cache = new Cache();
    }
    
    /**
     * Очищает кэш при изменении услуг
     */
    public function clearServicesCache() {
        debug_log("CacheManager: Clearing services cache");
        
        $keys = [
            'all_active_services',
            'services_led',
            'services_video', 
            'services_btl',
            'services_branding'
        ];
        
        // Очищаем все ключи услуг
        foreach ($keys as $key) {
            $this->cache->delete($key);
        }
        
        // Очищаем по шаблону
        $this->cache->clearByPattern('services_');
        
        // Очищаем связанные страницы
        $this->clearPageCache(['/', '/led', '/video', '/btl']);
        
        debug_log("CacheManager: Services cache cleared");
        return count($keys);
    }
    
    /**
     * Очищает кэш при изменении тарифов
     */
    public function clearTariffsCache() {
        debug_log("CacheManager: Clearing tariffs cache");

        $keys = [
            'active_tariffs',
            'active_tariffs_with_discount'
        ];

        foreach ($keys as $key) {
            $this->cache->delete($key);
        }

        // Очищаем страницы где используются тарифы
        $this->clearPageCache(['/', '/led']);

        debug_log("CacheManager: Tariffs cache cleared");
        return count($keys);
    }
    
    /**
     * Очищает кэш при изменении портфолио
     */
    public function clearPortfolioCache() {
        debug_log("CacheManager: Clearing portfolio cache");
        
        $keys = [
            'all_active_portfolio',
            'all_active_portfolio_6',
            'portfolio_led',
            'portfolio_video', 
            'portfolio_btl',
            'portfolio_branding',
            'portfolio_slider_led_4',
            'portfolio_slider_video_4',
            'portfolio_slider_btl_4',
            'portfolio_videos_led',
            'portfolio_videos_video',
            'portfolio_videos_btl'
        ];
        
        foreach ($keys as $key) {
            $this->cache->delete($key);
        }
        
        // Очищаем по шаблону
        $this->cache->clearByPattern('portfolio_');
        
        // Очищаем все страницы с портфолио
        $this->clearPageCache(['/', '/led', '/video', '/btl']);
        
        debug_log("CacheManager: Portfolio cache cleared");
        return count($keys);
    }
    
    /**
     * Очищает кэш при изменении Трислав Групп
     */
    public function clearTrislavGroupCache() {
        debug_log("CacheManager: Clearing Trislav Group cache");

        $keys = [
            'all_active_trislav_projects',
            'all_active_trislav_clients',
            'all_active_trislav_reviews',
            'all_active_trislav_advantages',
            'all_active_work_processes',
            'all_active_led_requirements',
            'led_requirements_main',
            'led_requirements_additional'
        ];

        foreach ($keys as $key) {
            $this->cache->delete($key);
        }

        // Очищаем по шаблону
        $this->cache->clearByPattern('trislav');
        $this->cache->clearByPattern('led_requirements');
        $this->cache->clearByPattern('work_process');

        // Очищаем страницы
        $this->clearPageCache(['/', '/trislav-group', '/led', '/video', '/btl']);

        debug_log("CacheManager: Trislav Group cache cleared");
        return count($keys);
    }
    
    /**
     * Очищает кэш при изменении процесса работы
     */
    public function clearWorkProcessCache() {
        debug_log("CacheManager: Clearing work process cache");

        $keys = [
            'all_active_work_processes'
        ];

        foreach ($keys as $key) {
            $this->cache->delete($key);
        }

        // Очищаем страницы где отображается процесс работы
        $this->clearPageCache(['/led', '/video', '/btl']);

        debug_log("CacheManager: Work process cache cleared");
        return count($keys);
    }

    /**
     * Очищает кэш при изменении LED требований
     */
    public function clearLedRequirementsCache() {
        debug_log("CacheManager: Clearing LED requirements cache");

        $keys = [
            'all_active_led_requirements',
            'led_requirements_main',
            'led_requirements_additional'
        ];

        foreach ($keys as $key) {
            $this->cache->delete($key);
        }

        // Очищаем страницу LED
        $this->clearPageCache(['/led']);

        debug_log("CacheManager: LED requirements cache cleared");
        return count($keys);
    }

    /**
     * Очищает кэш при изменении настроек сайта
     */
    public function clearSettingsCache() {
        debug_log("CacheManager: Clearing settings cache");

        $keys = [
            'site_settings',
            'all_site_settings'
        ];

        // Очищаем все ключи настроек
        $allKeys = $this->cache->getAllKeys();
        foreach ($allKeys as $key) {
            if (strpos($key, 'site_setting_') === 0) {
                $keys[] = $key;
            }
        }

        foreach ($keys as $key) {
            $this->cache->delete($key);
        }

        // Очищаем весь кэш страниц, т.к. настройки влияют на все
        $this->clearAllPageCache();

        debug_log("CacheManager: Settings cache cleared (" . count($keys) . " keys)");
        return count($keys);
    }
    
    /**
     * Очищает кэш при изменении торговых центров
     */
    public function clearShoppingCentersCache() {
        debug_log("CacheManager: Clearing shopping centers cache");

        // Очищаем страницы где используются ТЦ
        $this->clearPageCache(['/led']);

        debug_log("CacheManager: Shopping centers cache cleared");
        return 1;
    }
    
    /**
     * Очищает кэш для конкретных страниц
     */
    private function clearPageCache($urls) {
        foreach ($urls as $url) {
            $pageKey = 'page_' . md5($url);
            $this->cache->delete($pageKey);
            debug_log("CacheManager: Cleared page cache for: " . $url);
        }
    }
    
    /**
     * Очищает кэш всех страниц
     */
    private function clearAllPageCache() {
        $keys = $this->cache->getAllKeys();
        $pageKeys = array_filter($keys, function($key) {
            return strpos($key, 'page_') === 0;
        });
        
        foreach ($pageKeys as $key) {
            $this->cache->delete($key);
        }
        
        debug_log("CacheManager: Cleared all page cache (" . count($pageKeys) . " pages)");
        return count($pageKeys);
    }
    
    /**
     * Полная очистка всего кэша
     */
    public function clearAllCache() {
        debug_log("CacheManager: Clearing ALL cache");
        $result = $this->cache->clearAll();
        debug_log("CacheManager: ALL cache cleared (" . $result . " files)");
        return $result;
    }
    
    /**
     * Получает статистику кэша
     */
    public function getCacheStats() {
        return $this->cache->getStats();
    }

    public function clearLedAdvantagesCache() {
        debug_log("CacheManager: Clearing LED advantages cache");

        $keys = [
            'all_active_led_advantages',
            'led_advantages_led',
            'led_advantages_trislav_group',
            'led_advantages_trislav_media'
        ];

        foreach ($keys as $key) {
            $this->cache->delete($key);
        }

        // Очищаем по шаблону
        $this->cache->clearByPattern('led_advantages');

        // Очищаем страницы где используются преимущества
        $this->clearPageCache(['/', '/led', '/trislav-group']);

        debug_log("CacheManager: LED advantages cache cleared");
        return count($keys);
    }
}