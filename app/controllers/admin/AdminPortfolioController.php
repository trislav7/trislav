<?php
class AdminPortfolioController extends AdminBaseController {

    public function list() {
        $portfolioModel = new Portfolio();

        // Получаем выбранную категорию из GET параметра
        $category = $_GET['category'] ?? 'all';

        // Получаем все работы или фильтруем по категории
        if ($category === 'all') {
            $portfolio = $portfolioModel->getAll();
        } else {
            $portfolio = $portfolioModel->getByCategory($category);
        }

        // Подготавливаем данные для отображения
        $portfolio = array_map(function($item) {
            $item['category_label'] = $this->getCategoryLabel($item['category']);
            $item['category_color'] = $this->getCategoryColor($item['category']);
            return $item;
        }, $portfolio);

        $this->view('admin/portfolio_list', [
            'portfolio' => $portfolio,
            'title' => 'Управление портфолио',
            'current_category' => $category
        ]);
    }

    protected function getCategoryLabel($category)
    {
        $labels = [
            'led' => 'LED экраны',
            'video' => 'Видео и лого',
            'btl' => 'BTL мероприятия',
            'branding' => 'Брендинг'
        ];

        return $labels[$category] ?? $category;
    }

    private function getCategoryColor($category)
    {
        $colors = [
            'led' => 'bg-blue-500/20 text-blue-300',
            'video' => 'bg-purple-500/20 text-purple-300',
            'btl' => 'bg-green-500/20 text-green-300',
            'branding' => 'bg-orange-500/20 text-orange-300'
        ];

        return $colors[$category] ?? 'bg-gray-500/20 text-gray-300';
    }

    public function create() {
        if ($_POST) {
            $portfolioModel = new Portfolio();

            // Сначала создаем запись чтобы получить ID
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'category' => $_POST['category'],
                'tags' => json_encode(array_map('trim', explode(",", $_POST['tags']))),
                'client_name' => $_POST['client_name'],
                'project_date' => $_POST['project_date'],
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'image' => '', // Временно пустое значение
                'video_url' => $_POST['video_url'] ?? null,
                'video_filename' => null,
                'yandex_disk_path' => null // Всегда null для портфолио
            ];

            // Создаем запись и получаем ID
            $portfolioId = $portfolioModel->create($data);

            if ($portfolioId) {
                // Обрабатываем загрузку изображения
                if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $imagePath = $this->handleImageUpload($_FILES['image'], $portfolioId);
                    if ($imagePath) {
                        $portfolioModel->update($portfolioId, ['image' => $imagePath]);
                    }
                }

                // ОБРАБОТКА ЗАГРУЗКИ ВИДЕО ФАЙЛА - ТОЛЬКО ЛОКАЛЬНО
                if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
                    $videoResult = $this->saveVideoLocally($_FILES['video_file'], $portfolioId);

                    if ($videoResult) {
                        $portfolioModel->updateVideoInfo($portfolioId, [
                            'video_filename' => $videoResult['filename'],
                            'yandex_disk_path' => null, // Всегда null для портфолио
                            'video_url' => null // Очищаем URL если загружаем файл
                        ]);
                    }
                }

                $this->setFlashMessage('success', 'Работа успешно добавлена в портфолио');
                $this->redirect('/admin.php?action=portfolio_list&success=1');
                exit;
            }
        }

        $this->view('admin/portfolio_form', [
            'title' => 'Добавить работу в портфолио',
            'portfolio' => null
        ]);
    }

    /**
     * Сохранение видео локально - ЕДИНСТВЕННЫЙ МЕТОД ДЛЯ ПОРТФОЛИО
     */
    private function saveVideoLocally($file, $portfolioId) {

        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = ROOT_PATH . '/uploads/videos/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'portfolio_' . $portfolioId . '.' . $extension;
            $filePath = $uploadDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                return [
                    'filename' => $filename,
                    'disk_path' => null // Всегда null для портфолио
                ];
            } else {
            }
        } else {
        }

        return null;
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
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'video_url' => $_POST['video_url'] ?? null
            ];

            // ОБРАБОТКА УДАЛЕНИЯ ВИДЕО
            $removeVideo = isset($_POST['remove_video']) && $_POST['remove_video'] === 'on';
            if ($removeVideo) {
                $this->deletePortfolioVideo($portfolio);
                $data['video_filename'] = null;
                $data['yandex_disk_path'] = null;
                $data['video_url'] = null;
            }

            // ОБРАБОТКА ЗАГРУЗКИ НОВОГО ВИДЕО - ТОЛЬКО ЛОКАЛЬНО
            if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
                // Удаляем старое видео если есть
                $this->deletePortfolioVideo($portfolio);

                $videoResult = $this->saveVideoLocally($_FILES['video_file'], $id);
                if ($videoResult) {
                    $data['video_filename'] = $videoResult['filename'];
                    $data['yandex_disk_path'] = null; // Всегда null для портфолио
                    $data['video_url'] = null; // Очищаем URL если загружаем файл
                }
            }

            // Обработка изображения (существующий код)...
            $removeImage = isset($_POST['remove_image']) && $_POST['remove_image'] === 'on';
            if ($removeImage) {
                $data['image'] = '';
                if (!empty($portfolio['image'])) {
                    $this->deleteOldImage($portfolio['image']);
                }
            } else if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                if (!empty($portfolio['image'])) {
                    $this->deleteOldImage($portfolio['image']);
                }
                $imagePath = $this->handleImageUpload($_FILES['image'], $id);
                if ($imagePath) {
                    $data['image'] = $imagePath;
                }
            } else {
                $data['image'] = $portfolio['image'] ?? '';
            }

            $portfolioModel->update($id, $data);

            $this->setFlashMessage('success', 'Работа успешно обновлена');
            $this->redirect('/admin.php?action=portfolio_list&success=1');
            exit;
        }

        $this->view('admin/portfolio_form', [
            'portfolio' => $portfolio,
            'title' => 'Редактировать работу'
        ]);
    }

    private function deletePortfolioVideo($portfolio) {

        // УДАЛЯЕМ ТОЛЬКО ЛОКАЛЬНЫЙ ФАЙЛ
        if (!empty($portfolio['video_filename'])) {
            $localPath = ROOT_PATH . '/uploads/videos/' . $portfolio['video_filename'];
            if (file_exists($localPath)) {
                if (unlink($localPath)) {
                } else {
                }
            } else {
            }
        }

        // УДАЛЯЕМ ВРЕМЕННЫЙ ФАЙЛ ЕСЛИ ЕСТЬ
        if (!empty($portfolio['video_filename'])) {
            $tempPath = ROOT_PATH . '/uploads/videos/temp/' . $portfolio['video_filename'];
            if (file_exists($tempPath)) {
                if (unlink($tempPath)) {
                }
            }
        }
    }

    private function handleImageUpload($file, $portfolioId = null) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = ROOT_PATH . '/uploads/portfolio/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

            // Генерируем имя файла на основе ID портфолио
            if ($portfolioId) {
                $filename = 'portfolio_' . $portfolioId . '.' . $extension;
            } else {
                // Временное имя для новых записей (до получения ID)
                $safeName = preg_replace('/[^a-zA-Z0-9-_]/', '', pathinfo($file['name'], PATHINFO_FILENAME));
                $filename = 'temp_' . time() . '_' . $safeName . '.' . $extension;
            }

            $filepath = $uploadDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                return '/uploads/portfolio/' . $filename;
            }
        }
        return '';
    }

    private function deleteOldImage($imagePath) {
        if (!empty($imagePath)) {
            $fullPath = ROOT_PATH . $imagePath;
            if (file_exists($fullPath) && is_file($fullPath)) {
                // Также удаляем все возможные варианты имен для этого портфолио
                $portfolioId = $this->extractPortfolioIdFromPath($imagePath);
                if ($portfolioId) {
                    $this->deleteAllPortfolioImages($portfolioId);
                } else {
                    unlink($fullPath);
                }
                return true;
            }
        }
        return false;
    }

    private function extractPortfolioIdFromPath($imagePath) {
        // Извлекаем ID из пути типа /uploads/portfolio/portfolio_123.jpg
        if (preg_match('/portfolio_(\d+)\./', $imagePath, $matches)) {
            return $matches[1];
        }
        return null;
    }

    private function deleteAllPortfolioImages($portfolioId) {
        $uploadDir = ROOT_PATH . '/uploads/portfolio/';
        $pattern = $uploadDir . 'portfolio_' . $portfolioId . '.*';

        $files = glob($pattern);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
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

            // Удаляем видео если есть
            if (!empty($portfolio['video_filename'])) {
                $this->deletePortfolioVideo($portfolio);
            }

            $portfolioModel->delete($id);
        }
        $this->redirect('/admin.php?action=portfolio_list&success=1');
    }
}
?>