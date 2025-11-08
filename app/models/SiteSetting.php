<?php
// app/models/SiteSetting.php
class SiteSetting extends Model {
    protected $table = 'site_settings';
    public function getByKey($key) {
        $cacheKey = "site_setting_{$key}";

        if ($cached = $this->cache->get($cacheKey)) {
            debug_log("SiteSetting: Cache HIT for key: {$key}");
            return $cached;
        }

        debug_log("SiteSetting: Cache MISS for key: {$key}");
        $result = $this->db->fetch("SELECT * FROM {$this->table} WHERE setting_key = ?", [$key]);

        $this->cache->set($cacheKey, $result, 86400); // 24 часа
        return $result;
    }

    public function updateByKey($key, $value) {
        $existing = $this->getByKey($key);
        if ($existing) {
            $result = $this->update($existing['id'], ['setting_value' => $value]);
        } else {
            $result = $this->create(['setting_key' => $key, 'setting_value' => $value]);
        }

        // Инвалидируем кэш после изменения
        $this->clearSettingsCache();
        return $result;
    }

    public function getAllSettings() {
        $cacheKey = "all_site_settings";

        if ($cached = $this->cache->get($cacheKey)) {
            debug_log("SiteSetting: Cache HIT for all settings");
            return $cached;
        }

        debug_log("SiteSetting: Cache MISS for all settings");
        $settings = $this->getAll();
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting['setting_key']] = $setting['setting_value'];
        }

        $this->cache->set($cacheKey, $result, 86400); // 24 часа
        return $result;
    }

    /**
     * Очищает кэш настроек
     */
    private function clearSettingsCache() {
        debug_log("SiteSetting: Clearing settings cache");

        // Очищаем все ключи настроек
        $keys = $this->cache->getAllKeys();
        foreach ($keys as $key) {
            if (strpos($key, 'site_setting_') === 0 || $key === 'all_site_settings') {
                $this->cache->delete($key);
                debug_log("SiteSetting: Deleted cache key: {$key}");
            }
        }

        // Очищаем кэш страниц через CacheManager
        $cacheManager = new CacheManager();
        $cacheManager->clearSettingsCache();
    }
}
?>