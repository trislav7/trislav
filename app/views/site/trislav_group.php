<?php
// app/views/site/trislav_group.php
ob_start();
?>

    <!-- Первый блок - Логотип и название -->
    <section class="pt-24 pb-16 flex items-center justify-center bg-gradient-to-br from-secondary to-primary px-4">
        <div class="container mx-auto max-w-4xl text-center">
            <div class="flex justify-center mb-20">
                <div class="w-64 h-64 from-accent to-highlight rounded-xl flex items-center justify-center">
                    <img src="/images/tg_.png" />
                </div>
            </div>
            <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto">
                Комплексные решения для развития бизнеса через инновационные подходы и креативные стратегии
            </p>
        </div>
    </section>

    <!-- Второй блок - Проекты (из админки) -->
<?php if (!empty($projects)): ?>
    <section class="py-16 bg-secondary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Наши проекты</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Успешные бизнес-решения, которые уже доказали свою эффективность</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php foreach ($projects as $project): ?>
                <?php
                $projectUrl = $project['project_url'] ?? null;
                $hasUrl = !empty($projectUrl);
                $wrapperTag = $hasUrl ? 'a' : 'div';
                $wrapperAttributes = $hasUrl ? 'href="' . htmlspecialchars($projectUrl) . '" target="_blank" rel="noopener"' : '';
                ?>

                <<?= $wrapperTag ?> <?= $wrapperAttributes ?>
                class="project-card block bg-white/5 rounded-xl overflow-hidden border border-transparent transition-all duration-300 hover:border-highlight hover:shadow-2xl hover:shadow-highlight/20 <?= $hasUrl ? 'cursor-pointer group no-underline' : '' ?>">

                <?php if (!empty($project['image_url'])): ?>
                    <div class="h-40 overflow-hidden">
                        <img src="<?= htmlspecialchars($project['image_url']) ?>"
                             alt="<?= htmlspecialchars($project['title'] ?? '') ?>"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </div>
                <?php else: ?>
                    <div class="h-40 bg-highlight/20 flex items-center justify-center group-hover:bg-highlight/30 transition-colors duration-300">
                        <i class="fas fa-briefcase text-4xl text-highlight/50 group-hover:text-highlight/70 transition-colors duration-300"></i>
                    </div>
                <?php endif; ?>

                <div class="p-6">
                    <h3 class="text-2xl font-bold text-highlight mb-3 group-hover:text-light transition-colors duration-300 flex items-center">
                        <?= htmlspecialchars($project['title'] ?? '') ?>
                        <?php if ($hasUrl): ?>
                            <span class="inline-block ml-2 text-sm opacity-0 group-hover:opacity-70 transition-opacity duration-300">↗</span>
                        <?php endif; ?>
                    </h3>

                    <p class="text-gray-300 mb-4 group-hover:text-gray-200 transition-colors duration-300">
                        <?= htmlspecialchars($project['description'] ?? '') ?>
                    </p>

                    <?php if (!empty($project['tags'])): ?>
                        <div class="flex flex-wrap gap-2">
                            <?php
                            $tags = explode(',', $project['tags']);
                            foreach ($tags as $tag):
                                if (trim($tag)):
                                    ?>
                                    <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm group-hover:bg-highlight/30 transition-colors duration-300">
                                                <?= htmlspecialchars(trim($tag)) ?>
                                            </span>
                                <?php
                                endif;
                            endforeach;
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($hasUrl): ?>
                        <div class="mt-4 inline-flex items-center text-highlight group-hover:text-light transition-colors duration-300 font-medium">
                            <i class="fas fa-external-link-alt mr-2"></i>Открыть проект
                        </div>
                    <?php endif; ?>
                </div>
            </<?= $wrapperTag ?>>
            <?php endforeach; ?>
        </div>
        </div>
    </section>
<?php endif; ?>

    <!-- Третий блок - Нам доверяют (только отзывы из админки) -->
<?php if (!empty($reviews)): ?>
    <section class="py-16 bg-primary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Нам доверяют</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Что говорят наши клиенты о сотрудничестве</p>
            </div>

            <!-- Слайдер с отзывами как на странице BTL -->
            <div class="reviews-slider">
                <?php foreach ($reviews as $review): ?>
                    <div class="px-3">
                        <div class="bg-white/5 rounded-xl p-6 md:p-8 mx-auto max-w-4xl border border-highlight/20">
                            <div class="flex flex-col md:flex-row items-start md:items-center mb-6">
                                <?php if (!empty($review['author_avatar'])): ?>
                                    <div class="w-16 h-16 rounded-full overflow-hidden mr-0 md:mr-6 mb-4 md:mb-0">
                                        <img src="<?= htmlspecialchars($review['author_avatar']) ?>"
                                             alt="<?= htmlspecialchars($review['author_name'] ?? '') ?>"
                                             class="w-full h-full object-cover">
                                    </div>
                                <?php else: ?>
                                    <div class="w-16 h-16 bg-highlight/20 rounded-full flex items-center justify-center mr-0 md:mr-6 mb-4 md:mb-0">
                                        <span class="text-2xl font-bold text-highlight">
                                            <?= !empty($review['author_name']) ? mb_substr($review['author_name'], 0, 1) : '?' ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                <div class="text-center md:text-left">
                                    <h4 class="text-xl font-bold text-light"><?= htmlspecialchars($review['author_name'] ?? '') ?></h4>
                                    <?php if (!empty($review['author_position'])): ?>
                                        <p class="text-gray-400"><?= htmlspecialchars($review['author_position']) ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($review['company'])): ?>
                                        <p class="text-highlight font-semibold"><?= htmlspecialchars($review['company']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <p class="text-gray-300 text-lg leading-relaxed italic mb-4">
                                "<?= htmlspecialchars($review['content'] ?? '') ?>"
                            </p>

                            <?php if (!empty($review['rating'])): ?>
                                <div class="flex items-center justify-center md:justify-start">
                                    <div class="flex text-highlight">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php if ($i <= $review['rating']): ?>
                                                <i class="fas fa-star"></i>
                                            <?php else: ?>
                                                <i class="far fa-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="ml-2 text-gray-400"><?= $review['rating'] ?>.0</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <style>
        .reviews-slider .slick-list {
            margin: 0 -12px;
        }

        .reviews-slider .slick-slide {
            padding: 0 12px;
        }

        /* Стили для стрелок - БЕЗ АНИМАЦИЙ */
        .reviews-slider .slick-prev,
        .reviews-slider .slick-next {
            width: 48px;
            height: 48px;
            background: rgba(0, 183, 194, 0.9) !important;
            border-radius: 50%;
            z-index: 10;
            display: flex !important;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            transition: none !important; /* Убираем все переходы */
        }

        /* УБИРАЕМ ВСЕ ЭФФЕКТЫ ПРИ НАВЕДЕНИИ */
        .reviews-slider .slick-prev:hover,
        .reviews-slider .slick-next:hover {
            background: rgba(0, 183, 194, 0.9) !important; /* Оставляем тот же цвет */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important; /* Оставляем ту же тень */
        }

        .reviews-slider .slick-prev {
            left: -60px;
        }

        .reviews-slider .slick-next {
            right: -60px;
        }

        .reviews-slider .slick-prev:before,
        .reviews-slider .slick-next:before {
            content: '' !important; /* Убираем стандартные стрелки */
        }

        .reviews-slider .slick-prev:after {
            content: '‹';
            font-size: 24px;
            color: #0a0a1a;
            font-weight: bold;
            line-height: 1;
        }

        .reviews-slider .slick-next:after {
            content: '›';
            font-size: 24px;
            color: #0a0a1a;
            font-weight: bold;
            line-height: 1;
        }

        /* Стили для точек */
        .reviews-slider .slick-dots {
            bottom: -50px;
        }

        .reviews-slider .slick-dots li {
            margin: 0 4px;
        }

        .reviews-slider .slick-dots li button:before {
            font-size: 10px;
            color: #00b7c2;
            opacity: 0.3;
        }

        .reviews-slider .slick-dots li.slick-active button:before {
            opacity: 1;
            color: #00b7c2;
        }

        .reviews-slider .slick-dots li button:hover:before {
            opacity: 0.7;
        }

        /* Адаптивность */
        @media (max-width: 1280px) {
            .reviews-slider .slick-prev {
                left: -40px;
            }

            .reviews-slider .slick-next {
                right: -40px;
            }
        }

        @media (max-width: 1024px) {
            .reviews-slider .slick-prev {
                left: -30px;
            }

            .reviews-slider .slick-next {
                right: -30px;
            }

            .reviews-slider .slick-prev,
            .reviews-slider .slick-next {
                width: 40px;
                height: 40px;
            }
        }

        @media (max-width: 768px) {
            .reviews-slider .slick-prev {
                left: -20px;
            }

            .reviews-slider .slick-next {
                right: -20px;
            }

            .reviews-slider .slick-prev,
            .reviews-slider .slick-next {
                width: 36px;
                height: 36px;
            }

            .reviews-slider .slick-prev:after,
            .reviews-slider .slick-next:after {
                font-size: 20px;
            }
        }

        /* Убираем все лишние анимации */
        .reviews-slider .slick-slide {
            transition: none;
        }

        .reviews-slider .slick-slide:hover {
            transform: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.reviews-slider').slick({
                dots: true,
                arrows: true,
                infinite: true,
                speed: 700,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 5000,
                pauseOnHover: false,
                cssEase: 'linear', // Линейная анимация без easing
                responsive: [
                    {
                        breakpoint: 1280,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            // Дополнительно: отключаем любые hover эффекты через JS
            $('.reviews-slider .slick-prev, .reviews-slider .slick-next').on('mouseenter mouseleave', function(e) {
                e.stopPropagation();
                return false;
            });
        });
    </script>
<?php endif; ?>

    <!-- Четвертый блок - Призыв к действию -->
    <section class="py-16 bg-secondary px-4">
        <div class="container mx-auto max-w-4xl text-center">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6">Развивайся вместе с нами</h2>
            <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto">
                Преврати свой бизнес в лидера с помощью креативных решений, которые работают 24/7.
                Мы не просто создаём рекламу - мы строим успешные бренды. Закажи консультацию уже сейчас.
            </p>
            <a href="#contact" class="inline-block bg-highlight text-primary font-semibold py-3 px-8 rounded-full border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline text-lg">
                Связаться с нами
            </a>
        </div>
    </section>

    <!-- Пятый блок - Преимущества из админки -->
<?php if (!empty($advantages)): ?>
    <section class="py-16 bg-primary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($advantages as $advantage): ?>
                    <div class="advantage-card text-center p-6 bg-white/5 rounded-xl">
                        <div class="w-16 h-16 bg-highlight/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <?= $advantage['icon_svg'] ?: '<i class="fas fa-star text-2xl text-highlight"></i>' ?>
                        </div>
                        <h3 class="text-lg font-bold mb-3"><?= htmlspecialchars($advantage['title'] ?? '') ?></h3>
                        <p class="text-gray-300 text-sm"><?= htmlspecialchars($advantage['description'] ?? '') ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

    <!-- Шестой блок - Форма обратной связи -->
    <section id="contact" class="py-16 bg-secondary px-4">
        <div class="container mx-auto max-w-4xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Свяжитесь с нами</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Готовы обсудить развитие вашего бизнеса? Оставьте заявку!</p>
            </div>

            <div class="bg-white/5 rounded-xl p-6 md:p-8">
                <form action="/contact/submit" method="POST" id="contactForm">
                    <input type="hidden" name="source" value="trislav_group">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="form-group">
                            <label for="name" class="block mb-2 font-medium">ФИО *</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                        </div>
                        <div class="form-group">
                            <label for="company" class="block mb-2 font-medium">Название компании</label>
                            <input type="text" id="company" name="company"
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="form-group">
                            <label for="phone" class="block mb-2 font-medium">Телефон *</label>
                            <input type="tel" id="phone" name="phone" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                        </div>
                        <div class="form-group">
                            <label for="email" class="block mb-2 font-medium">Email *</label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                        </div>
                    </div>

                    <!-- НОВОЕ ПОЛЕ: Выбор проекта -->
                    <div class="form-group mb-6">
                        <label for="project_id" class="block mb-2 font-medium">Интересует проект</label>
                        <select id="project_id" name="project_id"
                                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight [&>option]:bg-primary [&>option]:text-light">
                            <option value="">Выберите проект (необязательно)</option>
                            <?php if (!empty($projects) && is_array($projects)): ?>
                                <?php foreach ($projects as $project): ?>
                                    <?php if ($project['is_active']): ?>
                                        <option value="<?= $project['id'] ?>">
                                            <?= htmlspecialchars($project['title']) ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group mb-6">
                        <label for="message" class="block mb-2 font-medium">Сообщение</label>
                        <textarea id="message" name="message" rows="4"
                                  class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                                  placeholder="Расскажите о вашем бизнесе и задачах..."></textarea>
                    </div>
                    <div class="form-group privacy-agreement mt-4 mb-6">
                        <label class="checkbox-label flex items-start space-x-3 cursor-pointer">
                            <input type="checkbox" name="privacy_agreement" required
                                   class="mt-1 w-4 h-4 text-highlight bg-primary border-highlight/30 rounded focus:ring-highlight focus:ring-2">
                            <span class="text-light text-sm">
                            Я соглашаюсь с
                            <a href="/privacy-policy" target="_blank" class="text-highlight hover:underline">
                                политикой обработки персональных данных
                            </a>
                        </span>
                        </label>
                    </div>
                    <!-- reCAPTCHA v3 -->
                    <input type="hidden" name="recaptcha_token" id="recaptchaToken">
                    <div class="form-group mb-6">
                        <div class="text-xs text-gray-400 text-center">
                            Защищено reCAPTCHA. Отправляя форму, вы соглашаетесь с
                            <a href="https://policies.google.com/privacy" target="_blank" class="text-highlight hover:underline">Политикой конфиденциальности</a> и
                            <a href="https://policies.google.com/terms" target="_blank" class="text-highlight hover:underline">Условиями использования</a> Google.
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-highlight text-primary font-semibold py-3 px-6 rounded-lg transition-all duration-300 hover:bg-transparent hover:text-highlight border-2 border-highlight">
                        Отправить заявку
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- КРАСИВЫЙ ПОПАП УСПЕХА -->
    <div id="successPopup" class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">
        <div class="bg-gradient-to-br from-primary to-secondary rounded-2xl p-8 mx-4 max-w-md w-full border-2 border-highlight/50 transform scale-95 transition-all duration-300">
            <div class="text-center">
                <!-- Анимированная иконка -->
                <div class="w-20 h-20 bg-highlight/20 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                    <svg class="w-10 h-10 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-highlight mb-4">Спасибо за вашу заявку!</h3>
                <p class="text-light mb-6">
                    Мы свяжемся с вами в ближайшее время для обсуждения сотрудничества и ответим на все ваши вопросы.
                </p>

                <button onclick="closeSuccessPopup()"
                        class="bg-highlight text-primary font-semibold py-3 px-8 rounded-lg transition-all duration-300 hover:bg-transparent hover:text-highlight border-2 border-highlight">
                    Понятно
                </button>
            </div>
        </div>
    </div>

    <style>
        /* Анимации для попапа */
        #successPopup {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #successPopup > div {
            transition: transform 0.3s ease;
        }

        #successPopup:not(.hidden) {
            opacity: 1;
        }

        #successPopup:not(.hidden) > div {
            transform: scale(1);
        }

        /* Стили для селекта */
        select option {
            background: #1a1a2e !important;
            color: #f1f1f1 !important;
            padding: 12px;
        }

        /* Кастомный скроллбар для селекта */
        select::-webkit-scrollbar {
            width: 8px;
        }

        select::-webkit-scrollbar-track {
            background: #16213e;
            border-radius: 4px;
        }

        select::-webkit-scrollbar-thumb {
            background: #00b7c2;
            border-radius: 4px;
        }
    </style>
    <script>
        function initializeForm() {
            const contactForm = document.getElementById('contactForm');
            if (!contactForm) return;

            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;

                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Отправка...';
                submitBtn.disabled = true;

                const formData = new FormData(this);

                fetch('/contact/submit', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => {
                        if (response.ok) {
                            showSuccessPopup();
                            this.reset();
                        } else {
                            alert('Ошибка отправки формы. Пожалуйста, попробуйте еще раз.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Произошла ошибка при отправке формы');
                    })
                    .finally(() => {
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    });
            });
        }

        function initializePopup() {
            const successPopup = document.getElementById('successPopup');
            if (!successPopup) return;

            // Закрытие попапа по клику на фон
            successPopup.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeSuccessPopup();
                }
            });

            // Закрытие попапа по ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeSuccessPopup();
                }
            });
        }

        function showSuccessPopup() {
            const popup = document.getElementById('successPopup');
            popup.classList.remove('hidden');
            setTimeout(() => {
                popup.classList.add('opacity-100', 'scale-100');
                popup.classList.remove('opacity-0', 'scale-95');
            }, 50);
        }

        function closeSuccessPopup() {
            const popup = document.getElementById('successPopup');
            popup.classList.add('opacity-0', 'scale-95');
            popup.classList.remove('opacity-100', 'scale-100');
            setTimeout(() => {
                popup.classList.add('hidden');
            }, 300);
        }

        // Инициализация при загрузке
        document.addEventListener('DOMContentLoaded', function() {
            initializeForm();
            initializePopup();
        });
    </script>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>