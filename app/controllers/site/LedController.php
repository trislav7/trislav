<?php
class LedController extends Controller {
    public function index() {
        $serviceModel = new Service();
        $tariffModel = new Tariff();
        $portfolioModel = new Portfolio();
        $ledAdvantageModel = new LedAdvantage();
        $ledRequirementModel = new LedRequirement();
        $settingModel = new SiteSetting();

        $services = $serviceModel->getActiveByCategory('led');
        $tariffs = $tariffModel->getActive();
        $portfolio = $portfolioModel->getByCategory('led');
        $advantages = $ledAdvantageModel->getActiveByCategory('led');
        $settings = $settingModel->getAllSettings();

        // Получаем требования из новой таблицы
        $mainRequirements = $ledRequirementModel->getByType('main');
        $additionalRequirements = $ledRequirementModel->getByType('additional');

        $requirements = [
            'title' => 'Требования к видеороликам',
            'subtitle' => 'Технические спецификации для качественного отображения на LED-экранах',
            'main_title' => 'Основные требования',
            'additional_title' => 'Дополнительные рекомендации',
            'main_requirements' => array_column($mainRequirements, 'description'),
            'additional_requirements' => array_column($additionalRequirements, 'description'),
            'info_title' => 'Важная информация',
            'info_content' => 'Можно разместить, как видео так и статическое изображение. Наша команда может помочь в разработке материалов, логотипов, постеров.'
        ];

        $this->view('site/led', [
            'services' => $services,
            'tariffs' => $tariffs,
            'portfolio' => $portfolio,
            'advantages' => $advantages,
            'requirements' => $requirements,
            'settings' => $settings,
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
                'created_at' => date('Y-m-d H:i:s'),
                'tariff_id' => $_POST['tariff_id'] ?? null,
            ]);

            header('Location: /led?success=1');
            exit;
        }

        header('Location: /led');
        exit;
    }
}