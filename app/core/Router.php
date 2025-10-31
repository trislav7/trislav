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

        // Показываем красивую 404 страницу из отдельного файла
        $errorPage = ROOT_PATH . '/app/views/errors/not_found.php';
        if (file_exists($errorPage)) {
            include $errorPage;
        } else {
            // Фолбэк на минимальную 404 страницу
            $this->showMinimal404();
        }
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
}