<?php
// app/views/admin/services_list.php
ob_start();
$success = $_GET['success'] ?? false;
?>

    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-highlight">Управление услугами</h1>
            <a href="/admin.php?action=services_create" class="bg-highlight text-primary font-semibold py-3 px-6 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline">
                <i class="fas fa-plus mr-2"></i>Добавить услугу
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
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Категория</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Проект</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Порядок</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Статус</th>
                        <th class="px-6 py-4 text-left text-highlight font-semibold">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($services)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                Услуги не найдены. <a href="/admin.php?action=services_create" class="text-highlight hover:underline">Добавить первую услугу</a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($services as $service): ?>
                            <tr class="border-b border-highlight/10 hover:bg-primary/30 transition-colors">
                                <td class="px-6 py-4 text-gray-300"><?= $service['id'] ?></td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-light"><?= htmlspecialchars($service['title']) ?></div>
                                    <?php if ($service['short_description']): ?>
                                        <div class="text-gray-400 text-sm mt-1"><?= htmlspecialchars($service['short_description']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if (!empty($service['category'])): ?>
                                        <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm font-medium">
                                        <?= strtoupper($service['category']) ?>
                                    </span>
                                    <?php else: ?>
                                        <span class="bg-gray-500/20 text-gray-300 px-3 py-1 rounded-full text-sm font-medium">
                                        НЕТ
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-gray-300">
                                    <?php
                                    $projectTitle = 'Не указан';
                                    if (!empty($service['project_id'])) {
                                        $projectModel = new TrislavGroupProject();
                                        $project = $projectModel->find($service['project_id']);
                                        $projectTitle = $project ? htmlspecialchars($project['title']) : 'Проект не найден';
                                    }
                                    echo $projectTitle;
                                    ?>
                                </td>
                                <td class="px-6 py-4 text-gray-300"><?= $service['order_index'] ?></td>
                                <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $service['is_active'] ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' ?>">
                                    <?= $service['is_active'] ? 'Активна' : 'Неактивна' ?>
                                </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <a href="/admin.php?action=services_edit&id=<?= $service['id'] ?>" class="bg-blue-500/20 text-blue-300 px-3 py-1 rounded-lg text-sm hover:bg-blue-500/30 transition-colors no-underline">
                                            Редактировать
                                        </a>
                                        <a href="/admin.php?action=services_toggle&id=<?= $service['id'] ?>" class="bg-yellow-500/20 text-yellow-300 px-3 py-1 rounded-lg text-sm hover:bg-yellow-500/30 transition-colors no-underline">
                                            <?= $service['is_active'] ? 'Деактивировать' : 'Активировать' ?>
                                        </a>
                                        <a href="/admin.php?action=services_delete&id=<?= $service['id'] ?>" class="bg-red-500/20 text-red-300 px-3 py-1 rounded-lg text-sm hover:bg-red-500/30 transition-colors no-underline" onclick="return confirm('Удалить услугу?')">
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