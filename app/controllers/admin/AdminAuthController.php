<?php
class AdminAuthController extends Controller {

    public function __construct() {
        // Конструктор пустой, сессия запускается в admin.php
    }

    public function login() {
        // Если уже авторизован - редирект в админку
        if ($this->isLoggedIn()) {
            header('Location: /admin.php?action=dashboard');
            exit;
        }

        if ($_POST) {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($this->authenticate($username, $password)) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $username;
                header('Location: /admin.php?action=dashboard');
                exit;
            } else {
                $error = "Неверные учетные данные";
            }
        }

        // Для страницы логина используем простой layout
        $this->view('admin/login', [
            'error' => $error ?? null,
            'title' => 'Вход в админку',
            'use_simple_layout' => true // Флаг для использования простого layout
        ]);
    }

    public function logout() {
        session_destroy();
        header('Location: /admin.php?action=login');
        exit;
    }

    public function dashboard() {
        $this->requireAdmin();

        // Простая статистика для дашборда
        $leadModel = new Lead();
        $serviceModel = new Service();
        $portfolioModel = new Portfolio();

        $newLeads = $leadModel->getNewLeads();
        $services = $serviceModel->getAll();
        $portfolio = $portfolioModel->getAll();

        $this->view('admin/dashboard', [
            'newLeadsCount' => count($newLeads),
            'servicesCount' => count($services),
            'portfolioCount' => count($portfolio),
            'title' => 'Дашборд админки'
        ]);
    }

    private function authenticate($username, $password) {
        // Простая аутентификация (ЗАМЕНИТЕ на свою!)
        $validUsername = 'admin';
        $validPassword = 'admin123';

        return $username === $validUsername && $password === $validPassword;
    }

    private function isLoggedIn() {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

    protected function requireAdmin() {
        if (!$this->isLoggedIn()) {
            header('Location: /admin.php?action=login');
            exit;
        }
    }
}