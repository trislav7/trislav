<?php ob_start(); ?>

<div class="space-y-6">
    <!-- Заголовок -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-highlight">
            <i class="fas fa-robot mr-3"></i>AI Ассистент
        </h1>
        <div class="text-gray-400 text-sm">
            <i class="fas fa-sync-alt mr-1"></i> Контекст обновлен: <?= date('d.m.Y H:i') ?>
        </div>
    </div>

    <!-- Основной интерфейс -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- Левая колонка - Ввод -->
        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <h2 class="text-xl font-bold text-highlight mb-4">Задайте вопрос</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Ваш вопрос:</label>
                    <textarea
                            id="userQuestion"
                            placeholder="Опишите задачу, например: 'Как переделать раздел каталога учитывая текущую структуру?'"
                            class="w-full h-32 bg-primary border border-highlight/30 rounded-lg p-4 text-light placeholder-gray-500 focus:border-highlight focus:outline-none transition-colors resize-none"
                    ></textarea>
                </div>

                <!-- НОВОЕ ПОЛЕ: Конкретные файлы -->
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">
                        Конкретные файлы (опционально):
                        <span class="text-gray-500 text-xs ml-1">Укажите пути к файлам через запятую</span>
                    </label>
                    <input
                            type="text"
                            id="specificFiles"
                            placeholder="Например: /app/models/User.php, /app/controllers/admin/AdminController.php"
                            class="w-full bg-primary border border-highlight/30 rounded-lg p-3 text-light placeholder-gray-500 focus:border-highlight focus:outline-none transition-colors"
                    >
                </div>

                <button
                        onclick="generatePrompt()"
                        class="w-full bg-highlight text-primary py-3 px-6 rounded-lg font-semibold hover:bg-transparent hover:text-highlight border-2 border-highlight transition-all duration-300 flex items-center justify-center"
                >
                    <i class="fas fa-magic mr-2"></i> Сгенерировать промпт
                </button>
            </div>

            <!-- Отслеживаемые файлы -->
            <div class="mt-6 p-4 bg-primary/50 rounded-lg">
                <h3 class="text-highlight font-semibold mb-3 flex items-center">
                    <i class="fas fa-file-code mr-2"></i> Отслеживаемые файлы:
                </h3>
                <div class="space-y-1 max-h-40 overflow-y-auto">
                    <?php foreach ($tracked_files as $file): ?>
                        <div class="text-gray-400 text-sm font-mono flex items-center">
                            <i class="fas fa-file-alt mr-2 text-highlight/70"></i>
                            <?= htmlspecialchars($file) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Правая колонка - Результат -->
        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <h2 class="text-xl font-bold text-highlight mb-4 flex items-center justify-between">
                <span>Готовый промпт</span>
                <button
                    onclick="copyToClipboard()"
                    id="copyBtn"
                    class="bg-highlight text-primary py-2 px-4 rounded-lg text-sm font-semibold hover:bg-transparent hover:text-highlight border-2 border-highlight transition-all duration-300"
                >
                    <i class="fas fa-copy mr-1"></i> Копировать
                </button>
            </h2>

            <textarea
                id="generatedPrompt"
                readonly
                class="w-full h-96 bg-primary border border-highlight/30 rounded-lg p-4 text-light font-mono text-sm resize-none focus:outline-none"
                placeholder="Здесь появится сгенерированный промпт с контекстом вашего проекта..."
            ></textarea>

            <div class="mt-4 p-3 bg-highlight/10 border border-highlight/30 rounded-lg">
                <p class="text-highlight text-sm flex items-center">
                    <i class="fas fa-lightbulb mr-2"></i>
                    <strong>Совет:</strong> Скопируйте промпт и вставьте в DeepSeek Chat для получения ответа с учетом контекста проекта
                </p>
            </div>
        </div>
    </div>

    <!-- Статус системы -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Отслеживаемых файлов</p>
                    <p class="text-2xl font-bold text-highlight"><?= count($tracked_files) ?></p>
                </div>
                <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-code text-highlight text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Моделей в проекте</p>
                    <p class="text-2xl font-bold text-highlight"><?= count($project_structure['Models'] ?? []) ?></p>
                </div>
                <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-database text-highlight text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Контроллеров</p>
                    <p class="text-2xl font-bold text-highlight"><?= count($project_structure['Controllers'] ?? []) ?></p>
                </div>
                <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-cogs text-highlight text-xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function generatePrompt() {
        const question = document.getElementById('userQuestion').value.trim();
        const specificFiles = document.getElementById('specificFiles').value.trim();

        if (!question) {
            alert('Пожалуйста, введите ваш вопрос');
            return;
        }

        // Показываем индикатор загрузки
        const generateBtn = document.querySelector('button[onclick="generatePrompt()"]');
        const originalText = generateBtn.innerHTML;
        generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Генерация...';
        generateBtn.disabled = true;

        // AJAX запрос к серверу
        fetch('/admin.php?action=ai_assistant_generate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'question=' + encodeURIComponent(question) + '&specific_files=' + encodeURIComponent(specificFiles)
        })
            .then(response => response.text().then(text => {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('JSON parse error:', e);
                    throw new Error('Invalid JSON: ' + text.substring(0, 100));
                }
            }))
            .then(data => {
                if (data.success) {
                    document.getElementById('generatedPrompt').value = data.prompt;
                } else {
                    alert('Ошибка при генерации промпта: ' + (data.error || 'Неизвестная ошибка'));
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Ошибка: ' + error.message);
            })
            .finally(() => {
                generateBtn.innerHTML = originalText;
                generateBtn.disabled = false;
            });
    }

function copyToClipboard() {
    const promptText = document.getElementById('generatedPrompt');
    const copyBtn = document.getElementById('copyBtn');

    if (!promptText.value) {
        alert('Сначала сгенерируйте промпт');
        return;
    }

    promptText.select();
    document.execCommand('copy');

    // Визуальное подтверждение
    const originalText = copyBtn.innerHTML;
    copyBtn.innerHTML = '<i class="fas fa-check mr-1"></i> Скопировано!';
    copyBtn.classList.remove('bg-highlight', 'hover:bg-transparent', 'hover:text-highlight');
    copyBtn.classList.add('bg-green-500', 'border-green-500', 'text-white');

    setTimeout(() => {
        copyBtn.innerHTML = originalText;
        copyBtn.classList.remove('bg-green-500', 'border-green-500', 'text-white');
        copyBtn.classList.add('bg-highlight', 'hover:bg-transparent', 'hover:text-highlight');
    }, 2000);
}

// Автофокус на поле ввода
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('userQuestion').focus();
});

// Enter для генерации промпта
document.getElementById('userQuestion').addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 'Enter') {
        generatePrompt();
    }
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>