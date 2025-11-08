<?php ob_start(); ?>
<div class="bg-secondary rounded-xl p-6 mb-6">
    <h1 class="text-2xl font-bold mb-6">Статистика кэша</h1>
    
    <!-- Основная статистика -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card p-4 rounded-lg">
            <div class="text-highlight text-sm font-semibold">Hit Ratio</div>
            <div class="text-2xl font-bold text-light"><?= $monitor_stats['hit_ratio'] ?? '0%' ?></div>
        </div>
        <div class="stat-card p-4 rounded-lg">
            <div class="text-green-400 text-sm font-semibold">Hits</div>
            <div class="text-2xl font-bold text-light"><?= $monitor_stats['hits'] ?? 0 ?></div>
        </div>
        <div class="stat-card p-4 rounded-lg">
            <div class="text-red-400 text-sm font-semibold">Misses</div>
            <div class="text-2xl font-bold text-light"><?= $monitor_stats['misses'] ?? 0 ?></div>
        </div>
        <div class="stat-card p-4 rounded-lg">
            <div class="text-blue-400 text-sm font-semibold">Total Operations</div>
            <div class="text-2xl font-bold text-light"><?= $monitor_stats['total_operations'] ?? 0 ?></div>
        </div>
    </div>
    
    <!-- Статистика файлов кэша -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="stat-card p-4 rounded-lg">
            <h3 class="text-lg font-semibold mb-4">Файлы кэша</h3>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-300">Всего файлов:</span>
                    <span class="text-highlight"><?= $cache_stats['total_files'] ?? 0 ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-300">Активных ключей:</span>
                    <span class="text-green-400"><?= $cache_stats['active_keys'] ?? 0 ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-300">Просроченных:</span>
                    <span class="text-red-400"><?= $cache_stats['expired_keys'] ?? 0 ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-300">Общий размер:</span>
                    <span class="text-blue-400"><?= $cache_stats['total_size'] ?? '0 B' ?></span>
                </div>
            </div>
        </div>
        
        <div class="stat-card p-4 rounded-lg">
            <h3 class="text-lg font-semibold mb-4">Действия</h3>
            <div class="space-y-3">
                <a href="/admin.php?action=reset_cache_stats" 
                   class="block w-full bg-highlight text-primary text-center py-2 px-4 rounded-lg hover:bg-highlight/80 transition-colors">
                   Сбросить статистику
                </a>
                <a href="/admin.php?action=actions_clear_cache&type=all" 
                   class="block w-full bg-red-600 text-white text-center py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">
                   Очистить весь кэш
                </a>
            </div>
        </div>
    </div>
    
    <!-- Последние операции -->
    <?php if (!empty($monitor_stats['recent_operations'])): ?>
    <div class="stat-card p-4 rounded-lg">
        <h3 class="text-lg font-semibold mb-4">Последние операции (10)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-highlight/30">
                        <th class="text-left py-2">Время</th>
                        <th class="text-left py-2">Тип</th>
                        <th class="text-left py-2">Ключ</th>
                        <th class="text-left py-2">Результат</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($monitor_stats['recent_operations'] as $op): ?>
                    <tr class="border-b border-highlight/10">
                        <td class="py-2 text-gray-300"><?= date('H:i:s', (int)$op['timestamp']) ?></td>
                        <td class="py-2">
                            <span class="<?= $op['type'] === 'get' ? 'text-blue-400' : 'text-green-400' ?>">
                                <?= strtoupper($op['type']) ?>
                            </span>
                        </td>
                        <td class="py-2 text-gray-300 font-mono text-xs"><?= substr($op['key'], 0, 50) ?></td>
                        <td class="py-2">
                            <?php if ($op['type'] === 'get'): ?>
                                <span class="<?= $op['hit'] ? 'text-green-400' : 'text-red-400' ?>">
                                    <?= $op['hit'] ? 'HIT' : 'MISS' ?>
                                </span>
                            <?php else: ?>
                                <span class="text-gray-400">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>