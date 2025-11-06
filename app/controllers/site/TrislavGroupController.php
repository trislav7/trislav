<?php
class TrislavGroupController extends Controller {
    public function index() {
        $projectModel = new TrislavGroupProject();
        $clientModel = new TrislavGroupClient();
        $reviewModel = new TrislavGroupReview();
        $advantageModel = new LedAdvantage(); // Используем общую модель преимуществ
        $settingModel = new SiteSetting();

        $data = [
            'projects' => $projectModel->getAllActive(),
            'clients' => $clientModel->getAllActive(),
            'reviews' => $reviewModel->getAllActive(),
            'advantages' => $advantageModel->getActiveByCategory('trislav_group'), // Только преимущества Трислав Групп
            'settings' => $settingModel->getAllSettings(),
            'title' => 'Трислав Групп | Развитие бизнеса через креативные решения'
        ];

        $this->view('site/trislav_group', $data);
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
        debug_log("=== TRISLAV GROUP FORM SUBMISSION STARTED ===");
        debug_log("POST data: " . json_encode($_POST));

        if ($_POST) {
            try {
                $leadModel = new Lead();

                // Проверяем согласие с политикой
                if (!isset($_POST['privacy_agreement'])) {
                    debug_log("Privacy agreement not accepted");
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

                debug_log("Prepared lead data for DB: " . json_encode($data));

                // Создаем лид
                $leadId = $leadModel->create($data);
                debug_log("SUCCESS: Lead created with ID: " . $leadId);

                // Возвращаем успешный статус для AJAX
                header('HTTP/1.1 200 OK');
                exit;

            } catch (Exception $e) {
                debug_log("ERROR creating lead: " . $e->getMessage());
                debug_log("Error trace: " . $e->getTraceAsString());
                header('HTTP/1.1 500 Internal Server Error');
                exit;
            }
        } else {
            debug_log("No POST data received");
            header('HTTP/1.1 400 Bad Request');
            exit;
        }
    }
}
?>