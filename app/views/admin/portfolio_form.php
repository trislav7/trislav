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

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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

                    <div>
                        <label class="block text-light font-semibold mb-3">Дата проекта</label>
                        <input type="date" name="project_date" value="<?= $portfolio['project_date'] ?? date('Y-m-d') ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">


                    <div>
                        <?php
                        $currentImage = $portfolio['image'] ?? '';

                        // Переменные для компонента
                        $fieldName = 'image';
                        $currentFile = $currentImage ? $currentImage : '';
                        $label = 'Изображение работы';
                        $accept = 'image/*';
                        $previewId = 'portfolioImagePreview';

                        // Подключаем компонент
                        $componentPath = __DIR__ . '/components/file_upload.php';
                        if (file_exists($componentPath)) {
                            include $componentPath;
                        } else {
                            // Fallback на старую версию если компонент не найден
                            debug_log("Компонент file_upload.php не найден по пути: " . $componentPath);
                            ?>
                            <label class="block text-light font-semibold mb-3">Изображение</label>
                            <input type="file" name="image" accept="image/*"
                                   class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-highlight file:text-primary hover:file:bg-transparent hover:file:text-highlight hover:file:border hover:file:border-highlight">
                            <?php if (isset($portfolio['image']) && $portfolio['image']): ?>
                                <p class="text-gray-400 text-sm mt-2">
                                    <i class="fas fa-image mr-1"></i>Текущее изображение: /<?= $portfolio['image'] ?>
                                </p>
                            <?php endif; ?>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <!-- СЕКЦИЯ ДЛЯ ВИДЕО -->
                <div class="border-t border-highlight/30 pt-6">
                    <h3 class="text-xl font-bold text-highlight mb-4">Видео материал</h3>

                    <!-- Поле для видео URL -->
                    <div class="mb-6">
                        <label class="block text-light font-semibold mb-3">Ссылка на видео (YouTube/Vimeo)</label>
                        <input type="url" name="video_url" value="<?= $portfolio['video_url'] ?? '' ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"
                               placeholder="https://youtube.com/watch?v=...">
                        <p class="text-gray-400 text-sm mt-1">
                            ИЛИ загрузите видео файл ниже. Приоритет у файла.
                        </p>
                    </div>

                    <!-- Загрузка видео файла -->
                    <div class="mb-6">
                        <label class="block text-light font-semibold mb-3">Видео файл</label>
                        <input type="file" name="video_file" accept="video/*"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                        <p class="text-gray-400 text-sm mt-1">
                            Макс. размер: 500MB. Поддерживаемые форматы: MP4, AVI, MOV, MKV
                            <br><span class="text-highlight">Видео сохраняется локально на сервере</span>
                        </p>
                    </div>

                    <!-- Информация о текущем видео -->
                    <?php if (!empty($portfolio['video_url']) || !empty($portfolio['video_filename'])): ?>
                        <div class="bg-primary/50 rounded-lg p-4 mb-4">
                            <h4 class="font-semibold text-highlight mb-2">Текущее видео:</h4>
                            <?php if (!empty($portfolio['video_url'])): ?>
                                <p class="text-light">URL: <?= htmlspecialchars($portfolio['video_url']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($portfolio['video_filename'])): ?>
                                <p class="text-light">Файл: <?= htmlspecialchars($portfolio['video_filename']) ?></p>
                                <p class="text-gray-400 text-sm">
                                    <i class="fas fa-server mr-1"></i>Хранится локально на сервере
                                </p>
                            <?php endif; ?>

                            <label class="flex items-center mt-3">
                                <input type="checkbox" name="remove_video" value="on"
                                       class="mr-3 w-4 h-4 text-red-500 bg-primary border-red-500/30 rounded focus:ring-red-500 focus:ring-2">
                                <span class="text-red-400">Удалить текущее видео</span>
                            </label>
                        </div>
                    <?php endif; ?>
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