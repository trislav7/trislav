<?php
class BtlController extends Controller {
    public function index() {

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