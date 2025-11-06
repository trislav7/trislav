<?php
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
            $videoFileCount = 0;
            if (!empty($_POST['connections']) && is_array($_POST['connections'])) {
                foreach ($_POST['connections'] as $index => $connection) {
                    if (!empty($_FILES['connections']['name'][$index]['video_file'])) {
                        $videoFileCount++;
                    }
                }
            }

            if ($videoFileCount > 1) {
                debug_log("Too many video files attempted: " . $videoFileCount);
                header('Location: /admin.php?action=trislav_clients&error=too_many_videos');
                exit;
            }

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
            debug_log("Client created with ID: " . $clientId);

            // 1. Сохраняем связи и получаем их ID
            $connectionIds = [];
            if (!empty($_POST['connections']) && is_array($_POST['connections'])) {
                foreach ($_POST['connections'] as $index => $connection) {
                    if (!empty($connection['project_id'])) {
                        $videoUrl = $connection['video_url'] ?? null;

                        // Сохраняем связь и получаем её ID
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

                        $connectionIds[$index] = $connectionId;
                        debug_log("Connection created with ID: " . $connectionId . " for project: " . $connection['project_id']);
                    }
                }
            }

            // 2. Обрабатываем загрузку видео файлов с правильными именами
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

                        // Используем ID связки для именования файла
                        $connectionId = $connectionIds[$index] ?? null;
                        debug_log("Processing video for connection ID: " . ($connectionId ?? 'NULL'));

                        $videoResult = $this->handleVideoUpload($videoFile, $connection['shopping_center_id'] ?? null, $connectionId);

                        if ($videoResult) {
                            debug_log("Video upload successful, filename: " . $videoResult['filename']);

                            // Обновляем связь с информацией о видео
                            $this->updateConnectionWithVideo(
                                $connectionId,
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
            $videoFileCount = 0;
            if (!empty($_POST['connections']) && is_array($_POST['connections'])) {
                foreach ($_POST['connections'] as $index => $connection) {
                    if (!empty($_FILES['connections']['name'][$index]['video_file'])) {
                        $videoFileCount++;
                    }
                }
            }

            if ($videoFileCount > 1) {
                debug_log("Too many video files attempted: " . $videoFileCount);
                header('Location: /admin.php?action=trislav_clients&error=too_many_videos');
                exit;
            }

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

            // 1. ОБНОВЛЯЕМ существующие связи вместо удаления
            $connectionIds = [];
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

                        // Если связка уже существует - ОБНОВЛЯЕМ её
                        if (isset($existingConnections[$index]) && !empty($existingConnections[$index]['id'])) {
                            $connectionId = $existingConnections[$index]['id'];

                            // Если отмечено "удалить текущее видео" - удаляем файлы
                            if ($removeVideo && isset($existingConnections[$index])) {
                                $existing = $existingConnections[$index];
                                $this->deleteVideoFile(
                                    $existing['video_filename'] ?? null,
                                    $existing['yandex_disk_path'] ?? null
                                );
                                $videoFilename = null;
                                $yandexDiskPath = null;
                                debug_log("Video files marked for deletion in connection: " . $connectionId);
                            }

                            $connectionModel->update($connectionId, [
                                'id_project' => $connection['project_id'],
                                'id_service' => $connection['service_id'] ?? null,
                                'id_shopping_center' => $connection['shopping_center_id'] ?? null,
                                'id_tariff' => $connection['tariff_id'] ?? null,
                                'video' => $videoUrl,
                                'video_filename' => $videoFilename,
                                'yandex_disk_path' => $yandexDiskPath
                            ]);

                            $connectionIds[$index] = $connectionId;
                            debug_log("Updated existing connection ID: " . $connectionId);
                        } else {
                            // Если связки нет - СОЗДАЕМ новую
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

                            $connectionIds[$index] = $connectionId;
                            debug_log("Created new connection ID: " . $connectionId);
                        }
                    }
                }
            }

            // 2. УДАЛЯЕМ связи, которые были удалены в форме
            $existingConnectionIds = array_column($existingConnections, 'id');
            $updatedConnectionIds = array_values($connectionIds);
            $connectionsToDelete = array_diff($existingConnectionIds, $updatedConnectionIds);

            foreach ($connectionsToDelete as $connectionIdToDelete) {
                // Находим связку чтобы получить информацию о видео
                $connectionToDelete = $connectionModel->find($connectionIdToDelete);
                if ($connectionToDelete) {
                    debug_log("Deleting connection ID: " . $connectionIdToDelete);
                    debug_log("Connection video data - filename: " . ($connectionToDelete['video_filename'] ?? 'NULL') . ", yandex path: " . ($connectionToDelete['yandex_disk_path'] ?? 'NULL'));

                    // Удаляем видеофайлы если есть
                    if (!empty($connectionToDelete['video_filename']) || !empty($connectionToDelete['yandex_disk_path'])) {
                        $this->deleteVideoFile(
                            $connectionToDelete['video_filename'] ?? null,
                            $connectionToDelete['yandex_disk_path'] ?? null
                        );
                        debug_log("Video files deleted for connection: " . $connectionIdToDelete);
                    } else {
                        debug_log("No video files to delete for connection: " . $connectionIdToDelete);
                    }
                } else {
                    debug_log("Connection not found for deletion: " . $connectionIdToDelete);
                }

                $connectionModel->delete($connectionIdToDelete);
                debug_log("Connection record deleted from database: " . $connectionIdToDelete);
            }

            // 3. Обрабатываем загрузку НОВЫХ видео файлов
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

                        // Используем ID связки для именования файла
                        $connectionId = $connectionIds[$index] ?? null;
                        debug_log("Processing video for connection ID: " . ($connectionId ?? 'NULL'));

                        $videoResult = $this->handleVideoUpload($videoFile, $connection['shopping_center_id'] ?? null, $connectionId);

                        if ($videoResult) {
                            debug_log("Video upload successful, filename: " . $videoResult['filename']);

                            // Обновляем связь с информацией о видео
                            $this->updateConnectionWithVideo(
                                $connectionId,
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

        foreach ($connections as &$connection) {
            $connection['show_video_fields'] = $this->shouldShowVideoFields($connection);
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
            $connectionModel = new TrislavGroupClientProject();

            debug_log("Starting deletion of client ID: " . $id);

            // Получаем все связи клиента
            $connections = $connectionModel->getByClient($id);
            debug_log("Found " . count($connections) . " connections for client");

            // Удаляем видеофайлы всех связей
            foreach ($connections as $connection) {
                debug_log("Deleting video files for connection ID: " . $connection['id']);
                $this->deleteVideoFile(
                    $connection['video_filename'] ?? null,
                    $connection['yandex_disk_path'] ?? null
                );
            }

            // Удаляем изображение клиента если есть
            $client = $clientModel->find($id);
            if ($client && !empty($client['image_url'])) {
                debug_log("Deleting client image: " . $client['image_url']);
                $clientModel->deleteOldImage($client['image_url']);
            }

            // Удаляем клиента (связи удалятся каскадом благодаря внешним ключам)
            $clientModel->delete($id);

            debug_log("Client deletion completed for ID: " . $id);
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
     * Обработка загрузки видео файла с уникальным именем на основе ID связки
     */
    private function handleVideoUpload($file, $shoppingCenterId = null, $connectionId = null) {
        debug_log("=== START VIDEO UPLOAD ===");
        debug_log("Connection ID: " . ($connectionId ?? 'NULL'));
        debug_log("Shopping Center ID: " . ($shoppingCenterId ?? 'NULL'));
        debug_log("Original filename: " . $file['name']);

        if ($file['error'] === UPLOAD_ERR_OK) {
            // Временное сохранение файла
            $uploadDir = ROOT_PATH . '/uploads/videos/temp/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

            // ГЕНЕРИРУЕМ УНИКАЛЬНОЕ ИМЯ НА ОСНОВЕ ID СВЯЗКИ
            if ($connectionId) {
                $filename = 'video_' . $connectionId . '.' . $extension;
                debug_log("Using connection-based filename: " . $filename);
            } else {
                // Резервный вариант если ID связки еще нет
                $safeName = preg_replace('/[^a-zA-Z0-9-_]/', '', pathinfo($file['name'], PATHINFO_FILENAME));
                $filename = time() . '_' . $safeName . '.' . $extension;
                debug_log("Using FALLBACK filename: " . $filename);
            }

            $filepath = $uploadDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                debug_log("File moved to temp location: " . $filepath);

                // Загружаем на Яндекс.Диск если указан ТЦ
                if ($shoppingCenterId) {
                    try {
                        $yandexConfig = require ROOT_PATH . '/config/yandex_disk.php';
                        $diskService = new YandexDiskService($yandexConfig['token']);

                        // Проверим подключение
                        $isConnected = $diskService->checkConnection();
                        debug_log("Yandex Disk connection: " . ($isConnected ? 'OK' : 'FAILED'));

                        if ($isConnected) {
                            // ВАЖНО: передаем ПЕРЕИМЕНОВАННЫЙ файл на Яндекс.Диск
                            $remoteFilename = $filename; // Используем то же имя, что и локально
                            $yandexDiskPath = "slides/{$shoppingCenterId}/{$remoteFilename}";

                            debug_log("Uploading to Yandex Disk - path: " . $yandexDiskPath);

                            // Используем существующий метод, но передаем переименованный файл
                            $uploadResult = $diskService->uploadVideoToShoppingCenter($filepath, $shoppingCenterId, $remoteFilename);

                            if ($uploadResult) {
                                debug_log("Yandex Disk upload SUCCESS: " . $yandexDiskPath);

                                // Удаляем временный файл после успешной загрузки
                                unlink($filepath);
                                debug_log("Temp file deleted: " . $filepath);

                                return [
                                    'filename' => $remoteFilename,
                                    'disk_path' => $yandexDiskPath
                                ];
                            } else {
                                debug_log("Yandex Disk upload FAILED");
                            }
                        } else {
                            debug_log("Yandex Disk not connected");
                        }
                    } catch (Exception $e) {
                        debug_log("Yandex Disk exception: " . $e->getMessage());
                    }
                } else {
                    debug_log("No shopping center ID provided, skipping Yandex Disk");
                }

                // Если Яндекс.Диск не доступен, сохраняем локально
                $finalDir = ROOT_PATH . '/uploads/videos/';
                if (!is_dir($finalDir)) {
                    mkdir($finalDir, 0755, true);
                }

                $finalPath = $finalDir . $filename;
                rename($filepath, $finalPath);
                debug_log("File saved locally: " . $finalPath);

                return [
                    'filename' => $filename,
                    'disk_path' => null
                ];
            } else {
                debug_log("Failed to move uploaded file");
            }
        } else {
            debug_log("File upload error: " . $file['error']);
        }

        debug_log("=== END VIDEO UPLOAD ===");
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
    private function updateConnectionWithVideo($connectionId, $videoFilename, $yandexDiskPath) {
        debug_log("Updating connection with video - connection ID: $connectionId");

        $connectionModel = new TrislavGroupClientProject();

        if ($connectionId) {
            debug_log("Updating connection ID: " . $connectionId);

            // Обновляем связь с видео информацией
            $result = $connectionModel->update($connectionId, [
                'video_filename' => $videoFilename,
                'yandex_disk_path' => $yandexDiskPath
            ]);

            debug_log("Connection update result: " . ($result ? 'SUCCESS' : 'FAILED'));

            return $connectionId;
        } else {
            debug_log("Connection ID not provided for video update");
        }

        return null;
    }

    /**
     * Находит ID связи по клиенту и проекту
     */
    private function findConnectionId($clientId, $projectId) {
        debug_log("Searching connection - client: $clientId, project: $projectId");

        $connectionModel = new TrislavGroupClientProject();
        $connection = $connectionModel->findByClientAndProject($clientId, $projectId);

        if ($connection) {
            debug_log("Connection FOUND - ID: " . $connection['id']);
        } else {
            debug_log("Connection NOT FOUND for client $clientId and project $projectId");
        }

        return $connection ? $connection['id'] : null;
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

    public function trislav_media_dashboard() {
        $portfolioModel = new Portfolio();
        $shoppingCenterModel = new ShoppingCenter();
        $leadModel = new Lead();
        $advantageModel = new LedAdvantage();

        $data = [
            'portfolio' => $portfolioModel->getAll(),
            'shoppingCenters' => $shoppingCenterModel->getAll(),
            'leads' => $leadModel->getAll(),
            'ledAdvantages' => $advantageModel->getByCategory('led'),
            'title' => 'Дашборд Трислав Медиа',
            'current_action' => 'trislav_media_dashboard'
        ];

        $this->view('admin/trislav_media_dashboard', $data);
    }

    /**
     * Удаляет видеофайл (с Яндекс.Диска и локально)
     */
    private function deleteVideoFile($videoFilename, $yandexDiskPath) {
        debug_log("=== START VIDEO FILE DELETION ===");
        debug_log("Video filename: " . ($videoFilename ?? 'NULL'));
        debug_log("Yandex disk path: " . ($yandexDiskPath ?? 'NULL'));

        $deletedCount = 0;

        // Удаляем с Яндекс.Диска если есть
        if (!empty($yandexDiskPath)) {
            try {
                $yandexConfig = require ROOT_PATH . '/config/yandex_disk.php';
                $diskService = new YandexDiskService($yandexConfig['token']);

                debug_log("Attempting to delete from Yandex Disk: " . $yandexDiskPath);
                $deleteResult = $diskService->deleteFile($yandexDiskPath);

                if ($deleteResult) {
                    debug_log("✓ Yandex Disk file deleted: " . $yandexDiskPath);
                    $deletedCount++;
                } else {
                    debug_log("✗ Yandex Disk file deletion failed: " . $yandexDiskPath);
                }
            } catch (Exception $e) {
                debug_log("✗ Yandex Disk deletion error: " . $e->getMessage());
            }
        } else {
            debug_log("No Yandex Disk path provided for deletion");
        }

        // Удаляем локальный файл если есть
        if (!empty($videoFilename)) {
            $localPath = ROOT_PATH . '/uploads/videos/' . $videoFilename;
            if (file_exists($localPath)) {
                if (unlink($localPath)) {
                    debug_log("✓ Local video file deleted: " . $localPath);
                    $deletedCount++;
                } else {
                    debug_log("✗ Local video file deletion failed: " . $localPath);
                }
            } else {
                debug_log("Local video file not found: " . $localPath);
            }

            // Также удаляем временный файл если есть
            $tempPath = ROOT_PATH . '/uploads/videos/temp/' . $videoFilename;
            if (file_exists($tempPath)) {
                if (unlink($tempPath)) {
                    debug_log("✓ Temp video file deleted: " . $tempPath);
                    $deletedCount++;
                } else {
                    debug_log("✗ Temp video file deletion failed: " . $tempPath);
                }
            }
        } else {
            debug_log("No local video filename provided for deletion");
        }

        debug_log("Total files deleted: " . $deletedCount);
        debug_log("=== END VIDEO FILE DELETION ===");

        return $deletedCount > 0;
    }

    /**
     * Проверяет нужно ли показывать поля для видео
     */
    private function shouldShowVideoFields($connection) {
        // Если есть существующее видео - показываем поля
        if (($connection['video'] ?? '') || ($connection['video_filename'] ?? '')) {
            return true;
        }

        // Для новых связок проверяем условия
        $projectModel = new TrislavGroupProject();
        $serviceModel = new Service();

        $project = null;
        $service = null;

        // Получаем данные проекта если есть ID
        if (!empty($connection['id_project'])) {
            $project = $projectModel->find($connection['id_project']);
        }

        // Получаем данные услуги если есть ID
        if (!empty($connection['id_service'])) {
            $service = $serviceModel->find($connection['id_service']);
        }

        $isTrislavMedia = $project && strpos($project['title'], 'Медиа') !== false;
        $isLedService = $service && strpos($service['title'], 'LED') !== false;
        $hasShoppingCenter = !empty($connection['id_shopping_center']);
        $hasTariff = !empty($connection['id_tariff']);

        return $isTrislavMedia && $isLedService && $hasShoppingCenter && $hasTariff;
    }
}
?>