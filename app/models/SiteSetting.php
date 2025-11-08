<?php
// app/models/SiteSetting.php
class SiteSetting extends Model {
    protected $table = 'site_settings';
    public function getByKey($key) {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE setting_key = ?", [$key]);
    }

    public function updateByKey($key, $value) {
        $existing = $this->getByKey($key);
        if ($existing) {
            return $this->update($existing['id'], ['setting_value' => $value]);
        } else {
            return $this->create(['setting_key' => $key, 'setting_value' => $value]);
        }
    }

    public function getAllSettings() {
        $settings = $this->getAll();
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting['setting_key']] = $setting['setting_value'];
        }
        return $result;
    }
}
?>