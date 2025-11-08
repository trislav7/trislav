<?php
class AdminActionsController extends AdminBaseController {
    
    protected function getModel() {
        return $this->actionModel;
    }
    
    protected function getViewPath() {
        return 'admin/actions';
    }
    
    protected function getCachePatterns() {
        return ['actions_'];
    }
    
    protected function getTitle() {
        return 'акцию';
    }
    
    protected function prepareStoreData() {
        return [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'published' => isset($_POST['published']) ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
    }
    
    protected function prepareUpdateData() {
        return [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'published' => isset($_POST['published']) ? 1 : 0
        ];
    }
    
    protected function getCreateData() {
        try {
            $categories = $this->categoryModel->getActionCategories();
        } catch (Exception $e) {
            $categories = [];
        }
        
        return ['categories' => $categories];
    }
    
    protected function getEditData($id) {
        try {
            $categories = $this->categoryModel->getActionCategories();
            $itemCategories = $this->categoryModel->getActionCategoriesForAction($id);
        } catch (Exception $e) {
            $categories = [];
            $itemCategories = [];
        }
        
        return [
            'categories' => $categories,
            'itemCategories' => array_column($itemCategories, 'category_id')
        ];
    }

    /**
     * Очистка кэша из админки
     */
    public function clear_cache() {
        $type = $_GET['type'] ?? 'all';
        debug_log("AdminActionsController: Manual cache clearance requested for type: " . $type);

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
            case 'tariffs':
                $cleared = $this->cacheManager->clearTariffsCache();
                break;
            case 'settings':
                $cleared = $this->cacheManager->clearSettingsCache();
                break;
            case 'shopping_centers':
                $cleared = $this->cacheManager->clearShoppingCentersCache();
                break;
            case 'work_process':
                $cleared = $this->cacheManager->clearWorkProcessCache();
                break;
            case 'led_requirements':
                $cleared = $this->cacheManager->clearLedRequirementsCache();
                break;
            case 'all':
                $cleared = $this->cacheManager->clearAllCache();
                break;
            default:
                debug_log("AdminActionsController: Unknown cache type: " . $type);
                break;
        }

        $this->setFlashMessage('success', "Кэш очищен ($cleared файлов)");
        debug_log("AdminActionsController: Manual cache clearance completed for " . $type);

        // Редирект обратно на предыдущую страницу
        $referer = $_SERVER['HTTP_REFERER'] ?? '/admin.php?action=dashboard';
        header('Location: ' . $referer);
        exit;
    }

    /**
     * Показать статистику кэша
     */
    public function cache_stats() {
        $cacheStats = $this->cacheManager->getCacheStats();
        $monitorStats = CacheMonitor::getStats();

        $data = [
            'cache_stats' => $cacheStats,
            'monitor_stats' => $monitorStats,
            'title' => 'Статистика кэша'
        ];

        $this->view('admin/cache_stats', $data);
    }

    /**
     * Сброс статистики мониторинга
     */
    public function reset_cache_stats() {
        CacheMonitor::resetStats();
        $this->setFlashMessage('success', 'Статистика кэша сброшена');
        header('Location: /admin.php?action=cache_stats');
        exit;
    }
}