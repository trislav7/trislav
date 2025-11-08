<?php
class TrislavGroupClient extends Model {
    protected $table = 'trislav_group_clients';

    public function getAllActive() {
        $cacheKey = "all_active_trislav_clients";

        if ($cached = $this->cache->get($cacheKey)) {
            debug_log("TrislavGroupClient: Cache HIT for all_active_trislav_clients");
            return $cached;
        }

        debug_log("TrislavGroupClient: Cache MISS for all_active_trislav_clients");
        $result = $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE is_active = 1 
            ORDER BY COALESCE(order_index, 0), id
        ");

        $this->cache->set($cacheKey, $result, 7200); // 2 часа
        return $result;
    }

    public function getAll() {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            ORDER BY COALESCE(order_index, 0), id
        ");
    }

    public function findWithDetails($id) {
        $client = $this->find($id);
        if ($client && !empty($client['image_url'])) {
            // Проверяем существование файла и переименовываем если нужно
            $this->ensureCorrectClientImageName($client);
        }

        if ($client) {
            // Получаем все связки клиента
            $connectionModel = new TrislavGroupClientProject();
            $client['connections'] = $connectionModel->getByClient($id);
        }

        return $client;
    }

    public function toggleStatus($id) {
        $current = $this->find($id);
        $newStatus = $current['is_active'] ? 0 : 1;
        return $this->update($id, ['is_active' => $newStatus]);
    }

    // Новый метод для обработки загрузки изображения
    public function handleImageUpload($file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = ROOT_PATH . '/uploads/clients/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $safeName = preg_replace('/[^a-zA-Z0-9-_]/', '', pathinfo($file['name'], PATHINFO_FILENAME));
            $filename = time() . '_' . $safeName . '.' . $extension;
            $filepath = $uploadDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                return '/uploads/clients/' . $filename;
            }
        }
        return '';
    }

    private function deleteOldImage($imagePath) {
        if (!empty($imagePath)) {
            $fullPath = ROOT_PATH . $imagePath;
            if (file_exists($fullPath) && is_file($fullPath)) {
                if (unlink($fullPath)) {
                    return true;
                } else {
                }
            } else {
            }
        }
        return false;
    }

    private function ensureCorrectClientImageName(&$client) {
        $currentPath = ROOT_PATH . $client['image_url'];
        $expectedFilename = 'client_' . $client['id'] . '.' . pathinfo($client['image_url'], PATHINFO_EXTENSION);
        $expectedPath = ROOT_PATH . '/uploads/clients/' . $expectedFilename;

        // Если файл существует но с другим именем - переименовываем
        if (file_exists($currentPath) && basename($client['image_url']) !== $expectedFilename) {
            if (rename($currentPath, $expectedPath)) {
                $client['image_url'] = '/uploads/clients/' . $expectedFilename;
                // Обновляем в БД
                $this->update($client['id'], ['image_url' => $client['image_url']]);
            }
        }
    }
}
?>