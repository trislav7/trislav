<?php
class TrislavGroupClientProject extends Model {
    protected $table = 'trislav_group_client_project';

    /**
     * Получить все связки проекта
     */
    public function getByProject($projectId) {
        return $this->db->fetchAll("
            SELECT cp.*, 
                   c.title as client_title
            FROM {$this->table} cp 
            LEFT JOIN trislav_group_clients c ON cp.id_client = c.id 
            WHERE cp.id_project = ?
            ORDER BY cp.created_at DESC
        ", [$projectId]);
    }

    /**
     * Добавить связку
     */
    public function addConnection($clientId, $projectId, $serviceId = null, $shoppingCenterId = null, $tariffId = null, $videoUrl = null, $videoFilename = null, $yandexDiskPath = null) {
        $data = [
            'id_client' => $clientId,
            'id_project' => $projectId,
            'id_service' => $serviceId,
            'id_shopping_center' => $shoppingCenterId,
            'id_tariff' => $tariffId,
            'video' => $videoUrl,
            'video_filename' => $videoFilename,
            'yandex_disk_path' => $yandexDiskPath
        ];

        return $this->create($data);
    }

    /**
     * Удалить все связки клиента
     */
    public function removeByClient($clientId) {
        return $this->db->query(
            "DELETE FROM {$this->table} WHERE id_client = ?",
            [$clientId]
        );
    }

    /**
     * Получить все связки клиента
     */
    public function getByClient($clientId) {
        return $this->db->fetchAll("
            SELECT cp.*, 
                   p.title as project_title,
                   s.title as service_title,
                   sc.title as shopping_center_title,
                   sc.address as shopping_center_address
            FROM {$this->table} cp 
            LEFT JOIN trislav_group_projects p ON cp.id_project = p.id 
            LEFT JOIN services s ON cp.id_service = s.id 
            LEFT JOIN shopping_centers sc ON cp.id_shopping_center = sc.id 
            WHERE cp.id_client = ?
            ORDER BY cp.created_at DESC
        ", [$clientId]);
    }

    /**
     * Получить связки по клиенту и проекту
     */
    public function getByClientAndProject($clientId, $projectId) {
        return $this->db->fetchAll("
            SELECT cp.*, 
                   s.title as service_title,
                   sc.title as shopping_center_title
            FROM {$this->table} cp 
            LEFT JOIN services s ON cp.id_service = s.id 
            LEFT JOIN shopping_centers sc ON cp.id_shopping_center = sc.id 
            WHERE cp.id_client = ? AND cp.id_project = ?
            ORDER BY cp.created_at DESC
        ", [$clientId, $projectId]);
    }

    /**
     * Проверяет, есть ли связка с видео для Трислав Медиа и LED экранов
     */
    public function hasVideoForMediaAndLed($clientId) {
        return $this->db->fetch("
            SELECT cp.* 
            FROM {$this->table} cp 
            JOIN trislav_group_projects p ON cp.id_project = p.id 
            JOIN services s ON cp.id_service = s.id 
            WHERE cp.id_client = ? 
            AND p.title LIKE '%Медиа%' 
            AND s.title LIKE '%LED%'
            AND (cp.video IS NOT NULL OR cp.video_filename IS NOT NULL)
            LIMIT 1
        ", [$clientId]);
    }

    /**
     * Найти связь по клиенту и проекту
     */
    public function findByClientAndProject($clientId, $projectId) {
        return $this->db->fetch("
        SELECT * FROM {$this->table} 
        WHERE id_client = ? AND id_project = ? 
        ORDER BY id DESC 
        LIMIT 1
    ", [$clientId, $projectId]);
    }

    public function getByShoppingCenter($shoppingCenterId) {
        try {
            // Используем правильное имя таблицы - БЕЗ 's' на конце
            $tableName = 'trislav_group_client_project';

            // Правильный запрос с существующими полями
            $result = $this->db->fetchAll("
                SELECT * 
                FROM " . $tableName . " 
                WHERE id_shopping_center = ? 
                AND (video_filename IS NOT NULL OR yandex_disk_path IS NOT NULL)
                ORDER BY id
            ", [$shoppingCenterId]);

            return $result;

        } catch (Exception $e) {
            return [];
        }
    }

    public function clients_delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $clientModel = new TrislavGroupClient();
            $connectionModel = new TrislavGroupClientProject();

            debug_log("Starting deletion of client ID: " . $id);

            // Получаем все связи клиента
            $connections = $connectionModel->getByClient($id);
            debug_log("Found " . count($connections) . " connections for client");

            // Удаляем видеофайлы всех связей
            foreach ($connections as $connection) {
                debug_log("Deleting video files for connection ID: " . $connection['id']);
                $this->deleteVideoFile(
                    $connection['video_filename'] ?? null,
                    $connection['yandex_disk_path'] ?? null
                );
            }

            // Удаляем изображение клиента если есть
            $client = $clientModel->find($id);
            if ($client && !empty($client['image_url'])) {
                debug_log("Deleting client image: " . $client['image_url']);
                $clientModel->deleteOldImage($client['image_url']);
            }

            // Удаляем клиента (связи удалятся каскадом благодаря внешним ключам)
            $clientModel->delete($id);

            debug_log("Client deletion completed for ID: " . $id);
        }
        header('Location: /admin.php?action=trislav_clients&success=1');
        exit;
    }
}
?>