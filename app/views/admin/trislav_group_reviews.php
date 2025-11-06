<?php
ob_start();
?>

    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-highlight">Управление отзывами</h1>
            <a href="/admin.php?action=trislav_reviews_create"
               class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg hover:bg-highlight/80 transition-colors">
                + Добавить отзыв
            </a>
        </div>

        <?php if (isset($flash_message)): ?>
            <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-lg">
                <?= $flash_message ?>
            </div>
        <?php endif; ?>

        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                    <tr class="border-b border-highlight/30">
                        <th class="text-left py-3 px-4 text-light font-semibold">ID</th>
                        <th class="text-left py-3 px-4 text-light font-semibold">Изображение</th>
                        <th class="text-left py-3 px-4 text-light font-semibold">Автор</th>
                        <th class="text-left py-3 px-4 text-light font-semibold">Должность</th>
                        <th class="text-left py-3 px-4 text-light font-semibold">Статус</th>
                        <th class="text-left py-3 px-4 text-light font-semibold">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($reviews)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-400">
                                Отзывы не найдены
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($reviews as $review): ?>
                            <tr class="border-b border-highlight/20 hover:bg-highlight/5 transition-colors">
                                <td class="py-3 px-4 text-gray-300"><?= $review['id'] ?></td>
                                <td class="py-3 px-4">
                                    <?php if (!empty($review['image_url'])): ?>
                                        <img src="<?= htmlspecialchars($review['image_url']) ?>"
                                             alt="<?= htmlspecialchars($review['author_name'] ?? '') ?>"
                                             class="w-16 h-16 object-cover rounded-lg">
                                    <?php else: ?>
                                        <div class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center text-gray-400">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-light font-medium">
                                    <?= htmlspecialchars($review['author_name'] ?? '') ?>
                                </td>
                                <td class="py-3 px-4 text-gray-300">
                                    <?= htmlspecialchars($review['author_position'] ?? '') ?>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $review['is_active'] ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' ?>">
                                        <?= $review['is_active'] ? 'Активен' : 'Неактивен' ?>
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <a href="/admin.php?action=trislav_reviews_edit&id=<?= $review['id'] ?>"
                                           class="bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 px-3 py-1 rounded-lg transition-colors">
                                            <i class="fas fa-edit mr-1"></i> Редакт.
                                        </a>
                                        <form method="POST" action="/admin.php?action=trislav_reviews_toggle&id=<?= $review['id'] ?>"
                                              class="inline" onsubmit="return confirm('Изменить статус отзыва?')">
                                            <button type="submit" class="bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500/30 px-3 py-1 rounded-lg transition-colors">
                                                <i class="fas fa-toggle-<?= $review['is_active'] ? 'on' : 'off' ?> mr-1"></i>
                                                <?= $review['is_active'] ? 'Выкл.' : 'Вкл.' ?>
                                            </button>
                                        </form>
                                        <form method="POST" action="/admin.php?action=trislav_reviews_delete&id=<?= $review['id'] ?>"
                                              class="inline" onsubmit="return confirm('Удалить отзыв?')">
                                            <button type="submit" class="bg-red-500/20 text-red-400 hover:bg-red-500/30 px-3 py-1 rounded-lg transition-colors">
                                                <i class="fas fa-trash mr-1"></i> Удалить
                                            </button>
                                        </form>
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
include ROOT_PATH . '/app/views/layouts/admin.php';
?>