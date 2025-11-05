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
            background-color: #00b7c2;
            color: #1a1a2e;
        }
        .stat-card {
            background: linear-gradient(135deg, #16213e 0%, #0f4c75 100%);
            border: 1px solid #00b7c2;
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
            <h1 class="text-xl font-bold">Админ-панель <span class="text-highlight">Трислав Медиа</span></h1>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-gray-300"><?= $admin_username ?? 'Администратор' ?></span>
            <a href="/admin.php?action=logout" class="bg-highlight text-primary px-4 py-2 rounded-lg hover:bg-transparent hover:text-highlight border-2 border-highlight transition-all duration-300 text-sm font-semibold">
                <i class="fas fa-sign-out-alt mr-2"></i>Выйти
            </a>
        </div>
    </div>
</header>

<div class="flex">
    <!-- Боковое меню -->
    <aside class="sidebar bg-secondary shadow-lg h-screen sticky top-0 w-64 border-r border-highlight/30">
        <nav class="p-4 space-y-2">
            <a href="/admin.php?action=dashboard" class="flex items-center py-3 px-4 text-light hover:bg-highlight/20 hover:text-highlight rounded-lg transition-all duration-300 <?= (($current_action ?? '') == 'dashboard') ? 'active-menu' : '' ?>">
                <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                Дашборд
            </a>
            <a href="/admin.php?action=settings" class="flex items-center py-3 px-4 text-light hover:bg-highlight/20 hover:text-highlight rounded-lg transition-all duration-300 <?= (($current_action ?? '') == 'dashboard') ? 'active-menu' : '' ?>">
                <i class="fas fa-cog mr-3"></i>
                Настройки сайта
            </a>
            <a href="/admin.php?action=services_list" class="flex items-center py-3 px-4 text-light hover:bg-highlight/20 hover:text-highlight rounded-lg transition-all duration-300 <?= (strpos(($current_action ?? ''), 'services') === 0) ? 'active-menu' : '' ?>">
                <i class="fas fa-cog w-5 mr-3"></i>
                Услуги
            </a>
            <a href="/admin.php?action=tariffs_list" class="flex items-center py-3 px-4 text-light hover:bg-highlight/20 hover:text-highlight rounded-lg transition-all duration-300 <?= (strpos(($current_action ?? ''), 'tariffs') === 0) ? 'active-menu' : '' ?>">
                <i class="fas fa-tags w-5 mr-3"></i>
                Тарифы
            </a>
            <a href="/admin.php?action=portfolio_list" class="flex items-center py-3 px-4 text-light hover:bg-highlight/20 hover:text-highlight rounded-lg transition-all duration-300 <?= (strpos(($current_action ?? ''), 'portfolio') === 0) ? 'active-menu' : '' ?>">
                <i class="fas fa-images w-5 mr-3"></i>
                Портфолио
            </a>
            <a href="/admin.php?action=leads_list" class="flex items-center py-3 px-4 text-light hover:bg-highlight/20 hover:text-highlight rounded-lg transition-all duration-300 <?= (strpos(($current_action ?? ''), 'leads') === 0) ? 'active-menu' : '' ?>">
                <i class="fas fa-envelope w-5 mr-3"></i>
                Заявки
            </a>
            <a href="/admin.php?action=work_process" class="flex items-center py-3 px-4 text-light hover:bg-highlight/20 hover:text-highlight rounded-lg transition-all duration-300">
                <i class="fas fa-cogs mr-3"></i>Процесс работы
            </a>
            <a href="/admin.php?action=trislav_content" class="flex items-center py-3 px-4 text-light hover:bg-highlight/20 hover:text-highlight rounded-lg transition-all duration-300 <?= (strpos(($current_action ?? ''), 'trislav') === 0) ? 'active-menu' : '' ?>">
                <i class="fas fa-building w-5 mr-3"></i>
                Трислав Групп
            </a>
            <a href="/admin.php?action=led_advantages" class="flex items-center py-3 px-4 text-light hover:bg-highlight/20 hover:text-highlight rounded-lg transition-all duration-300">
                <i class="fas fa-building w-5 mr-3"></i>
                Преимущества
            </a>
            <a href="/admin.php?action=led_requirements" class="flex items-center py-3 px-4 text-light hover:bg-highlight/20 hover:text-highlight rounded-lg transition-all duration-300">
                <i class="fas fa-building w-5 mr-3"></i>
                Требования
            </a>
            <a href="/admin.php?action=trislav_shopping_centers" class="flex items-center py-3 px-4 text-light hover:bg-highlight/20 hover:text-highlight rounded-lg transition-all duration-300">
                <i class="fas fa-store w-5 mr-3"></i> Торговые центры
            </a>
            <a href="/admin.php?action=video_schedule" class="flex items-center py-3 px-4 text-light hover:bg-highlight/20 hover:text-highlight rounded-lg transition-all duration-300 <?= (($current_action ?? '') == 'ai_assistant') ? 'active-menu' : '' ?>">
                <i class="fas fa-robot w-5 mr-3"></i>
                Сетка показов
            </a>
            <a href="/admin.php?action=ai_assistant" class="flex items-center py-3 px-4 text-light hover:bg-highlight/20 hover:text-highlight rounded-lg transition-all duration-300 <?= (($current_action ?? '') == 'ai_assistant') ? 'active-menu' : '' ?>">
                <i class="fas fa-robot w-5 mr-3"></i>
                AI Ассистент
            </a>
        </nav>
    </aside>

    <!-- Основной контент -->
    <main class="flex-1 p-6">
        <?= $content ?? 'Контент не найден' ?>
    </main>
</div>
</body>
</html>