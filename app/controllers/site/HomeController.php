<?php
class HomeController extends Controller {
    public function index() {
        // Инициализируем модели
        $serviceModel = new Service();
        $portfolioModel = new Portfolio();

        // Получаем данные
        $services = $serviceModel->getAllActive();
        $portfolio = $portfolioModel->getAllActive(6);

        $this->view('site/home', [
            'services' => $services,
            'portfolio' => $portfolio,
            'title' => 'Трислав Медиа - Элитное рекламное агентство'
        ]);
    }
}