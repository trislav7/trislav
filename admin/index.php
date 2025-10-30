<?php
require_once '../app/core/Router.php';
require_once '../app/models/Database.php';
require_once '../app/controllers/AdminController.php';

$router = new Router();

// Админ маршруты
$router->addRoute('/admin', 'AdminController', 'dashboard', 'GET');
$router->addRoute('/admin/login', 'AdminController', 'login', 'GET');
$router->addRoute('/admin/login', 'AdminController', 'login', 'POST');
$router->addRoute('/admin/logout', 'AdminController', 'logout', 'GET');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($uri, $method);