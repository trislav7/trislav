<?php
class AdminLedRequirementsController extends AdminBaseController {
    
    public function index() {
        $requirementModel = new LedRequirement();
        $requirements = $requirementModel->getAll();

        $this->view('admin/led_requirements', [
            'title' => 'Управление требованиями',
            'requirements' => $requirements,
            'current_action' => 'led_requirements'
        ]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requirementModel = new LedRequirement();
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'type' => $_POST['type'] ?? 'main',
                'sort_order' => $_POST['sort_order'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $requirementModel->create($data);
            $this->setFlashMessage('success', 'Требование успешно создано');
            $this->redirect('/admin.php?action=led_requirements');
            return;
        }

        $this->view('admin/led_requirements_form', [
            'title' => 'Добавить требование LED',
            'current_action' => 'led_requirements',
            'item' => null
        ]);
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('/admin.php?action=led_requirements');
        }

        $requirementModel = new LedRequirement();
        $item = $requirementModel->find($id);

        if (!$item) {
            $this->setFlashMessage('error', 'Требование не найдено');
            $this->redirect('/admin.php?action=led_requirements');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'type' => $_POST['type'] ?? 'main',
                'sort_order' => $_POST['sort_order'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $requirementModel->update($id, $data);
            $this->setFlashMessage('success', 'Требование успешно обновлено');
            $this->redirect('/admin.php?action=led_requirements');
            return;
        }

        $this->view('admin/led_requirements_form', [
            'title' => 'Редактировать требование LED',
            'current_action' => 'led_requirements',
            'item' => $item
        ]);
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $requirementModel = new LedRequirement();
            $requirementModel->delete($id);
        }
        $this->redirect('/admin.php?action=led_requirements&success=1');
    }

    public function toggle() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $requirementModel = new LedRequirement();
            $current = $requirementModel->find($id);
            $newStatus = $current['is_active'] ? 0 : 1;
            $requirementModel->update($id, ['is_active' => $newStatus]);
        }
        $this->redirect('/admin.php?action=led_requirements');
    }
}
?>