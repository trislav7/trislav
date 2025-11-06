<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Админ-панель' ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1a1a2e',
                        secondary: '#16213e',
                        accent: '#0f4c75',
                        highlight: '#00b7c2',
                        light: '#f1f1f1',
                        dark: '#0d0d1a',
                    },
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .sidebar {
            transition: all 0.3s ease;
        }
        .active-menu {
            background: linear-gradient(135deg, #00b7c2 0%, #0099a8 100%);
            color: #1a1a2e;
            font-weight: 600;
        }
        .active-submenu {
            background-color: rgba(0, 183, 194, 0.15);
            color: #00b7c2;
            border-left: 3px solid #00b7c2;
        }
        .stat-card {
            background: linear-gradient(135deg, #16213e 0%, #0f4c75 100%);
            border: 1px solid #00b7c2;
        }
        .menu-divider {
            border-bottom: 1px solid rgba(0, 183, 194, 0.2);
            margin: 0.5rem 0;
        }
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .submenu.open {
            max-height: 1000px;
        }
        .menu-header {
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
        }
        .menu-item {
            border-radius: 0.375rem;
            margin: 0.125rem 0;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }
        .menu-item:hover {
            background-color: rgba(0, 183, 194, 0.1);
            transform: translateX(2px);
        }
    </style>
</head>
<body class="bg-primary text-light font-montserrat">
<!-- Админ-шапка -->
<header class="bg-secondary shadow-lg border-b border-highlight/30">
    <div class="flex items-center justify-between px-6 py-4">
        <div class="flex items-center space-x-4">
            <div class="w-8 h-8 bg-gradient-to-br from-accent to-highlight rounded-lg flex items-center justify-center">
                <div class="flex space-x-1">
                    <div class="w-1.5 h-1.5 bg-white rounded-full opacity-80"></div>
                    <div class="w-1.5 h-1.5 bg-white rounded-full opacity-80"></div>
                    <div class="w-1.5 h-1.5 bg-white rounded-full opacity-80"></div>
                </div>
            </div>
            <h1 class="text-xl font-bold">Админ-панель <span class="text-highlight">Трислав</span></h1>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-gray-300 text-sm"><?= $admin_username ?? 'Администратор' ?></span>
            <a href="/admin.php?action=logout" class="bg-highlight text-primary px-4 py-2 rounded-lg hover:bg-transparent hover:text-highlight border-2 border-highlight transition-all duration-300 text-sm font-semibold">
                <i class="fas fa-sign-out-alt mr-2"></i>Выйти
            </a>
        </div>
    </div>
</header>

<div class="flex">
    <!-- Боковое меню -->
    <aside class="sidebar bg-secondary/95 backdrop-blur-sm shadow-xl h-screen sticky top-0 w-64 border-r border-highlight/20">
        <nav class="p-4">
            <!-- РАЗДЕЛ 1: НАСТРОЙКИ -->
            <div class="menu-section mb-4">
                <div class="menu-header flex items-center py-3 px-4 text-light bg-primary/40 rounded-lg cursor-pointer transition-all duration-300 hover:bg-primary/60" onclick="toggleSubmenu('settings-menu')">
                    <i class="fas fa-cog w-5 mr-3 text-lg"></i>
                    <span class="flex-1 font-semibold">Настройки</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" id="settings-arrow"></i>
                </div>
                <div class="submenu mt-2 space-y-1" id="settings-menu" style="<?= in_array(($current_action ?? ''), ['dashboard', 'settings', 'video_schedule', 'ai_assistant']) ? 'max-height: 1000px;' : 'max-height: 0;' ?>">
                    <a href="/admin.php?action=dashboard" class="menu-item flex items-center text-sm <?= (($current_action ?? '') == 'dashboard') ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-tachometer-alt w-4 mr-3"></i>
                        Дашборд
                    </a>
                    <a href="/admin.php?action=settings" class="menu-item flex items-center text-sm <?= (($current_action ?? '') == 'settings') ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-sliders-h w-4 mr-3"></i>
                        Настройки сайта
                    </a>
                    <a href="/admin.php?action=video_schedule" class="menu-item flex items-center text-sm <?= (($current_action ?? '') == 'video_schedule') ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-calendar-alt w-4 mr-3"></i>
                        Сетка показов
                    </a>
                    <a href="/admin.php?action=ai_assistant" class="menu-item flex items-center text-sm <?= (($current_action ?? '') == 'ai_assistant') ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-robot w-4 mr-3"></i>
                        AI Ассистент
                    </a>
                </div>
            </div>

            <div class="menu-divider"></div>

            <!-- РАЗДЕЛ 2: ТРИСЛАВ ГРУПП -->
            <div class="menu-section mb-4">
                <div class="menu-header flex items-center py-3 px-4 text-light bg-primary/40 rounded-lg cursor-pointer transition-all duration-300 hover:bg-primary/60" onclick="toggleSubmenu('trislav-group-menu')">
                    <i class="fas fa-building w-5 mr-3 text-lg"></i>
                    <span class="flex-1 font-semibold">Трислав Групп</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" id="trislav-group-arrow"></i>
                </div>
                <div class="submenu mt-2 space-y-1" id="trislav-group-menu" style="<?= strpos(($current_action ?? ''), 'trislav_') === 0 ? 'max-height: 1000px;' : 'max-height: 0;' ?>">
                    <a href="/admin.php?action=trislav_content" class="menu-item flex items-center text-sm <?= (($current_action ?? '') == 'trislav_content') ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-chart-pie w-4 mr-3"></i>
                        Обзор дашборд
                    </a>
                    <a href="/admin.php?action=trislav_clients" class="menu-item flex items-center text-sm <?= (($current_action ?? '') == 'trislav_clients') ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-users w-4 mr-3"></i>
                        Клиенты
                    </a>
                    <a href="/admin.php?action=trislav_reviews" class="menu-item flex items-center text-sm <?= (($current_action ?? '') == 'trislav_reviews') ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-star w-4 mr-3"></i>
                        Отзывы
                    </a>
                    <a href="/admin.php?action=led_advantages&category=trislav_group" class="menu-item flex items-center text-sm <?= (($current_action ?? '') == 'led_advantages' && ($_GET['category'] ?? '') == 'trislav_group') ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-chart-line w-4 mr-3"></i>
                        Преимущества
                    </a>
                    <a href="/admin.php?action=trislav_projects" class="menu-item flex items-center text-sm <?= (($current_action ?? '') == 'trislav_projects') ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-briefcase w-4 mr-3"></i>
                        Проекты
                    </a>
                    <a href="/admin.php?action=services_list" class="menu-item flex items-center text-sm <?= (strpos(($current_action ?? ''), 'services') === 0) ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-cog w-4 mr-3"></i>
                        Услуги
                    </a>
                    <a href="/admin.php?action=tariffs_list" class="menu-item flex items-center text-sm <?= (strpos(($current_action ?? ''), 'tariffs') === 0) ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-tags w-4 mr-3"></i>
                        Тарифы
                    </a>
                    <a href="/admin.php?action=leads_list" class="menu-item flex items-center text-sm <?= (strpos(($current_action ?? ''), 'leads') === 0) ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-envelope w-4 mr-3"></i>
                        Заявки
                    </a>
                </div>
            </div>

            <div class="menu-divider"></div>

            <!-- РАЗДЕЛ 3: ТРИСЛАВ МЕДИА -->
            <div class="menu-section mb-4">
                <div class="menu-header flex items-center py-3 px-4 text-light bg-primary/40 rounded-lg cursor-pointer transition-all duration-300 hover:bg-primary/60" onclick="toggleSubmenu('trislav-media-menu')">
                    <i class="fas fa-video w-5 mr-3 text-lg"></i>
                    <span class="flex-1 font-semibold">Трислав Медиа</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" id="trislav-media-arrow"></i>
                </div>
                <div class="submenu mt-2 space-y-1" id="trislav-media-menu" style="<?= in_array(($current_action ?? ''), ['portfolio_list', 'work_process', 'leads_list', 'led_advantages', 'led_requirements', 'trislav_shopping_centers']) ? 'max-height: 1000px;' : 'max-height: 0;' ?>">
                    <a href="/admin.php?action=trislav_media_dashboard" class="menu-item flex items-center text-sm <?= (($current_action ?? '') == 'trislav_media_dashboard') ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-chart-pie w-4 mr-3"></i>
                        Обзор дашборд
                    </a>
                    <a href="/admin.php?action=portfolio_list" class="menu-item flex items-center text-sm <?= (strpos(($current_action ?? ''), 'portfolio') === 0) ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-images w-4 mr-3"></i>
                        Портфолио
                    </a>
                    <a href="/admin.php?action=work_process" class="menu-item flex items-center text-sm <?= (($current_action ?? '') == 'work_process') ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-cogs w-4 mr-3"></i>
                        Процесс работы
                    </a>
                    <a href="/admin.php?action=led_advantages&category=led" class="menu-item flex items-center text-sm <?= (($current_action ?? '') == 'led_advantages' && ($_GET['category'] ?? '') == 'led') ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-bolt w-4 mr-3"></i>
                        Преимущества
                    </a>
                    <a href="/admin.php?action=led_requirements" class="menu-item flex items-center text-sm <?= (strpos(($current_action ?? ''), 'led_requirements') === 0) ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-clipboard-list w-4 mr-3"></i>
                        Требования
                    </a>
                    <a href="/admin.php?action=trislav_shopping_centers" class="menu-item flex items-center text-sm <?= (strpos(($current_action ?? ''), 'trislav_shopping_centers') === 0) ? 'active-submenu' : 'text-gray-300' ?>">
                        <i class="fas fa-store w-4 mr-3"></i>
                        Торговые центры
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <!-- Основной контент -->
    <main class="flex-1 p-6 bg-primary/50 min-h-screen">
        <?= $content ?? 'Контент не найден' ?>
    </main>
</div>

<script>
    function toggleSubmenu(menuId) {
        const submenu = document.getElementById(menuId);
        const arrow = document.getElementById(menuId.replace('-menu', '-arrow'));

        // Закрываем все другие подменю
        document.querySelectorAll('.submenu').forEach(sm => {
            if (sm.id !== menuId && sm.style.maxHeight !== '0px') {
                sm.style.maxHeight = '0';
                const otherArrow = document.getElementById(sm.id.replace('-menu', '-arrow'));
                if (otherArrow) otherArrow.style.transform = 'rotate(0deg)';
            }
        });

        if (submenu.style.maxHeight && submenu.style.maxHeight !== '0px') {
            submenu.style.maxHeight = '0';
            arrow.style.transform = 'rotate(0deg)';
        } else {
            submenu.style.maxHeight = submenu.scrollHeight + 'px';
            arrow.style.transform = 'rotate(180deg)';
        }
    }

    // Автоматически открываем активные разделы при загрузке
    document.addEventListener('DOMContentLoaded', function() {
        const currentAction = '<?= $current_action ?? "" ?>';
        const urlParams = new URLSearchParams(window.location.search);
        const category = urlParams.get('category');

        // Авто-открытие разделов где есть активный пункт
        if (['dashboard', 'settings', 'video_schedule', 'ai_assistant'].includes(currentAction)) {
            toggleSubmenu('settings-menu');
        }
        if (currentAction.startsWith('trislav_') && currentAction !== 'trislav_shopping_centers') {
            toggleSubmenu('trislav-group-menu');
        }
        if (['portfolio_list', 'work_process', 'leads_list', 'trislav_media_dashboard'].includes(currentAction) ||
            (currentAction === 'led_advantages' && category === 'led') ||
            currentAction.startsWith('led_requirements') ||
            currentAction.startsWith('trislav_shopping_centers')) {
            toggleSubmenu('trislav-media-menu');
        }
    });
</script>
</body>
</html>