<?php
class AdminPortfolioController extends AdminBaseController {

    public function list() {
        $portfolioModel = new Portfolio();
        $portfolio = $portfolioModel->getAll();

        $this->view('admin/portfolio_list', [
            'portfolio' => $portfolio,
            'title' => 'Управление портфолио'
        ]);
    }

    public function create() {
        if ($_POST) {
            $portfolioModel = new Portfolio();

            // Обработка загрузки изображения
            $imagePath = $this->handleImageUpload($_FILES['image']);

            $portfolioModel->create([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'image' => $imagePath,
                'category' => $_POST['category'],
                'tags' => json_encode(array_map('trim', explode(",", $_POST['tags']))),
                'client_name' => $_POST['client_name'],
                'project_date' => $_POST['project_date'],
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ]);

            header('Location: /admin.php?action=portfolio_list&success=1');
            exit;
        }

        $this->view('admin/portfolio_form', [
            'title' => 'Добавить работу в портфолио'
        ]);
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin.php?action=portfolio_list');
            exit;
        }

        $portfolioModel = new Portfolio();
        $portfolio = $portfolioModel->find($id);

        if ($_POST) {
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'category' => $_POST['category'],
                'tags' => json_encode(array_map('trim', explode(",", $_POST['tags']))),
                'client_name' => $_POST['client_name'],
                'project_date' => $_POST['project_date'],
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            // Если загружено новое изображение
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $data['image'] = $this->handleImageUpload($_FILES['image']);

                // Удаляем старое изображение если есть
                if (!empty($portfolio['image'])) {
                    $this->deleteOldImage($portfolio['image']);
                }
            }

            $portfolioModel->update($id, $data);

            header('Location: /admin.php?action=portfolio_list&success=1');
            exit;
        }

        $this->view('admin/portfolio_form', [
            'portfolio' => $portfolio,
            'title' => 'Редактировать работу'
        ]);
    }

    private function handleImageUpload($file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            // Создаем директорию в корне проекта
            $uploadDir = ROOT_PATH . '/uploads/portfolio/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Безопасное имя файла
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $safeName = preg_replace('/[^a-zA-Z0-9-_]/', '', pathinfo($file['name'], PATHINFO_FILENAME));
            $filename = time() . '_' . $safeName . '.' . $extension;
            $filepath = $uploadDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                return '/uploads/portfolio/' . $filename;
            }
        }
        return '';
    }

    private function deleteOldImage($imagePath) {
        $fullPath = ROOT_PATH . $imagePath;
        if (file_exists($fullPath) && is_file($fullPath)) {
            unlink($fullPath);
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $portfolioModel = new Portfolio();
            $portfolio = $portfolioModel->find($id);

            // Удаляем изображение если есть
            if (!empty($portfolio['image'])) {
                $this->deleteOldImage($portfolio['image']);
            }

            $portfolioModel->delete($id);
        }
        $this->redirect('/admin.php?action=portfolio_list&success=1');
    }
}
?>