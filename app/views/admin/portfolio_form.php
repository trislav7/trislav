<?php ob_start(); ?>

    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-highlight"><?= $title ?></h1>

        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label class="block text-light font-semibold mb-3">Название работы *</label>
                    <input type="text" name="title" value="<?= $portfolio['title'] ?? '' ?>" required
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500">
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Описание</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"><?= $portfolio['description'] ?? '' ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-light font-semibold mb-3">Категория *</label>
                        <select name="category" required class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                            <option value="" class="bg-primary">Выберите категорию</option>
                            <option value="led" <?= isset($portfolio['category']) && $portfolio['category'] == 'led' ? 'selected' : '' ?> class="bg-primary">LED экраны</option>
                            <option value="video" <?= isset($portfolio['category']) && $portfolio['category'] == 'video' ? 'selected' : '' ?> class="bg-primary">Видео и логотипы</option>
                            <option value="btl" <?= isset($portfolio['category']) && $portfolio['category'] == 'btl' ? 'selected' : '' ?> class="bg-primary">BTL мероприятия</option>
                            <option value="branding" <?= isset($portfolio['category']) && $portfolio['category'] == 'branding' ? 'selected' : '' ?> class="bg-primary">Брендинг</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-light font-semibold mb-3">Клиент</label>
                        <input type="text" name="client_name" value="<?= $portfolio['client_name'] ?? '' ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-light font-semibold mb-3">Дата проекта</label>
                        <input type="date" name="project_date" value="<?= $portfolio['project_date'] ?? date('Y-m-d') ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                    </div>

                    <div>
                        <label class="block text-light font-semibold mb-3">Изображение</label>
                        <input type="file" name="image" accept="image/*"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-highlight file:text-primary hover:file:bg-transparent hover:file:text-highlight hover:file:border hover:file:border-highlight">
                        <?php if (isset($portfolio['image']) && $portfolio['image']): ?>
                            <p class="text-gray-400 text-sm mt-2">
                                <i class="fas fa-image mr-1"></i>Текущее изображение: <?= $portfolio['image'] ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Теги (через запятую) *</label>
                    <input type="text" name="tags" value="<?= isset($portfolio['tags']) ? implode(", ", json_decode($portfolio['tags'], true)) : '' ?>" required
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"
                           placeholder="Размер: 12x6м, HD качество">
                    <p class="text-gray-400 text-sm mt-1">
                        Первый тег будет слева, второй - справа. Максимум 2 тега для красивого отображения.
                    </p>
                </div>

                <div class="flex items-center">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" <?= isset($portfolio['is_active']) && $portfolio['is_active'] ? 'checked' : 'checked' ?> class="mr-3 w-4 h-4 text-highlight bg-primary border-highlight/30 rounded focus:ring-highlight focus:ring-2">
                        <span class="text-light">Активная работа</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-highlight/30">
                    <a href="/admin.php?action=portfolio_list" class="bg-primary text-light px-6 py-3 rounded-lg border border-highlight/30 hover:bg-highlight/20 transition-all duration-300 no-underline">
                        Отмена
                    </a>
                    <button type="submit" class="bg-highlight text-primary font-semibold px-6 py-3 rounded-lg border-2 border-highlight hover:bg-transparent hover:text-highlight transition-all duration-300">
                        Сохранить работу
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>