<?php
// app/views/admin/work_process_form.php
ob_start();
?>

    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-highlight"><?= $title ?></h1>

        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <form method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-light font-semibold mb-3">Номер этапа *</label>
                        <input type="number" name="step_number" value="<?= $item['step_number'] ?? '' ?>" required
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                               placeholder="1, 2, 3...">
                    </div>

                    <div>
                        <label class="block text-light font-semibold mb-3">Порядок отображения *</label>
                        <input type="number" name="step_order" value="<?= $item['step_order'] ?? 0 ?>" required
                               class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                               placeholder="Чем меньше число, тем выше в списке">
                    </div>
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Название этапа *</label>
                    <input type="text" name="title" value="<?= $item['title'] ?? '' ?>" required
                           class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"
                           placeholder="Например: Консультация, Проектирование, Реализация...">
                </div>

                <div>
                    <label class="block text-light font-semibold mb-3">Описание этапа</label>
                    <textarea name="description" rows="4" 
                              class="w-full px-4 py-3 bg-primary border border-highlight/30 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight placeholder-gray-500"
                              placeholder="Подробное описание этапа работы..."><?= $item['description'] ?? '' ?></textarea>
                </div>

                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" 
                               <?= isset($item['is_active']) ? ($item['is_active'] ? 'checked' : '') : 'checked' ?>
                               class="mr-3 w-4 h-4 text-highlight bg-primary border-highlight/30 rounded focus:ring-highlight focus:ring-2">
                        <span class="text-light">Активный этап</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-highlight/30">
                    <a href="/admin.php?action=work_process" 
                       class="bg-primary text-light px-6 py-3 rounded-lg border border-highlight/30 hover:bg-highlight/20 transition-all duration-300 no-underline">
                        Отмена
                    </a>
                    <button type="submit" 
                            class="bg-highlight text-primary font-semibold px-6 py-3 rounded-lg border-2 border-highlight hover:bg-transparent hover:text-highlight transition-all duration-300">
                        <?= isset($item) ? 'Обновить этап' : 'Создать этап' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>