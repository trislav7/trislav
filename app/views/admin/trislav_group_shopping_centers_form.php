<?php
// app/views/admin/trislav_group_shopping_centers_form.php
ob_start();
?>

    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-highlight"><?= $title ?? 'Форма торгового центра' ?></h1>

        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <form method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-light font-semibold mb-3">Название ТЦ *</label>
                        <input type="text" name="title" value="<?= htmlspecialchars($item['title'] ?? '') ?>" required
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                    </div>

                    <div>
                        <label class="block text-light font-semibold mb-3">Порядок отображения</label>
                        <input type="number" name="order_index" value="<?= $item['order_index'] ?? 0 ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                    </div>
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Адрес *</label>
                    <textarea name="address" rows="3" required
                              class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"><?= htmlspecialchars($item['address'] ?? '') ?></textarea>
                </div>

                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                                <?= isset($item['is_active']) && $item['is_active'] ? 'checked' : 'checked' ?>
                               class="mr-3 w-4 h-4 text-highlight bg-primary border-highlight/30 rounded focus:ring-highlight focus:ring-2">
                        <span class="text-light">Активный</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-highlight/30">
                    <a href="/admin.php?action=trislav_shopping_centers"
                       class="bg-primary text-light px-6 py-3 rounded-lg border border-highlight/30 hover:bg-highlight/20 transition-all duration-300 no-underline">
                        Отмена
                    </a>
                    <button type="submit"
                            class="bg-highlight text-primary font-semibold px-6 py-3 rounded-lg border-2 border-highlight hover:bg-transparent hover:text-highlight transition-all duration-300">
                        Сохранить торговый центр
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>