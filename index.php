<?php
// index.php (корневой)
session_start();

define('ROOT_PATH', __DIR__);
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once ROOT_PATH . '/app/core/Dumper.php';

// ПОДКЛЮЧАЕМ КОНФИГУРАЦИЮ ДОМЕНОВ ПЕРВЫМ ДЕЛОМ
require_once ROOT_PATH . '/config/domains.php';
require_once ROOT_PATH . '/app/core/helpers.php';

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

// Подключаем конфигурацию БД
$configFile = ROOT_PATH . '/config/database.php';
if (!file_exists($configFile)) {
    header('HTTP/1.1 500 Internal Server Error');
    die("Файл конфигурации не найден: $configFile");
}
require_once $configFile;

// 🔥 НОВЫЙ КОД: Подключаем и запускаем CacheMiddleware
require_once ROOT_PATH . '/app/core/CacheMiddleware.php';
CacheMiddleware::handle();

// Создаем роутер
$router = new Router();

// МАРШРУТИЗАЦИЯ В ЗАВИСИМОСТИ ОТ ТИПА САЙТА
if (IS_TRISLAV_MEDIA) {
    $router->add('GET', '/', 'HomeController@index');
    $router->add('GET', '/led', 'LedController@index');
    $router->add('POST', '/led/submit', 'LedController@submitForm');
    $router->add('GET', '/video', 'VideoController@index');
    $router->add('POST', '/video/submit', 'VideoController@submitForm');
    $router->add('GET', '/btl', 'BtlController@index');
    $router->add('POST', '/btl/submit', 'BtlController@submitForm');
    $router->add('POST', '/contact/submit', 'ContactController@submit');
    $router->add('GET', '/privacy-policy', 'HomeController@privacyPolicy');
} else {
    $router->add('GET', '/', 'TrislavGroupController@index');
    $router->add('POST', '/contact/submit', 'TrislavGroupController@contactSubmit');
    $router->add('GET', '/privacy-policy', 'TrislavGroupController@privacyPolicy');
}

$router->add('GET', '/video/stream', 'VideoProxyController@stream');
$router->add('GET', '/sitemap.xml', 'SitemapController@index');

// ЯВНО УСТАНАВЛИВАЕМ ЗАГОЛОВОК 200 ПЕРЕД РОУТЕРОМ
if (!headers_sent()) {
    http_response_code(200);
}

// Запускаем маршрутизацию
$router->route();
?>
