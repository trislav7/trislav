<?php
class AdminBaseController extends Controller {

    public function __construct() {
        $this->checkAuth();
    }

    private function checkAuth() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin.php?action=login');
            exit;
        }
    }

    protected function view($view, $data = []) {
        // Добавляем базовые данные для админки
        $data['current_action'] = $_GET['action'] ?? 'dashboard';
        $data['admin_username'] = $_SESSION['admin_username'] ?? 'Администратор';
        parent::view($view, $data);
    }
}