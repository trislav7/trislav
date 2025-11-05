<?php
// app/views/admin/trislav_group_shopping_centers.php
$title = $title ?? 'Управление торговыми центрами';
$centers = $centers ?? [];
?>
<?php include(ROOT_PATH . '/app/views/layouts/admin.php'); ?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light"><?= htmlspecialchars($title) ?></h1>
        <a href="/admin.php?action=trislav_shopping_centers_create" class="btn btn-success">
            <i class="fas fa-plus"></i> Добавить ТЦ
        </a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Операция выполнена успешно!</div>
    <?php endif; ?>

    <div class="card bg-dark border-light">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Адрес</th>
                            <th>Порядок</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($centers as $center): ?>
                        <tr>
                            <td><?= $center['id'] ?></td>
                            <td><?= htmlspecialchars($center['title']) ?></td>
                            <td><?= htmlspecialchars($center['address']) ?></td>
                            <td><?= $center['order_index'] ?></td>
                            <td>
                                <span class="badge bg-<?= $center['is_active'] ? 'success' : 'secondary' ?>">
                                    <?= $center['is_active'] ? 'Активен' : 'Неактивен' ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="/admin.php?action=trislav_shopping_centers_edit&id=<?= $center['id'] ?>" 
                                       class="btn btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/admin.php?action=trislav_shopping_centers_toggle&id=<?= $center['id'] ?>" 
                                       class="btn btn-outline-<?= $center['is_active'] ? 'secondary' : 'success' ?>">
                                        <i class="fas fa-<?= $center['is_active'] ? 'eye-slash' : 'eye' ?>"></i>
                                    </a>
                                    <a href="/admin.php?action=trislav_shopping_centers_delete&id=<?= $center['id'] ?>" 
                                       class="btn btn-outline-danger" 
                                       onclick="return confirm('Удалить торговый центр?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>