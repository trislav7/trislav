<?php
ob_start();
$success = $_GET['success'] ?? false;
$current_category = $current_category ?? 'all';
?>

    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-highlight"><?= $title ?></h1>

                <!-- Переключение категорий -->
                <div class="flex space-x-2 mt-4">
                    <a href="/admin.php?action=portfolio_list&category=all"
                       class="px-4 py-2 rounded-lg transition-all duration-300 no-underline <?= $current_category === 'all' ? 'bg-highlight text-primary' : 'bg-primary/50 text-light hover:bg-primary' ?>">
                        Все работы
                    </a>
                    <a href="/admin.php?action=portfolio_list&category=led"
                       class="px-4 py-2 rounded-lg transition-all duration-300 no-underline <?= $current_category === 'led' ? 'bg-highlight text-primary' : 'bg-primary/50 text-light hover:bg-primary' ?>">
                        LED экраны
                    </a>
                    <a href="/admin.php?action=portfolio_list&category=video"
                       class="px-4 py-2 rounded-lg transition-all duration-300 no-underline <?= $current_category === 'video' ? 'bg-highlight text-primary' : 'bg-primary/50 text-light hover:bg-primary' ?>">
                        Видео и лого
                    </a>
                    <a href="/admin.php?action=portfolio_list&category=btl"
                       class="px-4 py-2 rounded-lg transition-all duration-300 no-underline <?= $current_category === 'btl' ? 'bg-highlight text-primary' : 'bg-primary/50 text-light hover:bg-primary' ?>">
                        BTL мероприятия
                    </a>
                    <a href="/admin.php?action=portfolio_list&category=branding"
                       class="px-4 py-2 rounded-lg transition-all duration-300 no-underline <?= $current_category === 'branding' ? 'bg-highlight text-primary' : 'bg-primary/50 text-light hover:bg-primary' ?>">
                        Брендинг
                    </a>
                </div>
            </div>
            <a href="/admin.php?action=portfolio_create&category=<?= $current_category ?>" class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline">
                + Добавить работу
            </a>
        </div>

        <?php if ($success): ?>
            <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded-lg">
                Изменения успешно сохранены!
            </div>
        <?php endif; ?>

        <div class="bg-secondary rounded-xl border border-highlight/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                    <tr class="bg-primary/50">
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Изображение</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Название</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Описание</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Категория</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Клиент</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Дата</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Статус</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($portfolio)): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                                Работы не найдены. <a href="/admin.php?action=portfolio_create&category=<?= $current_category ?>" class="text-highlight hover:underline">Добавить первую работу</a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($portfolio as $item): ?>
                            <tr class="border-b border-highlight/10 hover:bg-primary/30 transition-colors">
                                <td class="px-6 py-4">
                                    <?php if (!empty($item['image'])): ?>
                                        <div class="w-16 h-16 bg-primary rounded-lg overflow-hidden">
                                            <img src="<?= htmlspecialchars($item['image']) ?>"
                                                 alt="<?= htmlspecialchars($item['title']) ?>"
                                                 class="w-full h-full object-cover">
                                        </div>
                                    <?php else: ?>
                                        <div class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-highlight/50"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-light"><?= htmlspecialchars($item['title']) ?></div>
                                </td>
                                <td class="px-6 py-4 text-gray-300 max-w-xs">
                                    <?= !empty($item['description']) ? htmlspecialchars(mb_substr($item['description'], 0, 100) . (mb_strlen($item['description']) > 100 ? '...' : '')) : '—' ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if (isset($item['category_label']) && isset($item['category_color'])): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $item['category_color'] ?>">
                                            <?= $item['category_label'] ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-500/20 text-gray-300">
                                            <?= htmlspecialchars($item['category']) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-gray-300">
                                    <?= !empty($item['client_name']) ? htmlspecialchars($item['client_name']) : '—' ?>
                                </td>
                                <td class="px-6 py-4 text-gray-300">
                                    <?= !empty($item['project_date']) ? date('d.m.Y', strtotime($item['project_date'])) : '—' ?>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $item['is_active'] ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' ?>">
                                        <?= $item['is_active'] ? 'Активна' : 'Неактивна' ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <a href="/admin.php?action=portfolio_edit&id=<?= $item['id'] ?>&category=<?= $item['category'] ?>" class="bg-blue-500/20 text-blue-300 px-3 py-1 rounded-lg text-sm hover:bg-blue-500/30 transition-colors no-underline">
                                            Редактировать
                                        </a>
                                        <a href="/admin.php?action=portfolio_toggle&id=<?= $item['id'] ?>&category=<?= $item['category'] ?>" class="bg-yellow-500/20 text-yellow-300 px-3 py-1 rounded-lg text-sm hover:bg-yellow-500/30 transition-colors no-underline">
                                            <?= $item['is_active'] ? 'Скрыть' : 'Показать' ?>
                                        </a>
                                        <a href="/admin.php?action=portfolio_delete&id=<?= $item['id'] ?>&category=<?= $item['category'] ?>" class="bg-red-500/20 text-red-300 px-3 py-1 rounded-lg text-sm hover:bg-red-500/30 transition-colors no-underline" onclick="return confirm('Удалить работу?')">
                                            Удалить
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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