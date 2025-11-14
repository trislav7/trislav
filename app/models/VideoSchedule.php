<?php
class VideoSchedule extends Model {
    protected $table = 'video_schedules';

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
                cp.video as video_url,
                t.price as tariff_price
            FROM trislav_group_client_project cp
            JOIN trislav_group_clients c ON cp.id_client = c.id
            LEFT JOIN tariffs t ON cp.id_tariff = t.id
            WHERE cp.id_shopping_center = ?
            AND cp.id_project = 1  -- Трислав Медиа
            AND cp.id_service = 1  -- LED экраны
            AND (cp.yandex_disk_path IS NOT NULL OR cp.video_filename IS NOT NULL OR cp.video IS NOT NULL)
            AND c.is_active = 1
            ORDER BY c.title
        ", [$shoppingCenterId]);
    }

    /**
     * Сгенерировать 8-минутный блок согласно тарифам и вернуть данные для отображения и скачивания
     */
    public function generateScheduleData($shoppingCenterId) {
        $clients = $this->getClientsForShoppingCenter($shoppingCenterId);

        
        

        // Правила тарифов: в каких блоках должен появляться клиент
        $tariffRules = [
            1 => [1],      // Эконом (8 мин) - только в 1 блоке
            2 => [1, 3],
            3 => [1, 2, 3, 4],   // Премиум (4 мин) - в 1 и 3 блоке
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
                if (!empty($client['video_path']) || !empty($client['video_filename']) || !empty($client['video_url'])) {
                    $schedule["block_{$blockNum}"][] = [
                        'client_id' => $client['client_id'],
                        'client_name' => $client['client_name'],
                        'tariff_name' => $client['tariff_name'],
                        'video_path' => $client['video_path'],
                        'video_filename' => $client['video_filename'],
                        'video_url' => $client['video_url'],
                        'connection_id' => $client['connection_id'],
                        'is_real_client' => true
                    ];
                }
            }
        }

        // Получаем список случайных видео для заглушек
        $randomDefaultVideos = $this->getRandomDefaultVideos();
        

        // Дополняем оставшиеся слоты до 12 в каждом блоке случайными видео
        for ($block = 1; $block <= 4; $block++) {
            $currentCount = count($schedule["block_{$block}"]);
            $slotsToFill = 12 - $currentCount;

            

            // Если в блоке меньше 12 видео, добавляем случайные заглушки
            for ($i = 0; $i < $slotsToFill; $i++) {
                $randomVideo = $this->getRandomDefaultVideo($randomDefaultVideos);
                $schedule["block_{$block}"][] = $randomVideo;
            }

            // Обрезаем если больше 12 (на всякий случай)
            $schedule["block_{$block}"] = array_slice($schedule["block_{$block}"], 0, 12);
        }

        

        // Создаем последовательность для скачивания
        $downloadSequence = [];
        $counter = 1;

        $blocks = ['block_1', 'block_2', 'block_3', 'block_4'];
        foreach ($blocks as $blockName) {
            foreach ($schedule[$blockName] as $videoItem) {
                $downloadSequence[] = [
                    'slot_number' => $counter,
                    'client_name' => $videoItem['client_name'],
                    'filename' => $videoItem['video_filename'] ?? null,
                    'yandex_disk_path' => $videoItem['video_path'] ?? null,
                    'video_url' => $videoItem['video_url'] ?? null,
                    'is_default' => !($videoItem['is_real_client'] ?? false),
                    'full_path' => $videoItem['full_path'] ?? null
                ];
                $counter++;
            }
        }

        return [
            'schedule' => $schedule, // для отображения таблицы
            'download_sequence' => $downloadSequence // для скачивания
        ];
    }

    /**
     * Сгенерировать 8-минутный блок согласно тарифам (для обратной совместимости)
     */
    public function generateScheduleBlock($shoppingCenterId) {
        $data = $this->generateScheduleData($shoppingCenterId);
        return $data['schedule'];
    }

    /**
     * Получить последовательность видео файлов для скачивания
     */
    public function getDownloadSequence($shoppingCenterId) {
        $data = $this->generateScheduleData($shoppingCenterId);
        return $data['download_sequence'];
    }

    /**
     * Получает список всех доступных видео для заглушек
     */
    private function getRandomDefaultVideos() {
        $defaultVideosDir = './uploads/def_video/';
        $videos = [];

        

        if (!is_dir($defaultVideosDir)) {
            
            return $videos;
        }

        // Получаем список видео файлов
        $allowedExtensions = ['mp4', 'avi', 'mov', 'mkv', 'wmv'];

        foreach ($allowedExtensions as $ext) {
            $pattern = $defaultVideosDir . '*.' . $ext;
            $files = glob($pattern);
            foreach ($files as $file) {
                $videos[] = [
                    'filename' => basename($file),
                    'full_path' => $file
                ];
            }
        }

        
        return $videos;
    }

    /**
     * Выбирает случайное видео из списка
     */
    private function getRandomDefaultVideo($availableVideos) {
        if (empty($availableVideos)) {
            
            return [
                'client_name' => 'Стандартная реклама',
                'tariff_name' => 'По умолчанию',
                'video_path' => 'default/default_ad.mp4',
                'video_filename' => 'default_ad.mp4',
                'is_real_client' => false
            ];
        }

        $randomIndex = array_rand($availableVideos);
        $selectedVideo = $availableVideos[$randomIndex];

        

        return [
            'client_name' => 'Стандартная реклама',
            'tariff_name' => 'По умолчанию',
            'video_path' => 'default/' . $selectedVideo['filename'],
            'video_filename' => $selectedVideo['filename'],
            'full_path' => $selectedVideo['full_path'],
            'is_real_client' => false
        ];
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

    /**
     * Копирует случайное видео из папки дефолтных видео с правильным именем
     */
    private function copyDefaultAd($tempDir, $counter) {
        $defaultVideosDir = './uploads/def_video/';

        

        // Получаем список видео файлов
        $videoFiles = [];
        $allowedExtensions = ['mp4', 'avi', 'mov', 'mkv', 'wmv'];

        foreach ($allowedExtensions as $ext) {
            $pattern = $defaultVideosDir . '*.' . $ext;
            $files = glob($pattern);
            $videoFiles = array_merge($videoFiles, $files);
        }

        

        if (empty($videoFiles)) {
            
            return $this->createEmptyVideoFile($tempDir, $counter);
        }

        // Выбираем случайное видео
        $randomIndex = array_rand($videoFiles);
        $selectedVideo = $videoFiles[$randomIndex];

        

        $filename = sprintf("%05d", $counter) . '.mp4';
        $newPath = $tempDir . '/' . $filename;

        // Копируем выбранное видео
        if (copy($selectedVideo, $newPath)) {
            
            return $newPath;
        } else {
            
            return $this->createEmptyVideoFile($tempDir, $counter);
        }
    }
}
?>