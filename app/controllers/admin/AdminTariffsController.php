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
        $serviceModel = new Service();
        $services = $serviceModel->getAllActive();

        if ($_POST) {
            $tariffModel = new Tariff();
            $tariffModel->create([
                'title' => $_POST['title'],
                'price' => $_POST['price'],
                'period' => $_POST['period'],
                'features' => json_encode(explode("\n", $_POST['features'])),
                'is_popular' => isset($_POST['is_popular']) ? 1 : 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'service_id' => $_POST['service_id']
            ]);

            header('Location: /admin.php?action=tariffs_list&success=1');
            exit;
        }

        $this->view('admin/tariffs_form', [
            'services' => $services,
            'title' => 'Добавить тариф'
        ]);
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin.php?action=tariffs_list');
            exit;
        }

        $tariffModel = new Tariff();
        $serviceModel = new Service();
        
        $tariff = $tariffModel->find($id);
        $services = $serviceModel->getAllActive();

        if ($_POST) {
            $tariffModel->update($id, [
                'title' => $_POST['title'],
                'price' => $_POST['price'],
                'period' => $_POST['period'],
                'features' => json_encode(explode("\n", $_POST['features'])),
                'is_popular' => isset($_POST['is_popular']) ? 1 : 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'service_id' => $_POST['service_id']
            ]);

            header('Location: /admin.php?action=tariffs_list&success=1');
            exit;
        }

        $this->view('admin/tariffs_form', [
            'tariff' => $tariff,
            'services' => $services,
            'title' => 'Редактировать тариф'
        ]);
    }
}