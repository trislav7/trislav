<?php
// app/views/admin/trislav_group_projects_form.php (обновленная)
ob_start();
$isEdit = isset($item) && $item;
?>

    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-highlight"><?= $isEdit ? 'Редактировать проект' : 'Добавить проект' ?></h1>
            <a href="/admin.php?action=trislav_projects" class="bg-gray-500/20 text-gray-300 font-semibold py-2 px-4 rounded-lg border-2 border-gray-500 transition-all duration-300 hover:bg-gray-500 hover:text-light no-underline">
                ← Назад к списку
            </a>
        </div>

        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Скрытое поле для сохранения старого изображения -->
                <?php if ($isEdit && $item['image_url']): ?>
                    <input type="hidden" name="old_image" value="<?= htmlspecialchars($item['image_url']) ?>">
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block mb-2 font-medium text-light">Название проекта *</label>
                        <input type="text" id="title" name="title" required
                               value="<?= htmlspecialchars($item['title'] ?? '') ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                               placeholder="Например: Трислав Медиа">
                    </div>

                    <div>
                        <label for="order_index" class="block mb-2 font-medium text-light">Порядок отображения</label>
                        <input type="number" id="order_index" name="order_index"
                               value="<?= $item['order_index'] ?? 0 ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                    </div>
                </div>

                <div>
                    <label for="description" class="block mb-2 font-medium text-light">Описание проекта *</label>
                    <textarea id="description" name="description" rows="4" required
                              class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                              placeholder="Подробное описание проекта..."><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
                </div>

                <!-- Загрузка изображения -->
                <div>
                    <?php
                    $uploadParams = [
                            'label' => 'Изображение проекта',
                            'fieldName' => 'image',
                            'currentFile' => $item['image_url'] ?? '',
                            'accept' => 'image/*',
                            'previewId' => 'imagePreview'
                    ];
                    include __DIR__ . '/components/file_upload.php';
                    ?>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="project_url" class="block mb-2 font-medium text-light">URL проекта</label>
                        <input type="url" id="project_url" name="project_url"
                               value="<?= htmlspecialchars($item['project_url'] ?? '') ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                               placeholder="https://example.com">
                    </div>
                </div>

                <div>
                    <label for="tags" class="block mb-2 font-medium text-light">Теги (через запятую)</label>
                    <input type="text" id="tags" name="tags"
                           value="<?= htmlspecialchars($item['tags'] ?? '') ?>"
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                           placeholder="Реклама, Маркетинг, Брендинг">
                    <p class="text-gray-400 text-sm mt-1">
                        Укажите теги через запятую для категоризации проектов
                    </p>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active"
                            <?= ($item['is_active'] ?? 1) ? 'checked' : '' ?>
                           class="w-4 h-4 text-highlight bg-primary border-highlight/30 rounded focus:ring-highlight focus:ring-2">
                    <label for="is_active" class="ml-2 text-light">Активный (отображается на сайте)</label>
                </div>

                <div class="flex space-x-4 pt-4">
                    <button type="submit" class="bg-highlight text-primary font-semibold py-3 px-8 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight">
                        <?= $isEdit ? 'Обновить' : 'Создать' ?>
                    </button>
                    <a href="/admin.php?action=trislav_projects" class="bg-gray-500/20 text-gray-300 font-semibold py-3 px-8 rounded-lg border-2 border-gray-500 transition-all duration-300 hover:bg-gray-500 hover:text-light no-underline">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>