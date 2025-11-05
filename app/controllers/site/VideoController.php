<?php
class VideoController extends Controller {
    public function index() {
        $serviceModel = new Service();
        $portfolioModel = new Portfolio();

        $services = $serviceModel->getActiveByCategory('video');
        $portfolio = $portfolioModel->getByCategory('video');

        $this->view('site/video', [
            'services' => $services,
            'portfolio' => $portfolio,
            'title' => 'Видеоролики и Логотипы | Трислав Медиа'
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
                'service_type' => $_POST['service'] ?? 'video',
                'budget' => $_POST['budget'] ?? '',
                'message' => $_POST['message'] ?? '',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            header('Location: /video?success=1');
            exit;
        }

        header('Location: /video');
        exit;
    }
}