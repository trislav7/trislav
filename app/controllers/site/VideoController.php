<?php
class VideoController extends Controller {
    public function index() {
        // Инициализируем кэш напрямую
        $cache = new Cache();

        $cacheKey = "page_video_" . md5($_SERVER['REQUEST_URI']);

        // Проверяем кэш страницы
        if ($cached = $cache->get($cacheKey)) {
            
            echo $cached;
            return;
        }

        

        // Начинаем буферизацию для кэширования
        ob_start();

        $serviceModel = new Service();
        $portfolioModel = new Portfolio();

        $services = $serviceModel->getActiveByCategory('video');
        $portfolio = $portfolioModel->getByCategory('video');

        // Детальное логирование для отладки
        

        foreach ($portfolio as $index => $item) {
            
            
            
            

            // Получаем финальный URL для отладки
            $finalUrl = getPortfolioVideoUrl($item);
            
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
            try {
                // ВАЛИДАЦИЯ reCAPTCHA
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
                    'service_type' => $_POST['service'] ?? 'video',
                    'budget' => $_POST['budget'] ?? '',
                    'message' => $_POST['message'] ?? '',
                    'created_at' => date('Y-m-d H:i:s')
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