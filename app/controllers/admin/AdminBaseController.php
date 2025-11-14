<?php
class AdminBaseController extends Controller {
    protected $cacheManager;
    public function __construct() {
        parent::__construct();

        $this->cacheManager = new CacheManager();

        // Проверяем аутентификацию (кроме страницы логина)
        $currentAction = $_GET['action'] ?? 'dashboard';
        if ($currentAction !== 'login') {
            $this->checkAuth();
        }

        // Начинаем буферизацию вывода чтобы избежать ошибок с заголовками
        if (!headers_sent()) {
            ob_start();
        }
    }

    private function checkAuth() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            $this->redirect('/admin.php?action=login');
        }
    }

    protected function view($view, $data = []) {
        // Добавляем базовые данные для админки
        $data['current_action'] = $_GET['action'] ?? 'dashboard';
        $data['admin_username'] = $_SESSION['admin_username'] ?? 'Администратор';
        $data['cache_stats'] = $this->cacheManager->getCacheStats();

        // Очищаем буфер если он есть
        if (ob_get_level() > 0) {
            ob_end_clean();
        }
        parent::view($view, $data);
    }

    // Метод для загрузки одиночного файла
    protected function handleFileUpload($fieldName, $uploadPath = '/uploads/') {
        if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
            $uploadDir = ROOT_PATH . $uploadPath;
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Безопасное имя файла
            $originalName = $_FILES[$fieldName]['name'];
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $safeName = preg_replace('/[^a-zA-Z0-9-_]/', '', pathinfo($originalName, PATHINFO_FILENAME));
            $fileName = time() . '_' . $safeName . '.' . $extension;

            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $filePath)) {
                return $uploadPath . $fileName;
            }
        }
        return null;
    }

    protected function handleMultipleFileUpload($fieldName, $uploadPath = '/uploads/') {
        $uploadedFiles = [];

        if (isset($_FILES[$fieldName]) && is_array($_FILES[$fieldName]['name'])) {
            $uploadDir = ROOT_PATH . $uploadPath;
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            foreach ($_FILES[$fieldName]['name'] as $key => $name) {
                if ($_FILES[$fieldName]['error'][$key] === UPLOAD_ERR_OK) {
                    $extension = pathinfo($name, PATHINFO_EXTENSION);
                    $safeName = preg_replace('/[^a-zA-Z0-9-_]/', '', pathinfo($name, PATHINFO_FILENAME));
                    $fileName = time() . '_' . $key . '_' . $safeName . '.' . $extension;

                    $filePath = $uploadDir . $fileName;

                    if (move_uploaded_file($_FILES[$fieldName]['tmp_name'][$key], $filePath)) {
                        $uploadedFiles[] = $uploadPath . $fileName;
                    }
                }
            }
        }

        return $uploadedFiles;
    }

    // Метод для редиректа с очисткой буфера
    protected function redirect($url) {
        // Очищаем буфер вывода перед редиректом
        if (ob_get_level() > 0) {
            ob_end_clean();
        }
        header('Location: ' . $url);
        exit;
    }

    // Вспомогательный метод для установки сообщений об успехе/ошибке
    protected function setFlashMessage($type, $message) {
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    // Вспомогательный метод для получения flash сообщения
    protected function getFlashMessage() {
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return $message;
        }
        return null;
    }

    /**
     * Ручная очистка кэша из админки
     */
    protected function clearCacheManually($type = 'all') {

        $cleared = 0;
        switch ($type) {
            case 'services':
                $cleared = $this->cacheManager->clearServicesCache();
                break;
            case 'portfolio':
                $cleared = $this->cacheManager->clearPortfolioCache();
                break;
            case 'trislav':
                $cleared = $this->cacheManager->clearTrislavGroupCache();
                break;
            case 'settings':
                $cleared = $this->cacheManager->clearSettingsCache();
                break;
            case 'all':
                $cleared = $this->cacheManager->clearAllCache();
                break;
        }

        $this->setFlashMessage('success', "Кэш очищен ($cleared файлов)");
    }
}
?>