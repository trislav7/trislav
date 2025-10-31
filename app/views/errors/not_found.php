<?php
// app/views/errors/not_found.php
http_response_code(404);

// Определяем контекст (сайт или админка)
$isAdmin = strpos($_SERVER['REQUEST_URI'] ?? '', '/admin') === 0;
$theme = $isAdmin ? 'admin' : (IS_TRISLAV_MEDIA ? 'media' : 'group');
$title = $isAdmin ? 'Страница не найдена - Админка' : 
         (IS_TRISLAV_MEDIA ? 'Страница не найдена - Трислав Медиа' : 'Страница не найдена - Трислав Групп');

ob_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

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
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translate(0, 0px); }
            50% { transform: translate(0, -15px); }
            100% { transform: translate(0, -0px); }
        }
    </style>
</head>
<body class="bg-primary text-light font-montserrat min-h-screen flex items-center justify-center px-4">
    <div class="container mx-auto max-w-4xl text-center">
        
        <?php if ($theme === 'admin'): ?>
        <!-- 404 для Админки -->
        <div class="floating mb-8">
            <div class="text-9xl font-bold text-highlight">404</div>
        </div>

        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Страница не найдена</h1>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Запрашиваемая страница в админ-панели не существует или была перемещена.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="/admin.php" class="bg-highlight text-primary font-semibold py-3 px-8 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline text-lg">
                <i class="fas fa-tachometer-alt mr-2"></i>В дашборд
            </a>
            <button onclick="history.back()" class="bg-transparent text-gray-300 font-semibold py-3 px-8 rounded-lg border-2 border-gray-500 transition-all duration-300 hover:bg-gray-500 hover:text-light no-underline text-lg">
                <i class="fas fa-arrow-left mr-2"></i>Назад
            </button>
        </div>

        <?php elseif ($theme === 'media'): ?>
        <!-- 404 для Трислав Медиа -->
        <div class="floating mb-8">
            <div class="text-9xl font-bold text-highlight">404</div>
        </div>

            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Страница не найдена</h1>
                <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                    Запрашиваемая страница не существует или была перемещена.
                </p>
            </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="/" class="bg-highlight text-primary font-semibold py-3 px-8 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline text-lg">
                <i class="fas fa-home mr-2"></i>На главную
            </a>
            <a href="https://трислав.рф" target="_blank" class="bg-transparent text-highlight font-semibold py-3 px-8 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline text-lg">
                <i class="fas fa-external-link-alt mr-2"></i>Трислав групп
            </a>
            <button onclick="history.back()" class="bg-transparent text-gray-300 font-semibold py-3 px-8 rounded-lg border-2 border-gray-500 transition-all duration-300 hover:bg-gray-500 hover:text-light no-underline text-lg">
                <i class="fas fa-arrow-left mr-2"></i>Назад
            </button>
        </div>

        <?php else: ?>
        <!-- 404 для Трислав Групп -->
        <div class="floating mb-8">
            <div class="text-9xl font-bold text-highlight">404</div>
        </div>

        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Страница не найдена</h1>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Запрашиваемая страница не существует или была перемещена.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="/" class="bg-highlight text-primary font-semibold py-3 px-8 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline text-lg">
                <i class="fas fa-home mr-2"></i>На главную
            </a>
            <a href="https://медиа.трислав.рф" target="_blank" class="bg-transparent text-highlight font-semibold py-3 px-8 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline text-lg">
                <i class="fas fa-external-link-alt mr-2"></i>Трислав Медиа
            </a>
            <button onclick="history.back()" class="bg-transparent text-gray-300 font-semibold py-3 px-8 rounded-lg border-2 border-gray-500 transition-all duration-300 hover:bg-gray-500 hover:text-light no-underline text-lg">
                <i class="fas fa-arrow-left mr-2"></i>Назад
            </button>
        </div>
        <?php endif; ?>

        <!-- Декоративные элементы -->
        <div class="mt-16 text-gray-500">
            <p class="text-sm">
                Ошибка 404 • Страница не найдена • 
                <?= $theme === 'admin' ? 'Админ-панель' : ($theme === 'media' ? 'Трислав Медиа' : 'Трислав Групп') ?>
            </p>
        </div>
    </div>
</body>
</html>

<?php
$content = ob_get_clean();
echo $content;
?>