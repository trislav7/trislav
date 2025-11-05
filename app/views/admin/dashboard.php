<?php ob_start(); ?>

    <div class="space-y-6">
        <!-- Заголовок -->
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-highlight">Дашборд</h1>
            <div class="text-gray-400">
                <i class="fas fa-calendar-alt mr-2"></i>
                <?= date('d.m.Y') ?>
            </div>
        </div>

        <!-- Статистика -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="stat-card rounded-xl p-6 text-center">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-envelope text-highlight text-xl"></i>
                    </div>
                </div>
                <p class="text-gray-300 text-sm mb-2">Новые заявки</p>
                <p class="text-3xl font-bold text-highlight"><?= $newLeadsCount ?></p>
            </div>

            <div class="stat-card rounded-xl p-6 text-center">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-cog text-highlight text-xl"></i>
                    </div>
                </div>
                <p class="text-gray-300 text-sm mb-2">Активные услуги</p>
                <p class="text-3xl font-bold text-highlight"><?= $servicesCount ?></p>
            </div>

            <div class="stat-card rounded-xl p-6 text-center">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-images text-highlight text-xl"></i>
                    </div>
                </div>
                <p class="text-gray-300 text-sm mb-2">Работ в портфолио</p>
                <p class="text-3xl font-bold text-highlight"><?= $portfolioCount ?></p>
            </div>
        </div>

        <!-- Быстрые действия -->
        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <h2 class="text-xl font-bold text-highlight mb-6">Быстрые действия</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="/admin.php?action=services_create" class="bg-secondary hover:bg-highlight/20 border border-highlight/30 rounded-lg p-4 text-center transition-all duration-300 hover:border-highlight group">
                    <i class="fas fa-plus-circle text-highlight text-2xl mb-3 group-hover:scale-110 transition-transform"></i>
                    <p class="font-semibold text-light">Добавить услугу</p>
                    <p class="text-gray-400 text-sm mt-1">Создать новую услугу</p>
                </a>

                <a href="/admin.php?action=tariffs_create" class="bg-secondary hover:bg-highlight/20 border border-highlight/30 rounded-lg p-4 text-center transition-all duration-300 hover:border-highlight group">
                    <i class="fas fa-tag text-highlight text-2xl mb-3 group-hover:scale-110 transition-transform"></i>
                    <p class="font-semibold text-light">Добавить тариф</p>
                    <p class="text-gray-400 text-sm mt-1">Создать новый тариф</p>
                </a>

                <a href="/admin.php?action=portfolio_create" class="bg-secondary hover:bg-highlight/20 border border-highlight/30 rounded-lg p-4 text-center transition-all duration-300 hover:border-highlight group">
                    <i class="fas fa-plus-square text-highlight text-2xl mb-3 group-hover:scale-110 transition-transform"></i>
                    <p class="font-semibold text-light">Добавить работу</p>
                    <p class="text-gray-400 text-sm mt-1">Добавить в портфолио</p>
                </a>

                <a href="/admin.php?action=leads_list" class="bg-secondary hover:bg-highlight/20 border border-highlight/30 rounded-lg p-4 text-center transition-all duration-300 hover:border-highlight group">
                    <i class="fas fa-eye text-highlight text-2xl mb-3 group-hover:scale-110 transition-transform"></i>
                    <p class="font-semibold text-light">Просмотр заявок</p>
                    <p class="text-gray-400 text-sm mt-1">Все заявки клиентов</p>
                </a>
            </div>
        </div>

        <!-- Последние действия -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Последние заявки -->
            <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
                <h2 class="text-xl font-bold text-highlight mb-4">Последние заявки</h2>
                <div class="space-y-3">
                    <?php
                    $leadModel = new Lead();
                    $recentLeads = $leadModel->getAll();
                    $recentLeads = array_slice($recentLeads, 0, 5);
                    ?>

                    <?php if (!empty($recentLeads)): ?>
                        <?php foreach ($recentLeads as $lead): ?>
                            <div class="flex items-center justify-between p-3 bg-primary/50 rounded-lg">
                                <div>
                                    <p class="font-semibold text-light"><?= htmlspecialchars($lead['name']) ?></p>
                                    <p class="text-gray-400 text-sm"><?= htmlspecialchars($lead['service_type']) ?></p>
                                </div>
                                <span class="text-xs px-2 py-1 rounded <?= $lead['status'] == 'new' ? 'bg-highlight/20 text-highlight' : 'bg-green-500/20 text-green-400' ?>">
                            <?= $lead['status'] == 'new' ? 'Новая' : 'Обработана' ?>
                        </span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-400 text-center py-4">Заявок пока нет</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Статус системы -->
            <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
                <h2 class="text-xl font-bold text-highlight mb-4">Статус системы</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-300">База данных</span>
                        <span class="text-highlight font-semibold">
                        <i class="fas fa-check-circle mr-1"></i> Активна
                    </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-300">Файловая система</span>
                        <span class="text-highlight font-semibold">
                        <i class="fas fa-check-circle mr-1"></i> Доступна
                    </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-300">Загрузка CPU</span>
                        <span class="text-highlight font-semibold">12%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-300">Память</span>
                        <span class="text-highlight font-semibold">64%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>