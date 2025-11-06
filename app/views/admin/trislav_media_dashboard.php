<?php ob_start(); ?>

<div class="space-y-6">
    <!-- Заголовок и статистика -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-highlight">Дашборд Трислав Медиа</h1>
            <p class="text-gray-400 mt-2">Управление LED-рекламой и портфолио</p>
        </div>
        <div class="flex items-center space-x-2 text-sm text-gray-400">
            <i class="fas fa-sync-alt"></i>
            <span>Обновлено: <?= date('d.m.Y H:i') ?></span>
        </div>
    </div>

    <!-- Статистика в реальном времени -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- Портфолио -->
        <div class="stat-card rounded-xl p-4 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-highlight/10 rounded-full -mr-4 -mt-4"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-images text-highlight text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-light mb-1"><?= count($portfolio ?? []) ?></h3>
                <p class="text-gray-400 text-sm">Работ в портфолио</p>
                <div class="mt-2">
                    <a href="/admin.php?action=portfolio_list" class="text-highlight hover:text-light text-xs transition-colors">
                        Управлять →
                    </a>
                </div>
            </div>
        </div>

        <!-- Торговые центры -->
        <div class="stat-card rounded-xl p-4 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-green-500/10 rounded-full -mr-4 -mt-4"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-store text-green-400 text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-light mb-1"><?= count($shoppingCenters ?? []) ?></h3>
                <p class="text-gray-400 text-sm">Торговых центров</p>
                <div class="mt-2">
                    <a href="/admin.php?action=trislav_shopping_centers" class="text-green-400 hover:text-light text-xs transition-colors">
                        Управлять →
                    </a>
                </div>
            </div>
        </div>

        <!-- Заявки -->
        <div class="stat-card rounded-xl p-4 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-blue-500/10 rounded-full -mr-4 -mt-4"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-envelope text-blue-400 text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-light mb-1"><?= count($leads ?? []) ?></h3>
                <p class="text-gray-400 text-sm">Заявок</p>
                <div class="mt-2">
                    <a href="/admin.php?action=leads_list" class="text-blue-400 hover:text-light text-xs transition-colors">
                        Управлять →
                    </a>
                </div>
            </div>
        </div>

        <!-- Преимущества LED -->
        <div class="stat-card rounded-xl p-4 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-purple-500/10 rounded-full -mr-4 -mt-4"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-bolt text-purple-400 text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-light mb-1"><?= count($ledAdvantages ?? []) ?></h3>
                <p class="text-gray-400 text-sm">Преимуществ LED</p>
                <div class="mt-2">
                    <a href="/admin.php?action=led_advantages&category=led" class="text-purple-400 hover:text-light text-xs transition-colors">
                        Управлять →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Основные разделы -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Портфолио -->
        <div class="bg-secondary rounded-xl p-6 border border-highlight/30 hover:border-highlight/50 transition-all duration-300 hover:transform hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-highlight/20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-images text-highlight"></i>
                </div>
                <h2 class="text-lg font-bold text-highlight">Портфолио</h2>
            </div>
            <p class="text-gray-400 text-sm mb-4">Управление работами и проектами</p>
            <div class="flex flex-col space-y-2">
                <a href="/admin.php?action=portfolio_list" class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline text-center text-sm">
                    Управлять портфолио
                </a>
                <a href="/admin.php?action=portfolio_create" class="bg-transparent text-highlight font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline text-center text-sm">
                    + Добавить работу
                </a>
            </div>
        </div>

        <!-- Торговые центры -->
        <div class="bg-secondary rounded-xl p-6 border border-green-500/30 hover:border-green-500/50 transition-all duration-300 hover:transform hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-store text-green-400"></i>
                </div>
                <h2 class="text-lg font-bold text-green-400">Торговые центры</h2>
            </div>
            <p class="text-gray-400 text-sm mb-4">Управление локациями для LED-экранов</p>
            <div class="flex flex-col space-y-2">
                <a href="/admin.php?action=trislav_shopping_centers" class="bg-green-500 text-primary font-semibold py-2 px-4 rounded-lg border-2 border-green-500 transition-all duration-300 hover:bg-transparent hover:text-green-400 no-underline text-center text-sm">
                    Управлять ТЦ
                </a>
                <a href="/admin.php?action=trislav_shopping_centers_create" class="bg-transparent text-green-400 font-semibold py-2 px-4 rounded-lg border-2 border-green-500 transition-all duration-300 hover:bg-green-500 hover:text-primary no-underline text-center text-sm">
                    + Добавить ТЦ
                </a>
            </div>
        </div>

        <!-- Требования LED -->
        <div class="bg-secondary rounded-xl p-6 border border-blue-500/30 hover:border-blue-500/50 transition-all duration-300 hover:transform hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-clipboard-list text-blue-400"></i>
                </div>
                <h2 class="text-lg font-bold text-blue-400">Требования LED</h2>
            </div>
            <p class="text-gray-400 text-sm mb-4">Технические требования к видеороликам</p>
            <div class="flex flex-col space-y-2">
                <a href="/admin.php?action=led_requirements" class="bg-blue-500 text-primary font-semibold py-2 px-4 rounded-lg border-2 border-blue-500 transition-all duration-300 hover:bg-transparent hover:text-blue-400 no-underline text-center text-sm">
                    Управлять требованиями
                </a>
                <a href="/admin.php?action=led_requirements_create" class="bg-transparent text-blue-400 font-semibold py-2 px-4 rounded-lg border-2 border-blue-500 transition-all duration-300 hover:bg-blue-500 hover:text-primary no-underline text-center text-sm">
                    + Добавить требование
                </a>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
        <!-- Преимущества LED -->
        <div class="bg-secondary rounded-xl p-6 border border-purple-500/30 hover:border-purple-500/50 transition-all duration-300 hover:transform hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-bolt text-purple-400"></i>
                </div>
                <h2 class="text-lg font-bold text-purple-400">Преимущества</h2>
            </div>
            <p class="text-gray-400 text-sm mb-4">Управление преимуществами</p>
            <div class="flex flex-col space-y-2">
                <a href="/admin.php?action=led_advantages&category=led" class="bg-purple-500 text-primary font-semibold py-2 px-4 rounded-lg border-2 border-purple-500 transition-all duration-300 hover:bg-transparent hover:text-purple-400 no-underline text-center text-sm">
                    Управлять преимуществами
                </a>
                <a href="/admin.php?action=led_advantages_create&category=led" class="bg-transparent text-purple-400 font-semibold py-2 px-4 rounded-lg border-2 border-purple-500 transition-all duration-300 hover:bg-purple-500 hover:text-primary no-underline text-center text-sm">
                    + Добавить преимущество
                </a>
            </div>
        </div>

        <!-- Процесс работы -->
        <div class="bg-secondary rounded-xl p-6 border border-red-500/30 hover:border-red-500/50 transition-all duration-300 hover:transform hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-red-500/20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-cogs text-red-400"></i>
                </div>
                <h2 class="text-lg font-bold text-red-400">Процесс работы</h2>
            </div>
            <p class="text-gray-400 text-sm mb-4">Настройка этапов работы с клиентами</p>
            <div class="flex flex-col space-y-2">
                <a href="/admin.php?action=work_process" class="bg-red-500 text-primary font-semibold py-2 px-4 rounded-lg border-2 border-red-500 transition-all duration-300 hover:bg-transparent hover:text-red-400 no-underline text-center text-sm">
                    Настроить процесс
                </a>
                <a href="/admin.php?action=work_process" class="bg-transparent text-red-400 font-semibold py-2 px-4 rounded-lg border-2 border-red-500 transition-all duration-300 hover:bg-red-500 hover:text-primary no-underline text-center text-sm">
                    Редактировать
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>