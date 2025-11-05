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
}