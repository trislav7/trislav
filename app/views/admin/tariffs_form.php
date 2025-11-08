<?php
// app/views/admin/tariffs_form.php
ob_start();
?>

    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-highlight"><?= $title ?></h1>

        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <form method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-light font-semibold mb-3">Название тарифа *</label>
                        <input type="text" name="title" value="<?= $tariff['title'] ?? '' ?>" required
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500">
                    </div>

                    <div>
                        <label class="block text-light font-semibold mb-3">Период *</label>
                        <input type="text" name="period" value="<?= $tariff['period'] ?? 'неделя' ?>" required
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                               placeholder="неделя, месяц, год">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-light font-semibold mb-3">Текущая цена *</label>
                        <input type="number" name="price" value="<?= $tariff['price'] ?? '' ?>" required
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                               placeholder="0.00" step="0.01" min="0">
                    </div>

                    <div>
                        <label class="block text-light font-semibold mb-3">Старая цена (для акций)</label>
                        <input type="number" name="old_price" value="<?= $tariff['old_price'] ?? '' ?>"
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                               placeholder="0.00" step="0.01" min="0">
                        <p class="text-gray-400 text-sm mt-1">
                            Если указана старая цена, она будет отображаться перечеркнутой рядом с текущей
                        </p>
                    </div>
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Услуга</label>
                    <select name="service_id" class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                        <option value="" class="bg-primary">Выберите услугу</option>
                        <?php if (!empty($services)): ?>
                            <?php foreach ($services as $service): ?>
                                <option value="<?= $service['id'] ?>" <?= isset($tariff['service_id']) && $tariff['service_id'] == $service['id'] ? 'selected' : '' ?> class="bg-primary">
                                    <?= htmlspecialchars($service['title']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Особенности (каждая с новой строки)</label>
                    <textarea name="features" rows="4" class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"><?= isset($tariff['features']) ? implode("\n", json_decode($tariff['features'], true)) : '' ?></textarea>
                </div>

                <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" <?= isset($tariff['is_active']) && $tariff['is_active'] ? 'checked' : 'checked' ?> class="mr-3 w-4 h-4 text-highlight bg-primary border-highlight/30 rounded focus:ring-highlight focus:ring-2">
                        <span class="text-light">Активный тариф</span>
                    </label>

                    <label class="flex items-center">
                        <input type="checkbox" name="is_popular" value="1" <?= isset($tariff['is_popular']) && $tariff['is_popular'] ? 'checked' : '' ?> class="mr-3 w-4 h-4 text-highlight bg-primary border-highlight/30 rounded focus:ring-highlight focus:ring-2">
                        <span class="text-light">Популярный тариф</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-highlight/30">
                    <a href="/admin.php?action=tariffs_list" class="bg-primary text-light px-6 py-3 rounded-lg border border-highlight/30 hover:bg-highlight/20 transition-all duration-300 no-underline">
                        Отмена
                    </a>
                    <button type="submit" class="bg-highlight text-primary font-semibold px-6 py-3 rounded-lg border-2 border-highlight hover:bg-transparent hover:text-highlight transition-all duration-300">
                        Сохранить тариф
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>