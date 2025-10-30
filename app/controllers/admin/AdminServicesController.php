<?php
class AdminServicesController extends AdminBaseController {
    
    public function list() {
        $serviceModel = new Service();
        $services = $serviceModel->getAll();

        $this->view('admin/services_list', [
            'services' => $services,
            'title' => 'Управление услугами'
        ]);
    }

    public function create() {
        if ($_POST) {
            $serviceModel = new Service();
            $serviceModel->create([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'short_description' => $_POST['short_description'],
                'icon' => $_POST['icon'],
                'features' => json_encode(explode("\n", $_POST['features'])),
                'tags' => json_encode(explode(",", $_POST['tags'])),
                'category' => $_POST['category'],
                'order_index' => $_POST['order_index'],
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ]);

            header('Location: /admin.php?action=services_list&success=1');
            exit;
        }

        $this->view('admin/services_form', [
            'title' => 'Добавить услугу'
        ]);
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin.php?action=services_list');
            exit;
        }

        $serviceModel = new Service();
        $service = $serviceModel->find($id);

        if ($_POST) {
            $serviceModel->update($id, [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'short_description' => $_POST['short_description'],
                'icon' => $_POST['icon'],
                'features' => json_encode(explode("\n", $_POST['features'])),
                'tags' => json_encode(explode(",", $_POST['tags'])),
                'category' => $_POST['category'],
                'order_index' => $_POST['order_index'],
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ]);

            header('Location: /admin.php?action=services_list&success=1');
            exit;
        }

        $this->view('admin/services_form', [
            'service' => $service,
            'title' => 'Редактировать услугу'
        ]);
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $serviceModel = new Service();
            // Вместо удаления делаем неактивным
            $serviceModel->update($id, ['is_active' => 0]);
        }
        
        header('Location: /admin.php?action=services_list&success=1');
        exit;
    }
}