<?php
class Router {
    private $routes = [];
    
    public function add($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }
    
    public function route() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];
        
        // Убираем query параметры
        $requestPath = parse_url($requestUri, PHP_URL_PATH);
        
        // ДЕБАГ: информация о запросе
        if (isset($_GET['debug'])) {
            echo "<pre style='background: #e0f7fa; padding: 10px; margin: 10px 0;'>";
            echo "=== ROUTER DEBUG ===\n";
            echo "URI: $requestPath\n";
            echo "Method: $requestMethod\n";
            echo "</pre>";
        }
        
        foreach ($this->routes as $route) {
            // Проверяем метод
            if ($route['method'] !== $requestMethod) {
                continue;
            }
            
            // Преобразуем маршрут в регулярное выражение
            $pattern = $this->convertToRegex($route['path']);
            
            if (preg_match($pattern, $requestPath, $matches)) {
                // Извлекаем параметры
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                // Разбираем handler
                list($controllerName, $methodName) = explode('@', $route['handler']);
                
                // ДЕБАГ: информация о найденном маршруте
                if (isset($_GET['debug'])) {
                    echo "<pre style='background: #c8e6c9; padding: 10px; margin: 10px 0;'>";
                    echo "Маршрут найден!\n";
                    echo "Контроллер: $controllerName\n";
                    echo "Метод: $methodName\n";
                    echo "Параметры: " . print_r($params, true) . "\n";
                    echo "</pre>";
                }
                
                // Проверяем существование класса
                if (!class_exists($controllerName)) {
                    if (isset($_GET['debug'])) {
                        echo "<pre style='background: #ffcdd2; padding: 10px; margin: 10px 0;'>";
                        echo "Класс не существует: $controllerName\n";
                        echo "</pre>";
                    }
                    continue;
                }
                
                // Создаем контроллер и вызываем метод
                $controller = new $controllerName();
                
                if (!method_exists($controller, $methodName)) {
                    if (isset($_GET['debug'])) {
                        echo "<pre style='background: #ffcdd2; padding: 10px; margin: 10px 0;'>";
                        echo "Метод не существует: $methodName в классе $controllerName\n";
                        echo "</pre>";
                    }
                    continue;
                }
                
                call_user_func_array([$controller, $methodName], $params);
                return;
            }
        }
        
        // Если маршрут не найден
        $this->handleNotFound();
    }
    
    private function convertToRegex($path) {
        // Заменяем {param} на named capture groups
        $pattern = preg_replace('/\{([a-z]+)\}/', '(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }
    
    private function handleNotFound() {
        http_response_code(404);
        
        if (isset($_GET['debug'])) {
            echo "<pre style='background: #ffeb3b; padding: 10px; margin: 10px 0;'>";
            echo "Маршрут не найден для: " . $_SERVER['REQUEST_URI'] . "\n";
            echo "Доступные маршруты:\n";
            foreach ($this->routes as $route) {
                echo $route['method'] . ' ' . $route['path'] . ' -> ' . $route['handler'] . "\n";
            }
            echo "</pre>";
        }
        
        // Пробуем показать красивую 404 страницу
        if (file_exists(ROOT_PATH . '/app/views/errors/404.php')) {
            include ROOT_PATH . '/app/views/errors/404.php';
        } else {
            echo "<h1>404 - Страница не найдена</h1>";
            echo "<p>Запрошенная страница не существует: " . $_SERVER['REQUEST_URI'] . "</p>";
        }
    }
}