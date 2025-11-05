<?php
ob_start();
?>

    <div class="space-y-6">
        <!-- Заголовок и кнопка добавления -->
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-highlight">Управление торговыми центрами</h1>
            <a href="/admin.php?action=trislav_shopping_centers_create"
               class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline">
                <i class="fas fa-plus mr-2"></i>Добавить ТЦ
            </a>
        </div>

        <!-- Сообщения об успехе/ошибке -->
        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>
                <?php
                switch ($_GET['success']) {
                    case '1': echo 'Торговый центр успешно создан'; break;
                    case '2': echo 'Торговый центр успешно обновлен'; break;
                    default: echo 'Операция выполнена успешно';
                }
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <?php
                switch ($_GET['error']) {
                    case '1': echo 'Ошибка при создании торгового центра'; break;
                    case '2': echo 'Ошибка при обновлении торгового центра'; break;
                    case 'no_id': echo 'Не указан ID торгового центра'; break;
                    case 'no_videos': echo 'Для этого ТЦ нет видео'; break;
                    case 'no_videos_found': echo 'Не удалось найти видео для скачивания'; break;
                    case 'download_failed': echo 'Ошибка при скачивании видео'; break;
                    default: echo 'Произошла ошибка';
                }
                ?>
            </div>
        <?php endif; ?>

        <!-- Таблица торговых центров -->
        <div class="bg-secondary rounded-xl border border-highlight/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-highlight/30">
                    <thead class="bg-primary/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-light uppercase tracking-wider">
                            Название
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-light uppercase tracking-wider">
                            Адрес
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-light uppercase tracking-wider">
                            Порядок
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-light uppercase tracking-wider">
                            Статус
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-light uppercase tracking-wider">
                            Действия
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-secondary divide-y divide-highlight/30">
                    <?php if (!empty($centers)): ?>
                        <?php foreach ($centers as $center): ?>
                            <tr class="hover:bg-primary/30 transition-colors duration-300">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-light">
                                        <?= htmlspecialchars($center['title']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-300">
                                        <?= htmlspecialchars($center['address'] ?? 'Не указан') ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-300">
                                        <?= $center['order_index'] ?? 0 ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        <?= $center['is_active'] ? 'bg-green-500/20 text-green-300' : 'bg-gray-500/20 text-gray-300' ?>">
                                        <?= $center['is_active'] ? 'Активен' : 'Неактивен' ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="/admin.php?action=trislav_shopping_centers_edit&id=<?= $center['id'] ?>"
                                           class="text-blue-400 hover:text-blue-300 transition-colors duration-300"
                                           title="Редактировать">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/admin.php?action=trislav_shopping_centers_toggle&id=<?= $center['id'] ?>"
                                           class="text-<?= $center['is_active'] ? 'green' : 'gray' ?>-400 hover:text-<?= $center['is_active'] ? 'green' : 'gray' ?>-300 transition-colors duration-300"
                                           title="<?= $center['is_active'] ? 'Деактивировать' : 'Активировать' ?>">
                                            <i class="fas fa-<?= $center['is_active'] ? 'eye' : 'eye-slash' ?>"></i>
                                        </a>
                                        <!-- НОВАЯ КНОПКА СКАЧИВАНИЯ ВИДЕО -->
                                        <a href="/admin.php?action=download_shopping_center_videos&shopping_center_id=<?= $center['id'] ?>"
                                           class="text-purple-400 hover:text-purple-300 transition-colors duration-300"
                                           title="Скачать все видео для этого ТЦ"
                                           onclick="return confirm('Скачать все видео для ТЦ <?= htmlspecialchars(addslashes($center['title'])) ?>?')">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <a href="/admin.php?action=trislav_shopping_centers_delete&id=<?= $center['id'] ?>"
                                           class="text-red-400 hover:text-red-300 transition-colors duration-300"
                                           title="Удалить"
                                           onclick="return confirm('Удалить торговый центр <?= htmlspecialchars(addslashes($center['title'])) ?>?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-400">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-store-slash text-4xl mb-4 text-gray-500"></i>
                                    <p class="text-lg">Торговые центры не найдены</p>
                                    <p class="text-sm text-gray-400 mt-2">Добавьте первый торговый центр</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Статистика -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="stat-card rounded-xl p-6 text-center">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-store text-highlight text-xl"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-light mb-2"><?= count($centers) ?></h3>
                <p class="text-gray-400">Всего ТЦ</p>
            </div>

            <div class="stat-card rounded-xl p-6 text-center">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-eye text-green-500 text-xl"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-light mb-2">
                    <?= count(array_filter($centers, function($center) { return $center['is_active']; })) ?>
                </h3>
                <p class="text-gray-400">Активных ТЦ</p>
            </div>

            <div class="stat-card rounded-xl p-6 text-center">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-12 bg-purple-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-video text-purple-500 text-xl"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-light mb-2">
                    <?= count(array_filter($centers, function($center) {
                        // Здесь можно добавить логику подсчета ТЦ с видео
                        return $center['is_active'];
                    })) ?>
                </h3>
                <p class="text-gray-400">ТЦ с видео</p>
            </div>
        </div>
    </div>

    <style>
        .stat-card {
            background: linear-gradient(135deg, rgba(26, 26, 46, 0.8), rgba(22, 33, 62, 0.8));
            border: 1px solid rgba(0, 183, 194, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            border-color: rgba(0, 183, 194, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 183, 194, 0.1);
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            background: rgba(26, 26, 46, 0.8);
            backdrop-filter: blur(10px);
        }

        tr:last-child td {
            border-bottom: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Добавляем анимацию появления строк таблицы
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    row.style.transition = 'all 0.5s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>