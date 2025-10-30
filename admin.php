<?php
session_start();
define('ROOT_PATH', __DIR__);
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Автозагрузка с поддержкой модулей
spl_autoload_register(function ($class) {
    $paths = [
        '/app/core/',
        '/app/models/',
        '/app/controllers/',
        '/app/controllers/admin/',
        '/app/controllers/site/'
    ];
    
    foreach ($paths as $path) {
        $file = ROOT_PATH . $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

require_once ROOT_PATH . '/config/database.php';

// Определяем действие и контроллер
$action = $_GET['action'] ?? 'dashboard';
$action = str_replace('-', '_', $action);

// РАЗБИВАЕМ ACTION НА КОНТРОЛЛЕР И МЕТОД
if (strpos($action, 'services_') === 0) {
    $controller = new AdminServicesController();
    $method = str_replace('services_', '', $action);
} elseif (strpos($action, 'tariffs_') === 0) {
    $controller = new AdminTariffsController();
    $method = str_replace('tariffs_', '', $action);
} elseif (strpos($action, 'portfolio_') === 0) {
    $controller = new AdminPortfolioController();
    $method = str_replace('portfolio_', '', $action);
} elseif (strpos($action, 'leads_') === 0) {
    $controller = new AdminLeadsController();
    $method = str_replace('leads_', '', $action);
} elseif (strpos($action, 'news_') === 0) {
    $controller = new AdminNewsController();
    $method = str_replace('news_', '', $action);
} elseif (strpos($action, 'actions_') === 0) {
    $controller = new AdminActionsController();
    $method = str_replace('actions_', '', $action);
} elseif (strpos($action, 'categories_') === 0) {
    $controller = new AdminCategoriesController();
    $method = str_replace('categories_', '', $action);
} else {
    $controller = new AdminAuthController();
    $method = $action;
}

// Вызываем метод
if (method_exists($controller, $method)) {
    $controller->$method();
} else {
    echo "<h1>Ошибка 404</h1>";
    echo "<p>Действие не найдено: $action</p>";
    echo "<p><a href='/admin.php'>На главную админки</a></p>";
}