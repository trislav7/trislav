<?php
class TrislavGroupClient extends Model {
    protected $table = 'trislav_group_clients';

    public function getAllActive() {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE is_active = 1 
            ORDER BY COALESCE(order_index, 0), id
        ");
    }

    public function getAll() {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            ORDER BY COALESCE(order_index, 0), id
        ");
    }

    public function findWithDetails($id) {
        $client = $this->find($id);

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

    // Удаление старого изображения
    public function deleteOldImage($imagePath) {
        $fullPath = ROOT_PATH . $imagePath;
        if (file_exists($fullPath) && is_file($fullPath)) {
            unlink($fullPath);
        }
    }
}
?>