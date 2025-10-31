<?php
ob_start(); 
$success = $_GET['success'] ?? false;
?>

<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-highlight">Управление проектами</h1>
        <a href="/admin.php?action=trislav_projects_create" class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline">
            + Добавить проект
        </a>
    </div>

    <?php if ($success): ?>
    <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded-lg">
        Изменения успешно сохранены!
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        <?php if (empty($projects)): ?>
        <div class="col-span-full text-center py-12 text-gray-400">
            Проекты не найдены. <a href="/admin.php?action=trislav_projects_create" class="text-highlight hover:underline">Добавить первый проект</a>
        </div>
        <?php else: ?>
        <?php foreach ($projects as $project): ?>
        <div class="bg-secondary rounded-xl border border-highlight/30 overflow-hidden hover:border-highlight/50 transition-colors">
            <?php if ($project['image_url']): ?>
            <div class="h-40 overflow-hidden">
                <img src="<?= htmlspecialchars($project['image_url']) ?>" alt="<?= htmlspecialchars($project['title']) ?>" class="w-full h-full object-cover">
            </div>
            <?php else: ?>
            <div class="h-40 bg-primary/50 flex items-center justify-center">
                <i class="fas fa-image text-highlight/50 text-4xl"></i>
            </div>
            <?php endif; ?>
            
            <div class="p-6">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-bold text-light text-lg"><?= htmlspecialchars($project['title']) ?></h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $project['is_active'] ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' ?>">
                        <?= $project['is_active'] ? 'Активен' : 'Скрыт' ?>
                    </span>
                </div>
                
                <p class="text-gray-300 text-sm mb-4 line-clamp-2"><?= htmlspecialchars($project['description'] ?? '') ?></p>
                
                <?php if ($project['tags']): ?>
                <div class="flex flex-wrap gap-1 mb-4">
                    <?php 
                    $tags = explode(',', $project['tags']);
                    foreach ($tags as $tag): 
                        if (trim($tag)):
                    ?>
                    <span class="bg-highlight/20 text-highlight px-2 py-1 rounded-full text-xs"><?= htmlspecialchars(trim($tag)) ?></span>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
                <?php endif; ?>
                
                <div class="flex space-x-2">
                    <a href="/admin.php?action=trislav_projects_edit&id=<?= $project['id'] ?>" class="flex-1 bg-blue-500/20 text-blue-300 px-3 py-2 rounded-lg text-sm hover:bg-blue-500/30 transition-colors no-underline text-center">
                        Редактировать
                    </a>
                    <a href="/admin.php?action=trislav_projects_toggle&id=<?= $project['id'] ?>" class="flex-1 bg-yellow-500/20 text-yellow-300 px-3 py-2 rounded-lg text-sm hover:bg-yellow-500/30 transition-colors no-underline text-center">
                        <?= $project['is_active'] ? 'Скрыть' : 'Показать' ?>
                    </a>
                </div>
                
                <?php if ($project['project_url']): ?>
                <div class="mt-3 pt-3 border-t border-highlight/10">
                    <a href="<?= htmlspecialchars($project['project_url']) ?>" target="_blank" class="text-highlight text-sm hover:underline no-underline flex items-center">
                        <i class="fas fa-external-link-alt mr-1"></i>
                        Перейти к проекту
                    </a>
                </div>
                <?php endif; ?>
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
