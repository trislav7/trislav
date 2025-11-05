<?php
ob_start();
$success = $_GET['success'] ?? false;
?>

<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-highlight">Управление отзывами</h1>
        <a href="/admin.php?action=trislav_reviews_create" class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline">
            + Добавить отзыв
        </a>
    </div>

    <?php if ($success): ?>
        <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded-lg">
            Изменения успешно сохранены!
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (empty($reviews)): ?>
            <div class="col-span-full text-center py-12 text-gray-400">
                Отзывы не найдены. <a href="/admin.php?action=trislav_reviews_create" class="text-highlight hover:underline">Добавить первый отзыв</a>
            </div>
        <?php else: ?>
            <?php foreach ($reviews as $review): ?>
                <div class="bg-secondary rounded-xl p-6 border border-highlight/30 hover:border-highlight/50 transition-colors">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <?php if ($review['image_url']): ?>
                                <img src="<?= htmlspecialchars($review['image_url']) ?>" alt="<?= htmlspecialchars($review['title']) ?>" class="w-12 h-12 rounded-full object-cover">
                            <?php else: ?>
                                <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center">
                                    <span class="text-lg font-bold text-highlight"><?= mb_substr($review['title'], 0, 1) ?></span>
                                </div>
                            <?php endif; ?>
                            <div>
                                <h3 class="font-bold text-light"><?= htmlspecialchars($review['title']) ?></h3>
                                <p class="text-gray-400 text-sm"><?= htmlspecialchars($review['author_position'] ?? '') ?></p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $review['is_active'] ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' ?>">
                    <?= $review['is_active'] ? 'Активен' : 'Скрыт' ?>
                </span>
                    </div>

                    <p class="text-gray-300 text-sm mb-4 line-clamp-3"><?= htmlspecialchars($review['description'] ?? '') ?></p>

                    <div class="flex space-x-2">
                        <a href="/admin.php?action=trislav_reviews_edit&id=<?= $review['id'] ?>" class="flex-1 bg-blue-500/20 text-blue-300 px-3 py-2 rounded-lg text-sm hover:bg-blue-500/30 transition-colors no-underline text-center">
                            Редактировать
                        </a>
                        <a href="/admin.php?action=trislav_reviews_toggle&id=<?= $review['id'] ?>" class="flex-1 bg-yellow-500/20 text-yellow-300 px-3 py-2 rounded-lg text-sm hover:bg-yellow-500/30 transition-colors no-underline text-center">
                            <?= $review['is_active'] ? 'Скрыть' : 'Показать' ?>
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
