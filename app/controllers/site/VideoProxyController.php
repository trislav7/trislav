// /app/controllers/site/VideoProxyController.php - АЛЬТЕРНАТИВНАЯ ВЕРСИЯ С КЭШИРОВАНИЕМ

<?php
class VideoProxyController extends Controller {
    
    public function stream() {
        $portfolioId = $_GET['id'] ?? null;
        
        if (!$portfolioId) {
            http_response_code(400);
            exit;
        }
        
        $cache = new Cache();
        $cacheKey = "video_proxy_{$portfolioId}";
        
        // Проверяем кэш
        if ($cachedUrl = $cache->get($cacheKey)) {
            $this->redirectToUrl($cachedUrl);
            return;
        }
        
        $portfolioModel = new Portfolio();
        $portfolioItem = $portfolioModel->find($portfolioId);
        
        if (!$portfolioItem || empty($portfolioItem['yandex_disk_path'])) {
            http_response_code(404);
            exit;
        }
        
        // Получаем временную ссылку (действует 6 часов)
        $yandexConfig = require ROOT_PATH . '/config/yandex_disk.php';
        $diskService = new YandexDiskService($yandexConfig['token']);
        $tempUrl = $this->getTemporaryDirectUrl($diskService, $portfolioItem['yandex_disk_path']);
        
        if ($tempUrl) {
            // Кэшируем на 5 часов
            $cache->set($cacheKey, $tempUrl, 18000);
            $this->redirectToUrl($tempUrl);
        } else {
            http_response_code(404);
        }
    }
    
    private function getTemporaryDirectUrl($diskService, $diskPath) {
        
        
        // Используем метод скачивания, но с временной ссылкой
        $downloadUrl = $diskService->getPublicUrl($diskPath);
        
        if ($downloadUrl) {
            
            return $downloadUrl;
        }
        
        return null;
    }
    
    private function redirectToUrl($url) {
        
        header('Location: ' . $url);
        exit;
    }
}