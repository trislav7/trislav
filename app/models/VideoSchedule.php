<?php
class VideoSchedule extends Model {
    protected $table = 'video_schedules';

    /**
     * Получить всех клиентов для ТЦ с видео для LED экранов
     */
    public function getClientsForShoppingCenter($shoppingCenterId) {
        return $this->db->fetchAll("
            SELECT 
                cp.id as connection_id,
                c.id as client_id,
                c.title as client_name,
                cp.id_tariff as tariff_id,
                t.title as tariff_name,
                cp.yandex_disk_path as video_path,
                cp.video_filename as video_filename,
                t.price as tariff_price
            FROM trislav_group_client_project cp
            JOIN trislav_group_clients c ON cp.id_client = c.id
            LEFT JOIN tariffs t ON cp.id_tariff = t.id
            WHERE cp.id_shopping_center = ?
            AND cp.id_project = 1  -- Трислав Медиа
            AND cp.id_service = 1  -- LED экраны
            AND cp.yandex_disk_path IS NOT NULL
            AND cp.yandex_disk_path != ''
            AND c.is_active = 1
            ORDER BY c.title
        ", [$shoppingCenterId]);
    }

    /**
     * Сгенерировать 8-минутный блок согласно тарифам
     */
    public function generateScheduleBlock($shoppingCenterId) {
        $clients = $this->getClientsForShoppingCenter($shoppingCenterId);
        
        // Правила тарифов: в каких блоках должен появляться клиент
        $tariffRules = [
            1 => [1],      // Эконом (8 мин) - только в 1 блоке
            2 => [1, 4],   // Оптимальный (6 мин) - в 1 и 4 блоке
            3 => [1, 3],   // Премиум (4 мин) - в 1 и 3 блоке  
        ];

        $schedule = [
            'block_1' => [], // 0-2 минуты
            'block_2' => [], // 2-4 минуты  
            'block_3' => [], // 4-6 минуты
            'block_4' => []  // 6-8 минуты
        ];

        // Распределяем клиентов по блокам согласно тарифам
        foreach ($clients as $client) {
            $tariffId = $client['tariff_id'] ?? 1;
            $blocks = $tariffRules[$tariffId] ?? [1];
            
            foreach ($blocks as $blockNum) {
                if (!empty($client['video_path'])) {
                    $schedule["block_{$blockNum}"][] = [
                        'client_id' => $client['client_id'],
                        'client_name' => $client['client_name'],
                        'tariff_name' => $client['tariff_name'],
                        'video_path' => $client['video_path'],
                        'video_filename' => $client['video_filename'],
                        'connection_id' => $client['connection_id']
                    ];
                }
            }
        }

        // Дополняем оставшиеся слоты до 12 в каждом блоке
        $defaultVideo = [
            'client_name' => 'Стандартная реклама',
            'tariff_name' => 'По умолчанию',
            'video_path' => 'default/default_ad.mp4',
            'video_filename' => 'default_ad.mp4'
        ];

        for ($block = 1; $block <= 4; $block++) {
            $currentCount = count($schedule["block_{$block}"]);
            
            // Если в блоке меньше 12 видео, добавляем стандартные
            while ($currentCount < 12) {
                $schedule["block_{$block}"][] = $defaultVideo;
                $currentCount++;
            }

            // Обрезаем если больше 12 (на всякий случай)
            $schedule["block_{$block}"] = array_slice($schedule["block_{$block}"], 0, 12);
        }

        return $schedule;
    }

    /**
     * Сохранить сгенерированную сетку
     */
    public function saveSchedule($shoppingCenterId, $schedule, $createdBy = 'admin') {
        // Удаляем старую сетку
        $this->db->query("
            DELETE FROM {$this->table} 
            WHERE shopping_center_id = ?
        ", [$shoppingCenterId]);

        // Сохраняем новую
        return $this->create([
            'shopping_center_id' => $shoppingCenterId,
            'schedule_data' => json_encode($schedule),
            'created_by' => $createdBy,
            'is_active' => 1
        ]);
    }

    /**
     * Получить сохраненную сетку для ТЦ
     */
    public function getSavedSchedule($shoppingCenterId) {
        $schedule = $this->db->fetch("
            SELECT * FROM {$this->table} 
            WHERE shopping_center_id = ? 
            AND is_active = 1
            ORDER BY created_at DESC 
            LIMIT 1
        ", [$shoppingCenterId]);

        if ($schedule) {
            $schedule['schedule_data'] = json_decode($schedule['schedule_data'], true) ?? [];
        }

        return $schedule;
    }
}
?>