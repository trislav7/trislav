<?php
// app/views/admin/leads_list.php
ob_start();
?>

    <div class="space-y-6">
        <!-- Заголовок и фильтры -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <h1 class="text-3xl font-bold text-highlight">Заявки</h1>

            <!-- Простые переключалки как в advantages -->
            <div class="flex space-x-1 bg-white/10 rounded-lg p-1">
                <a href="/admin.php?action=leads_list&filter=all"
                   class="px-4 py-2 rounded-md transition-all duration-300 <?= $current_filter === 'all' ? 'bg-highlight text-primary' : 'text-light hover:bg-white/10' ?>">
                    Все
                </a>
                <a href="/admin.php?action=leads_list&filter=trislav_group_general"
                   class="px-4 py-2 rounded-md transition-all duration-300 <?= $current_filter === 'trislav_group_general' ? 'bg-highlight text-primary' : 'text-light hover:bg-white/10' ?>">
                    Трислав Групп
                </a>
                <a href="/admin.php?action=leads_list&filter=led"
                   class="px-4 py-2 rounded-md transition-all duration-300 <?= $current_filter === 'led' ? 'bg-highlight text-primary' : 'text-light hover:bg-white/10' ?>">
                    LED
                </a>
                <a href="/admin.php?action=leads_list&filter=btl"
                   class="px-4 py-2 rounded-md transition-all duration-300 <?= $current_filter === 'btl' ? 'bg-highlight text-primary' : 'text-light hover:bg-white/10' ?>">
                    BTL
                </a>
                <a href="/admin.php?action=leads_list&filter=video"
                   class="px-4 py-2 rounded-md transition-all duration-300 <?= $current_filter === 'video' ? 'bg-highlight text-primary' : 'text-light hover:bg-white/10' ?>">
                    Видео
                </a>
                <a href="/admin.php?action=leads_list&filter=general"
                   class="px-4 py-2 rounded-md transition-all duration-300 <?= $current_filter === 'general' ? 'bg-highlight text-primary' : 'text-light hover:bg-white/10' ?>">
                    Медиа
                </a>
            </div>
        </div>

        <!-- Таблица заявок (оставляем как было) -->
        <div class="bg-white/5 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-white/10">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Имя</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Телефон</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Тип</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Статус</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Дата</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                    <?php if (!empty($leads)): ?>
                        <?php foreach ($leads as $lead): ?>
                            <tr class="hover:bg-white/5 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300"><?= $lead['id'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-light font-medium"><?= htmlspecialchars($lead['name']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300"><?= htmlspecialchars($lead['phone']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    <?= $lead['service_type'] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        <?= $lead['status'] === 'new' ? 'bg-yellow-500/20 text-yellow-400' :
                                            ($lead['status'] === 'processed' ? 'bg-blue-500/20 text-blue-400' : 'bg-green-500/20 text-green-400') ?>">
                                        <?= $lead['status'] === 'new' ? 'Новая' :
                                                ($lead['status'] === 'processed' ? 'В работе' : 'Завершена') ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    <?= date('d.m.Y H:i', strtotime($lead['created_at'])) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="/admin.php?action=leads_detail&id=<?= $lead['id'] ?>"
                                       class="text-highlight hover:text-light transition-colors duration-200 mr-3">
                                        <i class="fas fa-eye mr-1"></i>Просмотр
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                <i class="fas fa-inbox text-3xl mb-3"></i>
                                <p>Заявки не найдены</p>
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