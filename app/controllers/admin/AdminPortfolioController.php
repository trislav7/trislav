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
                'tags' => json_encode(explode(",", $_POST['tags'])),
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
                'tags' => json_encode(explode(",", $_POST['tags'])),
                'client_name' => $_POST['client_name'],
                'project_date' => $_POST['project_date'],
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            // Если загружено новое изображение
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $data['image'] = $this->handleImageUpload($_FILES['image']);
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
            $uploadDir = ROOT_PATH . '/public/uploads/portfolio/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $extension;
            $filepath = $uploadDir . $filename;
            
            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                return '/uploads/portfolio/' . $filename;
            }
        }
        return '';
    }
}