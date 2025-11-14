<?php
class SiteBaseController extends Controller {
    use CacheableTrait;
    
    protected function renderCachedPage($view, $data, $cachePrefix, $ttl = 3600) {
        $cacheKey = $this->getPageCacheKey($cachePrefix);
        
        if ($this->getCachedPage($cacheKey, $ttl)) {
            return;
        }
        
        $this->view($view, $data);
        $this->saveToCache($cacheKey, $ttl);
    }
    
    protected function getCommonData() {
        $settingModel = new SiteSetting();
        return [
            'settings' => $settingModel->getAllSettings(),
            'title' => 'Трислав Медиа - Профессиональные рекламные решения'
        ];
    }
}