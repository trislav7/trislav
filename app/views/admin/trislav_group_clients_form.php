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

                <!-- Загрузка изображения с drop-зоной -->
                <div>
                    <?php
                    $currentImage = $item['image_url'] ?? '';

                    // Переменные для компонента
                    $fieldName = 'image';
                    $currentFile = $currentImage;
                    $label = 'Изображение клиента';
                    $accept = 'image/*';
                    $previewId = 'clientImagePreview';

                    // Подключаем компонент
                    $componentPath = __DIR__ . '/components/file_upload.php';
                    if (file_exists($componentPath)) {
                        include $componentPath;
                    } else {
                        // Fallback на старую версию если компонент не найден
                        ?>
                        <label class="block mb-2 font-medium text-light">Изображение клиента</label>
                        <input type="file" id="image" name="image"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-highlight file:text-primary hover:file:bg-highlight/80"
                               accept="image/*">
                        <?php if (!empty($item['image_url'])): ?>
                            <div class="mt-2">
                                <p class="text-gray-400 text-sm">Текущее изображение:</p>
                                <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="Current image" class="mt-2 rounded-lg max-w-xs border border-highlight/30">
                            </div>
                        <?php endif; ?>
                        <?php
                    }
                    ?>
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

                                    <!-- Поля для видео -->
                                    <div class="video-fields mt-4 p-4 bg-secondary rounded-lg border border-highlight/20" style="display: none">
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
                            <!-- Нет связок - контейнер будет пустым -->
                        <?php endif; ?>
                    </div>

                    <!-- Скрытый шаблон для новых связок -->
                    <div id="connection-template" style="display: none;">
                        <div class="connection-item bg-primary rounded-lg p-4 border border-highlight/20">
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                <!-- Проект -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-light">Проект *</label>
                                    <select name="connections[TEMPLATE][project_id]" class="connection-project w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight" required>
                                        <option value="">Выберите проект</option>
                                        <?php foreach ($projects as $project): ?>
                                            <option value="<?= $project['id'] ?>"><?= htmlspecialchars($project['title']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Услуга -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-light">Услуга</label>
                                    <select name="connections[TEMPLATE][service_id]" class="connection-service w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight">
                                        <option value="">Выберите услугу</option>
                                        <?php foreach ($services as $service): ?>
                                            <option value="<?= $service['id'] ?>"><?= htmlspecialchars($service['title']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Торговый центр -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-light">Торговый центр</label>
                                    <select name="connections[TEMPLATE][shopping_center_id]" class="connection-shopping-center w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight">
                                        <option value="">Выберите ТЦ</option>
                                        <?php foreach ($shoppingCenters as $center): ?>
                                            <option value="<?= $center['id'] ?>"><?= htmlspecialchars($center['title']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Тариф -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-light">Тариф</label>
                                    <select name="connections[TEMPLATE][tariff_id]" class="connection-tariff w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight">
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
                                        <input type="file" name="connections[TEMPLATE][video_file]"
                                               class="video-file w-full px-3 py-2 bg-primary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-highlight file:text-primary hover:file:bg-highlight/80"
                                               accept="video/*">
                                        <p class="text-gray-400 text-xs mt-1">Будет загружено на Яндекс.Диск</p>
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-light">Или URL видео</label>
                                        <input type="text" name="connections[TEMPLATE][video_url]"
                                               class="video-url w-full px-3 py-2 bg-primary border border-highlight/30 rounded-lg text-light text-sm focus:outline-none focus:border-highlight"
                                               placeholder="https://example.com/video.mp4">
                                        <p class="text-gray-400 text-xs mt-1">Внешняя ссылка на видео</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="mt-6 p-4 bg-primary rounded-lg border border-highlight/20">
                        <button type="button" id="add-connection" class="bg-highlight/20 text-highlight hover:bg-highlight hover:text-primary font-semibold py-3 px-6 rounded-lg border-2 border-highlight transition-all duration-300">
                            <i class="fas fa-plus mr-2"></i>Добавить связку
                        </button>
                        <p class="text-gray-400 text-sm mt-2">
                            Вы можете добавить несколько связок, но загрузить видео можно только для одной связки за раз
                        </p>
                    </div>
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

        #upload-limit-message {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .video-fields {
            transition: all 0.3s ease;
        }

        .connection-item {
            transition: all 0.3s ease;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing ConnectionManager...');

            // Обработчик формы для прелоадера
            const form = document.querySelector('form');
            const loader = document.getElementById('fullscreen-loader');

            if (form && loader) {
                console.log('Form and loader found, setting up submit handler');

                // Убираем стандартную валидацию HTML5
                form.setAttribute('novalidate', 'novalidate');

                form.addEventListener('submit', function(e) {
                    console.log('Form submitted, showing loader');

                    // Показываем прелоадер сразу
                    loader.style.display = 'block';

                    // Проверяем только ВИДИМЫЕ обязательные поля
                    const requiredFields = form.querySelectorAll('[required]');
                    let isValid = true;
                    let firstInvalidField = null;

                    requiredFields.forEach(field => {
                        // Проверяем, видно ли поле (и его родители)
                        const isVisible = isElementVisible(field);

                        if (isVisible && !field.value.trim()) {
                            isValid = false;
                            if (!firstInvalidField) {
                                firstInvalidField = field;
                            }
                            field.style.borderColor = '#ef4444';
                            console.log('Required field is empty:', field.name);
                        } else {
                            field.style.borderColor = '';
                        }
                    });

                    if (!isValid) {
                        console.log('Form validation failed');
                        e.preventDefault();
                        loader.style.display = 'none';

                        if (firstInvalidField) {
                            firstInvalidField.focus();
                            alert('Пожалуйста, заполните все обязательные поля (отмечены *)');
                        }
                        return;
                    }

                    console.log('Form validation passed, submitting...');

                    // Если есть файлы для загрузки, показываем прогресс
                    const videoFiles = form.querySelectorAll('input[type="file"]');
                    const hasFiles = Array.from(videoFiles).some(file => file.files.length > 0);

                    if (hasFiles) {
                        const progress = document.getElementById('upload-progress');
                        if (progress) {
                            progress.innerHTML = '<p>Подготовка к загрузке файлов...</p>';
                        }
                    }
                });
            } else {
                console.error('Form or loader not found');
            }

            // Функция для проверки видимости элемента
            function isElementVisible(element) {
                if (!element) return false;

                // Проверяем сам элемент и всех родителей
                let currentElement = element;
                while (currentElement) {
                    const style = window.getComputedStyle(currentElement);
                    if (style.display === 'none' || style.visibility === 'hidden' || style.opacity === '0') {
                        return false;
                    }
                    currentElement = currentElement.parentElement;
                }

                return true;
            }

            class ConnectionManager {
                constructor() {
                    this.connectionCount = <?= !empty($connections) ? count($connections) : 0 ?>;
                    this.videoUploaded = false;
                    this.init();
                }

                init() {
                    console.log('Initializing ConnectionManager...');
                    this.bindEvents();
                    this.initExistingConnections();
                    this.checkVideoUploads();
                }

                bindEvents() {
                    // Кнопка добавления связки
                    const addButton = document.getElementById('add-connection');
                    if (addButton) {
                        addButton.addEventListener('click', () => {
                            console.log('Add connection button clicked');
                            this.addNewConnection();
                        });
                    } else {
                        console.error('Add connection button not found');
                    }

                    // Удаление связки (делегирование событий)
                    document.addEventListener('click', (e) => {
                        if (e.target.closest('.remove-connection')) {
                            console.log('Remove connection clicked');
                            this.removeConnection(e.target.closest('.connection-item'));
                        }
                    });

                    // Отслеживание загрузки видео файлов
                    document.addEventListener('change', (e) => {
                        if (e.target.classList.contains('video-file')) {
                            console.log('Video file selected');
                            this.checkVideoUploads();
                        }
                    });
                }

                initExistingConnections() {
                    // Инициализируем существующие связки
                    const existingConnections = document.querySelectorAll('#connections-container .connection-item');
                    console.log('Found existing connections:', existingConnections.length);

                    existingConnections.forEach(connection => {
                        this.setupConnection(connection);
                    });
                }

                addNewConnection() {
                    const template = document.getElementById('connection-template');
                    if (!template) {
                        console.error('Connection template not found');
                        return;
                    }

                    const newConnection = template.cloneNode(true);
                    newConnection.style.display = 'block';

                    const connectionItem = newConnection.querySelector('.connection-item');
                    if (!connectionItem) {
                        console.error('Connection item not found in template');
                        return;
                    }

                    // Обновляем имена полей
                    this.updateFieldNames(connectionItem, this.connectionCount);

                    // Сбрасываем значения
                    this.resetConnectionFields(connectionItem);

                    // Устанавливаем начальное состояние видимости
                    this.setInitialVisibility(connectionItem);

                    // Добавляем в контейнер
                    document.getElementById('connections-container').appendChild(connectionItem);

                    // Настраиваем обработчики
                    this.setupConnection(connectionItem);

                    this.connectionCount++;
                    console.log('New connection added, total:', this.connectionCount);
                }

                updateFieldNames(connectionItem, index) {
                    const fields = connectionItem.querySelectorAll('[name]');
                    console.log('Updating field names for connection:', index);

                    fields.forEach(field => {
                        const name = field.getAttribute('name');
                        if (name && name.includes('connections[TEMPLATE]')) {
                            const newName = name.replace('TEMPLATE', index);
                            field.setAttribute('name', newName);
                            console.log('Field name updated:', name, '->', newName);
                        }
                    });
                }

                resetConnectionFields(connectionItem) {
                    const fields = [
                        '.connection-project',
                        '.connection-service',
                        '.connection-shopping-center',
                        '.connection-tariff',
                        '.video-file',
                        '.video-url'
                    ];

                    fields.forEach(selector => {
                        const field = connectionItem.querySelector(selector);
                        if (field) {
                            field.value = '';
                        }
                    });

                    console.log('Connection fields reset');
                }

                setInitialVisibility(connectionItem) {
                    // Показываем только проект, остальное скрываем
                    const elementsToHide = [
                        '.connection-service',
                        '.connection-shopping-center',
                        '.connection-tariff',
                        '.video-fields'
                    ];

                    elementsToHide.forEach(selector => {
                        const element = connectionItem.querySelector(selector);
                        if (element) {
                            const parentDiv = element.closest('div');
                            if (parentDiv) {
                                this.hideElement(parentDiv);
                            }
                        }
                    });

                    console.log('Initial visibility set - only project visible');
                }

                setupConnection(connectionItem) {
                    const project = connectionItem.querySelector('.connection-project');
                    const service = connectionItem.querySelector('.connection-service');
                    const shoppingCenter = connectionItem.querySelector('.connection-shopping-center');
                    const tariff = connectionItem.querySelector('.connection-tariff');

                    if (!project || !service || !shoppingCenter || !tariff) {
                        console.error('Required connection fields not found');
                        return;
                    }

                    // Обработчики изменений
                    project.addEventListener('change', () => {
                        console.log('Project changed:', project.value);
                        this.onProjectChange(connectionItem);
                    });

                    service.addEventListener('change', () => {
                        console.log('Service changed:', service.value);
                        this.onServiceChange(connectionItem);
                    });

                    shoppingCenter.addEventListener('change', () => {
                        console.log('Shopping center changed:', shoppingCenter.value);
                        this.onShoppingCenterChange(connectionItem);
                    });

                    tariff.addEventListener('change', () => {
                        console.log('Tariff changed:', tariff.value);
                        this.onTariffChange(connectionItem);
                    });

                    // Инициализируем видимость
                    this.updateVisibility(connectionItem);

                    console.log('Connection setup complete');
                }

                onProjectChange(connectionItem) {
                    this.resetField(connectionItem, '.connection-service');
                    this.resetField(connectionItem, '.connection-shopping-center');
                    this.resetField(connectionItem, '.connection-tariff');
                    this.updateVisibility(connectionItem);
                }

                onServiceChange(connectionItem) {
                    this.resetField(connectionItem, '.connection-shopping-center');
                    this.resetField(connectionItem, '.connection-tariff');
                    this.updateVisibility(connectionItem);
                }

                onShoppingCenterChange(connectionItem) {
                    this.resetField(connectionItem, '.connection-tariff');
                    this.updateVisibility(connectionItem);
                }

                onTariffChange(connectionItem) {
                    this.updateVisibility(connectionItem);
                }

                resetField(connectionItem, selector) {
                    const field = connectionItem.querySelector(selector);
                    if (field) {
                        field.value = '';
                        console.log('Field reset:', selector);
                    }
                }

                updateVisibility(connectionItem) {
                    const project = connectionItem.querySelector('.connection-project');
                    const service = connectionItem.querySelector('.connection-service');
                    const shoppingCenter = connectionItem.querySelector('.connection-shopping-center');
                    const tariff = connectionItem.querySelector('.connection-tariff');
                    const videoFields = connectionItem.querySelector('.video-fields');

                    if (!project || !service || !shoppingCenter || !tariff || !videoFields) {
                        console.error('Required elements for visibility update not found');
                        return;
                    }

                    const serviceDiv = service.closest('div');
                    const shoppingCenterDiv = shoppingCenter.closest('div');
                    const tariffDiv = tariff.closest('div');

                    const projectValue = project.value;
                    const serviceValue = service.value;
                    const shoppingCenterValue = shoppingCenter.value;
                    const tariffValue = tariff.value;

                    console.log('Updating visibility:', {
                        project: projectValue,
                        service: serviceValue,
                        shoppingCenter: shoppingCenterValue,
                        tariff: tariffValue
                    });

                    // Каскадное отображение
                    if (projectValue) {
                        this.showElement(serviceDiv);
                    } else {
                        this.hideElement(serviceDiv);
                        this.hideElement(shoppingCenterDiv);
                        this.hideElement(tariffDiv);
                        this.hideElement(videoFields);
                        return;
                    }

                    if (serviceValue) {
                        this.showElement(shoppingCenterDiv);
                    } else {
                        this.hideElement(shoppingCenterDiv);
                        this.hideElement(tariffDiv);
                        this.hideElement(videoFields);
                        return;
                    }

                    if (shoppingCenterValue) {
                        this.showElement(tariffDiv);
                    } else {
                        this.hideElement(tariffDiv);
                        this.hideElement(videoFields);
                        return;
                    }

                    // Проверяем условия для показа видео
                    if (tariffValue) {
                        const hasExistingVideo = connectionItem.querySelector('.bg-primary.rounded-lg') !== null;
                        const isTrislavMedia = projectValue === '1';
                        const isLedService = serviceValue === '1';

                        console.log('Video conditions:', {
                            hasExistingVideo,
                            isTrislavMedia,
                            isLedService
                        });

                        if ((isTrislavMedia && isLedService) || hasExistingVideo) {
                            this.showElement(videoFields);
                            console.log('Showing video fields');
                        } else {
                            this.hideElement(videoFields);
                            console.log('Hiding video fields - conditions not met');
                        }
                    } else {
                        this.hideElement(videoFields);
                        console.log('Hiding video fields - no tariff selected');
                    }
                }

                showElement(element) {
                    if (element) {
                        element.style.display = 'block';
                    }
                }

                hideElement(element) {
                    if (element) {
                        element.style.display = 'none';
                    }
                }

                removeConnection(connectionItem) {
                    const totalConnections = document.querySelectorAll('.connection-item').length;
                    console.log('Remove connection requested, total connections:', totalConnections);

                    if (totalConnections > 1) {
                        connectionItem.remove();
                        console.log('Connection removed');
                        setTimeout(() => this.checkVideoUploads(), 100);
                    } else {
                        console.log('Cannot remove the last connection');
                    }
                }

                checkVideoUploads() {
                    const videoFiles = document.querySelectorAll('.video-file');
                    this.videoUploaded = Array.from(videoFiles).some(fileInput => fileInput.files.length > 0);

                    console.log('Video upload check:', {
                        totalVideoFields: videoFiles.length,
                        videoUploaded: this.videoUploaded
                    });

                    this.updateAddButton();
                }

                updateAddButton() {
                    const addButton = document.getElementById('add-connection');
                    const message = document.getElementById('upload-limit-message');

                    if (!addButton) {
                        console.error('Add button not found');
                        return;
                    }

                    if (this.videoUploaded) {
                        this.hideElement(addButton);
                        console.log('Add button hidden - video uploaded');

                        if (!message) {
                            this.createUploadLimitMessage();
                        }
                    } else {
                        this.showElement(addButton);
                        console.log('Add button shown - no video uploaded');

                        if (message) {
                            message.remove();
                            console.log('Upload limit message removed');
                        }
                    }
                }

                createUploadLimitMessage() {
                    const message = document.createElement('div');
                    message.id = 'upload-limit-message';
                    message.className = 'mt-4 p-4 bg-yellow-500/20 border border-yellow-500 rounded-lg';
                    message.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-3"></i>
                    <div>
                        <h4 class="font-semibold text-yellow-500">Ограничение загрузки</h4>
                        <p class="text-yellow-400 text-sm mt-1">
                            За один раз можно загрузить только одно видео.
                            Для добавления еще одного видео сохраните изменения и отредактируйте клиента снова.
                        </p>
                    </div>
                </div>
            `;

                    const addButtonContainer = document.getElementById('add-connection').parentNode;
                    if (addButtonContainer) {
                        addButtonContainer.appendChild(message);
                        console.log('Upload limit message created');
                    }
                }
            }

            // Инициализируем менеджер
            try {
                const manager = new ConnectionManager();
                console.log('ConnectionManager initialized successfully');
            } catch (error) {
                console.error('Error initializing ConnectionManager:', error);
            }

            // Дополнительные обработчики для прелоадера
            window.addEventListener('pageshow', function() {
                const loader = document.getElementById('fullscreen-loader');
                if (loader) {
                    loader.style.display = 'none';
                    console.log('Loader hidden on page show');
                }
            });
        });

        // Глобальный обработчик ошибок
        window.addEventListener('error', function(e) {
            console.error('Global error:', e.error);
        });
    </script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>