<?php
class BtlController extends Controller {
    public function index() {
        debug_log("BtlController::index called");

        $serviceModel = new Service();
        $portfolioModel = new Portfolio();
        $settingModel = new SiteSetting();

        try {
            debug_log("Fetching BTL services");
            $services = $serviceModel->getActiveByCategory('btl');
            debug_log("Found " . count($services) . " BTL services");

            debug_log("Fetching BTL portfolio for slider");
            $sliderPortfolio = $portfolioModel->getForSlider('btl', 4);
            debug_log("Found " . count($sliderPortfolio) . " portfolio items for slider");

            debug_log("Fetching all BTL portfolio");
            $portfolio = $portfolioModel->getByCategory('btl');
            debug_log("Found " . count($portfolio) . " total portfolio items");

            $data = [
                'services' => $services,
                'portfolio' => $portfolio,
                'slider_portfolio' => $sliderPortfolio,
                'settings' => $settingModel->getAllSettings(),
                'title' => 'BTL-мероприятия - Трислав Медиа'
            ];

            debug_log("Rendering BTL view");
            $this->view('site/btl', $data);

        } catch (Exception $e) {
            debug_log("ERROR in BtlController: " . $e->getMessage());
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