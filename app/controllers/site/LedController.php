<?php
class LedController extends Controller {
    public function index() {
        $serviceModel = new Service();
        $tariffModel = new Tariff();
        $portfolioModel = new Portfolio();
        $ledAdvantageModel = new LedAdvantage();
        $settingModel = new SiteSetting();

        $services = $serviceModel->getActiveByCategory('led');
        $tariffs = $tariffModel->getActive();
        $portfolio = $portfolioModel->getByCategory('led');
        $advantages = $ledAdvantageModel->getAllActive();
        $settings = $settingModel->getAllSettings();

        // Получаем требования из настроек
        $requirements = [
            'title' => $settings['led_requirements_title'] ?? 'Требования к видеороликам',
            'subtitle' => $settings['led_requirements_subtitle'] ?? 'Технические спецификации для качественного отображения на LED-экранах',
            'main_title' => $settings['led_requirements_main_title'] ?? 'Основные требования',
            'additional_title' => $settings['led_requirements_additional_title'] ?? 'Дополнительные рекомендации',
            'info_title' => $settings['led_requirements_info_title'] ?? 'Важная информация',
            'info_content' => $settings['led_requirements_info_content'] ?? '',
            'main_requirements' => [],
            'additional_requirements' => []
        ];

        // Собираем основные требования
        for ($i = 1; $i <= 5; $i++) {
            $key = 'led_requirement_main_' . $i;
            if (!empty($settings[$key])) {
                $requirements['main_requirements'][] = $settings[$key];
            }
        }

        // Собираем дополнительные рекомендации
        for ($i = 1; $i <= 5; $i++) {
            $key = 'led_requirement_additional_' . $i;
            if (!empty($settings[$key])) {
                $requirements['additional_requirements'][] = $settings[$key];
            }
        }

        $this->view('site/led', [
            'services' => $services,
            'tariffs' => $tariffs,
            'portfolio' => $portfolio,
            'advantages' => $advantages,
            'requirements' => $requirements,
            'title' => 'LED Экраны в Торговых Центрах | Трислав Медиа'
        ]);
    }

    public function submitForm() {
        if ($_POST) {
            $leadModel = new Lead();
            $leadModel->create([
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'company' => $_POST['company'] ?? '',
                'service_type' => 'led',
                'budget' => $_POST['budget'] ?? '',
                'message' => $_POST['message'] ?? '',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            header('Location: /led?success=1');
            exit;
        }

        header('Location: /led');
        exit;
    }
}