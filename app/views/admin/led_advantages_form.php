<?php
ob_start();
$current_category = $current_category ?? 'led';
?>

    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-highlight"><?= $title ?></h1>

        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <form method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-light font-semibold mb-3">Заголовок *</label>
                        <input type="text" name="title" value="<?= $item['title'] ?? '' ?>" required
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"
                               placeholder="Например: Опытная команда">
                    </div>

                    <div>
                        <label class="block text-light font-semibold mb-3">Категория *</label>
                        <select name="category" required class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                            <option value="led" <?= (isset($item['category']) ? $item['category'] : $current_category) === 'led' ? 'selected' : '' ?>>LED преимущества</option>
                            <option value="btl" <?= (isset($item['category']) ? $item['category'] : $current_category) === 'btl' ? 'selected' : '' ?>>BTL преимущества</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Описание *</label>
                    <textarea name="description" rows="3" required
                              class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"
                              placeholder="Краткое описание преимущества..."><?= $item['description'] ?? '' ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-light font-semibold mb-3">SVG иконка</label>
                        <textarea name="icon_svg" rows="4"
                                  class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500 font-mono text-sm"
                                  placeholder='<i class="fas fa-users text-2xl text-highlight"></i> или SVG код'><?= htmlspecialchars($item['icon_svg'] ?? '') ?></textarea>
                        <p class="text-gray-400 text-sm mt-1">
                            Можно использовать Font Awesome (как выше) или SVG код. Иконка будет отображаться в круге.
                        </p>
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
                        <span class="text-light">Активное преимущество</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-highlight/30">
                    <a href="/admin.php?action=led_advantages&category=<?= $current_category ?>"
                       class="bg-primary text-light px-6 py-3 rounded-lg border border-highlight/30 hover:bg-highlight/20 transition-all duration-300 no-underline">
                        Отмена
                    </a>
                    <button type="submit"
                            class="bg-highlight text-primary font-semibold px-6 py-3 rounded-lg border-2 border-highlight hover:bg-transparent hover:text-highlight transition-all duration-300">
                        <?= isset($item) ? 'Обновить преимущество' : 'Создать преимущество' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>