<?php
class LedController extends Controller {
    public function index() {
        $serviceModel = new Service();
        $tariffModel = new Tariff();
        $portfolioModel = new Portfolio();

        $services = $serviceModel->getActiveByCategory('led');
        $tariffs = $tariffModel->getActive();
        $portfolio = $portfolioModel->getByCategory('led');

        $this->view('site/led', [
            'services' => $services,
            'tariffs' => $tariffs,
            'portfolio' => $portfolio,
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