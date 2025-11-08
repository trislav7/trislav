<?php
class BtlController extends Controller {
    public function index() {
        // Инициализируем кэш напрямую
        $cache = new Cache();

        $cacheKey = "page_btl_" . md5($_SERVER['REQUEST_URI']);

        // Проверяем кэш страницы
        if ($cached = $cache->get($cacheKey)) {
            debug_log("BtlController: Cache HIT for page BTL");
            echo $cached;
            return;
        }

        debug_log("BtlController: Cache MISS for page BTL");

        // Начинаем буферизацию для кэширования
        ob_start();

        $serviceModel = new Service();
        $portfolioModel = new Portfolio();
        $settingModel = new SiteSetting();

        try {
            $services = $serviceModel->getActiveByCategory('btl');
            $sliderPortfolio = $portfolioModel->getForSlider('btl', 4);
            $portfolio = $portfolioModel->getByCategory('btl');

            $data = [
                'services' => $services,
                'portfolio' => $portfolio,
                'slider_portfolio' => $sliderPortfolio,
                'settings' => $settingModel->getAllSettings(),
                'title' => 'BTL-мероприятия - Трислав Медиа'
            ];

            $this->view('site/btl', $data);

        } catch (Exception $e) {
            throw $e;
        }

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
                'service_type' => 'btl',
                'budget' => $_POST['budget'] ?? '',
                'message' => $_POST['message'] ?? '',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            header('Location: /btl?success=1');
            exit;
        }

        header('Location: /btl');
        exit;
    }
}
?>