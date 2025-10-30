<?php ob_start(); ?>

    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-highlight"><?= $title ?></h1>

        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <form method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-light font-semibold mb-3">Название услуги *</label>
                        <input type="text" name="title" value="<?= $service['title'] ?? '' ?>" required
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500">
                    </div>

                    <div>
                        <label class="block text-light font-semibold mb-3">Категория *</label>
                        <select name="category" required class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                            <option value="" class="bg-primary">Выберите категорию</option>
                            <option value="led" <?= isset($service['category']) && $service['category'] == 'led' ? 'selected' : '' ?> class="bg-primary">LED экраны</option>
                            <option value="video" <?= isset($service['category']) && $service['category'] == 'video' ? 'selected' : '' ?> class="bg-primary">Видео и логотипы</option>
                            <option value="btl" <?= isset($service['category']) && $service['category'] == 'btl' ? 'selected' : '' ?> class="bg-primary">BTL мероприятия</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Краткое описание</label>
                    <input type="text" name="short_description" value="<?= $service['short_description'] ?? '' ?>"
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500">
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Полное описание</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"><?= $service['description'] ?? '' ?></textarea>
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Иконка (Font Awesome класс)</label>
                    <input type="text" name="icon" value="<?= $service['icon'] ?? 'fas fa-star' ?>"
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"
                           placeholder="fas fa-video">
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Особенности (каждая с новой строки)</label>
                    <textarea name="features" rows="4" class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"><?= isset($service['features']) ? implode("\n", json_decode($service['features'], true)) : '' ?></textarea>
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Теги (через запятую)</label>
                    <input type="text" name="tags" value="<?= isset($service['tags']) ? implode(", ", json_decode($service['tags'], true)) : '' ?>"
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-light font-semibold mb-3">Порядок отображения</label>
                        <input type="number" name="order_index" value="<?= $service['order_index'] ?? 0 ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                    </div>

                    <div class="flex items-center space-x-4 pt-8">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" <?= isset($service['is_active']) && $service['is_active'] ? 'checked' : 'checked' ?> class="mr-3 w-4 h-4 text-highlight bg-primary border-highlight/30 rounded focus:ring-highlight focus:ring-2">
                            <span class="text-light">Активная услуга</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-highlight/30">
                    <a href="/admin.php?action=services_list" class="bg-primary text-light px-6 py-3 rounded-lg border border-highlight/30 hover:bg-highlight/20 transition-all duration-300 no-underline">
                        Отмена
                    </a>
                    <button type="submit" class="bg-highlight text-primary font-semibold px-6 py-3 rounded-lg border-2 border-highlight hover:bg-transparent hover:text-highlight transition-all duration-300">
                        Сохранить услугу
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>