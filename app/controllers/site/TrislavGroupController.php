<?php
class TrislavGroupController extends Controller {
    public function index() {
        // Инициализируем кэш напрямую
        $cache = new Cache();

        $cacheKey = "page_trislav_group_" . md5($_SERVER['REQUEST_URI']);

        // Проверяем кэш страницы
        if ($cached = $cache->get($cacheKey)) {
            debug_log("TrislavGroupController: Cache HIT for page Trislav Group");
            echo $cached;
            return;
        }

        debug_log("TrislavGroupController: Cache MISS for page Trislav Group");

        // Начинаем буферизацию для кэширования
        ob_start();

        $projectModel = new TrislavGroupProject();
        $clientModel = new TrislavGroupClient();
        $reviewModel = new TrislavGroupReview();
        $advantageModel = new LedAdvantage();
        $settingModel = new SiteSetting();

        $data = [
            'projects' => $projectModel->getAllActive(),
            'clients' => $clientModel->getAllActive(),
            'reviews' => $reviewModel->getAllActive(),
            'advantages' => $advantageModel->getActiveByCategory('trislav_group'),
            'settings' => $settingModel->getAllSettings(),
            'title' => 'Трислав Групп | Развитие бизнеса через креативные решения'
        ];

        $this->view('site/trislav_group', $data);

        // Сохраняем в кэш
        $content = ob_get_contents();
        $cache->set($cacheKey, $content, 3600);
        ob_end_flush();
    }

    public function privacyPolicy() {
        $settingModel = new SiteSetting();

        $data = [
            'settings' => $settingModel->getAllSettings(),
            'title' => 'Политика конфиденциальности - Трислав Групп'
        ];

        $this->view('site/privacy_policy', $data);
    }

    public function contactSubmit() {

        if ($_POST) {
            try {
                $leadModel = new Lead();

                // Проверяем согласие с политикой
                if (!isset($_POST['privacy_agreement'])) {
                    header('HTTP/1.1 400 Bad Request');
                    exit;
                }

                // Подготавливаем данные для БД - БЕЗ ПОЛЯ source
                $data = [
                    'name' => $_POST['name'] ?? '',
                    'phone' => $_POST['phone'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'company' => $_POST['company'] ?? '',
                    'service_type' => 'trislav_group_general',
                    'message' => $_POST['message'] ?? '',
                    'project_id' => !empty($_POST['project_id']) ? (int)$_POST['project_id'] : null,
                    'privacy_agreement' => 1,
                    'status' => 'new'
                ];


                // Создаем лид
                $leadId = $leadModel->create($data);

                // Возвращаем успешный статус для AJAX
                header('HTTP/1.1 200 OK');
                exit;

            } catch (Exception $e) {
                header('HTTP/1.1 500 Internal Server Error');
                exit;
            }
        } else {
            header('HTTP/1.1 400 Bad Request');
            exit;
        }
    }
}
?>