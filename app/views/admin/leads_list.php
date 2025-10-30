<?php ob_start(); ?>

    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-highlight">Управление заявками</h1>

        <?php if (isset($_GET['success'])): ?>
            <div class="bg-highlight/20 border border-highlight text-highlight px-4 py-3 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>Заявка обработана!
            </div>
        <?php endif; ?>

        <!-- Таблица заявок -->
        <div class="bg-secondary rounded-xl border border-highlight/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                    <tr class="bg-primary/50 border-b border-highlight/30">
                        <th class="py-4 px-6 text-left text-light font-semibold">Клиент</th>
                        <th class="py-4 px-6 text-left text-light font-semibold">Контакты</th>
                        <th class="py-4 px-6 text-left text-light font-semibold">Услуга</th>
                        <th class="py-4 px-6 text-left text-light font-semibold">Статус</th>
                        <th class="py-4 px-6 text-left text-light font-semibold">Дата</th>
                        <th class="py-4 px-6 text-left text-light font-semibold">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($leads)): ?>
                        <?php foreach ($leads as $lead): ?>
                            <tr class="border-b border-highlight/10 hover:bg-primary/30 transition-colors">
                                <td class="py-4 px-6">
                                    <p class="font-semibold text-light"><?= htmlspecialchars($lead['name']) ?></p>
                                    <p class="text-gray-400 text-sm"><?= htmlspecialchars($lead['company'] ?? 'Не указана') ?></p>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-light"><?= htmlspecialchars($lead['phone']) ?></p>
                                    <p class="text-gray-400 text-sm"><?= htmlspecialchars($lead['email']) ?></p>
                                </td>
                                <td class="py-4 px-6">
                                <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm font-medium">
                                    <?= $lead['service_type'] ?>
                                </span>
                                </td>
                                <td class="py-4 px-6">
                                <span class="<?= $lead['status'] == 'new' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-highlight/20 text-highlight' ?> px-3 py-1 rounded-full text-sm font-medium">
                                    <?= $lead['status'] == 'new' ? 'Новая' : 'Обработана' ?>
                                </span>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-gray-400"><?= date('d.m.Y H:i', strtotime($lead['created_at'])) ?></p>
                                </td>
                                <td class="py-4 px-6">
                                    <a href="/admin.php?action=leads_detail&id=<?= $lead['id'] ?>" class="text-highlight hover:text-light transition-colors mr-4">
                                        <i class="fas fa-eye mr-1"></i>Просмотр
                                    </a>
                                    <?php if ($lead['status'] == 'new'): ?>
                                        <a href="/admin.php?action=leads_process&id=<?= $lead['id'] ?>" class="text-green-400 hover:text-green-300 transition-colors">
                                            <i class="fas fa-check mr-1"></i>Обработать
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="py-8 px-6 text-center text-gray-400">
                                <i class="fas fa-inbox text-3xl mb-2 block"></i>
                                Заявки не найдены
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