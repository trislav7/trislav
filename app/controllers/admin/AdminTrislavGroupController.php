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
                header('Location: /admin.php?action=trislav_clients&error=too_many_videos');
                exit;
            }

            $clientModel = new TrislavGroupClient();
            $connectionModel = new TrislavGroupClientProject();

            // Сначала создаем клиента без изображения чтобы получить ID
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'image_url' => '' // Временно пустое значение
            ];

            $clientId = $clientModel->create($data);

            if ($clientId) {
                // Теперь обрабатываем загрузку изображения с правильным именем
                if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $imagePath = $this->handleClientImageUpload($_FILES['image'], $clientId);
                    if ($imagePath) {
                        // Обновляем запись с правильным путем к изображению
                        $clientModel->update($clientId, ['image_url' => $imagePath]);
                    }
                }

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

                            $videoResult = $this->handleVideoUpload($videoFile, $connection['shopping_center_id'] ?? null, $connectionId);

                            if ($videoResult) {
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
                // Удаляем старое изображение если есть
                if (!empty($item['image_url'])) {
                    $this->deleteOldClientImage($item['image_url']);
                }

                // Загружаем новое изображение с правильным именем
                $data['image_url'] = $this->handleClientImageUpload($_FILES['image'], $id);
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

                    // Удаляем видеофайлы если есть
                    if (!empty($connectionToDelete['video_filename']) || !empty($connectionToDelete['yandex_disk_path'])) {
                        $this->deleteVideoFile(
                            $connectionToDelete['video_filename'] ?? null,
                            $connectionToDelete['yandex_disk_path'] ?? null
                        );
                    } else {
                    }
                } else {
                }

                $connectionModel->delete($connectionIdToDelete);
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

                        $videoResult = $this->handleVideoUpload($videoFile, $connection['shopping_center_id'] ?? null, $connectionId);

                        if ($videoResult) {

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

            // Получаем все связи клиента
            $connections = $connectionModel->getByClient($id);

            // Удаляем видеофайлы всех связей
            foreach ($connections as $connection) {
                $this->deleteVideoFile(
                    $connection['video_filename'] ?? null,
                    $connection['yandex_disk_path'] ?? null
                );
            }

            // УДАЛЯЕМ ВСЕ СВЯЗКИ КЛИЕНТА ВРУЧНУЮ (так как каскадного удаления нет)
            $connectionModel->removeByClient($id);

            // Удаляем изображение клиента если есть
            $client = $clientModel->find($id);
            if ($client && !empty($client['image_url'])) {
                $this->deleteOldClientImage($client['image_url']);
            }

            // Удаляем клиента
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

            // Сначала создаем запись чтобы получить ID
            $data = [
                'author_name' => $_POST['author_name'] ?? '',
                'author_position' => $_POST['author_position'] ?? '',
                'content' => $_POST['content'] ?? '',
                'author_avatar' => '', // Временно пустое значение
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            // Создаем запись и получаем ID
            $reviewId = $reviewModel->create($data);

            if ($reviewId) {
                // Теперь обрабатываем загрузку изображения с правильным именем
                if (isset($_FILES['author_avatar_file']) && $_FILES['author_avatar_file']['error'] === UPLOAD_ERR_OK) {
                    $avatarPath = $this->handleReviewImageUpload($_FILES['author_avatar_file'], $reviewId);

                    if ($avatarPath) {
                        // Обновляем запись с правильным путем к изображению
                        $reviewModel->update($reviewId, ['author_avatar' => $avatarPath]);
                    }
                } elseif (!empty($_POST['author_avatar'])) {
                    // Сохраняем URL если указан
                    $reviewModel->update($reviewId, ['author_avatar' => $_POST['author_avatar']]);
                }

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
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            // ПРОВЕРКА НА УДАЛЕНИЕ ТЕКУЩЕГО ИЗОБРАЖЕНИЯ
            $removeImage = isset($_POST['remove_avatar']) && $_POST['remove_avatar'] === 'on';

            if ($removeImage) {
                $data['author_avatar'] = '';
                // Удаляем старое изображение если есть
                if (!empty($item['author_avatar'])) {
                    $this->deleteOldReviewImage($item['author_avatar']);
                }
            }
            // ЗАГРУЗКА НОВОГО ИЗОБРАЖЕНИЯ
            else if (isset($_FILES['author_avatar_file']) && $_FILES['author_avatar_file']['error'] === UPLOAD_ERR_OK) {
                // Удаляем старое изображение если есть
                if (!empty($item['author_avatar'])) {
                    $this->deleteOldReviewImage($item['author_avatar']);
                }

                // Загружаем новое изображение с правильным именем
                $avatarPath = $this->handleReviewImageUpload($_FILES['author_avatar_file'], $id);
                if ($avatarPath) {
                    $data['author_avatar'] = $avatarPath;
                }
            }
            // ИСПОЛЬЗОВАНИЕ URL АВАТАРА
            else if (!empty($_POST['author_avatar'])) {
                $data['author_avatar'] = $_POST['author_avatar'];
            } else {
                // Сохраняем существующее изображение
                $data['author_avatar'] = $item['author_avatar'] ?? '';
            }

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

            // Сначала создаем запись чтобы получить ID
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'project_url' => $_POST['project_url'] ?? '',
                'tags' => $_POST['tags'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'image_url' => '' // Временно пустое значение
            ];

            // Создаем запись и получаем ID
            $projectId = $projectModel->create($data);

            if ($projectId) {
                // Теперь обрабатываем загрузку изображения с правильным именем
                if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                    $imagePath = $this->handleProjectImageUpload($_FILES['file'], $projectId);

                    if ($imagePath) {
                        // Обновляем запись с правильным путем к изображению
                        $projectModel->update($projectId, ['image_url' => $imagePath]);
                    }
                }

                header('Location: /admin.php?action=trislav_projects&success=1');
                exit;
            } else {
                // Обработка ошибки создания
                header('Location: /admin.php?action=trislav_projects&error=create_failed');
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
        $item = $projectModel->getProjectWithImage($id);

        if (!$item) {
            header('Location: /admin.php?action=trislav_projects&error=1');
            exit;
        }

        if ($_POST) {
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'project_url' => $_POST['project_url'] ?? '',
                'tags' => $_POST['tags'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            // ПРОВЕРКА НА УДАЛЕНИЕ ТЕКУЩЕГО ИЗОБРАЖЕНИЯ
            $removeImage = isset($_POST['remove_file']) && $_POST['remove_file'] === 'on';

            if ($removeImage) {
                $data['image_url'] = '';
                // Удаляем старое изображение если есть
                if (!empty($item['image_url'])) {
                    $this->deleteOldProjectImage($item['image_url']);
                }
            }
            // ЗАГРУЗКА НОВОГО ИЗОБРАЖЕНИЯ
            else if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                // Удаляем старое изображение если есть
                if (!empty($item['image_url'])) {
                    $this->deleteOldProjectImage($item['image_url']);
                }

                // Загружаем новое изображение с правильным именем
                $imagePath = $this->handleProjectImageUpload($_FILES['file'], $id);
                if ($imagePath) {
                    $data['image_url'] = $imagePath;
                }
            } else {
                // Сохраняем существующее изображение
                $data['image_url'] = $item['image_url'] ?? '';
            }

            if ($projectModel->update($id, $data)) {
                header('Location: /admin.php?action=trislav_projects&success=1');
                exit;
            } else {
                header('Location: /admin.php?action=trislav_projects&error=update_failed');
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

        if ($item) {
        }

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
            } else {
                // Резервный вариант если ID связки еще нет
                $safeName = preg_replace('/[^a-zA-Z0-9-_]/', '', pathinfo($file['name'], PATHINFO_FILENAME));
                $filename = time() . '_' . $safeName . '.' . $extension;
            }

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
                            // ВАЖНО: передаем ПЕРЕИМЕНОВАННЫЙ файл на Яндекс.Диск
                            $remoteFilename = $filename; // Используем то же имя, что и локально
                            $yandexDiskPath = "slides/{$shoppingCenterId}/{$remoteFilename}";


                            // Используем существующий метод, но передаем переименованный файл
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
    private function updateConnectionWithVideo($connectionId, $videoFilename, $yandexDiskPath) {

        $connectionModel = new TrislavGroupClientProject();

        if ($connectionId) {

            // Обновляем связь с видео информацией
            $result = $connectionModel->update($connectionId, [
                'video_filename' => $videoFilename,
                'yandex_disk_path' => $yandexDiskPath
            ]);


            return $connectionId;
        } else {
        }

        return null;
    }

    /**
     * Находит ID связи по клиенту и проекту
     */
    private function findConnectionId($clientId, $projectId) {

        $connectionModel = new TrislavGroupClientProject();
        $connection = $connectionModel->findByClientAndProject($clientId, $projectId);

        if ($connection) {
        } else {
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


            // Генерируем имя архива на основе названия ТЦ (транслит + дата)
            $translitTitle = $this->translit($shoppingCenter['title']);
            $currentDate = date('d_m_Y');
            $archiveName = $translitTitle . '_' . $currentDate . '.zip';


            // Получаем последовательность видео для скачивания
            $videoScheduleModel = new VideoSchedule();
            $downloadSequence = $videoScheduleModel->getDownloadSequence($shoppingCenterId);


            // Создаем временную папку
            $tempDir = ROOT_PATH . '/temp/tc_videos_' . time() . '_' . $shoppingCenterId;
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $videoFiles = [];

            // Обрабатываем каждое видео в последовательности
            foreach ($downloadSequence as $videoInfo) {
                $slotNumber = $videoInfo['slot_number'];
                $videoPath = null;

                // Если это реальный клиент (не заглушка)
                if (!$videoInfo['is_default']) {
                    // Пробуем скачать с Яндекс.Диска (приоритет 1)
                    if (!empty($videoInfo['yandex_disk_path'])) {
                        $videoPath = $this->downloadFromYandexDisk(
                            $videoInfo['yandex_disk_path'],
                            $tempDir,
                            $slotNumber
                        );
                    }
                    // Пробуем локальный файл (приоритет 2)
                    elseif (!empty($videoInfo['filename'])) {
                        $videoPath = $this->copyLocalVideo(
                            $videoInfo['filename'],
                            $tempDir,
                            $slotNumber
                        );
                    }
                    // Пробуем скачать по URL (приоритет 3)
                    elseif (!empty($videoInfo['video_url'])) {
                        $videoPath = $this->downloadVideoFromUrl(
                            $videoInfo['video_url'],
                            $tempDir,
                            $slotNumber
                        );
                    }
                }

                // Если видео не найдено или это заглушка - используем заглушку
                if (!$videoPath) {
                    $videoPath = $this->copyDefaultAd($tempDir, $slotNumber);
                }

                if ($videoPath) {
                    $videoFiles[] = $videoPath;
                } else {
                }
            }


            // Создаем архив
            if (!empty($videoFiles)) {
                $archivePath = $this->createNumberedArchive($videoFiles, $tempDir, $archiveName);

                // Отправляем архив
                $this->sendArchiveForDownload($archivePath, $archiveName);

                // Очищаем временные файлы ПОСЛЕ отправки архива
                $this->cleanupTempFiles($tempDir);

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

    /**
     * Транслитерация русского текста
     */
    private function translit($string) {
        $converter = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
            'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'sch', 'ь' => '', 'ы' => 'y', 'ъ' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
            'Е' => 'E', 'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
            'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Ch',
            'Ш' => 'Sh', 'Щ' => 'Sch', 'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        );

        $string = strtr($string, $converter);

        // Заменяем все не-ASCII символы и пробелы на подчеркивания
        $string = preg_replace('/[^a-zA-Z0-9_]/', '_', $string);

        // Убираем множественные подчеркивания
        $string = preg_replace('/_{2,}/', '_', $string);

        // Убираем подчеркивания в начале и конце
        $string = trim($string, '_');

        return $string;
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
    private function createNumberedArchive($files, $tempDir, $archiveName) {
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
    private function sendArchiveForDownload($archivePath, $archiveName) {
        if (!file_exists($archivePath)) {
            throw new Exception("Archive file not found: $archivePath");
        }

        // Очищаем все буферы вывода
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

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
    }

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
        $defaultVideosDir = './uploads/def_video/';


        // Проверяем существование директории
        if (!is_dir($defaultVideosDir)) {

            // Фолбэк на создание пустого файла
            $filename = sprintf("%05d", $counter) . '.mp4';
            $newPath = $tempDir . '/' . $filename;
            file_put_contents($newPath, '');
            return $newPath;
        }

        // Получаем список видео файлов
        $videoFiles = [];
        $allowedExtensions = ['mp4', 'avi', 'mov', 'mkv', 'wmv'];

        foreach ($allowedExtensions as $ext) {
            $pattern = $defaultVideosDir . '*.' . $ext;
            $files = glob($pattern);
            $videoFiles = array_merge($videoFiles, $files);
        }


        if (empty($videoFiles)) {

            // Фолбэк на создание пустого файла
            $filename = sprintf("%05d", $counter) . '.mp4';
            $newPath = $tempDir . '/' . $filename;
            file_put_contents($newPath, '');
            return $newPath;
        }

        // Выбираем случайное видео
        $randomIndex = array_rand($videoFiles);
        $selectedVideo = $videoFiles[$randomIndex];


        $filename = sprintf("%05d", $counter) . '.mp4';
        $newPath = $tempDir . '/' . $filename;

        // Копируем выбранное видео
        if (copy($selectedVideo, $newPath)) {
            return $newPath;
        } else {
            // Фолбэк на создание пустого файла
            file_put_contents($newPath, '');
            return $newPath;
        }
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

        $deletedCount = 0;

        // Удаляем с Яндекс.Диска если есть
        if (!empty($yandexDiskPath)) {
            try {
                $yandexConfig = require ROOT_PATH . '/config/yandex_disk.php';
                $diskService = new YandexDiskService($yandexConfig['token']);

                $deleteResult = $diskService->deleteFile($yandexDiskPath);

                if ($deleteResult) {
                    $deletedCount++;
                } else {
                }
            } catch (Exception $e) {
            }
        } else {
        }

        // Удаляем локальный файл если есть
        if (!empty($videoFilename)) {
            $localPath = ROOT_PATH . '/uploads/videos/' . $videoFilename;
            if (file_exists($localPath)) {
                if (unlink($localPath)) {
                    $deletedCount++;
                } else {
                }
            } else {
            }

            // Также удаляем временный файл если есть
            $tempPath = ROOT_PATH . '/uploads/videos/temp/' . $videoFilename;
            if (file_exists($tempPath)) {
                if (unlink($tempPath)) {
                    $deletedCount++;
                } else {
                }
            }
        } else {
        }


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

    private function deleteOldImage($imagePath) {
        if (!empty($imagePath)) {
            $fullPath = ROOT_PATH . $imagePath;
            if (file_exists($fullPath) && is_file($fullPath)) {
                if (unlink($fullPath)) {
                    return true;
                } else {
                }
            } else {
            }
        }
        return false;
    }

    // В /app/controllers/admin/AdminTrislavGroupController.php
    private function handleProjectImageUpload($file, $projectId = null) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = ROOT_PATH . '/uploads/projects/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

            // Генерируем имя файла на основе ID проекта
            if ($projectId) {
                $filename = 'project_' . $projectId . '.' . $extension;
            } else {
                // Временное имя для новых записей (до получения ID)
                $safeName = preg_replace('/[^a-zA-Z0-9-_]/', '', pathinfo($file['name'], PATHINFO_FILENAME));
                $filename = 'temp_project_' . time() . '_' . $safeName . '.' . $extension;
            }

            $filepath = $uploadDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                return '/uploads/projects/' . $filename;
            }
        }
        return '';
    }

    private function deleteOldProjectImage($imagePath) {
        if (!empty($imagePath)) {
            $fullPath = ROOT_PATH . $imagePath;
            if (file_exists($fullPath) && is_file($fullPath)) {
                // Также удаляем все возможные варианты имен для этого проекта
                $projectId = $this->extractProjectIdFromPath($imagePath);
                if ($projectId) {
                    $this->deleteAllProjectImages($projectId);
                } else {
                    unlink($fullPath);
                }
                return true;
            }
        }
        return false;
    }

    private function extractProjectIdFromPath($imagePath) {
        // Извлекаем ID из пути типа /uploads/projects/project_123.jpg
        if (preg_match('/project_(\d+)\./', $imagePath, $matches)) {
            return $matches[1];
        }
        return null;
    }

    private function deleteAllProjectImages($projectId) {
        $uploadDir = ROOT_PATH . '/uploads/projects/';
        $pattern = $uploadDir . 'project_' . $projectId . '.*';

        $files = glob($pattern);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        // Также удаляем временные файлы для этого проекта
        $tempPattern = $uploadDir . 'temp_project_*_' . $projectId . '.*';
        $tempFiles = glob($tempPattern);
        foreach ($tempFiles as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    public function projects_delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $projectModel = new TrislavGroupProject();
            $project = $projectModel->find($id);

            // Удаляем изображение если есть
            if (!empty($project['image_url'])) {
                $this->deleteOldProjectImage($project['image_url']);
            }

            $projectModel->delete($id);
        }
        header('Location: /admin.php?action=trislav_projects&success=1');
        exit;
    }

    private function handleClientImageUpload($file, $clientId = null) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = ROOT_PATH . '/uploads/clients/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

            // Генерируем имя файла на основе ID клиента
            if ($clientId) {
                $filename = 'client_' . $clientId . '.' . $extension;
            } else {
                // Временное имя для новых записей (до получения ID)
                $safeName = preg_replace('/[^a-zA-Z0-9-_]/', '', pathinfo($file['name'], PATHINFO_FILENAME));
                $filename = 'temp_client_' . time() . '_' . $safeName . '.' . $extension;
            }

            $filepath = $uploadDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                return '/uploads/clients/' . $filename;
            }
        }
        return '';
    }

    private function deleteOldClientImage($imagePath) {
        if (!empty($imagePath)) {
            $fullPath = ROOT_PATH . $imagePath;
            if (file_exists($fullPath) && is_file($fullPath)) {
                // Также удаляем все возможные варианты имен для этого клиента
                $clientId = $this->extractClientIdFromPath($imagePath);
                if ($clientId) {
                    $this->deleteAllClientImages($clientId);
                } else {
                    unlink($fullPath);
                }
                return true;
            }
        }
        return false;
    }

    private function extractClientIdFromPath($imagePath) {
        // Извлекаем ID из пути типа /uploads/clients/client_123.jpg
        if (preg_match('/client_(\d+)\./', $imagePath, $matches)) {
            return $matches[1];
        }
        return null;
    }

    private function deleteAllClientImages($clientId) {
        $uploadDir = ROOT_PATH . '/uploads/clients/';
        $pattern = $uploadDir . 'client_' . $clientId . '.*';

        $files = glob($pattern);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        // Также удаляем временные файлы для этого клиента
        $tempPattern = $uploadDir . 'temp_client_*_' . $clientId . '.*';
        $tempFiles = glob($tempPattern);
        foreach ($tempFiles as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    // В /app/controllers/admin/AdminTrislavGroupController.php
    private function handleReviewImageUpload($file, $reviewId = null) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = ROOT_PATH . '/uploads/reviews/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

            // Генерируем имя файла на основе ID отзыва
            if ($reviewId) {
                $filename = 'review_' . $reviewId . '.' . $extension;
            } else {
                // Временное имя для новых записей (до получения ID)
                $safeName = preg_replace('/[^a-zA-Z0-9-_]/', '', pathinfo($file['name'], PATHINFO_FILENAME));
                $filename = 'temp_review_' . time() . '_' . $safeName . '.' . $extension;
            }

            $filepath = $uploadDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                return '/uploads/reviews/' . $filename;
            }
        }
        return '';
    }

    private function deleteOldReviewImage($imagePath) {
        if (!empty($imagePath)) {
            $fullPath = ROOT_PATH . $imagePath;
            if (file_exists($fullPath) && is_file($fullPath)) {
                // Также удаляем все возможные варианты имен для этого отзыва
                $reviewId = $this->extractReviewIdFromPath($imagePath);
                if ($reviewId) {
                    $this->deleteAllReviewImages($reviewId);
                } else {
                    unlink($fullPath);
                }
                return true;
            }
        }
        return false;
    }

    private function extractReviewIdFromPath($imagePath) {
        // Извлекаем ID из пути типа /uploads/reviews/review_123.jpg
        if (preg_match('/review_(\d+)\./', $imagePath, $matches)) {
            return $matches[1];
        }
        return null;
    }

    private function deleteAllReviewImages($reviewId) {
        $uploadDir = ROOT_PATH . '/uploads/reviews/';
        $pattern = $uploadDir . 'review_' . $reviewId . '.*';

        $files = glob($pattern);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        // Также удаляем временные файлы для этого отзыва
        $tempPattern = $uploadDir . 'temp_review_*_' . $reviewId . '.*';
        $tempFiles = glob($tempPattern);
        foreach ($tempFiles as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    // В /app/controllers/admin/AdminTrislavGroupController.php
    public function reviews_delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {

            $reviewModel = new TrislavGroupReview();
            $review = $reviewModel->find($id);

            if ($review) {
                // Удаляем аватар если есть
                if (!empty($review['author_avatar'])) {
                    $this->deleteOldReviewImage($review['author_avatar']);
                }

                // Удаляем отзыв из БД
                $deleted = $reviewModel->delete($id);
            } else {
            }

        }

        header('Location: /admin.php?action=trislav_reviews&success=1');
        exit;
    }
}
?>