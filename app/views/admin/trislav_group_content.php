<?php ob_start(); ?>

<div class="space-y-6">
    <h1 class="text-3xl font-bold text-highlight">Управление контентом Трислав Групп</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Блок клиентов -->
        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <h2 class="text-xl font-bold text-highlight mb-4">Клиенты</h2>
            <p class="text-gray-400 mb-4">Управление компаниями в слайдере "Нам доверяют"</p>
            <div class="flex flex-col space-y-2">
                <a href="/admin.php?action=trislav_clients" class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline text-center">
                    Управлять клиентами
                </a>
                <a href="/admin.php?action=trislav_clients_create" class="bg-transparent text-highlight font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline text-center">
                    + Добавить клиента
                </a>
            </div>
        </div>

        <!-- Блок отзывов -->
        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <h2 class="text-xl font-bold text-highlight mb-4">Отзывы</h2>
            <p class="text-gray-400 mb-4">Управление отзывами клиентов</p>
            <div class="flex flex-col space-y-2">
                <a href="/admin.php?action=trislav_reviews" class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline text-center">
                    Управлять отзывами
                </a>
                <a href="/admin.php?action=trislav_reviews_create" class="bg-transparent text-highlight font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline text-center">
                    + Добавить отзыв
                </a>
            </div>
        </div>

        <!-- Блок преимуществ -->
        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <h2 class="text-xl font-bold text-highlight mb-4">Преимущества</h2>
            <p class="text-gray-400 mb-4">Управление блоком преимуществ компании</p>
            <div class="flex flex-col space-y-2">
                <a href="/admin.php?action=trislav_advantages" class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline text-center">
                    Управлять преимуществами
                </a>
                <a href="/admin.php?action=trislav_advantages_create" class="bg-transparent text-highlight font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline text-center">
                    + Добавить преимущество
                </a>
            </div>
        </div>

        <!-- Блок проектов -->
        <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
            <h2 class="text-xl font-bold text-highlight mb-4">Проекты</h2>
            <p class="text-gray-400 mb-4">Управление проектами компании</p>
            <div class="flex flex-col space-y-2">
                <a href="/admin.php?action=trislav_projects" class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline text-center">
                    Управлять проектами
                </a>
                <a href="/admin.php?action=trislav_projects_create" class="bg-transparent text-highlight font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline text-center">
                    + Добавить проект
                </a>
            </div>
        </div>
    </div>

    <!-- Статистика -->
    <div class="bg-secondary rounded-xl p-6 border border-highlight/30 mt-6">
        <h2 class="text-xl font-bold text-highlight mb-4">Статистика контента</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-primary/50 rounded-lg">
                <div class="text-2xl font-bold text-highlight"><?= count($clients ?? []) ?></div>
                <div class="text-gray-400 text-sm">Клиентов</div>
            </div>
            <div class="text-center p-4 bg-primary/50 rounded-lg">
                <div class="text-2xl font-bold text-highlight"><?= count($reviews ?? []) ?></div>
                <div class="text-gray-400 text-sm">Отзывов</div>
            </div>
            <div class="text-center p-4 bg-primary/50 rounded-lg">
                <div class="text-2xl font-bold text-highlight"><?= count($advantages ?? []) ?></div>
                <div class="text-gray-400 text-sm">Преимуществ</div>
            </div>
            <div class="text-center p-4 bg-primary/50 rounded-lg">
                <div class="text-2xl font-bold text-highlight"><?= count($projects ?? []) ?></div>
                <div class="text-gray-400 text-sm">Проектов</div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>
