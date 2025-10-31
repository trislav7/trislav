<?php
class AdminTrislavGroupController extends AdminBaseController {

    private $contentModel;

    public function __construct() {
        parent::__construct();
        $this->contentModel = new TrislavGroupContent();
    }

    public function content() {
        $data = [
            'slides' => $this->contentModel->getAllByType('slide'),
            'reviews' => $this->contentModel->getAllByType('review'),
            'advantages' => $this->contentModel->getAllByType('advantage'),
            'clients' => $this->contentModel->getAllByType('client'),
            'projects' => $this->contentModel->getAllByType('project'),
            'title' => 'Управление контентом Трислав Групп',
            'current_action' => 'trislav_content'
        ];

        $this->view('admin/trislav_group_content', $data);
    }

    // КЛИЕНТЫ
    public function clients() {
        $clients = $this->contentModel->getAllByType('client');

        $this->view('admin/trislav_group_clients', [
            'title' => 'Управление клиентами Трислав Групп',
            'clients' => $clients,
            'current_action' => 'trislav_clients'
        ]);
    }

    public function clients_create() {
        if ($_POST) {
            $data = [
                'type' => 'client',
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'image_url' => $_POST['image_url'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $id = $this->contentModel->create($data);
            if ($id) {
                header('Location: /admin.php?action=trislav_clients&success=1');
                exit;
            }
        }

        $this->view('admin/trislav_group_clients_form', [
            'title' => 'Добавить клиента',
            'current_action' => 'trislav_clients',
            'item' => null
        ]);
    }

    public function clients_edit() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /admin.php?action=trislav_clients');
            exit;
        }

        $item = $this->contentModel->find($id);

        if (!$item) {
            header('Location: /admin.php?action=trislav_clients&error=1');
            exit;
        }

        if ($_POST) {
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'image_url' => $_POST['image_url'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if ($this->contentModel->update($id, $data)) {
                header('Location: /admin.php?action=trislav_clients&success=1');
                exit;
            }
        }

        $this->view('admin/trislav_group_clients_form', [
            'title' => 'Редактировать клиента',
            'current_action' => 'trislav_clients',
            'item' => $item
        ]);
    }

    public function clients_toggle() {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->contentModel->toggleStatus($id);
        }

        header('Location: /admin.php?action=trislav_clients');
        exit;
    }

    public function clients_delete() {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->contentModel->delete($id);
        }

        header('Location: /admin.php?action=trislav_clients&success=1');
        exit;
    }

    // ОТЗЫВЫ
    public function reviews() {
        $reviews = $this->contentModel->getAllByType('review');

        $this->view('admin/trislav_group_reviews', [
            'title' => 'Управление отзывами Трислав Групп',
            'reviews' => $reviews,
            'current_action' => 'trislav_reviews'
        ]);
    }

    public function reviews_create() {
        if ($_POST) {
            $data = [
                'type' => 'review',
                'title' => $_POST['author_name'] ?? '',
                'description' => $_POST['content'] ?? '',
                'author_position' => $_POST['author_position'] ?? '',
                'image_url' => $_POST['author_avatar'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $id = $this->contentModel->create($data);
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

        $item = $this->contentModel->find($id);

        if (!$item) {
            header('Location: /admin.php?action=trislav_reviews&error=1');
            exit;
        }

        if ($_POST) {
            $data = [
                'title' => $_POST['author_name'] ?? '',
                'description' => $_POST['content'] ?? '',
                'author_position' => $_POST['author_position'] ?? '',
                'image_url' => $_POST['author_avatar'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if ($this->contentModel->update($id, $data)) {
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
            $this->contentModel->toggleStatus($id);
        }

        header('Location: /admin.php?action=trislav_reviews');
        exit;
    }

    // ПРЕИМУЩЕСТВА
    public function advantages() {
        $advantages = $this->contentModel->getAllByType('advantage');

        $this->view('admin/trislav_group_advantages', [
            'title' => 'Управление преимуществами Трислав Групп',
            'advantages' => $advantages,
            'current_action' => 'trislav_advantages'
        ]);
    }

    public function advantages_create() {
        if ($_POST) {
            $data = [
                'type' => 'advantage',
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'icon_class' => $_POST['icon_class'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $id = $this->contentModel->create($data);
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

        $item = $this->contentModel->find($id);

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

            if ($this->contentModel->update($id, $data)) {
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
            $this->contentModel->toggleStatus($id);
        }

        header('Location: /admin.php?action=trislav_advantages');
        exit;
    }

    // ПРОЕКТЫ
    public function projects() {
        $projects = $this->contentModel->getAllByType('project');

        $this->view('admin/trislav_group_projects', [
            'title' => 'Управление проектами Трислав Групп',
            'projects' => $projects,
            'current_action' => 'trislav_projects'
        ]);
    }

    public function projects_create() {
        if ($_POST) {
            $data = [
                'type' => 'project',
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'image_url' => $_POST['image_url'] ?? '',
                'project_url' => $_POST['project_url'] ?? '',
                'tags' => $_POST['tags'] ?? '',
                'order_index' => $_POST['order_index'] ?? 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $id = $this->contentModel->create($data);
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

        $item = $this->contentModel->find($id);

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

            if ($this->contentModel->update($id, $data)) {
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
            $this->contentModel->toggleStatus($id);
        }

        header('Location: /admin.php?action=trislav_projects');
        exit;
    }
}
?>