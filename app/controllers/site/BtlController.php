<?php
class BtlController extends Controller {
    public function index() {
        $serviceModel = new Service();
        $portfolioModel = new Portfolio();

        $services = $serviceModel->getActiveByCategory('btl');
        $portfolio = $portfolioModel->getByCategory('btl');

        $this->view('site/btl', [
            'services' => $services,
            'portfolio' => $portfolio,
            'title' => 'BTL Мероприятия | Трислав Медиа'
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