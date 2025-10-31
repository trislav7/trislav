<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Трислав Групп - Развитие бизнеса через креативные решения' ?></title>

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

        /* Стили для слайдеров Трислав Групп */
        .slider-container {
            position: relative;
            overflow: hidden;
        }

        .slider-track {
            display: flex;
            transition: transform 0.5s ease;
        }

        .slider-slide {
            min-width: 100%;
        }

        .slider-indicators {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .slider-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.3);
            margin: 0 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .slider-indicator.active {
            background-color: #00b7c2;
        }

        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 183, 194, 0.7);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: background-color 0.3s ease;
        }

        .slider-nav:hover {
            background-color: rgba(0, 183, 194, 1);
        }

        .slider-prev {
            left: 15px;
        }

        .slider-next {
            right: 15px;
        }

        .project-card {
            transition: all 0.3s ease;
        }

        .project-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .advantage-card {
            transition: all 0.3s ease;
        }

        .advantage-card:hover {
            transform: translateY(-5px);
        }

        .mobile-menu {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-primary text-light font-montserrat">
<!-- Включаем шапку в зависимости от типа сайта -->
<?php if (IS_TRISLAV_MEDIA): ?>
    <!-- Для медиа.трислав.рф - старый header с внутренними ссылками -->
    <?php include __DIR__ . '/../components/header.php'; ?>
<?php else: ?>
    <!-- Для трислав.рф - новый header с внешними ссылками -->
    <?php include __DIR__ . '/../components/header_trislav_group.php'; ?>
<?php endif; ?>

<!-- Основной контент -->
<main>
    <?= $content ?? 'Контент не найден' ?>
</main>

<!-- Включаем футер -->
<?php if (IS_TRISLAV_MEDIA): ?>
    <?php include __DIR__ . '/../components/footer.php'; ?>
<?php else: ?>
    <?php include __DIR__ . '/../components/footer_trislav_group.php'; ?>
<?php endif; ?>

<!-- Общие скрипты -->
<script>
    // Плавная прокрутка для якорных ссылок (только для внутренних ссылок)
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

    // Функция для слайдеров (если есть на странице)
    function initSlider(sliderTrackId, prevBtnId, nextBtnId, indicatorsId) {
        const sliderTrack = document.getElementById(sliderTrackId);
        const sliderPrev = document.getElementById(prevBtnId);
        const sliderNext = document.getElementById(nextBtnId);
        const sliderIndicators = document.getElementById(indicatorsId);

        if (!sliderTrack) return; // Если слайдера нет на странице

        const slides = document.querySelectorAll(`#${sliderTrackId} .slider-slide`);
        let currentSlide = 0;

        // Создание индикаторов
        slides.forEach((_, index) => {
            const indicator = document.createElement('div');
            indicator.classList.add('slider-indicator');
            if (index === 0) indicator.classList.add('active');
            indicator.addEventListener('click', () => goToSlide(index));
            sliderIndicators.appendChild(indicator);
        });

        // Функция перехода к слайду
        function goToSlide(slideIndex) {
            currentSlide = slideIndex;
            sliderTrack.style.transform = `translateX(-${currentSlide * 100}%)`;

            // Обновление активного индикатора
            document.querySelectorAll(`#${indicatorsId} .slider-indicator`).forEach((indicator, index) => {
                if (index === currentSlide) {
                    indicator.classList.add('active');
                } else {
                    indicator.classList.remove('active');
                }
            });
        }

        // Следующий слайд
        sliderNext?.addEventListener('click', () => {
            currentSlide = (currentSlide + 1) % slides.length;
            goToSlide(currentSlide);
        });

        // Предыдущий слайд
        sliderPrev?.addEventListener('click', () => {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            goToSlide(currentSlide);
        });

        // Автопереключение слайдов
        setInterval(() => {
            currentSlide = (currentSlide + 1) % slides.length;
            goToSlide(currentSlide);
        }, 5000);
    }

    // Инициализация слайдеров при загрузке страницы
    document.addEventListener('DOMContentLoaded', () => {
        initSlider('logosSlider', 'logosPrev', 'logosNext', 'logosIndicators');
        initSlider('reviewsSlider', 'reviewsPrev', 'reviewsNext', 'reviewsIndicators');
    });
</script>
</body>
</html>