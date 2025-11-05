<?php
class HomeController extends Controller {
    public function index() {
        $serviceModel = new Service();
        $projectModel = new Project();
        $clientModel = new TrislavGroupClient();
        $reviewModel = new TrislavGroupReview();
        $advantageModel = new TrislavGroupAdvantage();
        $settingModel = new SiteSetting();

        $data = [
            'services' => $serviceModel->getAllActive(),
            'projects' => $projectModel->getAllActive(),
            'clients' => $clientModel->getAllActive(),
            'reviews' => $reviewModel->getAllActive(),
            'advantages' => $advantageModel->getAllActive(),
            'settings' => $settingModel->getAllSettings(),
            'title' => 'Трислав Медиа - Мы создаем точечную рекламу, которая доходит до потребителя.'
        ];

        $this->view('site/home', $data);
    }

    public function privacyPolicy() {
        $settingModel = new SiteSetting();

        $data = [
            'settings' => $settingModel->getAllSettings(),
            'title' => 'Политика конфиденциальности - Трислав Групп'
        ];

        $this->view('site/privacy_policy', $data);
    }
}
?>