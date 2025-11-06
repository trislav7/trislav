<?php
ob_start();
$success = $_GET['success'] ?? false;
$current_category = $current_category ?? 'led';
?>

    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-highlight"><?= $title ?></h1>

                <!-- Переключение категорий -->
                <div class="flex space-x-2 mt-4">
                    <a href="/admin.php?action=led_advantages&category=led"
                       class="px-4 py-2 rounded-lg transition-all duration-300 no-underline <?= $current_category === 'led' ? 'bg-highlight text-primary' : 'bg-primary/50 text-light hover:bg-primary' ?>">
                        LED преимущества
                    </a>
                    <a href="/admin.php?action=led_advantages&category=btl"
                       class="px-4 py-2 rounded-lg transition-all duration-300 no-underline <?= $current_category === 'btl' ? 'bg-highlight text-primary' : 'bg-primary/50 text-light hover:bg-primary' ?>">
                        BTL преимущества
                    </a>
                    <a href="/admin.php?action=led_advantages&category=trislav_group"
                       class="px-4 py-2 rounded-lg transition-all duration-300 no-underline <?= $current_category === 'trislav_group' ? 'bg-highlight text-primary' : 'bg-primary/50 text-light hover:bg-primary' ?>">
                        Трислав Групп
                    </a>
                    <a href="/admin.php?action=led_advantages&category=trislav_media"
                       class="px-4 py-2 rounded-lg transition-all duration-300 no-underline <?= $current_category === 'trislav_media' ? 'bg-highlight text-primary' : 'bg-primary/50 text-light hover:bg-primary' ?>">
                        Трислав Медиа
                    </a>
                </div>
            </div>
            <a href="/admin.php?action=led_advantages_create&category=<?= $current_category ?>" class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline">
                + Добавить преимущество
            </a>
        </div>

        <?php if ($success): ?>
            <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded-lg">
                Изменения успешно сохранены!
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <?php $flash = $this->getFlashMessage(); ?>
            <?php if ($flash): ?>
                <div class="bg-<?= $flash['type'] === 'success' ? 'green' : 'red' ?>-500/20 border border-<?= $flash['type'] === 'success' ? 'green' : 'red' ?>-500 text-<?= $flash['type'] === 'success' ? 'green' : 'red' ?>-300 px-4 py-3 rounded-lg">
                    <?= $flash['message'] ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="bg-secondary rounded-xl border border-highlight/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                    <tr class="bg-primary/50">
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Иконка</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Заголовок</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Описание</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Категория</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Порядок</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Статус</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($advantages)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                Преимущества не найдены. <a href="/admin.php?action=led_advantages_create&category=<?= $current_category ?>" class="text-highlight hover:underline">Добавить первое преимущество</a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($advantages as $advantage): ?>
                            <tr class="border-b border-highlight/10 hover:bg-primary/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="w-10 h-10 bg-highlight/20 rounded-full flex items-center justify-center">
                                        <?= $advantage['icon_svg'] ?: '<i class="fas fa-star text-highlight"></i>' ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-light"><?= htmlspecialchars($advantage['title']) ?></div>
                                </td>
                                <td class="px-6 py-4 text-gray-300 max-w-xs"><?= htmlspecialchars($advantage['description'] ?? '') ?></td>
                                <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $advantage['category'] === 'led' ? 'bg-blue-500/20 text-blue-300' : 'bg-green-500/20 text-green-300' ?>">
                                    <?= strtoupper($advantage['category']) ?>
                                </span>
                                </td>
                                <td class="px-6 py-4 text-gray-300"><?= $advantage['sort_order'] ?></td>
                                <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $advantage['is_active'] ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' ?>">
                                    <?= $advantage['is_active'] ? 'Активен' : 'Неактивен' ?>
                                </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <a href="/admin.php?action=led_advantages_edit&id=<?= $advantage['id'] ?>&category=<?= $advantage['category'] ?>" class="bg-blue-500/20 text-blue-300 px-3 py-1 rounded-lg text-sm hover:bg-blue-500/30 transition-colors no-underline">
                                            Редактировать
                                        </a>
                                        <a href="/admin.php?action=led_advantages_toggle&id=<?= $advantage['id'] ?>&category=<?= $advantage['category'] ?>" class="bg-yellow-500/20 text-yellow-300 px-3 py-1 rounded-lg text-sm hover:bg-yellow-500/30 transition-colors no-underline">
                                            <?= $advantage['is_active'] ? 'Скрыть' : 'Показать' ?>
                                        </a>
                                        <a href="/admin.php?action=led_advantages_delete&id=<?= $advantage['id'] ?>&category=<?= $advantage['category'] ?>" class="bg-red-500/20 text-red-300 px-3 py-1 rounded-lg text-sm hover:bg-red-500/30 transition-colors no-underline" onclick="return confirm('Удалить преимущество?')">
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