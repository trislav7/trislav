<?php
class HomeController extends Controller {
    public function index() {
        // Инициализируем кэш напрямую
        $cache = new Cache();

        $cacheKey = "page_home_" . md5($_SERVER['REQUEST_URI']);

        // Проверяем кэш страницы
        if ($cached = $cache->get($cacheKey)) {
            
            echo $cached;
            return;
        }

        

        // Начинаем буферизацию для кэширования
        ob_start();

        $serviceModel = new Service();
        $projectModel = new Project();
        $clientModel = new TrislavGroupClient();
        $reviewModel = new TrislavGroupReview();
        $ledAdvantageModel = new LedAdvantage();
        $settingModel = new SiteSetting();

        $data = [
            'services' => $serviceModel->getAllActive(),
            'projects' => $projectModel->getAllActive(),
            'clients' => $clientModel->getAllActive(),
            'reviews' => $reviewModel->getAllActive(),
            'advantages' => $ledAdvantageModel->getActiveByCategory('trislav_media'),
            'settings' => $settingModel->getAllSettings(),
            'title' => 'Трислав Медиа - Мы создаем точечную рекламу, которая доходит до потребителя.'
        ];

        $this->view('site/home', $data);

        // Сохраняем в кэш
        $content = ob_get_contents();
        $cache->set($cacheKey, $content, 3600); // 1 час
        ob_end_flush();
    }

    public function privacyPolicy() {
        // Инициализируем кэш напрямую
        $cache = new Cache();

        $cacheKey = "page_privacy_" . md5($_SERVER['REQUEST_URI']);

        // Проверяем кэш страницы
        if ($cached = $cache->get($cacheKey)) {
            
            echo $cached;
            return;
        }

        

        // Начинаем буферизацию для кэширования
        ob_start();

        $settingModel = new SiteSetting();

        $data = [
            'settings' => $settingModel->getAllSettings(),
            'title' => 'Политика конфиденциальности - Трислав Групп'
        ];

        $this->view('site/privacy_policy', $data);

        // Сохраняем в кэш
        $content = ob_get_contents();
        $cache->set($cacheKey, $content, 86400); // 24 часа - редко меняется
        ob_end_flush();
    }
}
?>