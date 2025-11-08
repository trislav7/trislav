<?php
// app/views/admin/components/file_upload.php

// Получаем параметры
$label = $label ?? 'Загрузить файл';
$fieldName = $fieldName ?? 'file';
$currentFile = $currentFile ?? '';
$accept = $accept ?? '*';
$previewId = $previewId ?? 'filePreview';
$isImage = strpos($accept, 'image') !== false;
?>

<div class="file-upload-wrapper space-y-4">
    <label class="block text-light font-semibold mb-2"><?= htmlspecialchars($label) ?></label>

    <!-- Область для drag & drop -->
    <div class="relative">
        <input type="file"
               name="<?= htmlspecialchars($fieldName) ?>"
               accept="<?= htmlspecialchars($accept) ?>"
               id="<?= $fieldName ?>Input"
               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
               onchange="handleFileSelect(this, '<?= $previewId ?>')">

        <div class="border-2 border-dashed border-highlight/40 rounded-xl p-6 bg-primary/30 transition-all duration-300 hover:border-highlight hover:bg-primary/50"
             id="dropZone">
            <div class="text-center space-y-3">
                <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center mx-auto">
                    <i class="fas fa-cloud-upload-alt text-highlight text-xl"></i>
                </div>
                <div class="space-y-1">
                    <p class="text-light font-medium">Перетащите файл сюда</p>
                    <p class="text-gray-400 text-sm">или нажмите для выбора</p>
                </div>
                <div class="text-xs text-gray-500">
                    <?= $isImage ? 'JPG, PNG, GIF, WEBP' : 'Любой файл' ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Текущий файл -->
    <?php if (!empty($currentFile)): ?>
        <div class="current-file bg-secondary/50 rounded-lg p-4 border border-highlight/20">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <?php if ($isImage && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $currentFile)): ?>
                        <div class="w-10 h-10 bg-highlight/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-highlight"></i>
                        </div>
                    <?php else: ?>
                        <div class="w-10 h-10 bg-highlight/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file text-highlight"></i>
                        </div>
                    <?php endif; ?>

                    <div>
                        <p class="text-light font-medium text-sm truncate max-w-xs">
                            <?= htmlspecialchars(basename($currentFile)) ?>
                        </p>
                        <p class="text-gray-400 text-xs flex items-center">
                            <i class="fas fa-check-circle text-green-400 mr-1"></i>
                            Текущий файл
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <?php if ($isImage && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $currentFile)): ?>
                        <a href="<?= htmlspecialchars($currentFile) ?>"
                           target="_blank"
                           class="w-8 h-8 bg-highlight/20 rounded-lg flex items-center justify-center text-highlight hover:bg-highlight hover:text-primary transition-colors duration-200"
                           title="Посмотреть">
                            <i class="fas fa-eye text-xs"></i>
                        </a>
                    <?php endif; ?>
                    <a href="<?= htmlspecialchars($currentFile) ?>"
                       target="_blank"
                       class="w-8 h-8 bg-highlight/20 rounded-lg flex items-center justify-center text-highlight hover:bg-highlight hover:text-primary transition-colors duration-200"
                       title="Скачать">
                        <i class="fas fa-download text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Preview текущего изображения -->
            <?php if ($isImage && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $currentFile)): ?>
                <div class="mt-3 pt-3 border-t border-highlight/10">
                    <p class="text-gray-400 text-xs mb-2">Предпросмотр:</p>
                    <img src="<?= htmlspecialchars($currentFile) ?>"
                         alt="Текущее изображение"
                         class="max-h-32 rounded-lg border border-highlight/20">
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Preview нового файла -->
    <div id="<?= $previewId ?>" class="new-file-preview hidden bg-secondary/50 rounded-lg p-4 border border-highlight/30">
        <div class="flex items-center justify-between mb-3">
            <p class="text-light font-medium text-sm">Новый файл:</p>
            <button type="button"
                    onclick="clearFileSelection('<?= $fieldName ?>Input', '<?= $previewId ?>')"
                    class="w-6 h-6 bg-red-500/20 rounded-full flex items-center justify-center text-red-400 hover:bg-red-500 hover:text-white transition-colors duration-200">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        <div id="<?= $previewId ?>Content"></div>
    </div>

    <!-- Информация о выбранном файле -->
    <div id="<?= $fieldName ?>Info" class="file-info hidden text-xs text-gray-400 space-y-1"></div>
</div>

<script>
    function handleFileSelect(input, previewId) {
        const file = input.files[0];
        if (!file) return;

        const fileInfo = document.getElementById(input.name + 'Info');
        const preview = document.getElementById(previewId);
        const previewContent = document.getElementById(previewId + 'Content');
        const dropZone = document.getElementById('dropZone');

        // Обновляем информацию о файле
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        fileInfo.innerHTML = `
        <div class="flex justify-between">
            <span>Размер:</span>
            <span class="text-light">${fileSize} MB</span>
        </div>
        <div class="flex justify-between">
            <span>Тип:</span>
            <span class="text-light">${file.type || 'Неизвестно'}</span>
        </div>
    `;
        fileInfo.classList.remove('hidden');

        // Обновляем drop zone
        dropZone.innerHTML = `
        <div class="text-center space-y-2">
            <div class="w-10 h-10 bg-green-500/20 rounded-full flex items-center justify-center mx-auto">
                <i class="fas fa-check text-green-400 text-lg"></i>
            </div>
            <p class="text-light font-medium text-sm">Файл выбран</p>
            <p class="text-gray-400 text-xs truncate">${file.name}</p>
        </div>
    `;

        // Показываем preview для изображений
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContent.innerHTML = `
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 bg-highlight/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-image text-highlight"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-light font-medium text-sm truncate">${file.name}</p>
                        <p class="text-gray-400 text-xs">${fileSize} MB</p>
                    </div>
                </div>
                <img src="${e.target.result}"
                     alt="Preview"
                     class="w-full max-h-48 object-contain rounded-lg border border-highlight/20">
            `;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            previewContent.innerHTML = `
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-highlight/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file text-highlight"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-light font-medium text-sm truncate">${file.name}</p>
                    <p class="text-gray-400 text-xs">${fileSize} MB • ${file.type || 'Неизвестный формат'}</p>
                </div>
            </div>
        `;
            preview.classList.remove('hidden');
        }
    }

    function clearFileSelection(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const fileInfo = document.getElementById(input.name + 'Info');
        const dropZone = document.getElementById('dropZone');

        // Сбрасываем input
        input.value = '';

        // Скрываем preview и информацию
        preview.classList.add('hidden');
        fileInfo.classList.add('hidden');

        // Восстанавливаем исходный вид drop zone
        dropZone.innerHTML = `
        <div class="text-center space-y-3">
            <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center mx-auto">
                <i class="fas fa-cloud-upload-alt text-highlight text-xl"></i>
            </div>
            <div class="space-y-1">
                <p class="text-light font-medium">Перетащите файл сюда</p>
                <p class="text-gray-400 text-sm">или нажмите для выбора</p>
            </div>
            <div class="text-xs text-gray-500">
                <?= $isImage ? 'JPG, PNG, GIF, WEBP' : 'Любой файл' ?>
            </div>
        </div>
    `;
    }

    // Добавляем обработчики для drag & drop
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('dropZone');
        if (dropZone) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropZone.classList.add('border-highlight', 'bg-highlight/10');
            }

            function unhighlight() {
                dropZone.classList.remove('border-highlight', 'bg-highlight/10');
            }

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                const input = dropZone.querySelector('input[type="file"]');

                if (files.length > 0) {
                    input.files = files;
                    handleFileSelect(input, '<?= $previewId ?>');
                }
            }
        }
    });
</script>