<?php
// app/views/admin/settings.php
ob_start();
$flashMessage = $this->getFlashMessage() ?? null;
?>

<div class="space-y-8">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-highlight">Настройки сайта</h1>
    </div>

    <?php if ($flashMessage): ?>
        <div class="bg-<?= $flashMessage['type'] == 'success' ? 'green' : 'red' ?>-500/20 border border-<?= $flashMessage['type'] == 'success' ? 'green' : 'red' ?>-500 text-<?= $flashMessage['type'] == 'success' ? 'green' : 'red' ?>-300 px-4 py-3 rounded-lg">
            <?= htmlspecialchars($flashMessage['message']) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-8">
        
        <!-- Контактная информация -->
        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <h2 class="text-xl font-bold text-highlight mb-6">Контактная информация</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-3 font-medium text-light">Телефон *</label>
                    <input type="text" name="setting_phone" required
                           value="<?= htmlspecialchars($settings['phone'] ?? '+7 (902) 907-66-36') ?>"
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                </div>
                <div>
                    <label class="block mb-3 font-medium text-light">Адрес *</label>
                    <input type="text" name="setting_address" required
                           value="<?= htmlspecialchars($settings['address'] ?? 'г. Тула, ул. Советская д. 7') ?>"
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-3 font-medium text-light">VK URL *</label>
                    <input type="url" name="setting_vk_url" required
                           value="<?= htmlspecialchars($settings['vk_url'] ?? 'https://vk.com/id567236987') ?>"
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                </div>
            </div>
        </div>

        <!-- Политика конфиденциальности -->
        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <h2 class="text-xl font-bold text-highlight mb-4">Политика конфиденциальности</h2>
            <div>
                <label class="block mb-2 font-medium text-light">Текст политики *</label>
                <textarea name="setting_privacy_policy" rows="12" required
                          class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                          placeholder="Введите текст политики конфиденциальности..."><?= htmlspecialchars($settings['privacy_policy'] ?? '') ?></textarea>
                <p class="text-gray-400 text-sm mt-2">
                    Этот текст будет отображаться на странице /privacy-policy
                </p>
            </div>
        </div>

        <!-- Преимущества "Почему именно мы" -->
        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-highlight">Преимущества "Почему именно мы"</h2>
                <button type="button" onclick="addNewAdvantage()" class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight">
                    + Добавить преимущество
                </button>
            </div>
            
            <div id="advantages-container" class="space-y-4">
                <?php if (!empty($advantages)): ?>
                    <?php foreach ($advantages as $advantage): ?>
                    <div class="advantage-item bg-primary/50 p-4 rounded-lg border border-highlight/30">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                            <div class="md:col-span-4">
                                <label class="block mb-2 text-sm font-medium text-light">Заголовок</label>
                                <input type="text" name="advantages[<?= $advantage['id'] ?>][title]" 
                                       value="<?= htmlspecialchars($advantage['title']) ?>"
                                       class="w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block mb-2 text-sm font-medium text-light">Иконка (Font Awesome)</label>
                                <input type="text" name="advantages[<?= $advantage['id'] ?>][icon_class]" 
                                       value="<?= htmlspecialchars($advantage['icon_class']) ?>"
                                       class="w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm"
                                       placeholder="fas fa-star">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block mb-2 text-sm font-medium text-light">Порядок</label>
                                <input type="number" name="advantages[<?= $advantage['id'] ?>][order_index]" 
                                       value="<?= $advantage['order_index'] ?>"
                                       class="w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm">
                            </div>
                            <div class="md:col-span-2 flex items-end space-x-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="advantages[<?= $advantage['id'] ?>][is_active]" value="1" 
                                           <?= $advantage['is_active'] ? 'checked' : '' ?>
                                           class="mr-2 w-4 h-4 text-highlight bg-secondary border-highlight/30 rounded">
                                    <span class="text-light text-sm">Активно</span>
                                </label>
                                <button type="button" onclick="removeAdvantage(this)" class="text-red-400 hover:text-red-300">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="md:col-span-12">
                                <label class="block mb-2 text-sm font-medium text-light">Описание</label>
                                <textarea name="advantages[<?= $advantage['id'] ?>][description]" rows="2"
                                          class="w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm"><?= htmlspecialchars($advantage['description']) ?></textarea>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Пустые преимущества по умолчанию -->
                    <?php 
                    $defaultAdvantages = [
                        ['title' => 'Мы создаем поток клиентов', 'icon' => 'fas fa-chart-line', 'order' => 1],
                        ['title' => 'Команда профессионалов', 'icon' => 'fas fa-users', 'order' => 2],
                        ['title' => 'Инновационные решения', 'icon' => 'fas fa-lightbulb', 'order' => 3],
                        ['title' => 'Точная аудитория', 'icon' => 'fas fa-bullseye', 'order' => 4],
                        ['title' => 'Аналитика в реальном времени', 'icon' => 'fas fa-chart-bar', 'order' => 5],
                        ['title' => 'Гарантированный результат', 'icon' => 'fas fa-award', 'order' => 6],
                    ];
                    ?>
                    <?php foreach ($defaultAdvantages as $index => $default): ?>
                    <div class="advantage-item bg-primary/50 p-4 rounded-lg border border-highlight/30">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                            <div class="md:col-span-4">
                                <label class="block mb-2 text-sm font-medium text-light">Заголовок</label>
                                <input type="text" name="new_advantages[<?= $index ?>][title]" 
                                       value="<?= htmlspecialchars($default['title']) ?>"
                                       class="w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block mb-2 text-sm font-medium text-light">Иконка</label>
                                <input type="text" name="new_advantages[<?= $index ?>][icon_class]" 
                                       value="<?= htmlspecialchars($default['icon']) ?>"
                                       class="w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block mb-2 text-sm font-medium text-light">Порядок</label>
                                <input type="number" name="new_advantages[<?= $index ?>][order_index]" 
                                       value="<?= $default['order'] ?>"
                                       class="w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm">
                            </div>
                            <div class="md:col-span-2 flex items-end">
                                <label class="flex items-center">
                                    <input type="checkbox" name="new_advantages[<?= $index ?>][is_active]" value="1" checked
                                           class="mr-2 w-4 h-4 text-highlight bg-secondary border-highlight/30 rounded">
                                    <span class="text-light text-sm">Активно</span>
                                </label>
                            </div>
                            <div class="md:col-span-12">
                                <label class="block mb-2 text-sm font-medium text-light">Описание</label>
                                <textarea name="new_advantages[<?= $index ?>][description]" rows="2"
                                          class="w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm"></textarea>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-highlight">Требования к видеороликам (LED)</h2>
            </div>

            <!-- Основные настройки -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block mb-3 font-medium text-light">Заголовок блока</label>
                    <input type="text" name="setting_led_requirements_title"
                           value="<?= htmlspecialchars($settings['led_requirements_title'] ?? 'Требования к видеороликам') ?>"
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                </div>
                <div>
                    <label class="block mb-3 font-medium text-light">Подзаголовок</label>
                    <input type="text" name="setting_led_requirements_subtitle"
                           value="<?= htmlspecialchars($settings['led_requirements_subtitle'] ?? 'Технические спецификации для качественного отображения на LED-экранах') ?>"
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                </div>
                <div>
                    <label class="block mb-3 font-medium text-light">Заголовок основных требований</label>
                    <input type="text" name="setting_led_requirements_main_title"
                           value="<?= htmlspecialchars($settings['led_requirements_main_title'] ?? 'Основные требования') ?>"
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                </div>
                <div>
                    <label class="block mb-3 font-medium text-light">Заголовок рекомендаций</label>
                    <input type="text" name="setting_led_requirements_additional_title"
                           value="<?= htmlspecialchars($settings['led_requirements_additional_title'] ?? 'Дополнительные рекомендации') ?>"
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                </div>
            </div>

            <!-- Основные требования -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-highlight mb-4">Основные требования</h3>
                <div class="space-y-4">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-light">Требование <?= $i ?></label>
                            <input type="text" name="setting_led_requirement_main_<?= $i ?>"
                                   value="<?= htmlspecialchars($settings['led_requirement_main_' . $i] ?? '') ?>"
                                   class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                                   placeholder="Например: Формат видео: MP4, MOV, AVI">
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Дополнительные рекомендации -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-highlight mb-4">Дополнительные рекомендации</h3>
                <div class="space-y-4">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-light">Рекомендация <?= $i ?></label>
                            <input type="text" name="setting_led_requirement_additional_<?= $i ?>"
                                   value="<?= htmlspecialchars($settings['led_requirement_additional_' . $i] ?? '') ?>"
                                   class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                                   placeholder="Например: Длительность ролика: 5-30 секунд">
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Информационный блок -->
            <div>
                <h3 class="text-lg font-bold text-highlight mb-4">Информационный блок</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block mb-3 font-medium text-light">Заголовок информации</label>
                        <input type="text" name="setting_led_requirements_info_title"
                               value="<?= htmlspecialchars($settings['led_requirements_info_title'] ?? 'Важная информация') ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                    </div>
                </div>
                <div>
                    <label class="block mb-3 font-medium text-light">Текст информации</label>
                    <textarea name="setting_led_requirements_info_content" rows="4"
                              class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                              placeholder="Текст информационного блока..."><?= htmlspecialchars($settings['led_requirements_info_content'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <button type="submit" class="bg-highlight text-primary font-semibold px-8 py-3 rounded-lg border-2 border-highlight hover:bg-transparent hover:text-highlight transition-all duration-300">
                Сохранить настройки
            </button>
        </div>
    </form>
</div>

<script>
let advantageCount = <?= !empty($advantages) ? count($advantages) : 6 ?>;

function addNewAdvantage() {
    const container = document.getElementById('advantages-container');
    const newIndex = advantageCount++;
    
    const newAdvantageHtml = `
        <div class="advantage-item bg-primary/50 p-4 rounded-lg border border-highlight/30">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                <div class="md:col-span-4">
                    <label class="block mb-2 text-sm font-medium text-light">Заголовок</label>
                    <input type="text" name="new_advantages[${newIndex}][title]" 
                           class="w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm">
                </div>
                <div class="md:col-span-3">
                    <label class="block mb-2 text-sm font-medium text-light">Иконка</label>
                    <input type="text" name="new_advantages[${newIndex}][icon_class]" 
                           class="w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm"
                           placeholder="fas fa-star">
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-light">Порядок</label>
                    <input type="number" name="new_advantages[${newIndex}][order_index]" 
                           value="${newIndex}"
                           class="w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm">
                </div>
                <div class="md:col-span-2 flex items-end space-x-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="new_advantages[${newIndex}][is_active]" value="1" checked
                               class="mr-2 w-4 h-4 text-highlight bg-secondary border-highlight/30 rounded">
                        <span class="text-light text-sm">Активно</span>
                    </label>
                    <button type="button" onclick="removeAdvantage(this)" class="text-red-400 hover:text-red-300">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="md:col-span-12">
                    <label class="block mb-2 text-sm font-medium text-light">Описание</label>
                    <textarea name="new_advantages[${newIndex}][description]" rows="2"
                              class="w-full px-3 py-2 bg-secondary border border-highlight/30 rounded-lg text-light text-sm"></textarea>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newAdvantageHtml);
}

function removeAdvantage(button) {
    const advantageItem = button.closest('.advantage-item');
    advantageItem.remove();
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>