<?php ob_start(); ?>

    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-highlight"><?= $title ?></h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Информация о клиенте -->
            <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
                <h2 class="text-xl font-bold text-highlight mb-4">
                    <i class="fas fa-user mr-2"></i>Информация о клиенте
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-400">Имя:</label>
                        <p class="text-light text-lg"><?= htmlspecialchars($lead['name']) ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-400">Телефон:</label>
                        <p class="text-light text-lg"><?= htmlspecialchars($lead['phone']) ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-400">Email:</label>
                        <p class="text-light text-lg"><?= htmlspecialchars($lead['email']) ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-400">Компания:</label>
                        <p class="text-light"><?= htmlspecialchars($lead['company'] ?? 'Не указана') ?></p>
                    </div>
                </div>
            </div>

            <!-- Детали заявки -->
            <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
                <h2 class="text-xl font-bold text-highlight mb-4">
                    <i class="fas fa-info-circle mr-2"></i>Детали заявки
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-400">Услуга:</label>
                        <p class="text-light text-lg"><?= htmlspecialchars($lead['service_type']) ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-400">Бюджет:</label>
                        <p class="text-light"><?= htmlspecialchars($lead['budget'] ?? 'Не указан') ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-400">Статус:</label>
                        <span class="<?= $lead['status'] == 'new' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-highlight/20 text-highlight' ?> px-3 py-1 rounded-full text-sm font-medium">
                        <?= $lead['status'] == 'new' ? 'Новая' : 'Обработана' ?>
                    </span>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-400">Дата создания:</label>
                        <p class="text-light"><?= date('d.m.Y H:i', strtotime($lead['created_at'])) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Сообщение -->
        <?php if ($lead['message']): ?>
            <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
                <h2 class="text-xl font-bold text-highlight mb-4">
                    <i class="fas fa-comment mr-2"></i>Сообщение от клиента
                </h2>
                <div class="bg-primary/50 p-4 rounded-lg">
                    <p class="text-light leading-relaxed"><?= nl2br(htmlspecialchars($lead['message'])) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Действия -->
        <div class="flex justify-end space-x-4">
            <a href="/admin.php?action=leads_list" class="bg-primary text-light px-6 py-3 rounded-lg border border-highlight/30 hover:bg-highlight/20 transition-all duration-300 no-underline">
                <i class="fas fa-arrow-left mr-2"></i>Назад к списку
            </a>
            <?php if ($lead['status'] == 'new'): ?>
                <a href="/admin.php?action=leads_process&id=<?= $lead['id'] ?>" class="bg-highlight text-primary font-semibold px-6 py-3 rounded-lg border-2 border-highlight hover:bg-transparent hover:text-highlight transition-all duration-300 no-underline">
                    <i class="fas fa-check mr-2"></i>Отметить как обработанную
                </a>
            <?php endif; ?>
        </div>
    </div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>