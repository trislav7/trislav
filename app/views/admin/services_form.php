<?php
// app/views/admin/services_form.php - обновленная версия
ob_start();
?>

    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-highlight"><?= $title ?></h1>

        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
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

                <!-- SVG иконка -->
                <div>
                    <label class="block text-light font-semibold mb-3">SVG иконка</label>
                    <textarea name="icon_svg" rows="6"
                              class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500 font-mono text-sm"
                              placeholder='&lt;svg class="w-8 h-8 text-highlight" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"&gt;...&lt;/svg&gt;'><?= htmlspecialchars($service['icon_svg'] ?? '') ?></textarea>
                    <p class="text-gray-400 text-sm mt-1">
                        Вставьте SVG код иконки. Иконка будет отображаться размером 32x32px с цветом text-highlight
                    </p>
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Краткое описание *</label>
                    <textarea name="short_description" rows="2" required
                              class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"><?= $service['short_description'] ?? '' ?></textarea>
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Полное описание</label>
                    <textarea name="description" rows="4"
                              class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"><?= $service['description'] ?? '' ?></textarea>
                </div>

                <!-- Особенности (список) -->
                <div>
                    <label class="block text-light font-semibold mb-3">Особенности (каждая с новой строки) *</label>
                    <textarea name="features" rows="6" required
                              class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"><?= isset($service['features']) ? implode("\n", json_decode($service['features'], true)) : '' ?></textarea>
                    <p class="text-gray-400 text-sm mt-1">
                        Каждая особенность должна быть на новой строке. Будет отображаться в виде списка с галочками.
                    </p>
                </div>

                <!-- Теги -->
                <div>
                    <label class="block text-light font-semibold mb-3">Теги (через запятую) *</label>
                    <input type="text" name="tags" value="<?= isset($service['tags']) ? implode(", ", json_decode($service['tags'], true)) : '' ?>" required
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"
                           placeholder="Full HD, Анимация, Моушн-дизайн, Color Grading">
                    <p class="text-gray-400 text-sm mt-1">
                        Укажите теги через запятую. Они будут отображаться как цветные метки под списком особенностей.
                    </p>
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