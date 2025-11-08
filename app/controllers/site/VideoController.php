<?php
class VideoController extends Controller {
class VideoController extends Controller {
    public function index() {
        // Инициализируем кэш напрямую
        $cache = new Cache();

        $cacheKey = "page_video_" . md5($_SERVER['REQUEST_URI']);

        // Проверяем кэш страницы
        if ($cached = $cache->get($cacheKey)) {
            debug_log("VideoController: Cache HIT for page Video");
            echo $cached;
            return;
        }

        debug_log("VideoController: Cache MISS for page Video");

        // Начинаем буферизацию для кэширования
        ob_start();

        $serviceModel = new Service();
        $portfolioModel = new Portfolio();

        $services = $serviceModel->getActiveByCategory('video');
        $portfolio = $portfolioModel->getByCategory('video');

        // Детальное логирование для отладки
        debug_log("VideoController: Found " . count($portfolio) . " portfolio items");

        foreach ($portfolio as $index => $item) {
            debug_log("Portfolio item {$index}: ID={$item['id']}, Title={$item['title']}");
            debug_log("  - yandex_disk_path: " . ($item['yandex_disk_path'] ?? 'NULL'));
            debug_log("  - video_filename: " . ($item['video_filename'] ?? 'NULL'));
            debug_log("  - video_url: " . ($item['video_url'] ?? 'NULL'));

            // Получаем финальный URL для отладки
            $finalUrl = getPortfolioVideoUrl($item);
            debug_log("  - final_video_url: " . ($finalUrl ?? 'NULL'));
        }

        $this->view('site/video', [
            'services' => $services,
            'portfolio' => $portfolio,
            'title' => 'Видеоролики и Логотипы | Трислав Медиа'
        ]);

        // Сохраняем в кэш
        $content = ob_get_contents();
        $cache->set($cacheKey, $content, 3600);
        ob_end_flush();
    }


    public function submitForm() {
        if ($_POST) {
            $leadModel = new Lead();
            $leadModel->create([
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'company' => $_POST['company'] ?? '',
                'service_type' => $_POST['service'] ?? 'video',
                'budget' => $_POST['budget'] ?? '',
                'message' => $_POST['message'] ?? '',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            header('Location: /video?success=1');
            exit;
        }

        header('Location: /video');
        exit;
    }
}