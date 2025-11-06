<?php
class AdminLedAdvantagesController extends AdminBaseController {

    public function index() {
        $advantageModel = new LedAdvantage();
        $category = $_GET['category'] ?? 'led';
        $advantages = $advantageModel->getByCategory($category);

        $this->view('admin/led_advantages', [
            'title' => 'Управление преимуществами',
            'advantages' => $advantages,
            'current_action' => 'led_advantages',
            'current_category' => $category
        ]);
    }

    public function create() {
        $category = $_GET['category'] ?? 'led';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $advantageModel = new LedAdvantage();
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'icon_svg' => $_POST['icon_svg'] ?? '',
                'sort_order' => $_POST['sort_order'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'category' => $_POST['category'] ?? $category
            ];

            $advantageModel->create($data);
            $this->setFlashMessage('success', 'Преимущество успешно создано');
            $this->redirect('/admin.php?action=led_advantages&category=' . $category);
            return;
        }

        $this->view('admin/led_advantages_form', [
            'title' => 'Добавить преимущество',
            'current_action' => 'led_advantages',
            'current_category' => $category,
            'item' => null
        ]);
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        $category = $_GET['category'] ?? 'led';

        if (!$id) {
            $this->redirect('/admin.php?action=led_advantages&category=' . $category);
        }

        $advantageModel = new LedAdvantage();
        $item = $advantageModel->find($id);

        if (!$item) {
            $this->setFlashMessage('error', 'Преимущество не найдено');
            $this->redirect('/admin.php?action=led_advantages&category=' . $category);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'icon_svg' => $_POST['icon_svg'] ?? '',
                'sort_order' => $_POST['sort_order'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'category' => $_POST['category'] ?? $category
            ];

            $advantageModel->update($id, $data);
            $this->setFlashMessage('success', 'Преимущество успешно обновлено');
            $this->redirect('/admin.php?action=led_advantages&category=' . $category);
            return;
        }

        $this->view('admin/led_advantages_form', [
            'title' => 'Редактировать преимущество',
            'current_action' => 'led_advantages',
            'current_category' => $category,
            'item' => $item
        ]);
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        $category = $_GET['category'] ?? 'led';
        if ($id) {
            $advantageModel = new LedAdvantage();
            $advantageModel->delete($id);
        }
        $this->redirect('/admin.php?action=led_advantages&category=' . $category . '&success=1');
    }

    public function toggle() {
        $id = $_GET['id'] ?? null;
        $category = $_GET['category'] ?? 'led';
        if ($id) {
            $advantageModel = new LedAdvantage();
            $current = $advantageModel->find($id);
            $newStatus = $current['is_active'] ? 0 : 1;
            $advantageModel->update($id, ['is_active' => $newStatus]);
        }
        $this->redirect('/admin.php?action=led_advantages&category=' . $category);
    }
}
?>