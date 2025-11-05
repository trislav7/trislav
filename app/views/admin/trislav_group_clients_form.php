<?php
ob_start();
$isEdit = isset($item) && $item;
$tariffs = $tariffs ?? [];
?>

    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-highlight"><?= $isEdit ? 'Редактировать клиента' : 'Добавить клиента' ?></h1>
            <a href="/admin.php?action=trislav_clients" class="bg-gray-500/20 text-gray-300 font-semibold py-2 px-4 rounded-lg border-2 border-gray-500 transition-all duration-300 hover:bg-gray-500 hover:text-light no-underline">
                ← Назад к списку
            </a>
        </div>

        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Основная информация -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block mb-2 font-medium text-light">Название *</label>
                        <input type="text" id="title" name="title" required
                               value="<?= htmlspecialchars($item['title'] ?? '') ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                               placeholder="Название клиента">
                    </div>

                    <div>
                        <label for="order_index" class="block mb-2 font-medium text-light">Порядок отображения</label>
                        <input type="number" id="order_index" name="order_index"
                               value="<?= $item['order_index'] ?? 0 ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                    </div>
                </div>

                <div>
                    <label for="description" class="block mb-2 font-medium text-light">Описание</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                              placeholder="Описание клиента..."><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
                </div>

                <div>
                    <label for="image" class="block mb-2 font-medium text-light">Изображение клиента</label>
                    <input type="file" id="image" name="image"
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-highlight file:text-primary hover:file:bg-highlight/80"
                           accept="image/*">
                    <?php if (!empty($item['image_url'])): ?>
                        <div class="mt-2">
                            <p class="text-gray-400 text-sm">Текущее изображение:</p>
                            <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="Current image" class="mt-2 rounded-lg max-w-xs border border-highlight/30">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active"
                            <?= ($item['is_active'] ?? 1) ? 'checked' : '' ?>
                           class="w-4 h-4 text-highlight bg-primary border-highlight/30 rounded focus:ring-highlight focus:ring-2">
                    <label for="is_active" class="ml-2 text-light">Активный (отображается на сайте)</label>
                </div>

                <!-- Связки с проектами и услугами -->
                <div class="border-t border-highlight/30 pt-6">
                    <h3 class="text-xl font-bold text-highlight mb-4">Связки с проектами и услугами</h3>

                    <div id="connections-container" class="space-y-4">
                        <?php if (!empty($connections)): ?>
                            <?php foreach ($connections as $index => $connection): ?>
                                <div class="connection-item bg-primary rounded-lg p-4 border border-highlight/20">
                                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                        <!-- Проект -->
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-light">Проект *</label>
                                            <select name="connections[<?= $index ?>][project_id]" class="connection-project w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight" required>
                                                <option value="">Выберите проект</option>
                                                <?php foreach ($projects as $project): ?>
                                                    <option value="<?= $project['id'] ?>"
                                                            <?= ($connection['id_project'] ?? '') == $project['id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($project['title']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- Услуга -->
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-light">Услуга</label>
                                            <select name="connections[<?= $index ?>][service_id]" class="connection-service w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight">
                                                <option value="">Выберите услугу</option>
                                                <?php foreach ($services as $service): ?>
                                                    <option value="<?= $service['id'] ?>"
                                                            <?= ($connection['id_service'] ?? '') == $service['id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($service['title']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- Торговый центр -->
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-light">Торговый центр</label>
                                            <select name="connections[<?= $index ?>][shopping_center_id]" class="connection-shopping-center w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight">
                                                <option value="">Выберите ТЦ</option>
                                                <?php foreach ($shoppingCenters as $center): ?>
                                                    <option value="<?= $center['id'] ?>"
                                                            <?= ($connection['id_shopping_center'] ?? '') == $center['id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($center['title']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- Тариф -->
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-light">Тариф</label>
                                            <select name="connections[<?= $index ?>][tariff_id]" class="connection-tariff w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight">
                                                <option value="">Выберите тариф</option>
                                                <?php foreach ($tariffs as $tariff): ?>
                                                    <option value="<?= $tariff['id'] ?>"
                                                            <?= ($connection['id_tariff'] ?? '') == $tariff['id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($tariff['title']) ?> - <?= number_format($tariff['price'], 0, '', ' ') ?> ₽
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- Удаление -->
                                        <div class="flex items-end">
                                            <button type="button" class="remove-connection bg-red-500/20 text-red-300 hover:bg-red-500 hover:text-light px-3 py-2 rounded-lg border border-red-500 transition-all duration-300 text-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Поля для видео (появляются при выборе Трислав Медиа + LED) -->
                                    <div class="video-fields mt-4 p-4 bg-secondary rounded-lg border border-highlight/20" style="<?= (($connection['video'] ?? '') || ($connection['video_filename'] ?? '')) ? 'display: block;' : 'display: none;' ?>">
                                        <h4 class="text-lg font-semibold text-highlight mb-3">Видео для LED экранов</h4>

                                        <!-- Информация о существующем видео -->
                                        <?php if (($connection['video'] ?? '') || ($connection['video_filename'] ?? '')): ?>
                                            <div class="mb-4 p-3 bg-primary rounded-lg border border-highlight/30">
                                                <h5 class="text-light font-semibold mb-2">Текущее видео:</h5>
                                                <?php if ($connection['video'] ?? ''): ?>
                                                    <div class="flex items-center justify-between mb-2">
                                                        <span class="text-light text-sm">URL видео:</span>
                                                        <a href="<?= htmlspecialchars($connection['video']) ?>" target="_blank" class="text-highlight hover:text-light text-sm">
                                                            <?= htmlspecialchars($connection['video']) ?>
                                                            <i class="fas fa-external-link-alt ml-1"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($connection['video_filename'] ?? ''): ?>
                                                    <div class="flex items-center justify-between mb-2">
                                                        <span class="text-light text-sm">Файл видео:</span>
                                                        <span class="text-highlight text-sm">
                                                    <?= htmlspecialchars($connection['video_filename']) ?>
                                                            <?php if ($connection['yandex_disk_path'] ?? ''): ?>
                                                                <i class="fas fa-cloud ml-1" title="На Яндекс.Диске"></i>
                                                            <?php else: ?>
                                                                <i class="fas fa-server ml-1" title="Локально на сервере"></i>
                                                            <?php endif; ?>
                                                </span>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($connection['yandex_disk_path'] ?? ''): ?>
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-light text-sm">Путь на Яндекс.Диске:</span>
                                                        <span class="text-highlight text-sm"><?= htmlspecialchars($connection['yandex_disk_path']) ?></span>
                                                    </div>
                                                <?php endif; ?>

                                                <!-- Кнопка удаления текущего видео -->
                                                <div class="mt-3 pt-3 border-t border-highlight/20">
                                                    <label class="flex items-center text-light text-sm">
                                                        <input type="checkbox" name="connections[<?= $index ?>][remove_video]" value="1" class="mr-2">
                                                        Удалить текущее видео
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block mb-2 text-sm font-medium text-light">Новое видео файл</label>
                                                <input type="file" name="connections[<?= $index ?>][video_file]"
                                                       class="video-file w-full px-3 py-2 bg-primary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-highlight file:text-primary hover:file:bg-highlight/80"
                                                       accept="video/*">
                                                <p class="text-gray-400 text-xs mt-1">Будет загружено на Яндекс.Диск</p>
                                            </div>
                                            <div>
                                                <label class="block mb-2 text-sm font-medium text-light">Или новый URL видео</label>
                                                <input type="text" name="connections[<?= $index ?>][video_url]"
                                                       class="video-url w-full px-3 py-2 bg-primary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight"
                                                       value="<?= htmlspecialchars($connection['video'] ?? '') ?>"
                                                       placeholder="https://example.com/video.mp4">
                                                <p class="text-gray-400 text-xs mt-1">Внешняя ссылка на видео</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Пустая связка по умолчанию -->
                            <div class="connection-item bg-primary rounded-lg p-4 border border-highlight/20">
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                    <!-- Проект -->
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-light">Проект *</label>
                                        <select name="connections[0][project_id]" class="connection-project w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight" required>
                                            <option value="">Выберите проект</option>
                                            <?php foreach ($projects as $project): ?>
                                                <option value="<?= $project['id'] ?>"><?= htmlspecialchars($project['title']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Услуга -->
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-light">Услуга</label>
                                        <select name="connections[0][service_id]" class="connection-service w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight">
                                            <option value="">Выберите услугу</option>
                                            <?php foreach ($services as $service): ?>
                                                <option value="<?= $service['id'] ?>"><?= htmlspecialchars($service['title']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Торговый центр -->
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-light">Торговый центр</label>
                                        <select name="connections[0][shopping_center_id]" class="connection-shopping-center w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight">
                                            <option value="">Выберите ТЦ</option>
                                            <?php foreach ($shoppingCenters as $center): ?>
                                                <option value="<?= $center['id'] ?>"><?= htmlspecialchars($center['title']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Тариф -->
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-light">Тариф</label>
                                        <select name="connections[0][tariff_id]" class="connection-tariff w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight">
                                            <option value="">Выберите тариф</option>
                                            <?php foreach ($tariffs as $tariff): ?>
                                                <option value="<?= $tariff['id'] ?>">
                                                    <?= htmlspecialchars($tariff['title']) ?> - <?= number_format($tariff['price'], 0, '', ' ') ?> ₽
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Удаление -->
                                    <div class="flex items-end">
                                        <button type="button" class="remove-connection bg-red-500/20 text-red-300 hover:bg-red-500 hover:text-light px-3 py-2 rounded-lg border border-red-500 transition-all duration-300 text-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Поля для видео -->
                                <div class="video-fields mt-4 p-4 bg-secondary rounded-lg border border-highlight/20" style="display: none;">
                                    <h4 class="text-lg font-semibold text-highlight mb-3">Видео для LED экранов</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-light">Видео файл</label>
                                            <input type="file" name="connections[0][video_file]"
                                                   class="video-file w-full px-3 py-2 bg-primary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-highlight file:text-primary hover:file:bg-highlight/80"
                                                   accept="video/*">
                                            <p class="text-gray-400 text-xs mt-1">Будет загружено на Яндекс.Диск</p>
                                        </div>
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-light">Или URL видео</label>
                                            <input type="text" name="connections[0][video_url]"
                                                   class="video-url w-full px-3 py-2 bg-primary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight"
                                                   placeholder="https://example.com/video.mp4">
                                            <p class="text-gray-400 text-xs mt-1">Внешняя ссылка на видео</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <button type="button" id="add-connection" class="bg-highlight/20 text-highlight hover:bg-highlight hover:text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300">
                        <i class="fas fa-plus mr-2"></i>Добавить связку
                    </button>
                </div>

                <div class="flex space-x-4 pt-6 border-t border-highlight/30">
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

    <!-- Полноэкранный прелоадер -->
    <div id="fullscreen-loader" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(26, 26, 46, 0.95); z-index: 9999; backdrop-filter: blur(10px);">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: #f1f1f1;">
            <div style="width: 80px; height: 80px; border: 4px solid #00b7c2; border-top: 4px solid transparent; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 20px;"></div>
            <h3 style="color: #00b7c2; margin-bottom: 10px;">Сохранение данных</h3>
            <p style="color: #f1f1f1; margin-bottom: 5px;">Идет сохранение клиента и загрузка файлов...</p>
            <p style="color: #f1f1f1; font-size: 14px;">Пожалуйста, не закрывайте страницу</p>
            <div id="upload-progress" style="margin-top: 20px; color: #00b7c2;"></div>
        </div>
    </div>

    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let connectionCount = <?= !empty($connections) ? count($connections) : 1 ?>;
            const loader = document.getElementById('fullscreen-loader');
            const progress = document.getElementById('upload-progress');

            // Обработчик отправки формы
            document.querySelector('form').addEventListener('submit', function(e) {
                // Проверяем есть ли видео файлы
                const videoFiles = document.querySelectorAll('.video-file');
                let hasLargeFiles = false;
                let totalSize = 0;

                videoFiles.forEach(fileInput => {
                    if (fileInput.files.length > 0) {
                        const file = fileInput.files[0];
                        totalSize += file.size;
                        if (file.size > 10 * 1024 * 1024) { // Файлы больше 10MB
                            hasLargeFiles = true;
                        }
                    }
                });

                // Показываем прелоадер
                showLoader(hasLargeFiles, totalSize);
            });

            function showLoader(hasLargeFiles, totalSize) {
                loader.style.display = 'block';
                document.body.style.overflow = 'hidden';

                if (hasLargeFiles) {
                    const sizeMB = (totalSize / 1024 / 1024).toFixed(1);
                    progress.innerHTML = `
                <div style="background: #16213e; padding: 10px; border-radius: 5px; margin: 10px 0;">
                    <p style="margin: 0; color: #f1f1f1;">Общий размер файлов: ${sizeMB} MB</p>
                    <p style="margin: 5px 0 0 0; color: #00b7c2; font-size: 12px;">Загрузка на Яндекс.Диск может занять несколько минут</p>
                </div>
            `;
                }

                // Блокируем повторную отправку формы
                setTimeout(() => {
                    const submitBtn = document.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Сохранение...';
                    }
                }, 100);
            }

            // Добавление новой связки
            document.getElementById('add-connection').addEventListener('click', function() {
                const container = document.getElementById('connections-container');
                const newItem = document.querySelector('.connection-item').cloneNode(true);

                // Обновляем индексы в name атрибутах
                const inputs = newItem.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name && name.includes('connections')) {
                        const newName = name.replace(/connections\[\d+\]/, `connections[${connectionCount}]`);
                        input.setAttribute('name', newName);
                    }
                });

                // Очищаем значения
                newItem.querySelectorAll('input, select, textarea').forEach(field => {
                    if (field.type !== 'button' && !field.classList.contains('remove-connection')) {
                        if (field.tagName === 'SELECT') {
                            field.selectedIndex = 0;
                        } else if (field.type === 'checkbox' || field.type === 'radio') {
                            field.checked = false;
                        } else {
                            field.value = '';
                        }
                    }
                });

                // Скрываем видео поля
                newItem.querySelector('.video-fields').style.display = 'none';

                container.appendChild(newItem);
                connectionCount++;

                // Добавляем обработчики для новой связки
                addConnectionEventListeners(newItem);
            });

            // Удаление связки
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-connection')) {
                    const item = e.target.closest('.connection-item');
                    if (document.querySelectorAll('.connection-item').length > 1) {
                        item.remove();
                    }
                }
            });

            // Функция для добавления обработчиков к элементу связки
            function addConnectionEventListeners(connectionItem) {
                const projectSelect = connectionItem.querySelector('.connection-project');
                const serviceSelect = connectionItem.querySelector('.connection-service');
                const videoFields = connectionItem.querySelector('.video-fields');

                function checkVideoFields() {
                    const isTrislavMedia = projectSelect.value &&
                        projectSelect.options[projectSelect.selectedIndex].text.includes('Медиа');
                    const isLedService = serviceSelect.value &&
                        serviceSelect.options[serviceSelect.selectedIndex].text.includes('LED');

                    // Проверяем есть ли уже загруженное видео
                    const hasExistingVideo = videoFields.querySelector('.bg-primary') !== null;

                    // Показываем поля видео если выбраны нужные условия ИЛИ уже есть загруженное видео
                    videoFields.style.display = (isTrislavMedia && isLedService) || hasExistingVideo ? 'block' : 'none';
                }

                projectSelect.addEventListener('change', checkVideoFields);
                serviceSelect.addEventListener('change', checkVideoFields);
            }

            // Добавляем обработчики к существующим связкам
            document.querySelectorAll('.connection-item').forEach(addConnectionEventListeners);
        });
    </script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>