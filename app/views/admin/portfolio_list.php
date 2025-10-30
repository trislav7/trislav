<?php ob_start(); ?>

    <div class="space-y-6">
        <!-- Заголовок и кнопка -->
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-highlight">Управление портфолио</h1>
            <a href="/admin.php?action=portfolio_create" class="bg-highlight text-primary font-semibold py-3 px-6 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline">
                <i class="fas fa-plus mr-2"></i>Добавить работу
            </a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="bg-highlight/20 border border-highlight text-highlight px-4 py-3 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>Работа успешно сохранена!
            </div>
        <?php endif; ?>

        <!-- Таблица портфолио -->
        <div class="bg-secondary rounded-xl border border-highlight/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                    <tr class="bg-primary/50 border-b border-highlight/30">
                        <th class="py-4 px-6 text-left text-light font-semibold">Работа</th>
                        <th class="py-4 px-6 text-left text-light font-semibold">Категория</th>
                        <th class="py-4 px-6 text-left text-light font-semibold">Клиент</th>
                        <th class="py-4 px-6 text-left text-light font-semibold">Дата</th>
                        <th class="py-4 px-6 text-left text-light font-semibold">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($portfolio)): ?>
                        <?php foreach ($portfolio as $item): ?>
                            <tr class="border-b border-highlight/10 hover:bg-primary/30 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <?php if ($item['image']): ?>
                                            <div class="w-12 h-12 bg-highlight/20 rounded-lg flex items-center justify-center mr-4 overflow-hidden">
                                                <i class="fas fa-image text-highlight"></i>
                                            </div>
                                        <?php else: ?>
                                            <div class="w-12 h-12 bg-highlight/20 rounded-lg flex items-center justify-center mr-4">
                                                <i class="fas fa-image text-highlight"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <p class="font-semibold text-light"><?= htmlspecialchars($item['title']) ?></p>
                                            <p class="text-gray-400 text-sm"><?= htmlspecialchars(substr($item['description'] ?? '', 0, 50)) ?>...</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm font-medium">
                                    <?= strtoupper($item['category']) ?>
                                </span>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-light"><?= htmlspecialchars($item['client_name'] ?? 'Не указан') ?></p>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-gray-400"><?= date('d.m.Y', strtotime($item['project_date'] ?? $item['created_at'])) ?></p>
                                </td>
                                <td class="py-4 px-6">
                                    <a href="/admin.php?action=portfolio_edit&id=<?= $item['id'] ?>" class="text-highlight hover:text-light transition-colors mr-4">
                                        <i class="fas fa-edit mr-1"></i>Редактировать
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-8 px-6 text-center text-gray-400">
                                <i class="fas fa-images text-3xl mb-2 block"></i>
                                Работы не найдены
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