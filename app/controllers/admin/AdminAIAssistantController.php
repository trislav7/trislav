<?php

class AdminAIAssistantController extends AdminBaseController {
    public function index() {
        $data = [
            'title' => 'AI Ассистент - Генератор промптов',
            'tracked_files' => $this->getTrackedFiles(),
            'project_structure' => $this->getProjectStructure()
        ];

        $this->view('admin/ai_assistant', $data);
    }

    public function generatePrompt() {
        // Очищаем все возможные буферы
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question'])) {
            $question = trim($_POST['question']);
            $focus = trim($_POST['focus'] ?? '');

            try {
                $prompt = $this->generateSmartPrompt($question, $focus);

                // Проверяем и чистим промпт перед JSON кодированием
                $cleanPrompt = mb_convert_encoding($prompt, 'UTF-8', 'UTF-8');
                $cleanPrompt = iconv('UTF-8', 'UTF-8//IGNORE', $prompt);

                $response = [
                    'success' => true,
                    'prompt' => $cleanPrompt
                ];

                // Пытаемся закодировать JSON с обработкой ошибок
                $json = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);

                if ($json === false) {
                    $errorMsg = json_last_error_msg();

                    // Если не удалось, пробуем очистить промпт более агрессивно
                    $cleanPrompt = $this->deepCleanString($prompt);
                    $response['prompt'] = $cleanPrompt;
                    $json = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);

                    if ($json === false) {
                        throw new Exception('Не удалось сгенерировать валидный JSON после очистки');
                    }
                }

                header('Content-Type: application/json; charset=utf-8');
                echo $json;
                exit;

            } catch (Exception $e) {

                $response = [
                    'success' => false,
                    'error' => 'Ошибка: ' . $e->getMessage()
                ];

                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($response, JSON_UNESCAPED_UNICODE);
                exit;
            }
        }

        $response = [
            'success' => false,
            'error' => 'Неверный запрос'
        ];

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    private function deepCleanString($string) {
        // Удаляем все не-UTF8 символы
        $string = preg_replace('/[^\x{0009}\x{000A}\x{000D}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', '', $string);

        // Удаляем управляющие символы кроме табуляции и переноса строк
        $string = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $string);

        return $string;
    }

    private function generateSmartPrompt($question, $focus = '') {
        // Получаем актуальное состояние ключевых файлов
        $fileContents = $this->getCurrentFileContents();

        $projectInfo = $this->getProjectInfo();
        $fileStructure = $this->getFileStructure();

        $prompt = "🎯 **КОНТЕКСТ ПРОЕКТА - ОСНОВНАЯ АРХИТЕКТУРА**\n\n";

        $prompt .= "📁 **СТРУКТУРА ПРОЕКТА:**\n";
        $prompt .= "- Тип: " . ($projectInfo['is_trislav_media'] ? 'Трислав Медиа' : 'Трислав Групп') . "\n";
        $prompt .= "- Архитектура: MVC\n";
        $prompt .= "- База данных: MySQL\n";
        $prompt .= "- Основные модули: Услуги, Тарифы, Портфолио, Заявки, Трислав Групп, LED\n";
        $prompt .= "- Ключевые модели: " . implode(', ', $projectInfo['models']) . "\n\n";

        $prompt .= "📂 **СТРУКТУРА ФАЙЛОВ И ПАПОК:**\n";
        $prompt .= "```\n";
        $prompt .= $fileStructure;
        $prompt .= "```\n\n";

        $prompt .= "🔧 **ОСНОВНЫЕ ФАЙЛЫ СИСТЕМЫ:**\n\n";

        foreach ($fileContents as $file => $content) {
            $prompt .= "--- {$file} ---\n";
            $prompt .= "```php\n{$content}\n```\n\n";
        }

        $prompt .= "💬 **ВОПРОС:** {$question}\n\n";

        $prompt .= "**ПРИМЕЧАНИЕ:** Показаны только основные файлы системы. Если нужны конкретные файлы - уточните какие.\n\n";
        $prompt .= "**Отвечай учитывая архитектуру проекта. Предлагай решения в рамках существующей структуры.**";

        //debug_log("Final prompt size: " . strlen($prompt));

        return $prompt;
    }

    private function getFileStructure() {
        $structure = "";
        $rootPath = ROOT_PATH;

        // Исключаем служебные папки
        $excludedDirs = ['.git', 'cache', 'images', 'uploads', 'vendor', 'node_modules', 'logs', 'tmp', '.idea'];

        $dirsToScan = [
            '',
            '/app',
            '/app/core',
            '/app/models',
            '/app/controllers',
            '/app/controllers/admin',
            '/app/controllers/site',
            '/app/views',
            '/app/views/layouts',
            '/app/views/site',
            '/app/views/admin',
            '/app/views/components',
            '/app/views/errors',
            '/config',
        ];

        foreach ($dirsToScan as $dir) {
            $fullPath = $rootPath . $dir;
            if (is_dir($fullPath)) {
                $structure .= $this->scanDirectory($fullPath, $dir, 0, $excludedDirs);
            }
        }

        return $structure;
    }

    private function scanDirectory($path, $relativePath, $level, $excludedDirs = []) {
        $output = "";
        $indent = str_repeat("  ", $level);

        // Показываем текущую папку
        $folderName = $relativePath ?: '/';
        $output .= $indent . "📁 " . basename($folderName) . "/\n";

        // Сканируем содержимое
        $items = scandir($path);
        $files = [];
        $subdirs = [];

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;

            // Пропускаем исключенные папки
            if (in_array($item, $excludedDirs)) {
                continue;
            }

            $fullPath = $path . '/' . $item;
            if (is_dir($fullPath)) {
                $subdirs[] = $item;
            } else {
                $files[] = $item;
            }
        }

        // Сортируем: сначала папки, потом файлы
        sort($subdirs);
        sort($files);

        // Показываем файлы
        foreach ($files as $file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            $icon = $this->getFileIcon($extension);
            $output .= $indent . "  " . $icon . " " . $file . "\n";
        }

        // Рекурсивно показываем подпапки
        foreach ($subdirs as $subdir) {
            $fullPath = $path . '/' . $subdir;
            $newRelativePath = $relativePath ? $relativePath . '/' . $subdir : $subdir;
            $output .= $this->scanDirectory($fullPath, $newRelativePath, $level + 1, $excludedDirs);
        }

        return $output;
    }

    private function getFileIcon($extension) {
        $icons = [
            'php' => '🐘',
            'js' => '📜',
            'css' => '🎨',
            'html' => '🌐',
            'json' => '📋',
            'sql' => '🗃️',
            'md' => '📝',
            'txt' => '📄',
        ];

        return $icons[$extension] ?? '📄';
    }

    private function getTrackedFiles() {
        return [
            // === CORE СИСТЕМЫ ===
            '/app/core/Database.php',
            '/app/core/Router.php',
            '/app/core/Model.php',
            '/app/core/Controller.php',
            '/app/core/helpers.php',

            // === КОНФИГУРАЦИЯ ===
            '/config/database.php',
            '/config/domains.php',

            // === ГЛАВНЫЕ ФАЙЛЫ ===
            '/admin.php',
            '/index.php',

            // === БАЗОВЫЕ КОНТРОЛЛЕРЫ ===
            '/app/controllers/Controller.php',
            '/app/controllers/admin/AdminBaseController.php',
            '/app/controllers/admin/AdminAIAssistantController.php',

            // === ОСНОВНЫЕ МОДЕЛИ ===
            '/app/models/Model.php',
            '/app/models/Service.php',
            '/app/models/Tariff.php',
            '/app/models/Portfolio.php',
            '/app/models/Lead.php',
            '/app/models/SiteSetting.php',

            // === ПРИМЕРЫ МОДЕЛЕЙ (по одной из каждой категории) ===
            '/app/models/TrislavGroupProject.php',    // Пример модели Трислав Групп
            '/app/models/LedAdvantage.php',           // Пример LED модели

            // === ОСНОВНЫЕ КОНТРОЛЛЕРЫ АДМИНКИ ===
            '/app/controllers/admin/AdminServicesController.php',
            '/app/controllers/admin/AdminTrislavGroupController.php',
            '/app/controllers/admin/AdminSettingsController.php',

            // === ПРИМЕРЫ КОНТРОЛЛЕРОВ АДМИНКИ ===
            '/app/controllers/admin/AdminPortfolioController.php', // Пример контроллера портфолио
            '/app/controllers/admin/AdminLedAdvantagesController.php', // Пример LED контроллера

            // === КОНТРОЛЛЕРЫ САЙТА ===
            '/app/controllers/site/HomeController.php',
            '/app/controllers/site/TrislavGroupController.php',

            // === ПРИМЕРЫ КОНТРОЛЛЕРОВ САЙТА ===
            '/app/controllers/site/LedController.php', // Пример LED контроллера сайта

            // === ОСНОВНЫЕ ПРЕДСТАВЛЕНИЯ ===
            '/app/views/layouts/main.php',
            '/app/views/layouts/admin.php',
            '/app/views/site/home.php',
            '/app/views/site/trislav_group.php',

            // === ПРИМЕРЫ ПРЕДСТАВЛЕНИЙ ===
            '/app/views/site/led.php', // Пример LED представления
            '/app/views/admin/dashboard.php', // Пример админ представления
            '/app/views/admin/services_form.php', // Пример формы админки

            // === КОМПОНЕНТЫ ===
            '/app/views/components/header.php',
            '/app/views/components/header_trislav_group.php',
            '/app/views/components/footer.php',
        ];
    }

    private function truncateFileSmart($content, $file) {
        $limits = [
            'core' => 2000,      // Core файлы - самые важные
            'model' => 1500,     // Модели
            'controller' => 1200, // Контроллеры
            'view' => 800,       // Представления
            'config' => 500,     // Конфиги
        ];

        // Определяем тип файла
        if (strpos($file, '/app/core/') !== false) $type = 'core';
        elseif (strpos($file, '/app/models/') !== false) $type = 'model';
        elseif (strpos($file, '/app/controllers/') !== false) $type = 'controller';
        elseif (strpos($file, '/app/views/') !== false) $type = 'view';
        elseif (strpos($file, '/config/') !== false) $type = 'config';
        else $type = 'controller';

        $limit = $limits[$type];

        if (strlen($content) <= $limit) {
            return $content;
        }

        $truncated = substr($content, 0, $limit);
        $totalLines = substr_count($content, "\n");
        $shownLines = substr_count($truncated, "\n");

        return $truncated . "\n\n// ... файл обрезан, показано {$shownLines} из {$totalLines} строк ...";
    }

    private function getCurrentFileContents() {
        $files = $this->getTrackedFiles();
        $contents = [];

        foreach ($files as $file) {
            $fullPath = ROOT_PATH . $file;
            if (file_exists($fullPath)) {
                $content = file_get_contents($fullPath);

                // Очищаем содержимое от бинарных данных и невалидных UTF-8 символов
                $cleanContent = $this->cleanFileContent($content, $file);

                // Умное обрезание в зависимости от типа файла
                $content = $this->truncateFileSmart($cleanContent, $file);
                $contents[$file] = $content;
            } else {

            }
        }

        return $contents;
    }

    private function cleanFileContent($content, $filename) {
        // Удаляем бинарные данные и невалидные UTF-8 символы
        $cleaned = preg_replace('/[^\x{0009}\x{000A}\x{000D}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', '', $content);

        // Если после очистки пусто, возвращаем оригинал с пометкой
        if (empty(trim($cleaned))) {
            return "// Файл содержит бинарные данные или изображения\n// Показана только текстовая часть\n" .
                substr($content, 0, 500);
        }

        return $cleaned;
    }

    private function getProjectStructure() {
        $structure = [];
        $paths = [
            '/app/core/' => 'Core Files',
            '/app/models/' => 'Models',
            '/app/controllers/' => 'Controllers',
            '/app/views/' => 'Views',
            '/config/' => 'Config'
        ];

        foreach ($paths as $path => $description) {
            $fullPath = ROOT_PATH . $path;
            if (is_dir($fullPath)) {
                $files = scandir($fullPath);
                $structure[$description] = array_filter($files, function($file) {
                    return $file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'php';
                });
            }
        }

        return $structure;
    }

    private function getProjectInfo() {
        return [
            'is_trislav_media' => defined('IS_TRISLAV_MEDIA') ? IS_TRISLAV_MEDIA : false,
            'models' => [
                'Service', 'Tariff', 'Portfolio', 'Lead', 'SiteSetting', 'WorkProcess', 'ShoppingCenter',
                'TrislavGroupProject', 'TrislavGroupClient', 'TrislavGroupReview', 'TrislavGroupAdvantage',
                'TrislavGroupContent', 'TrislavGroupClientProject', 'LedAdvantage', 'LedRequirement'
            ]
        ];
    }
}
?>