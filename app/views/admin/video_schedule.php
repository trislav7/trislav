<?php ob_start(); ?>
    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-highlight">Рекламная сетка LED экранов</h1>

        <!-- Фильтры -->
        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                <div>
                    <label class="block text-light font-semibold mb-2">Торговый центр</label>
                    <select id="center-select" class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light">
                        <?php foreach ($shopping_centers as $center): ?>
                            <option value="<?= $center['id'] ?>" <?= $selected_center == $center['id'] ? 'selected' : '' ?>>
                                <?= $center['title'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex space-x-2">
                    <?php if ($selected_center): ?>
                        <a href="/admin.php?action=download_shopping_center_videos&shopping_center_id=<?= $selected_center ?>"
                           class="bg-green-600 text-light font-semibold py-3 px-6 rounded-lg transition-colors hover:bg-green-700 no-underline inline-flex items-center">
                            <i class="fas fa-download mr-2"></i>
                            Скачать архив видео
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if ($selected_center): ?>
            <!-- Статистика -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <?php for ($block = 1; $block <= 4; $block++): ?>
                    <?php
                    $blockData = $generated_schedule["block_$block"] ?? [];
                    $clientCount = count(array_unique(array_column($blockData, 'client_id')));
                    ?>
                    <div class="bg-secondary rounded-xl p-4 text-center border border-highlight/30">
                        <div class="text-2xl font-bold text-highlight">Блок <?= $block ?></div>
                        <div class="text-light"><?= count($blockData) ?> видео</div>
                        <div class="text-gray-400 text-sm"><?= $clientCount ?> клиентов</div>
                    </div>
                <?php endfor; ?>
            </div>

            <!-- Сетка вещания -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6">
                <?php for ($block = 1; $block <= 4; $block++): ?>
                    <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
                        <h3 class="text-xl font-bold text-highlight mb-4 text-center">
                            Блок <?= $block ?>
                            <span class="text-sm text-gray-400">(<?= ($block-1)*2 ?>-<?= $block*2 ?> мин)</span>
                        </h3>

                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            <?php $blockVideos = $generated_schedule["block_$block"] ?? []; ?>
                            <?php foreach ($blockVideos as $index => $video): ?>
                                <div class="bg-primary/50 rounded-lg p-3 border border-highlight/20">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="text-sm font-semibold text-light">
                                                <?= $index + 1 ?>. <?= $video['client_name'] ?>
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                Тариф: <?= $video['tariff_name'] ?>
                                            </div>
                                            <div class="text-xs text-gray-500 truncate">
                                                <?= $video['video_filename'] ?? 'default' ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

            <!-- Информация о клиентах -->
            <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
                <h3 class="text-xl font-bold text-light mb-4">Клиенты в этом ТЦ</h3>
                <?php
                if (isset($selected_center) && $selected_center) {
                    $videoScheduleModel = new VideoSchedule();
                    $clients = $videoScheduleModel->getClientsForShoppingCenter($selected_center);
                } else {
                    $clients = [];
                }
                ?>

                <?php if (!empty($clients)): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php foreach ($clients as $client): ?>
                            <div class="bg-primary/50 rounded-lg p-4 border border-highlight/20">
                                <div class="text-lg font-semibold text-light"><?= $client['client_name'] ?></div>
                                <div class="text-sm text-gray-400">Тариф: <?= $client['tariff_name'] ?></div>
                                <div class="text-xs text-gray-500 truncate"><?= $client['video_filename'] ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-400 text-center py-4">Нет клиентов с видео для LED экранов в этом ТЦ</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const centerSelect = document.getElementById('center-select');

            centerSelect.addEventListener('change', function() {
                const selectedCenterId = this.value;
                window.location.href = '/admin.php?action=video_schedule&center_id=' + selectedCenterId;
            });
        });
    </script>

    <style>
        .video-item {
            transition: all 0.3s ease;
            cursor: move;
        }

        .video-item:hover {
            border-color: #00b7c2;
            transform: translateY(-2px);
        }
    </style>
<?php
$content = ob_get_clean();
include ROOT_PATH . '/app/views/layouts/admin.php';
?>