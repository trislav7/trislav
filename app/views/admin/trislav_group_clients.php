<?php
ob_start();
$success = $_GET['success'] ?? false;
?>

<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-highlight">Управление клиентами</h1>
        <a href="/admin.php?action=trislav_clients_create" class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline">
            + Добавить клиента
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
                    <th class="px-6 py-4 text-left text-highlight font-semibold">ID</th>
                    <th class="px-6 py-4 text-left text-highlight font-semibold">Название</th>
                    <th class="px-6 py-4 text-left text-highlight font-semibold">Описание</th>
                    <th class="px-6 py-4 text-left text-highlight font-semibold">Порядок</th>
                    <th class="px-6 py-4 text-left text-highlight font-semibold">Статус</th>
                    <th class="px-6 py-4 text-left text-highlight font-semibold">Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($clients)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                            Клиенты не найдены. <a href="/admin.php?action=trislav_clients_create" class="text-highlight hover:underline">Добавить первого клиента</a>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($clients as $client): ?>
                        <tr class="border-b border-highlight/10 hover:bg-primary/30 transition-colors">
                            <td class="px-6 py-4 text-gray-300"><?= $client['id'] ?></td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-light"><?= htmlspecialchars($client['title']) ?></div>
                            </td>
                            <td class="px-6 py-4 text-gray-300 max-w-xs truncate"><?= htmlspecialchars($client['description'] ?? '') ?></td>
                            <td class="px-6 py-4 text-gray-300"><?= $client['order_index'] ?></td>
                            <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $client['is_active'] ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' ?>">
                                <?= $client['is_active'] ? 'Активен' : 'Неактивен' ?>
                            </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="/admin.php?action=trislav_clients_edit&id=<?= $client['id'] ?>" class="bg-blue-500/20 text-blue-300 px-3 py-1 rounded-lg text-sm hover:bg-blue-500/30 transition-colors no-underline">
                                        Редактировать
                                    </a>
                                    <a href="/admin.php?action=trislav_clients_toggle&id=<?= $client['id'] ?>" class="bg-yellow-500/20 text-yellow-300 px-3 py-1 rounded-lg text-sm hover:bg-yellow-500/30 transition-colors no-underline">
                                        <?= $client['is_active'] ? 'Скрыть' : 'Показать' ?>
                                    </a>
                                    <a href="/admin.php?action=trislav_clients_delete&id=<?= $client['id'] ?>" class="bg-red-500/20 text-red-300 px-3 py-1 rounded-lg text-sm hover:bg-red-500/30 transition-colors no-underline" onclick="return confirm('Удалить клиента?')">
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
