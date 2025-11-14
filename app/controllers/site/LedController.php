<?php
class LedController extends Controller {
    public function index() {
        // Инициализируем кэш напрямую
        $cache = new Cache();

        $cacheKey = "page_led_" . md5($_SERVER['REQUEST_URI']);

        // Проверяем кэш страницы
        if ($cached = $cache->get($cacheKey)) {
            
            echo $cached;
            return;
        }

        

        // Начинаем буферизацию для кэширования
        ob_start();

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

        // Сохраняем в кэш
        $content = ob_get_contents();
        $cache->set($cacheKey, $content, 3600); // 1 час
        ob_end_flush();
    }

    public function submitForm() {
        if ($_POST) {
            try {
                // Валидация reCAPTCHA
                $recaptchaValidator = new RecaptchaValidator();
                $recaptchaToken = $_POST['recaptcha_token'] ?? '';

                if (!$recaptchaValidator->validate($recaptchaToken)) {
                    
                    header('HTTP/1.1 400 Bad Request');
                    echo json_encode(['success' => false, 'message' => 'Проверка безопасности не пройдена']);
                    exit;
                }

                $leadModel = new Lead();
                $leadId = $leadModel->create([
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

                

                header('HTTP/1.1 200 OK');
                echo json_encode(['success' => true, 'message' => 'Заявка успешно отправлена']);
                exit;

            } catch (Exception $e) {
                
                header('HTTP/1.1 500 Internal Server Error');
                echo json_encode(['success' => false, 'message' => 'Ошибка при отправке заявки']);
                exit;
            }
        }

        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['success' => false, 'message' => 'Неверные данные']);
        exit;
    }
}