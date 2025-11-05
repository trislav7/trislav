<?php
// app/views/admin/trislav_group_shopping_centers_form.php
$title = $title ?? 'Форма торгового центра';
$item = $item ?? null;
?>
<?php include(ROOT_PATH . '/app/views/layouts/admin.php'); ?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light"><?= htmlspecialchars($title) ?></h1>
        <a href="/admin.php?action=trislav_shopping_centers" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Назад к списку
        </a>
    </div>

    <div class="card bg-dark border-light">
        <div class="card-body">
            <form method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-light">Название ТЦ *</label>
                            <input type="text" name="title" class="form-control bg-secondary border-light text-light" 
                                   value="<?= htmlspecialchars($item['title'] ?? '') ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-light">Порядок отображения</label>
                            <input type="number" name="order_index" class="form-control bg-secondary border-light text-light" 
                                   value="<?= $item['order_index'] ?? 0 ?>">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-light">Адрес *</label>
                    <textarea name="address" class="form-control bg-secondary border-light text-light" 
                              rows="3" required><?= htmlspecialchars($item['address'] ?? '') ?></textarea>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" 
                           <?= isset($item['is_active']) && $item['is_active'] ? 'checked' : '' ?>>
                    <label class="form-check-label text-light" for="is_active">Активен</label>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Сохранить
                </button>
            </form>
        </div>
    </div>
</div>