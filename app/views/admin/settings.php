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

        <div class="flex justify-end pt-6">
            <button type="submit" class="bg-highlight text-primary font-semibold px-8 py-3 rounded-lg border-2 border-highlight hover:bg-transparent hover:text-highlight transition-all duration-300">
                Сохранить настройки
            </button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>