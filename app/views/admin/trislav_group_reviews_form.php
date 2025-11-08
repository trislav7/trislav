<?php
ob_start();
$isEdit = isset($item) && $item;
?>

    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-highlight"><?= $isEdit ? 'Редактировать отзыв' : 'Добавить отзыв' ?></h1>
            <a href="/admin.php?action=trislav_reviews" class="bg-gray-500/20 text-gray-300 font-semibold py-2 px-4 rounded-lg border-2 border-gray-500 transition-all duration-300 hover:bg-gray-500 hover:text-light no-underline">
                ← Назад к списку
            </a>
        </div>

        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-light font-semibold mb-3">Имя автора *</label>
                        <input type="text" name="author_name" required
                               value="<?= htmlspecialchars($item['author_name'] ?? '') ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500">
                    </div>

                    <div>
                        <label class="block text-light font-semibold mb-3">Должность/Компания</label>
                        <input type="text" name="author_position"
                               value="<?= htmlspecialchars($item['author_position'] ?? '') ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500">
                    </div>
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Текст отзыва *</label>
                    <textarea name="content" rows="4" required
                              class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"
                              placeholder="Текст отзыва..."><?= htmlspecialchars($item['content'] ?? '') ?></textarea>
                </div>

                <!-- БЛОК ДЛЯ АВАТАРА С КОМПОНЕНТОМ -->
                <div>
                    <?php
                    $currentImage = $item['author_avatar'] ?? '';

                    // Переменные для компонента
                    $fieldName = 'author_avatar_file';
                    $currentFile = $currentImage ? $currentImage : '';
                    $label = 'Аватар автора';
                    $accept = 'image/*';
                    $previewId = 'reviewAvatarPreview';

                    // Подключаем компонент
                    $componentPath = __DIR__ . '/components/file_upload.php';
                    if (file_exists($componentPath)) {
                        include $componentPath;
                    } else {
                        // Fallback если компонент не найден
                        debug_log("Компонент file_upload.php не найден по пути: " . $componentPath);
                        ?>
                        <label class="block text-light font-semibold mb-3">Аватар автора</label>
                        <input type="file" name="author_avatar_file" accept="image/*"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-highlight file:text-primary hover:file:bg-transparent hover:file:text-highlight hover:file:border hover:file:border-highlight">
                        <?php if (isset($item['author_avatar']) && $item['author_avatar']): ?>
                            <p class="text-gray-400 text-sm mt-2">
                                <i class="fas fa-image mr-1"></i>Текущий аватар: <?= $item['author_avatar'] ?>
                            </p>
                        <?php endif; ?>
                        <?php
                    }
                    ?>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-light font-semibold mb-3">URL аватара</label>
                        <input type="url" name="author_avatar"
                               value="<?= htmlspecialchars($item['author_avatar'] ?? '') ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"
                               placeholder="https://example.com/avatar.jpg">
                        <p class="text-gray-400 text-sm mt-1">Укажите URL или загрузите файл выше</p>
                    </div>

                    <div>
                        <label class="block text-light font-semibold mb-3">Порядок отображения</label>
                        <input type="number" name="order_index"
                               value="<?= $item['order_index'] ?? 0 ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                    </div>
                </div>

                <div class="flex items-center">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                                <?= ($item['is_active'] ?? 1) ? 'checked' : 'checked' ?>
                               class="mr-3 w-4 h-4 text-highlight bg-primary border-highlight/30 rounded focus:ring-highlight focus:ring-2">
                        <span class="text-light">Активный (отображается на сайте)</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-highlight/30">
                    <a href="/admin.php?action=trislav_reviews"
                       class="bg-primary text-light px-6 py-3 rounded-lg border border-highlight/30 hover:bg-highlight/20 transition-all duration-300 no-underline">
                        Отмена
                    </a>
                    <button type="submit"
                            class="bg-highlight text-primary font-semibold px-6 py-3 rounded-lg border-2 border-highlight hover:bg-transparent hover:text-highlight transition-all duration-300">
                        <?= $isEdit ? 'Обновить отзыв' : 'Создать отзыв' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>