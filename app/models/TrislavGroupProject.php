<?php
class TrislavGroupProject extends Model {
    protected $table = 'trislav_group_projects';

    public function getAllActive() {
        $cacheKey = "all_active_trislav_projects";

        if ($cached = $this->cache->get($cacheKey)) {
            debug_log("TrislavGroupProject: Cache HIT for all_active_trislav_projects");
            return $cached;
        }

        debug_log("TrislavGroupProject: Cache MISS for all_active_trislav_projects");
        $result = $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE is_active = 1 
            ORDER BY order_index
        ");

        $this->cache->set($cacheKey, $result, 7200);
        return $result;
    }

    public function toggleStatus($id) {
        $current = $this->find($id);
        $newStatus = $current['is_active'] ? 0 : 1;
        return $this->update($id, ['is_active' => $newStatus]);
    }

    // ДОБАВИТЬ: метод для получения правильного URL изображения
    public function getProjectWithImage($id) {
        $project = $this->find($id);
        if ($project && !empty($project['image_url'])) {
            // Проверяем существование файла и переименовываем если нужно
            $this->ensureCorrectImageName($project);
        }
        return $project;
    }

    private function ensureCorrectImageName(&$project) {
        $currentPath = ROOT_PATH . $project['image_url'];
        $expectedFilename = 'project_' . $project['id'] . '.' . pathinfo($project['image_url'], PATHINFO_EXTENSION);
        $expectedPath = ROOT_PATH . '/uploads/projects/' . $expectedFilename;

        // Если файл существует но с другим именем - переименовываем
        if (file_exists($currentPath) && basename($project['image_url']) !== $expectedFilename) {
            if (rename($currentPath, $expectedPath)) {
                $project['image_url'] = '/uploads/projects/' . $expectedFilename;
                // Обновляем в БД
                $this->update($project['id'], ['image_url' => $project['image_url']]);
            }
        }
    }
    private function getImageUrl($imagePath) {
        if (empty($imagePath)) return null;

        // Если путь уже абсолютный
        if (strpos($imagePath, 'http') === 0) {
            return $imagePath;
        }

        // Если путь начинается с /
        if (strpos($imagePath, '/') === 0) {
            return $imagePath;
        }

        // Добавляем базовый путь если нужно
        return '/uploads/projects/' . $imagePath;
    }
}
?>