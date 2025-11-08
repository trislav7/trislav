<?php
class AdminTariffsController extends AdminBaseController {
    
    public function list() {
        $tariffModel = new Tariff();
        $tariffs = $tariffModel->getAll();

        $this->view('admin/tariffs_list', [
            'tariffs' => $tariffs,
            'title' => 'Управление тарифами'
        ]);
    }

    public function create() {
        if ($_POST) {
            $tariffModel = new Tariff();

            $data = [
                'title' => $_POST['title'] ?? '',
                'price' => $_POST['price'] ?? 0,
                'old_price' => !empty($_POST['old_price']) ? $_POST['old_price'] : null,
                'period' => $_POST['period'] ?? 'неделя',
                'service_id' => !empty($_POST['service_id']) ? $_POST['service_id'] : null,
                'is_popular' => isset($_POST['is_popular']) ? 1 : 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            // Обрабатываем особенности
            if (!empty($_POST['features'])) {
                $features = array_filter(array_map('trim', explode("\n", $_POST['features'])));
                $data['features'] = json_encode($features, JSON_UNESCAPED_UNICODE);
            }

            $tariffModel->create($data);
            $this->setFlashMessage('success', 'Тариф успешно создан');
            $this->redirect('/admin.php?action=tariffs_list');
        }

        $serviceModel = new Service();
        $services = $serviceModel->getAll();

        $this->view('admin/tariffs_form', [
            'title' => 'Добавить тариф',
            'tariff' => null,
            'services' => $services
        ]);
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('/admin.php?action=tariffs_list');
        }

        $tariffModel = new Tariff();
        $tariff = $tariffModel->find($id);

        if (!$tariff) {
            $this->setFlashMessage('error', 'Тариф не найден');
            $this->redirect('/admin.php?action=tariffs_list');
        }

        if ($_POST) {
            $data = [
                'title' => $_POST['title'] ?? '',
                'price' => $_POST['price'] ?? 0,
                'old_price' => !empty($_POST['old_price']) ? $_POST['old_price'] : null,
                'period' => $_POST['period'] ?? 'неделя',
                'service_id' => !empty($_POST['service_id']) ? $_POST['service_id'] : null,
                'is_popular' => isset($_POST['is_popular']) ? 1 : 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            // Обрабатываем особенности
            if (!empty($_POST['features'])) {
                $features = array_filter(array_map('trim', explode("\n", $_POST['features'])));
                $data['features'] = json_encode($features, JSON_UNESCAPED_UNICODE);
            }

            $tariffModel->update($id, $data);
            $this->setFlashMessage('success', 'Тариф успешно обновлен');
            $this->redirect('/admin.php?action=tariffs_list');
        }

        $serviceModel = new Service();
        $services = $serviceModel->getAll();

        $this->view('admin/tariffs_form', [
            'title' => 'Редактировать тариф',
            'tariff' => $tariff,
            'services' => $services
        ]);
    }
}