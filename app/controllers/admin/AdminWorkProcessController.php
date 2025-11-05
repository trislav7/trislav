<?php
// app/controllers/admin/AdminWorkProcessController.php
class AdminWorkProcessController extends AdminBaseController {
    
    public function index() {
        $processModel = new WorkProcess();
        $processes = $processModel->getAll();

        $this->view('admin/work_process', [
            'title' => 'Управление процессом работы',
            'processes' => $processes,
            'current_action' => 'work_process'
        ]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $processModel = new WorkProcess();
            $data = [
                'step_number' => $_POST['step_number'] ?? 0,
                'step_order' => $_POST['step_order'] ?? 0,
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $processModel->create($data);
            $this->setFlashMessage('success', 'Этап успешно создан');
            $this->redirect('/admin.php?action=work_process');
            return; // Важно: завершаем выполнение после редиректа
        }

        // Показываем форму для GET запроса
        $this->view('admin/work_process_form', [
            'title' => 'Добавить этап работы',
            'current_action' => 'work_process',
            'item' => null
        ]);
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('/admin.php?action=work_process');
        }

        $processModel = new WorkProcess();
        $item = $processModel->find($id);

        if (!$item) {
            $this->setFlashMessage('error', 'Этап не найден');
            $this->redirect('/admin.php?action=work_process');
        }

        if ($_POST) {
            $data = [
                'step_number' => $_POST['step_number'] ?? 0,
                'step_order' => $_POST['step_order'] ?? 0,
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $processModel->update($id, $data);
            $this->setFlashMessage('success', 'Этап успешно обновлен');
            $this->redirect('/admin.php?action=work_process');
        }

        $this->view('admin/work_process_form', [
            'title' => 'Редактировать этап работы',
            'current_action' => 'work_process',
            'item' => $item
        ]);
    }

    public function toggle() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $processModel = new WorkProcess();
            $processModel->toggleStatus($id);
        }
        $this->redirect('/admin.php?action=work_process');
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $processModel = new WorkProcess();
            $processModel->delete($id);
        }
        $this->redirect('/admin.php?action=work_process&success=1');
    }
}
?>