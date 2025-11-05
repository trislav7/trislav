<?php
class Controller {

    public function __construct() {
        // Убедимся что конструктор существует и не вызывает ошибок
    }

    protected function view($view, $data = []) {
        // Извлекаем переменные из data
        extract($data);

        // Путь к файлу представления
        $viewFile = ROOT_PATH . '/app/views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new Exception("View file not found: $viewFile");
        }

        // Включаем файл представления
        require_once $viewFile;
    }

    // Вспомогательный метод для редиректа
    protected function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
}