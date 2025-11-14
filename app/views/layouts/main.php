<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Трислав Групп - Развитие бизнеса через креативные решения' ?></title>
    <!-- Чистый JS версия Slick -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Slick Slider -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <link rel="canonical" href="<?= (IS_TRISLAV_MEDIA ? 'https://медиа.трислав.рф' : 'https://трислав.рф') . $_SERVER['REQUEST_URI'] ?>" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="<?= $description ?? 'Трислав Медиа - профессиональные рекламные решения для вашего бизнеса' ?>" />

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


        /* Добавляем в основной CSS */
        .privacy-agreement .checkbox-label input:invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);
        }

        .privacy-agreement .checkbox-label input:checked {
            border-color: #00b7c2;
            background-color: #00b7c2;
        }

        /* Стили для неактивных кнопок */
        .btn-disabled {
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Анимация появления ошибок */
        .privacy-error {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Добавьте эти стили в существующий блок <style> */
        .input-error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);
        }

        .checkbox-error {
            outline: 2px solid #ef4444;
            border-radius: 2px;
        }
        .grecaptcha-badge {
            visibility: hidden !important;
            opacity: 0 !important;
            display: none !important;
        }

        /* Альтернативный способ - сдвинуть за пределы экрана */
        .grecaptcha-badge {
            position: absolute !important;
            left: -9999px !important;
            top: -9999px !important;
        }
    </style>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m,e,t,r,i,k,a){
            m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
        })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=105240181', 'ym');

        ym(105240181, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", accurateTrackBounce:true, trackLinks:true});
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/105240181" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
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

<script src="/app/views/components/form_validation.js"></script>

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
<?php include __DIR__ . '/../components/cookie_notice.php'; ?>
<!-- Google reCAPTCHA v3 -->
<script src="https://www.google.com/recaptcha/api.js?render=6LfCAAksAAAAANvHXlyuTBk4sDmsIhRBOWw7n5QO"></script>
<script>
    // Инициализация reCAPTCHA для всех форм
    function debugRecaptcha() {
        console.log('=== reCAPTCHA DEBUG ===');
        const tokenField = document.getElementById('recaptchaToken');
        console.log('Token field exists:', !!tokenField);
        console.log('Token value:', tokenField ? tokenField.value : 'NO FIELD');

        // Проверить все формы
        document.querySelectorAll('form').forEach((form, index) => {
            const tokenInput = form.querySelector('#recaptchaToken');
            console.log(`Form ${index}:`, form.id || 'no-id', 'Token input:', !!tokenInput);
        });
    }

    // Запустить отладку при загрузке
    function submitFormWithRecaptcha(form, originalText) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);

        // Определяем URL для отправки
        let submitUrl = form.action;
        if (!submitUrl || submitUrl === '') {
            // Определяем URL по ID формы или другим признакам
            if (form.id === 'contactForm') {
                submitUrl = '/contact/submit';
            } else if (form.id.includes('led')) {
                submitUrl = '/led/submit';
            } else if (form.id.includes('video')) {
                submitUrl = '/video/submit';
            } else if (form.id.includes('btl')) {
                submitUrl = '/btl/submit';
            } else {
                submitUrl = '/contact/submit';
            }
        }

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Отправка...';

        fetch(submitUrl, {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (response.ok) {
                    // Успешная отправка
                    if (typeof showSuccessPopup === 'function') {
                        showSuccessPopup();
                    }
                    form.reset();
                } else {
                    // Ошибка
                    if (typeof showErrorPopup === 'function') {
                        showErrorPopup();
                    } else {
                        alert('Ошибка отправки формы');
                    }
                }
            })
            .catch(error => {
                console.error('Form submission error:', error);
                if (typeof showErrorPopup === 'function') {
                    showErrorPopup();
                } else {
                    alert('Ошибка отправки формы');
                }
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
    }

    // Инициализация при загрузке
    document.addEventListener('DOMContentLoaded', initializeRecaptcha);
</script>
</body>
</html>