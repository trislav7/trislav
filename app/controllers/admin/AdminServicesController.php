<?php
class AdminServicesController extends AdminBaseController {
    public function index() {
        $serviceModel = new Service();
        $services = $serviceModel->getAll();

        $flashMessage = $this->getFlashMessage();

        $this->view('admin/services_list', [
            'title' => 'Управление услугами',
            'services' => $services,
            'flash_message' => $flashMessage
        ]);
    }
    public function list() {
        $serviceModel = new Service();
        $services = $serviceModel->getAll();

        $this->view('admin/services_list', [
            'services' => $services,
            'title' => 'Управление услугами'
        ]);
    }

    protected function handleFileUpload($fieldName, $uploadPath = '/uploads/services/') {
        if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
            $uploadDir = ROOT_PATH . $uploadPath;
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = time() . '_' . basename($_FILES[$fieldName]['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $filePath)) {
                return $uploadPath . $fileName;
            }
        }
        return null;
    }

    public function create() {
        if ($_POST) {
            $serviceModel = new Service();

            $data = [
                'title' => $_POST['title'] ?? '',
                'category' => $_POST['category'] ?? '',
                'icon_svg' => $_POST['icon_svg'] ?? '',
                'short_description' => $_POST['short_description'] ?? '',
                'description' => $_POST['description'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            // Обрабатываем особенности (список)
            if (!empty($_POST['features'])) {
                $features = array_filter(array_map('trim', explode("\n", $_POST['features'])));
                $data['features'] = json_encode($features, JSON_UNESCAPED_UNICODE);
            }

            // Обрабатываем теги
            if (!empty($_POST['tags'])) {
                $tags = array_filter(array_map('trim', explode(",", $_POST['tags'])));
                $data['tags'] = json_encode($tags, JSON_UNESCAPED_UNICODE);
            }

            $serviceModel->create($data);
            $this->setFlashMessage('success', 'Услуга успешно создана');
            $this->redirect('/admin.php?action=services_list');
        }

        $this->view('admin/services_form', [
            'title' => 'Добавить услугу',
            'service' => null
        ]);
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('/admin.php?action=services_list');
        }

        $serviceModel = new Service();
        $service = $serviceModel->find($id);

        if (!$service) {
            $this->setFlashMessage('error', 'Услуга не найдена');
            $this->redirect('/admin.php?action=services_list');
        }

        if ($_POST) {
            $data = [
                'title' => $_POST['title'] ?? '',
                'category' => $_POST['category'] ?? '',
                'icon_svg' => $_POST['icon_svg'] ?? '',
                'short_description' => $_POST['short_description'] ?? '',
                'description' => $_POST['description'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            // Обрабатываем особенности (список)
            if (!empty($_POST['features'])) {
                $features = array_filter(array_map('trim', explode("\n", $_POST['features'])));
                $data['features'] = json_encode($features, JSON_UNESCAPED_UNICODE);
            }

            // Обрабатываем теги
            if (!empty($_POST['tags'])) {
                $tags = array_filter(array_map('trim', explode(",", $_POST['tags'])));
                $data['tags'] = json_encode($tags, JSON_UNESCAPED_UNICODE);
            }

            $serviceModel->update($id, $data);
            $this->setFlashMessage('success', 'Услуга успешно обновлена');
            $this->redirect('/admin.php?action=services_list');
        }

        $this->view('admin/services_form', [
            'title' => 'Редактировать услугу',
            'service' => $service
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

    public function toggle() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $serviceModel = new Service();
            $service = $serviceModel->find($id);

            if ($service) {
                $newStatus = $service['is_active'] ? 0 : 1;
                $serviceModel->update($id, ['is_active' => $newStatus]);
            }
        }

        $this->redirect('/admin.php?action=services_list');
    }
}