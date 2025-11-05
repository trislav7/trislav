<?php
ob_start();
?>

<div class="space-y-6">
    <h1 class="text-3xl font-bold text-highlight"><?= $title ?></h1>

    <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-light font-semibold mb-3">Заголовок *</label>
                <input type="text" name="title" value="<?= $item['title'] ?? '' ?>" required
                       class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"
                       placeholder="Например: Формат видео, Длительность ролика...">
            </div>

            <div>
                <label class="block text-light font-semibold mb-3">Описание *</label>
                <textarea name="description" rows="3" required
                          class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"
                          placeholder="Подробное описание требования..."><?= $item['description'] ?? '' ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-light font-semibold mb-3">Тип требования *</label>
                    <select name="type" required class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                        <option value="main" <?= isset($item['type']) && $item['type'] == 'main' ? 'selected' : '' ?> class="bg-primary">Основное требование</option>
                        <option value="additional" <?= isset($item['type']) && $item['type'] == 'additional' ? 'selected' : '' ?> class="bg-primary">Дополнительная рекомендация</option>
                    </select>
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Порядок отображения</label>
                    <input type="number" name="sort_order" value="<?= $item['sort_order'] ?? 0 ?>"
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" 
                           <?= isset($item['is_active']) ? ($item['is_active'] ? 'checked' : '') : 'checked' ?>
                           class="mr-3 w-4 h-4 text-highlight bg-primary border-highlight/30 rounded focus:ring-highlight focus:ring-2">
                    <span class="text-light">Активное требование</span>
                </label>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t border-highlight/30">
                <a href="/admin.php?action=led_requirements" 
                   class="bg-primary text-light px-6 py-3 rounded-lg border border-highlight/30 hover:bg-highlight/20 transition-all duration-300 no-underline">
                    Отмена
                </a>
                <button type="submit" 
                        class="bg-highlight text-primary font-semibold px-6 py-3 rounded-lg border-2 border-highlight hover:bg-transparent hover:text-highlight transition-all duration-300">
                    <?= isset($item) ? 'Обновить требование' : 'Создать требование' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>