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

// admin.php - после подключения database.php
require_once ROOT_PATH . '/app/core/helpers.php';

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
} elseif (strpos($action, 'trislav_') === 0) {
    // ДОБАВЛЯЕМ ОБРАБОТКУ ДЛЯ ТРИСЛАВ ГРУПП
    $controller = new AdminTrislavGroupController();
    $method = str_replace('trislav_', '', $action);
} elseif (strpos($action, 'settings') === 0) {
    $controller = new AdminSettingsController();
    $method = 'index';
} elseif (strpos($action, 'led_advantages_') === 0) {
    $controller = new AdminLedAdvantagesController();
    $method = str_replace('led_advantages_', '', $action);
} elseif ($action === 'led_advantages') {
    $controller = new AdminLedAdvantagesController();
    $method = 'index';
} elseif (strpos($action, 'led_requirements_') === 0) {
    $controller = new AdminLedRequirementsController();
    $method = str_replace('led_requirements_', '', $action);
} elseif ($action === 'led_requirements') {
    $controller = new AdminLedRequirementsController();
    $method = 'index';
} elseif (strpos($action, 'video_schedule') === 0) {
    $controller = new AdminVideoScheduleController();
    $method = str_replace('video_schedule', '', $action);
    $method = $method ?: 'index';
} elseif (strpos($action, 'trislav_shopping_centers') === 0) {
    $controller = new AdminTrislavGroupController();
    $method = str_replace('trislav_', '', $action);
} elseif ($action === 'download_shopping_center_videos') {
    $controller = new AdminTrislavGroupController();
    $method = 'download_shopping_center_videos';
} elseif ($action === 'ai_assistant') {
    // ДЛЯ ГЛАВНОЙ СТРАНИЦЫ AI АССИСТЕНТА
    $controller = new AdminAIAssistantController();
    $method = 'index';
} elseif ($action === 'ai_assistant_generate') {
    // ДЛЯ AJAX ГЕНЕРАЦИИ ПРОМПТА
    $controller = new AdminAIAssistantController();
    $method = 'generatePrompt';
} else {
    $controller = new AdminAuthController();
    $method = $action;
}

// Вызываем метод
if (method_exists($controller, $method)) {
    // ОТЛАДКА: выведем что вызывается
    error_log("Calling method: " . get_class($controller) . "->" . $method);
    $controller->$method();
} else {
    // ОТЛАДКА: выведем информацию об ошибке
    error_log("Method not found: " . get_class($controller) . "->" . $method);
    error_log("Available methods: " . implode(', ', get_class_methods($controller)));

    // Показываем красивую 404 для админки
    $errorPage = ROOT_PATH . '/app/views/errors/not_found.php';
    if (file_exists($errorPage)) {
        include $errorPage;
    } else {
        echo "<h1>Ошибка 404</h1>";
        echo "<p>Действие не найдено: $action</p>";
        echo "<p>Контроллер: " . get_class($controller) . "</p>";
        echo "<p>Метод: $method</p>";
        echo "<p>Доступные методы: " . implode(', ', get_class_methods($controller)) . "</p>";
        echo "<p><a href='/admin.php'>На главную админки</a></p>";
    }
}