<?php
// Единая точка входа
session_start();

// Базовые настройки
define('ROOT_PATH', __DIR__);
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Автозагрузка классов
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

// Подключаем конфигурацию
$configFile = ROOT_PATH . '/config/database.php';
if (!file_exists($configFile)) {
    die("Файл конфигурации не найден: $configFile");
}
require_once $configFile;

// Создаем роутер
$router = new Router();

// ДЕБАГ: выводим маршруты
if (isset($_GET['debug'])) {
    echo "<pre style='background: #f0f0f0; padding: 20px; margin: 20px 0;'>";
    echo "=== ЗАРЕГИСТРИРОВАННЫЕ МАРШРУТЫ ===\n";
}

//// МАРШРУТЫ САЙТА (публичная часть)
//$router->add('GET', '/', 'SiteController@index');
//$router->add('GET', '/news', 'NewsController@list');
//$router->add('GET', '/news/{id}', 'NewsController@detail');
//$router->add('GET', '/actions', 'ActionsController@list');
//$router->add('GET', '/actions/{id}', 'ActionsController@detail');

// НОВЫЕ МАРШРУТЫ ДЛЯ ТРИСЛАВ МЕДИА
$router->add('GET', '/', 'HomeController@index');
$router->add('GET', '/led', 'LedController@index');
$router->add('POST', '/led/submit', 'LedController@submitForm');
$router->add('GET', '/video', 'VideoController@index');
$router->add('POST', '/video/submit', 'VideoController@submitForm');
$router->add('GET', '/btl', 'BtlController@index');
$router->add('POST', '/btl/submit', 'BtlController@submitForm');
$router->add('POST', '/contact/submit', 'ContactController@submit');

// Админ-маршруты
$router->add('GET', '/admin/services', 'AdminServicesController@index');
$router->add('GET', '/admin/services/create', 'AdminServicesController@create');
$router->add('POST', '/admin/services/create', 'AdminServicesController@create');
$router->add('GET', '/admin/services/edit/{id}', 'AdminServicesController@edit');
$router->add('POST', '/admin/services/edit/{id}', 'AdminServicesController@edit');

$router->add('GET', '/admin/tariffs', 'AdminTariffsController@index');
$router->add('GET', '/admin/portfolio', 'AdminPortfolioController@index');
$router->add('GET', '/admin/leads', 'AdminLeadsController@index');

if (isset($_GET['debug'])) {
    echo "</pre>";
}

// Запускаем маршрутизацию
$router->route();

if (isset($_GET['debug'])) {
    echo "<pre style='background: red; color: white; padding: 20px;'>";
    echo "=== МАРШРУТ НЕ НАЙДЕН ===\n";
    echo "URI: " . $_SERVER['REQUEST_URI'] . "\n";
    echo "Все маршруты:\n";
    // Здесь нужно добавить вывод маршрутов из Router
    echo "</pre>";
}