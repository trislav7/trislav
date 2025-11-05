<?php
ob_start();
$success = $_GET['success'] ?? false;
?>

<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-highlight">Управление преимуществами</h1>
        <a href="/admin.php?action=trislav_advantages_create" class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline">
            + Добавить преимущество
        </a>
    </div>

    <?php if ($success): ?>
        <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded-lg">
            Изменения успешно сохранены!
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
        <?php if (empty($advantages)): ?>
            <div class="col-span-full text-center py-12 text-gray-400">
                Преимущества не найдены. <a href="/admin.php?action=trislav_advantages_create" class="text-highlight hover:underline">Добавить первое преимущество</a>
            </div>
        <?php else: ?>
            <?php foreach ($advantages as $advantage): ?>
                <div class="bg-secondary rounded-xl p-6 border border-highlight/30 hover:border-highlight/50 transition-colors">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <?php if ($advantage['icon_class']): ?>
                                <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center">
                                    <i class="<?= htmlspecialchars($advantage['icon_class']) ?> text-highlight"></i>
                                </div>
                            <?php else: ?>
                                <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-star text-highlight"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <h3 class="font-bold text-light"><?= htmlspecialchars($advantage['title']) ?></h3>
                                <p class="text-gray-400 text-sm">Порядок: <?= $advantage['order_index'] ?></p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $advantage['is_active'] ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' ?>">
                    <?= $advantage['is_active'] ? 'Активно' : 'Скрыто' ?>
                </span>
                    </div>

                    <p class="text-gray-300 text-sm mb-4"><?= htmlspecialchars($advantage['description'] ?? '') ?></p>

                    <div class="flex space-x-2">
                        <a href="/admin.php?action=trislav_advantages_edit&id=<?= $advantage['id'] ?>" class="flex-1 bg-blue-500/20 text-blue-300 px-3 py-2 rounded-lg text-sm hover:bg-blue-500/30 transition-colors no-underline text-center">
                            Редактировать
                        </a>
                        <a href="/admin.php?action=trislav_advantages_toggle&id=<?= $advantage['id'] ?>" class="flex-1 bg-yellow-500/20 text-yellow-300 px-3 py-2 rounded-lg text-sm hover:bg-yellow-500/30 transition-colors no-underline text-center">
                            <?= $advantage['is_active'] ? 'Скрыть' : 'Показать' ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>
