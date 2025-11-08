<?php
class Router {
    private $routes = [];
    private $routeFound = false;

    public function add($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function getRoutes() {
        return $this->routes;
    }

    public function route() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];

        // Убираем query параметры
        $requestPath = parse_url($requestUri, PHP_URL_PATH);

        if (isset($_GET['no-cache'])) {
            $this->clearPageCache($requestPath);
        }

        foreach ($this->routes as $index => $route) {
            // ВАЖНО: обрабатываем HEAD запросы так же как GET
            $routeMethod = $route['method'];
            $isHeadRequest = $requestMethod === 'HEAD';
            $isGetRoute = $routeMethod === 'GET';

            if ($isHeadRequest && $isGetRoute) {
                // Для HEAD запросов используем GET маршруты
                $methodMatches = true;
            } else {
                // Для остальных - строгое сравнение
                $methodMatches = $routeMethod === $requestMethod;
            }

            if (!$methodMatches) {
                continue;
            }

            // Преобразуем маршрут в регулярное выражение
            $pattern = $this->convertToRegex($route['path']);

            if (preg_match($pattern, $requestPath, $matches)) {
                // Извлекаем параметры
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Разбираем handler
                list($controllerName, $methodName) = explode('@', $route['handler']);

                // Проверяем существование класса
                if (!class_exists($controllerName)) {
                    $this->handleNotFound();
                    return;
                }

                // Создаем контроллер и вызываем метод
                $controller = new $controllerName();

                if (!method_exists($controller, $methodName)) {
                    $this->handleNotFound();
                    return;
                }

                // Устанавливаем правильный заголовок 200 для найденных маршрутов
                if (!headers_sent()) {
                    http_response_code(200);
                }

                // ВАЖНО: для HEAD запросов не выводим контент
                if ($requestMethod === 'HEAD') {
                    // Устанавливаем заголовки и завершаем
                    if (!headers_sent()) {
                        header('Content-Type: text/html; charset=UTF-8');
                    }
                    return;
                }

                // Вызываем метод контроллера с параметрами
                call_user_func_array([$controller, $methodName], $params);

                // ВАЖНО: выходим после успешного выполнения контроллера
                return;
            }
        }

        $this->handleNotFound();
    }

    private function convertToRegex($path) {
        // Заменяем {param} на named capture groups
        $pattern = preg_replace('/\{([a-z]+)\}/', '(?P<$1>[^/]+)', $path);
        $regex = '#^' . $pattern . '$#';

        return $regex;
    }

    private function handleNotFound() {

        // Устанавливаем 404 только если заголовки еще не отправлены
        if (!headers_sent()) {
            http_response_code(404);
        }

        // Для HEAD запросов не показываем тело 404
        if ($_SERVER['REQUEST_METHOD'] === 'HEAD') {
            exit;
        }

        // Показываем красивую 404 страницу из отдельного файла
        $errorPage = ROOT_PATH . '/app/views/errors/not_found.php';
        if (file_exists($errorPage)) {
            include $errorPage;
        } else {
            // Фолбэк на минимальную 404 страницу
            $this->showMinimal404();
        }

        // ВАЖНО: завершаем выполнение после показа 404
        exit;
    }

    private function clearPageCache($pagePath) {
        $cache = new Cache();

        // Генерируем ключи кэша для этой страницы
        $cacheKeys = $this->generateCacheKeysForPage($pagePath);

        foreach ($cacheKeys as $key) {
            $cache->delete($key);
        }

        // Также очищаем общий кэш если нужно
        $cache->clearByPattern($pagePath);
    }


    private function showMinimal404() {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>404 - Страница не найдена</title>
            <style>
                body { 
                    font-family: Arial, sans-serif; 
                    background: #1a1a2e; 
                    color: #f1f1f1; 
                    display: flex; 
                    justify-content: center; 
                    align-items: center; 
                    min-height: 100vh; 
                    margin: 0; 
                }
                .container { 
                    text-align: center; 
                    padding: 2rem; 
                }
                h1 { 
                    color: #00b7c2; 
                    font-size: 4rem; 
                    margin: 0; 
                }
                a { 
                    color: #00b7c2; 
                    text-decoration: none; 
                }
                a:hover { 
                    text-decoration: underline; 
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>404</h1>
                <p>Страница не найдена</p>
                <p><a href='/'>Вернуться на главную</a></p>
            </div>
        </body>
        </html>";
    }

    private function generateCacheKeysForPage($pagePath) {
        $keys = [];

        // Базовый ключ для страницы
        $baseKey = 'page_' . md5($pagePath);
        $keys[] = $baseKey;

        // Ключи для различных компонентов
        $components = ['services', 'portfolio', 'tariffs', 'projects', 'clients', 'reviews'];
        foreach ($components as $component) {
            $keys[] = "all_active_{$component}";
            $keys[] = "{$component}_*";
        }

        return $keys;
    }
}
