<?php
class AdminCategoriesController extends AdminBaseController {
    
    protected function getModel() {
        return $this->categoryModel;
    }
    
    protected function getViewPath() {
        return 'admin/categories';
    }
    
    protected function getCachePatterns() {
        return ['sidebar_data'];
    }
    
    protected function getTitle() {
        return 'категорию';
    }
    
    protected function prepareStoreData() {
        return [
            'name' => $_POST['name'],
            'type' => $_POST['type'],
            'active' => isset($_POST['active']) ? 1 : 0
        ];
    }
    
    protected function prepareUpdateData() {
        return [
            'name' => $_POST['name'],
            'type' => $_POST['type'],
            'active' => isset($_POST['active']) ? 1 : 0
        ];
    }
    
    protected function getCreateData() {
        return []; // Для категорий не нужны дополнительные данные
    }
    
    protected function getEditData($id) {
        return []; // Для категорий не нужны дополнительные данные
    }
    
    // ПЕРЕОПРЕДЕЛЯЕМ handleCategories - для категорий он не нужен
    protected function handleCategories($itemId) {
        // Категории не имеют своих категорий, поэтому метод пустой
    }
}