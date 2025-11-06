<?php ob_start(); ?>

    <div class="space-y-6">
        <!-- Заголовок и статистика -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-highlight">Дашборд Трислав Групп</h1>
                <p class="text-gray-400 mt-2">Обзор контента и управление разделами</p>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-400">
                <i class="fas fa-sync-alt"></i>
                <span>Обновлено: <?= date('d.m.Y H:i') ?></span>
            </div>
        </div>

        <!-- Статистика в реальном времени -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Клиенты -->
            <div class="stat-card rounded-xl p-4 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-highlight/10 rounded-full -mr-4 -mt-4"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-users text-highlight text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-light mb-1"><?= count($clients ?? []) ?></h3>
                    <p class="text-gray-400 text-sm">Клиентов</p>
                    <div class="mt-2">
                        <a href="/admin.php?action=trislav_clients" class="text-highlight hover:text-light text-xs transition-colors">
                            Управлять →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Отзывы -->
            <div class="stat-card rounded-xl p-4 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-green-500/10 rounded-full -mr-4 -mt-4"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-star text-green-400 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-light mb-1"><?= count($reviews ?? []) ?></h3>
                    <p class="text-gray-400 text-sm">Отзывов</p>
                    <div class="mt-2">
                        <a href="/admin.php?action=trislav_reviews" class="text-green-400 hover:text-light text-xs transition-colors">
                            Управлять →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Преимущества -->
            <div class="stat-card rounded-xl p-4 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-blue-500/10 rounded-full -mr-4 -mt-4"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-chart-line text-blue-400 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-light mb-1"><?= count($advantages ?? []) ?></h3>
                    <p class="text-gray-400 text-sm">Преимуществ</p>
                    <div class="mt-2">
                        <a href="/admin.php?action=led_advantages&category=trislav_group" class="text-blue-400 hover:text-light text-xs transition-colors">
                            Управлять →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Проекты -->
            <div class="stat-card rounded-xl p-4 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-purple-500/10 rounded-full -mr-4 -mt-4"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-briefcase text-purple-400 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-light mb-1"><?= count($projects ?? []) ?></h3>
                    <p class="text-gray-400 text-sm">Проектов</p>
                    <div class="mt-2">
                        <a href="/admin.php?action=trislav_projects" class="text-purple-400 hover:text-light text-xs transition-colors">
                            Управлять →
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Быстрый доступ -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Клиенты -->
            <div class="bg-secondary rounded-xl p-6 border border-highlight/30 hover:border-highlight/50 transition-all duration-300 hover:transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-highlight/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-users text-highlight"></i>
                    </div>
                    <h2 class="text-lg font-bold text-highlight">Клиенты</h2>
                </div>
                <p class="text-gray-400 text-sm mb-4">Управление компаниями в слайдере "Нам доверяют"</p>
                <div class="flex flex-col space-y-2">
                    <a href="/admin.php?action=trislav_clients" class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline text-center text-sm">
                        Управлять клиентами
                    </a>
                    <a href="/admin.php?action=trislav_clients_create" class="bg-transparent text-highlight font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline text-center text-sm">
                        + Добавить клиента
                    </a>
                </div>
            </div>

            <!-- Отзывы -->
            <div class="bg-secondary rounded-xl p-6 border border-green-500/30 hover:border-green-500/50 transition-all duration-300 hover:transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-star text-green-400"></i>
                    </div>
                    <h2 class="text-lg font-bold text-green-400">Отзывы</h2>
                </div>
                <p class="text-gray-400 text-sm mb-4">Управление отзывами клиентов</p>
                <div class="flex flex-col space-y-2">
                    <a href="/admin.php?action=trislav_reviews" class="bg-green-500 text-primary font-semibold py-2 px-4 rounded-lg border-2 border-green-500 transition-all duration-300 hover:bg-transparent hover:text-green-400 no-underline text-center text-sm">
                        Управлять отзывами
                    </a>
                    <a href="/admin.php?action=trislav_reviews_create" class="bg-transparent text-green-400 font-semibold py-2 px-4 rounded-lg border-2 border-green-500 transition-all duration-300 hover:bg-green-500 hover:text-primary no-underline text-center text-sm">
                        + Добавить отзыв
                    </a>
                </div>
            </div>

            <!-- Преимущества -->
            <div class="bg-secondary rounded-xl p-6 border border-blue-500/30 hover:border-blue-500/50 transition-all duration-300 hover:transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-chart-line text-blue-400"></i>
                    </div>
                    <h2 class="text-lg font-bold text-blue-400">Преимущества</h2>
                </div>
                <p class="text-gray-400 text-sm mb-4">Управление блоком преимуществ компании</p>
                <div class="flex flex-col space-y-2">
                    <a href="/admin.php?action=led_advantages&category=trislav_group" class="bg-blue-500 text-primary font-semibold py-2 px-4 rounded-lg border-2 border-blue-500 transition-all duration-300 hover:bg-transparent hover:text-blue-400 no-underline text-center text-sm">
                        Управлять преимуществами
                    </a>
                    <a href="/admin.php?action=led_advantages_create&category=trislav_group" class="bg-transparent text-blue-400 font-semibold py-2 px-4 rounded-lg border-2 border-blue-500 transition-all duration-300 hover:bg-blue-500 hover:text-primary no-underline text-center text-sm">
                        + Добавить преимущество
                    </a>
                </div>
            </div>

            <!-- Проекты -->
            <div class="bg-secondary rounded-xl p-6 border border-purple-500/30 hover:border-purple-500/50 transition-all duration-300 hover:transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-briefcase text-purple-400"></i>
                    </div>
                    <h2 class="text-lg font-bold text-purple-400">Проекты</h2>
                </div>
                <p class="text-gray-400 text-sm mb-4">Управление проектами компании</p>
                <div class="flex flex-col space-y-2">
                    <a href="/admin.php?action=trislav_projects" class="bg-purple-500 text-primary font-semibold py-2 px-4 rounded-lg border-2 border-purple-500 transition-all duration-300 hover:bg-transparent hover:text-purple-400 no-underline text-center text-sm">
                        Управлять проектами
                    </a>
                    <a href="/admin.php?action=trislav_projects_create" class="bg-transparent text-purple-400 font-semibold py-2 px-4 rounded-lg border-2 border-purple-500 transition-all duration-300 hover:bg-purple-500 hover:text-primary no-underline text-center text-sm">
                        + Добавить проект
                    </a>
                </div>
            </div>
        </div>

        <!-- Дополнительные разделы -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Заявки -->
            <div class="bg-secondary rounded-xl p-6 border border-yellow-500/30 hover:border-yellow-500/50 transition-all duration-300 hover:transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-envelope text-yellow-400"></i>
                    </div>
                    <h2 class="text-lg font-bold text-yellow-400">Заявки</h2>
                </div>
                <p class="text-gray-400 text-sm mb-4">Просмотр и обработка заявок</p>
                <div class="flex flex-col space-y-2">
                    <a href="/admin.php?action=leads_list" class="bg-yellow-500 text-primary font-semibold py-2 px-4 rounded-lg border-2 border-yellow-500 transition-all duration-300 hover:bg-transparent hover:text-yellow-400 no-underline text-center text-sm">
                        Управлять заявками
                    </a>
                    <a href="/admin.php?action=leads_list" class="bg-transparent text-yellow-400 font-semibold py-2 px-4 rounded-lg border-2 border-yellow-500 transition-all duration-300 hover:bg-yellow-500 hover:text-primary no-underline text-center text-sm">
                        Просмотреть все
                    </a>
                </div>
            </div>
            <!-- Услуги -->
            <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-highlight">Услуги</h2>
                    <div class="w-8 h-8 bg-highlight/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-cog text-highlight"></i>
                    </div>
                </div>
                <p class="text-gray-400 mb-4">Управление услугами компании</p>
                <div class="flex space-x-2">
                    <a href="/admin.php?action=services_list" class="flex-1 bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline text-center text-sm">
                        Управлять услугами
                    </a>
                    <a href="/admin.php?action=services_create" class="flex-1 bg-transparent text-highlight font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline text-center text-sm">
                        + Добавить
                    </a>
                </div>
            </div>

            <!-- Тарифы -->
            <div class="bg-secondary rounded-xl p-6 border border-highlight/30">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-highlight">Тарифы</h2>
                    <div class="w-8 h-8 bg-highlight/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-tags text-highlight"></i>
                    </div>
                </div>
                <p class="text-gray-400 mb-4">Управление тарифными планами</p>
                <div class="flex space-x-2">
                    <a href="/admin.php?action=tariffs_list" class="flex-1 bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline text-center text-sm">
                        Управлять тарифами
                    </a>
                    <a href="/admin.php?action=tariffs_create" class="flex-1 bg-transparent text-highlight font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline text-center text-sm">
                        + Добавить
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>