<?php
ob_start(); 
$isEdit = isset($item) && $item;
?>

<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-highlight"><?= $isEdit ? 'Редактировать клиента' : 'Добавить клиента' ?></h1>
        <a href="/admin.php?action=trislav_clients" class="bg-gray-500/20 text-gray-300 font-semibold py-2 px-4 rounded-lg border-2 border-gray-500 transition-all duration-300 hover:bg-gray-500 hover:text-light no-underline">
            ← Назад к списку
        </a>
    </div>

    <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
        <form method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block mb-2 font-medium text-light">Название компании *</label>
                    <input type="text" id="title" name="title" required
                           value="<?= htmlspecialchars($item['title'] ?? '') ?>"
                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                </div>

                <div>
                    <label for="order_index" class="block mb-2 font-medium text-light">Порядок отображения</label>
                    <input type="number" id="order_index" name="order_index"
                           value="<?= $item['order_index'] ?? 0 ?>"
                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                </div>
            </div>

            <div>
                <label for="description" class="block mb-2 font-medium text-light">Описание</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                          placeholder="Краткое описание компании..."><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
            </div>

            <div>
                <label for="image_url" class="block mb-2 font-medium text-light">URL изображения</label>
                <input type="url" id="image_url" name="image_url"
                       value="<?= htmlspecialchars($item['image_url'] ?? '') ?>"
                       class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                       placeholder="https://example.com/image.jpg">
            </div>

            <div class="flex items-center">
                <input type="checkbox" id="is_active" name="is_active" 
                       <?= ($item['is_active'] ?? 1) ? 'checked' : '' ?>
                       class="w-4 h-4 text-highlight bg-white/10 border-white/20 rounded focus:ring-highlight focus:ring-2">
                <label for="is_active" class="ml-2 text-light">Активный (отображается на сайте)</label>
            </div>

            <div class="flex space-x-4 pt-4">
                <button type="submit" class="bg-highlight text-primary font-semibold py-3 px-8 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight">
                    <?= $isEdit ? 'Обновить' : 'Создать' ?>
                </button>
                <a href="/admin.php?action=trislav_clients" class="bg-gray-500/20 text-gray-300 font-semibold py-3 px-8 rounded-lg border-2 border-gray-500 transition-all duration-300 hover:bg-gray-500 hover:text-light no-underline">
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
