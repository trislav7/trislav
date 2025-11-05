<?php
error_log("AdminTrislavGroupController loaded");
class AdminTrislavGroupController extends AdminBaseController {

    public function content() {
        $clientModel = new TrislavGroupClient();
        $reviewModel = new TrislavGroupReview();
        $advantageModel = new TrislavGroupAdvantage();
        $projectModel = new TrislavGroupProject();

        $data = [
            'clients' => $clientModel->getAll(),
            'reviews' => $reviewModel->getAll(),
            'advantages' => $advantageModel->getAll(),
            'projects' => $projectModel->getAll(),
            'title' => 'Управление контентом Трислав Групп',
            'current_action' => 'trislav_content'
        ];

        $this->view('admin/trislav_group_content', $data);
    }

    // КЛИЕНТЫ
    public function clients() {
        $clientModel = new TrislavGroupClient();
        $clients = $clientModel->getAll();

        $this->view('admin/trislav_group_clients', [
            'title' => 'Управление клиентами Трислав Групп',
            'clients' => $clients,
            'current_action' => 'trislav_clients'
        ]);
    }

    public function clients_create() {
        $projectModel = new TrislavGroupProject();
        $serviceModel = new Service();
        $shoppingCenterModel = new ShoppingCenter();
        $tariffModel = new Tariff();

        $projects = $projectModel->getAllActive();
        $services = $serviceModel->getAllActive();
        $shoppingCenters = $shoppingCenterModel->getAllActive();
        $tariffs = $tariffModel->getActive();

        if ($_POST) {
            $clientModel = new TrislavGroupClient();
            $connectionModel = new TrislavGroupClientProject();

            // Обработка загрузки изображения
            $imagePath = '';
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = $clientModel->handleImageUpload($_FILES['image']);
            }

            // Создаем клиента
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'image_url' => $imagePath,
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $clientId = $clientModel->create($data);

            // 1. Сначала сохраняем связи БЕЗ видео (быстрая операция)
            if (!empty($_POST['connections']) && is_array($_POST['connections'])) {
                foreach ($_POST['connections'] as $index => $connection) {
                    if (!empty($connection['project_id'])) {
                        $videoUrl = $connection['video_url'] ?? null;

                        // Пока сохраняем без файлового видео
                        $connectionId = $connectionModel->addConnection(
                            $clientId,
                            $connection['project_id'],
                            $connection['service_id'] ?? null,
                            $connection['shopping_center_id'] ?? null,
                            $connection['tariff_id'] ?? null,
                            $videoUrl,
                            null, // video_filename - пока null
                            null  // yandex_disk_path - пока null
                        );
                    }
                }
            }

            // 2. ТЕПЕРЬ обрабатываем загрузку видео файлов (долгая операция)
            if (!empty($_POST['connections']) && is_array($_POST['connections'])) {
                foreach ($_POST['connections'] as $index => $connection) {
                    if (!empty($_FILES['connections']['name'][$index]['video_file'])) {
                        $videoFile = [
                            'name' => $_FILES['connections']['name'][$index]['video_file'],
                            'type' => $_FILES['connections']['type'][$index]['video_file'],
                            'tmp_name' => $_FILES['connections']['tmp_name'][$index]['video_file'],
                            'error' => $_FILES['connections']['error'][$index]['video_file'],
                            'size' => $_FILES['connections']['size'][$index]['video_file']
                        ];

                        $videoResult = $this->handleVideoUpload($videoFile, $connection['shopping_center_id'] ?? null);

                        if ($videoResult) {
                            // Обновляем связь с информацией о видео
                            $this->updateConnectionWithVideo(
                                $clientId,
                                $connection['project_id'],
                                $videoResult['filename'],
                                $videoResult['disk_path']
                            );
                        }
                    }
                }
            }

            header('Location: /admin.php?action=trislav_clients&success=1');
            exit;
        }

        $this->view('admin/trislav_group_clients_form', [
            'title' => 'Добавить клиента',
            'current_action' => 'trislav_clients',
            'item' => null,
            'projects' => $projects,
            'services' => $services,
            'shoppingCenters' => $shoppingCenters,
            'tariffs' => $tariffs,
            'connections' => []
        ]);
    }

    public function clients_edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin.php?action=trislav_clients');
            exit;
        }

        $clientModel = new TrislavGroupClient();
        $projectModel = new TrislavGroupProject();
        $serviceModel = new Service();
        $shoppingCenterModel = new ShoppingCenter();
        $tariffModel = new Tariff();

        $item = $clientModel->findWithDetails($id);
        $projects = $projectModel->getAllActive();
        $services = $serviceModel->getAllActive();
        $shoppingCenters = $shoppingCenterModel->getAllActive();
        $tariffs = $tariffModel->getActive();
        $connections = $item['connections'] ?? [];

        if (!$item) {
            header('Location: /admin.php?action=trislav_clients&error=1');
            exit;
        }

        if ($_POST) {
            // Сохраняем существующие связи для проверки видео
            $connectionModel = new TrislavGroupClientProject();
            $existingConnections = $connectionModel->getByClient($id);

            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            // Если загружено новое изображение
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $data['image_url'] = $clientModel->handleImageUpload($_FILES['image']);

                // Удаляем старое изображение если есть
                if (!empty($item['image_url'])) {
                    $clientModel->deleteOldImage($item['image_url']);
                }
            }

            $clientModel->update($id, $data);

            // 1. Сначала удаляем старые связи (быстрая операция)
            $connectionModel->removeByClient($id);

            // 2. Сохраняем новые связи БЕЗ видео (быстрая операция)
            if (!empty($_POST['connections']) && is_array($_POST['connections'])) {
                foreach ($_POST['connections'] as $index => $connection) {
                    if (!empty($connection['project_id'])) {
                        $videoUrl = $connection['video_url'] ?? null;
                        $videoFilename = null;
                        $yandexDiskPath = null;

                        // Проверяем нужно ли удалить существующее видео
                        $removeVideo = !empty($connection['remove_video']);

                        // Если не удаляем и есть существующее видео - сохраняем его
                        if (!$removeVideo && isset($existingConnections[$index])) {
                            $existing = $existingConnections[$index];
                            $videoFilename = $existing['video_filename'] ?? null;
                            $yandexDiskPath = $existing['yandex_disk_path'] ?? null;
                        }

                        // Пока сохраняем без обработки новых файлов
                        $connectionId = $connectionModel->addConnection(
                            $id,
                            $connection['project_id'],
                            $connection['service_id'] ?? null,
                            $connection['shopping_center_id'] ?? null,
                            $connection['tariff_id'] ?? null,
                            $videoUrl,
                            $videoFilename,
                            $yandexDiskPath
                        );
                    }
                }
            }

            // 3. ТЕПЕРЬ обрабатываем загрузку НОВЫХ видео файлов (долгая операция)
            if (!empty($_POST['connections']) && is_array($_POST['connections'])) {
                foreach ($_POST['connections'] as $index => $connection) {
                    if (!empty($_FILES['connections']['name'][$index]['video_file'])) {
                        $videoFile = [
                            'name' => $_FILES['connections']['name'][$index]['video_file'],
                            'type' => $_FILES['connections']['type'][$index]['video_file'],
                            'tmp_name' => $_FILES['connections']['tmp_name'][$index]['video_file'],
                            'error' => $_FILES['connections']['error'][$index]['video_file'],
                            'size' => $_FILES['connections']['size'][$index]['video_file']
                        ];

                        $videoResult = $this->handleVideoUpload($videoFile, $connection['shopping_center_id'] ?? null);

                        if ($videoResult) {
                            // Обновляем связь с информацией о видео
                            $this->updateConnectionWithVideo(
                                $id,
                                $connection['project_id'],
                                $videoResult['filename'],
                                $videoResult['disk_path']
                            );
                        }
                    }
                }
            }

            header('Location: /admin.php?action=trislav_clients&success=1');
            exit;
        }

        $this->view('admin/trislav_group_clients_form', [
            'title' => 'Редактировать клиента',
            'current_action' => 'trislav_clients',
            'item' => $item,
            'projects' => $projects,
            'services' => $services,
            'shoppingCenters' => $shoppingCenters,
            'tariffs' => $tariffs,
            'connections' => $connections
        ]);
    }

    public function clients_toggle() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $clientModel = new TrislavGroupClient();
            $clientModel->toggleStatus($id);
        }
        header('Location: /admin.php?action=trislav_clients');
        exit;
    }

    public function clients_delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $clientModel = new TrislavGroupClient();
            $clientModel->delete($id);
        }
        header('Location: /admin.php?action=trislav_clients&success=1');
        exit;
    }

    // ОТЗЫВЫ
    public function reviews() {
        $reviewModel = new TrislavGroupReview();
        $reviews = $reviewModel->getAll();

        $this->view('admin/trislav_group_reviews', [
            'title' => 'Управление отзывами Трислав Групп',
            'reviews' => $reviews,
            'current_action' => 'trislav_reviews'
        ]);
    }

    public function reviews_create() {
        if ($_POST) {
            $reviewModel = new TrislavGroupReview();
            $data = [
                'author_name' => $_POST['author_name'] ?? '',
                'author_position' => $_POST['author_position'] ?? '',
                'content' => $_POST['content'] ?? '',
                'author_avatar' => $_POST['author_avatar'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $id = $reviewModel->create($data);
            if ($id) {
                header('Location: /admin.php?action=trislav_reviews&success=1');
                exit;
            }
        }

        $this->view('admin/trislav_group_reviews_form', [
            'title' => 'Добавить отзыв',
            'current_action' => 'trislav_reviews',
            'item' => null
        ]);
    }

    public function reviews_edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin.php?action=trislav_reviews');
            exit;
        }

        $reviewModel = new TrislavGroupReview();
        $item = $reviewModel->find($id);

        if (!$item) {
            header('Location: /admin.php?action=trislav_reviews&error=1');
            exit;
        }

        if ($_POST) {
            $data = [
                'author_name' => $_POST['author_name'] ?? '',
                'author_position' => $_POST['author_position'] ?? '',
                'content' => $_POST['content'] ?? '',
                'author_avatar' => $_POST['author_avatar'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if ($reviewModel->update($id, $data)) {
                header('Location: /admin.php?action=trislav_reviews&success=1');
                exit;
            }
        }

        $this->view('admin/trislav_group_reviews_form', [
            'title' => 'Редактировать отзыв',
            'current_action' => 'trislav_reviews',
            'item' => $item
        ]);
    }

    public function reviews_toggle() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $reviewModel = new TrislavGroupReview();
            $reviewModel->toggleStatus($id);
        }
        header('Location: /admin.php?action=trislav_reviews');
        exit;
    }

    // ПРЕИМУЩЕСТВА
    public function advantages() {
        $advantageModel = new TrislavGroupAdvantage();
        $advantages = $advantageModel->getAll();

        $this->view('admin/trislav_group_advantages', [
            'title' => 'Управление преимуществами Трислав Групп',
            'advantages' => $advantages,
            'current_action' => 'trislav_advantages'
        ]);
    }

    public function advantages_create() {
        if ($_POST) {
            $advantageModel = new TrislavGroupAdvantage();
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'icon_class' => $_POST['icon_class'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $id = $advantageModel->create($data);
            if ($id) {
                header('Location: /admin.php?action=trislav_advantages&success=1');
                exit;
            }
        }

        $this->view('admin/trislav_group_advantages_form', [
            'title' => 'Добавить преимущество',
            'current_action' => 'trislav_advantages',
            'item' => null
        ]);
    }

    public function advantages_edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin.php?action=trislav_advantages');
            exit;
        }

        $advantageModel = new TrislavGroupAdvantage();
        $item = $advantageModel->find($id);

        if (!$item) {
            header('Location: /admin.php?action=trislav_advantages&error=1');
            exit;
        }

        if ($_POST) {
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'icon_class' => $_POST['icon_class'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if ($advantageModel->update($id, $data)) {
                header('Location: /admin.php?action=trislav_advantages&success=1');
                exit;
            }
        }

        $this->view('admin/trislav_group_advantages_form', [
            'title' => 'Редактировать преимущество',
            'current_action' => 'trislav_advantages',
            'item' => $item
        ]);
    }

    public function advantages_toggle() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $advantageModel = new TrislavGroupAdvantage();
            $advantageModel->toggleStatus($id);
        }
        header('Location: /admin.php?action=trislav_advantages');
        exit;
    }

    // ПРОЕКТЫ
    public function projects() {
        $projectModel = new TrislavGroupProject();
        $projects = $projectModel->getAll();

        $this->view('admin/trislav_group_projects', [
            'title' => 'Управление проектами Трислав Групп',
            'projects' => $projects,
            'current_action' => 'trislav_projects'
        ]);
    }

    public function projects_create() {
        if ($_POST) {
            $projectModel = new TrislavGroupProject();
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'image_url' => $_POST['image_url'] ?? '',
                'project_url' => $_POST['project_url'] ?? '',
                'tags' => $_POST['tags'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $id = $projectModel->create($data);
            if ($id) {
                header('Location: /admin.php?action=trislav_projects&success=1');
                exit;
            }
        }

        $this->view('admin/trislav_group_projects_form', [
            'title' => 'Добавить проект',
            'current_action' => 'trislav_projects',
            'item' => null
        ]);
    }

    public function projects_edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin.php?action=trislav_projects');
            exit;
        }

        $projectModel = new TrislavGroupProject();
        $item = $projectModel->find($id);

        if (!$item) {
            header('Location: /admin.php?action=trislav_projects&error=1');
            exit;
        }

        if ($_POST) {
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'image_url' => $_POST['image_url'] ?? '',
                'project_url' => $_POST['project_url'] ?? '',
                'tags' => $_POST['tags'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if ($projectModel->update($id, $data)) {
                header('Location: /admin.php?action=trislav_projects&success=1');
                exit;
            }
        }

        $this->view('admin/trislav_group_projects_form', [
            'title' => 'Редактировать проект',
            'current_action' => 'trislav_projects',
            'item' => $item
        ]);
    }

    public function projects_toggle() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $projectModel = new TrislavGroupProject();
            $projectModel->toggleStatus($id);
        }
        header('Location: /admin.php?action=trislav_projects');
        exit;
    }

    public function shopping_centers() {
        $shoppingCenterModel = new ShoppingCenter();
        $centers = $shoppingCenterModel->getAll();

        $this->view('admin/trislav_group_shopping_centers', [
            'title' => 'Управление торговыми центрами',
            'centers' => $centers,
            'current_action' => 'trislav_shopping_centers'
        ]);
    }

    public function shopping_centers_create() {
        if ($_POST) {
            $shoppingCenterModel = new ShoppingCenter();
            $data = [
                'title' => $_POST['title'] ?? '',
                'address' => $_POST['address'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $shoppingCenterModel->create($data);
            header('Location: /admin.php?action=trislav_shopping_centers&success=1');
            exit;
        }

        $this->view('admin/trislav_group_shopping_centers_form', [
            'title' => 'Добавить торговый центр',
            'current_action' => 'trislav_shopping_centers',
            'item' => null
        ]);
    }

    public function shopping_centers_edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin.php?action=trislav_shopping_centers');
            exit;
        }

        $shoppingCenterModel = new ShoppingCenter();
        $item = $shoppingCenterModel->find($id);

        if (!$item) {
            header('Location: /admin.php?action=trislav_shopping_centers&error=1');
            exit;
        }

        if ($_POST) {
            $data = [
                'title' => $_POST['title'] ?? '',
                'address' => $_POST['address'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $shoppingCenterModel->update($id, $data);
            header('Location: /admin.php?action=trislav_shopping_centers&success=1');
            exit;
        }

        $this->view('admin/trislav_group_shopping_centers_form', [
            'title' => 'Редактировать торговый центр',
            'current_action' => 'trislav_shopping_centers',
            'item' => $item
        ]);
    }

    public function shopping_centers_toggle() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $shoppingCenterModel = new ShoppingCenter();
            $shoppingCenterModel->toggleStatus($id);
        }
        header('Location: /admin.php?action=trislav_shopping_centers');
        exit;
    }

    public function shopping_centers_delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $shoppingCenterModel = new ShoppingCenter();
            $shoppingCenterModel->delete($id);
        }
        header('Location: /admin.php?action=trislav_shopping_centers&success=1');
        exit;
    }

    /**
     * Обработка загрузки видео файла с отладкой в файл
     */
    private function handleVideoUpload($file, $shoppingCenterId = null) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            // Временное сохранение файла
            $uploadDir = ROOT_PATH . '/uploads/videos/temp/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $safeName = preg_replace('/[^a-zA-Z0-9-_]/', '', pathinfo($file['name'], PATHINFO_FILENAME));
            $filename = time() . '_' . $safeName . '.' . $extension;
            $filepath = $uploadDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                // Загружаем на Яндекс.Диск если указан ТЦ
                if ($shoppingCenterId) {
                    try {
                        $yandexConfig = require ROOT_PATH . '/config/yandex_disk.php';
                        $diskService = new YandexDiskService($yandexConfig['token']);

                        // Проверим подключение
                        $isConnected = $diskService->checkConnection();

                        if ($isConnected) {
                            $remoteFilename = $safeName . '.mp4';
                            $yandexDiskPath = "slides/{$shoppingCenterId}/{$remoteFilename}";

                            $uploadResult = $diskService->uploadVideoToShoppingCenter($filepath, $shoppingCenterId, $remoteFilename);

                            if ($uploadResult) {

                                // Удаляем временный файл после успешной загрузки
                                unlink($filepath);

                                return [
                                    'filename' => $remoteFilename,
                                    'disk_path' => $yandexDiskPath
                                ];
                            } else {
                            }
                        } else {
                        }
                    } catch (Exception $e) {
                    }
                } else {
                }

                // Если Яндекс.Диск не доступен, сохраняем локально
                $finalDir = ROOT_PATH . '/uploads/videos/';
                if (!is_dir($finalDir)) {
                    mkdir($finalDir, 0755, true);
                }

                $finalPath = $finalDir . $filename;
                rename($filepath, $finalPath);


                return [
                    'filename' => $filename,
                    'disk_path' => null
                ];
            } else {
            }
        } else {
        }

        return null;
    }

    public function check_yandex_disk() {
        $yandexConfig = require ROOT_PATH . '/config/yandex_disk.php';
        $diskService = new YandexDiskService($yandexConfig['token']);

        $isConnected = $diskService->checkConnection();

        if ($isConnected) {
            echo json_encode(['status' => 'success', 'message' => 'Яндекс.Диск подключен успешно']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Ошибка подключения к Яндекс.Диску']);
        }
        exit;
    }

    /**
     * Обновляет связь с информацией о видео файле
     */
    /**
     * Обновляет связь с информацией о видео файле
     */
    private function updateConnectionWithVideo($clientId, $projectId, $videoFilename, $yandexDiskPath) {
        $connectionModel = new TrislavGroupClientProject();

        // Находим ID последней связи для этого клиента и проекта
        $connection = $connectionModel->findByClientAndProject($clientId, $projectId);

        if ($connection) {
            // Обновляем связь с видео информацией
            $connectionModel->update($connection['id'], [
                'video_filename' => $videoFilename,
                'yandex_disk_path' => $yandexDiskPath
            ]);
        } else {
        }
    }
    public function download_shopping_center_videos() {

        $shoppingCenterId = $_GET['shopping_center_id'] ?? null;
        if (!$shoppingCenterId) {
            header('Location: /admin.php?action=trislav_shopping_centers&error=no_id');
            exit;
        }

        try {
            // Получаем информацию о ТЦ
            $shoppingCenterModel = new ShoppingCenter();
            $shoppingCenter = $shoppingCenterModel->find($shoppingCenterId);

            if (!$shoppingCenter) {
                header('Location: /admin.php?action=trislav_shopping_centers&error=center_not_found');
                exit;
            }


            // Получаем ВСЕ связи для этого ТЦ
            $connectionModel = new TrislavGroupClientProject();
            $connections = $connectionModel->getByShoppingCenter($shoppingCenterId);


            // Создаем временную папку
            $tempDir = ROOT_PATH . '/temp/tc_videos_' . time() . '_' . $shoppingCenterId;
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $videoFiles = [];
            $counter = 1;

            // Обрабатываем КАЖДУЮ связку для этого ТЦ
            foreach ($connections as $connection) {

                $videoPath = null;

                // Пробуем скачать с Яндекс.Диска
                if (!empty($connection['yandex_disk_path'])) {
                    $videoPath = $this->downloadFromYandexDisk(
                        $connection['yandex_disk_path'],
                        $tempDir,
                        $counter
                    );
                }
                // Если нет на Яндекс.Диске, пробуем локальный файл
                elseif (!empty($connection['video_filename'])) {
                    $videoPath = $this->copyLocalVideo(
                        $connection['video_filename'],
                        $tempDir,
                        $counter
                    );
                }
                // Если есть только URL видео
                elseif (!empty($connection['video'])) {
                    $videoPath = $this->downloadVideoFromUrl(
                        $connection['video'],
                        $tempDir,
                        $counter
                    );
                }

                // Если видео не найдено - используем заглушку
                if (!$videoPath) {
                    $videoPath = $this->copyDefaultAd($tempDir, $counter);
                }

                if ($videoPath) {
                    $videoFiles[] = $videoPath;
                    $counter++;
                }
            }

            // ДОБАВЛЯЕМ ЗАГЛУШКИ ДЛЯ ПРОПУЩЕННЫХ СЛОТОВ
            // Создаем полный набор файлов от 00001 до максимального номера
            $maxSlots = 48; // Максимальное количество слотов
            $fullVideoFiles = [];

            for ($i = 1; $i <= $maxSlots; $i++) {
                $expectedFilename = sprintf("%05d", $i) . '.mp4';
                $expectedPath = $tempDir . '/' . $expectedFilename;

                // Ищем существующий файл с таким номером
                $existingFile = null;
                foreach ($videoFiles as $videoFile) {
                    if (basename($videoFile) === $expectedFilename) {
                        $existingFile = $videoFile;
                        break;
                    }
                }

                if ($existingFile) {
                    $fullVideoFiles[] = $existingFile;
                } else {
                    // Заполняем пропуск заглушкой
                    $placeholderPath = $this->copyDefaultAd($tempDir, $i);
                    if ($placeholderPath) {
                        $fullVideoFiles[] = $placeholderPath;
                    }
                }
            }


            // Создаем архив
            if (!empty($fullVideoFiles)) {
                $archivePath = $this->createNumberedArchive($fullVideoFiles, $tempDir, $shoppingCenter['title']);

                // Отправляем архив
                $this->sendArchiveForDownload($archivePath, $shoppingCenter['title']);


                // Очищаем временные файлы ПОСЛЕ отправки архива
                $this->cleanupTempFiles($tempDir);


                // Выходим после очистки
                exit;
            } else {
                header('Location: /admin.php?action=trislav_shopping_centers&error=no_videos_found');
                exit;
            }

        } catch (Exception $e) {
            header('Location: /admin.php?action=trislav_shopping_centers&error=download_failed');
            exit;
        }
    }

    public function test_download_simple() {

        // Просто создаем тестовый файл и отдаем его
        $testContent = "Тестовый файл для проверки скачивания\n";
        $testContent .= "ТЦ ID: " . ($_GET['shopping_center_id'] ?? 'unknown') . "\n";
        $testContent .= "Время: " . date('Y-m-d H:i:s') . "\n";

        $filename = 'test_download_' . time() . '.txt';

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo $testContent;
        exit;
    }

    /**
     * Скачивает видео с Яндекс.Диска с правильным именем
     */
    private function downloadFromYandexDisk($yandexPath, $tempDir, $counter) {
        try {
            $yandexConfig = require ROOT_PATH . '/config/yandex_disk.php';
            $diskService = new YandexDiskService($yandexConfig['token']);

            $filename = sprintf("%05d", $counter) . '.mp4';
            $localPath = $tempDir . '/' . $filename;

            if ($diskService->downloadFile($yandexPath, $localPath)) {
                return $localPath;
            }
        } catch (Exception $e) {
            error_log("Yandex Disk download error: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Копирует локальное видео с правильным именем
     */
    private function copyLocalVideo($filename, $tempDir, $counter) {
        $localPath = ROOT_PATH . '/uploads/videos/' . $filename;
        if (file_exists($localPath)) {
            $newFilename = sprintf("%05d", $counter) . '.mp4';
            $newPath = $tempDir . '/' . $newFilename;

            if (copy($localPath, $newPath)) {
                return $newPath;
            }
        }

        return null;
    }

    /**
     * Создает архив с правильно пронумерованными файлами
     */
    private function createNumberedArchive($files, $tempDir, $shoppingCenterTitle) {
        $archiveName = 'videos_' . preg_replace('/[^a-zA-Z0-9]/', '_', $shoppingCenterTitle) . '.zip';
        $archivePath = $tempDir . '/' . $archiveName;

        $zip = new ZipArchive();
        if ($zip->open($archivePath, ZipArchive::CREATE) === TRUE) {
            foreach ($files as $index => $file) {
                if (file_exists($file)) {
                    // Переименовываем файл в архиве
                    $number = $index + 1;
                    $archiveFilename = sprintf("%05d", $number) . '.mp4';
                    $zip->addFile($file, $archiveFilename);
                }
            }
            $zip->close();
            return $archivePath;
        }

        throw new Exception("Failed to create archive");
    }

    /**
     * Отправляет архив на скачивание
     */
    private function sendArchiveForDownload($archivePath, $shoppingCenterTitle) {
        if (!file_exists($archivePath)) {
            throw new Exception("Archive file not found: $archivePath");
        }


        // Очищаем все буферы вывода
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $archiveName = 'videos_' . preg_replace('/[^a-zA-Z0-9]/', '_', $shoppingCenterTitle) . '.zip';

        header('Content-Description: File Transfer');
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $archiveName . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($archivePath));

        // Читаем и отправляем файл
        readfile($archivePath);


        // НЕ ВЫХОДИМ здесь, чтобы выполнилась очистка
    }

    /**
     * Очищает временные файлы
     */
    /**
     * Очищает временные файлы включая архив
     */
    private function cleanupTempFiles($tempDir) {

        if (is_dir($tempDir)) {
            $files = glob($tempDir . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    if (unlink($file)) {
                    } else {
                    }
                }
            }

            // Удаляем саму папку
            if (rmdir($tempDir)) {
            } else {
            }
        } else {
        }
    }
    /**
     * Скачивает видео по URL
     */
    private function downloadVideoFromUrl($url, $tempDir, $counter) {
        try {
            $filename = sprintf("%05d", $counter) . '.mp4';
            $localPath = $tempDir . '/' . $filename;


            $ch = curl_init($url);
            $fp = fopen($localPath, 'wb');

            curl_setopt_array($ch, [
                CURLOPT_FILE => $fp,
                CURLOPT_HEADER => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT => 300,
                CURLOPT_SSL_VERIFYPEER => false
            ]);

            if (curl_exec($ch)) {
                curl_close($ch);
                fclose($fp);
                return $localPath;
            }

            curl_close($ch);
            fclose($fp);
            @unlink($localPath);

        } catch (Exception $e) {
        }

        return null;
    }

    /**
     * Копирует заглушку с правильным именем
     */
    private function copyDefaultAd($tempDir, $counter) {
        $defaultAdPath = ROOT_PATH . '/uploads/video/default_ad.mp4';

        if (!file_exists($defaultAdPath)) {
            // Создаем пустой файл как заглушку
            $filename = sprintf("%05d", $counter) . '.mp4';
            $newPath = $tempDir . '/' . $filename;
            file_put_contents($newPath, '');
            return $newPath;
        }

        $filename = sprintf("%05d", $counter) . '.mp4';
        $newPath = $tempDir . '/' . $filename;

        if (copy($defaultAdPath, $newPath)) {
            return $newPath;
        }

        return null;
    }
}
?>