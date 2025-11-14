<?php
class SitemapController extends Controller {
    public function index() {
        // Устанавливаем правильный content-type
        header('Content-Type: application/xml; charset=utf-8');
        
        // Получаем базовый URL
        $baseUrl = IS_TRISLAV_MEDIA ? 'https://медиа.трислав.рф' : 'https://трислав.рф';
        
        // Генерируем XML
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        // Статические страницы для каждого сайта
        $this->addStaticPages($baseUrl);
        
        echo '</urlset>';
        exit;
    }
    
    private function addStaticPages($baseUrl) {
        $currentDate = date('Y-m-d');
        
        if (IS_TRISLAV_MEDIA) {
            // Для медиа.трислав.рф
            $pages = [
                '/' => ['priority' => 1.0, 'changefreq' => 'daily'],
                '/led' => ['priority' => 0.9, 'changefreq' => 'weekly'],
                '/video' => ['priority' => 0.9, 'changefreq' => 'weekly'],
                '/btl' => ['priority' => 0.9, 'changefreq' => 'weekly'],
                '/privacy-policy' => ['priority' => 0.3, 'changefreq' => 'monthly'],
            ];
        } else {
            // Для трислав.рф
            $pages = [
                '/' => ['priority' => 1.0, 'changefreq' => 'daily'],
                '/privacy-policy' => ['priority' => 0.3, 'changefreq' => 'monthly'],
            ];
        }
        
        foreach ($pages as $path => $settings) {
            echo '<url>';
            echo '<loc>' . htmlspecialchars($baseUrl . $path) . '</loc>';
            echo '<lastmod>' . $currentDate . '</lastmod>';
            echo '<changefreq>' . $settings['changefreq'] . '</changefreq>';
            echo '<priority>' . $settings['priority'] . '</priority>';
            echo '</url>';
        }
    }
}
?>