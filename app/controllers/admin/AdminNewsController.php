<?php
class AdminNewsController extends AdminBaseController {
    
    protected function getModel() {
        return $this->newsModel;
    }
    
    protected function getViewPath() {
        return 'admin/news';
    }
    
    protected function getCachePatterns() {
        return ['news_'];
    }
    
    protected function getTitle() {
        return 'новость';
    }
    
    protected function prepareStoreData() {
        return [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'published' => isset($_POST['published']) ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
    }
    
    protected function prepareUpdateData() {
        return [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'published' => isset($_POST['published']) ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];
    }
    
    protected function getCreateData() {
        try {
            $categories = $this->categoryModel->getNewsCategories();
        } catch (Exception $e) {
            $categories = [];
        }
        
        return ['categories' => $categories];
    }
    
    protected function getEditData($id) {
        try {
            $categories = $this->categoryModel->getNewsCategories();
            $itemCategories = $this->categoryModel->getNewsCategoriesForNews($id);
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