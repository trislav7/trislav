<?php
class TrislavGroupController extends Controller {
    public function index() {
        $projectModel = new TrislavGroupProject();
        $clientModel = new TrislavGroupClient();
        $reviewModel = new TrislavGroupReview();
        $advantageModel = new TrislavGroupAdvantage();
        $settingModel = new SiteSetting();

        $data = [
            'projects' => $projectModel->getAllActive(),
            'clients' => $clientModel->getAllActive(),
            'reviews' => $reviewModel->getAllActive(),
            'advantages' => $advantageModel->getAllActive(),
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
        if ($_POST) {
            try {
                $leadModel = new Lead();

                $data = [
                    'name' => $_POST['name'] ?? '',
                    'phone' => $_POST['phone'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'company' => $_POST['company'] ?? '',
                    'service_type' => 'trislav_group_general',
                    'message' => $_POST['message'] ?? '',
                    'privacy_agreement' => isset($_POST['privacy_agreement']) ? 1 : 0,
                    'status' => 'new',
                    'created_at' => date('Y-m-d H:i:s')
                ];

                if (!$data['privacy_agreement']) {
                    header('Location: /?error=privacy');
                    exit;
                }

                $leadId = $leadModel->create($data);
                header('Location: /?success=1');
                exit;

            } catch (Exception $e) {
                header('Location: /?error=1');
                exit;
            }
        }
        header('Location: /');
        exit;
    }
}
?>