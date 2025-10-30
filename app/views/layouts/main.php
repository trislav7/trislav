<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Трислав Медиа - Элитное рекламное агентство' ?></title>
    
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
        html {
            scroll-behavior: smooth;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #00b7c2;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
        }
    </style>
</head>
<body class="bg-primary text-light font-montserrat">
    <!-- Включаем шапку -->
    <?php include __DIR__ . '/../components/header.php'; ?>

    <!-- Основной контент -->
    <main>
        <?= $content ?? 'Контент не найден' ?>
    </main>

    <!-- Включаем футер -->
    <?php include __DIR__ . '/../components/footer.php'; ?>

    <!-- Общие скрипты -->
    <script>
        // Мобильное меню
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        let menuOpen = false;

        menuToggle?.addEventListener('click', () => {
            menuOpen = !menuOpen;
            
            if (menuOpen) {
                mobileMenu.classList.remove('opacity-0', 'invisible', '-translate-y-2');
                mobileMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
                menuToggle.innerHTML = '<i class="fas fa-times"></i>';
            } else {
                mobileMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                mobileMenu.classList.add('opacity-0', 'invisible', '-translate-y-2');
                menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
            }
        });

        // Плавная прокрутка
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    const offsetTop = targetElement.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>