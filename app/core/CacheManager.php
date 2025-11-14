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
        
        return count($keys);
    }
    
    /**
     * Очищает кэш при изменении тарифов
     */
    public function clearTariffsCache() {

        $keys = [
            'active_tariffs',
            'active_tariffs_with_discount'
        ];

        foreach ($keys as $key) {
            $this->cache->delete($key);
        }

        // Очищаем страницы где используются тарифы
        $this->clearPageCache(['/', '/led']);

        return count($keys);
    }
    
    /**
     * Очищает кэш при изменении портфолио
     */
    public function clearPortfolioCache() {

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
        
        return count($keys);
    }
    
    /**
     * Очищает кэш при изменении Трислав Групп
     */
    public function clearTrislavGroupCache() {

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

        return count($keys);
    }
    
    /**
     * Очищает кэш при изменении процесса работы
     */
    public function clearWorkProcessCache() {

        $keys = [
            'all_active_work_processes'
        ];

        foreach ($keys as $key) {
            $this->cache->delete($key);
        }

        // Очищаем страницы где отображается процесс работы
        $this->clearPageCache(['/led', '/video', '/btl']);

        return count($keys);
    }

    /**
     * Очищает кэш при изменении LED требований
     */
    public function clearLedRequirementsCache() {

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

        return count($keys);
    }

    /**
     * Очищает кэш при изменении настроек сайта
     */
    public function clearSettingsCache() {

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

        return count($keys);
    }
    
    /**
     * Очищает кэш при изменении торговых центров
     */
    public function clearShoppingCentersCache() {

        // Очищаем страницы где используются ТЦ
        $this->clearPageCache(['/led']);

        return 1;
    }
    
    /**
     * Очищает кэш для конкретных страниц
     */
    private function clearPageCache($urls) {
        foreach ($urls as $url) {
            $pageKey = 'page_' . md5($url);
            $this->cache->delete($pageKey);
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
        
        return count($pageKeys);
    }
    
    /**
     * Полная очистка всего кэша
     */
    public function clearAllCache() {
        $result = $this->cache->clearAll();
        return $result;
    }
    
    /**
     * Получает статистику кэша
     */
    public function getCacheStats() {
        return $this->cache->getStats();
    }

    public function clearLedAdvantagesCache() {

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

        return count($keys);
    }
}