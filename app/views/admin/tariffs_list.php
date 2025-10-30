<?php ob_start(); ?>

    <div class="space-y-6">
        <!-- Заголовок и кнопка -->
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-highlight">Управление тарифами</h1>
            <a href="/admin.php?action=tariffs_create" class="bg-highlight text-primary font-semibold py-3 px-6 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline">
                <i class="fas fa-plus mr-2"></i>Добавить тариф
            </a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="bg-highlight/20 border border-highlight text-highlight px-4 py-3 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>Тариф успешно сохранен!
            </div>
        <?php endif; ?>

        <!-- Таблица тарифов -->
        <div class="bg-secondary rounded-xl border border-highlight/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                    <tr class="bg-primary/50 border-b border-highlight/30">
                        <th class="py-4 px-6 text-left text-light font-semibold">Название</th>
                        <th class="py-4 px-6 text-left text-light font-semibold">Цена</th>
                        <th class="py-4 px-6 text-left text-light font-semibold">Период</th>
                        <th class="py-4 px-6 text-left text-light font-semibold">Статус</th>
                        <th class="py-4 px-6 text-left text-light font-semibold">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($tariffs)): ?>
                        <?php foreach ($tariffs as $tariff): ?>
                            <tr class="border-b border-highlight/10 hover:bg-primary/30 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-highlight/20 rounded-full flex items-center justify-center mr-4">
                                            <i class="fas fa-tag text-highlight"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-light"><?= htmlspecialchars($tariff['title']) ?></p>
                                            <?php if ($tariff['is_popular']): ?>
                                                <span class="bg-highlight text-primary text-xs px-2 py-1 rounded-full">Популярный</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-2xl font-bold text-highlight"><?= number_format($tariff['price'], 0, '', ' ') ?> ₽</p>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-light">/<?= $tariff['period'] ?></span>
                                </td>
                                <td class="py-4 px-6">
                                <span class="<?= $tariff['is_active'] ? 'bg-highlight/20 text-highlight' : 'bg-red-500/20 text-red-400' ?> px-3 py-1 rounded-full text-sm font-medium">
                                    <?= $tariff['is_active'] ? 'Активен' : 'Неактивен' ?>
                                </span>
                                </td>
                                <td class="py-4 px-6">
                                    <a href="/admin.php?action=tariffs_edit&id=<?= $tariff['id'] ?>" class="text-highlight hover:text-light transition-colors mr-4">
                                        <i class="fas fa-edit mr-1"></i>Редактировать
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-8 px-6 text-center text-gray-400">
                                <i class="fas fa-tags text-3xl mb-2 block"></i>
                                Тарифы не найдены
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>