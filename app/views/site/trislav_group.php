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
                    <div class="project-card bg-white/5 rounded-xl overflow-hidden">
                        <?php if (!empty($project['image_url'])): ?>
                            <div class="h-40 overflow-hidden">
                                <img src="<?= htmlspecialchars($project['image_url']) ?>"
                                     alt="<?= htmlspecialchars($project['title'] ?? '') ?>"
                                     class="w-full h-full object-cover">
                            </div>
                        <?php else: ?>
                            <div class="h-40 bg-highlight/20 flex items-center justify-center">
                                <i class="fas fa-briefcase text-4xl text-highlight/50"></i>
                            </div>
                        <?php endif; ?>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-highlight mb-3"><?= htmlspecialchars($project['title'] ?? '') ?></h3>
                            <p class="text-gray-300 mb-4"><?= htmlspecialchars($project['description'] ?? '') ?></p>
                            <?php if (!empty($project['tags'])): ?>
                                <div class="flex flex-wrap gap-2">
                                    <?php
                                    $tags = explode(',', $project['tags']);
                                    foreach ($tags as $tag):
                                        if (trim($tag)):
                                            ?>
                                            <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm"><?= htmlspecialchars(trim($tag)) ?></span>
                                        <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($project['project_url'])): ?>
                                <a href="<?= htmlspecialchars($project['project_url']) ?>" target="_blank"
                                   class="mt-4 inline-block text-highlight hover:text-light transition-colors no-underline">
                                    <i class="fas fa-external-link-alt mr-1"></i>Подробнее
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

    <!-- Третий блок - Нам доверяют (клиенты из админки) -->
<?php if (!empty($clients)): ?>
    <section class="py-16 bg-primary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Нам доверяют</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Компании, которые уже оценили эффективность наших решений</p>
            </div>

            <!-- Слайдер с логотипами клиентов -->
            <div class="slider-container mb-12">
                <div class="slider-track" id="logosSlider">
                    <?php
                    // Разбиваем клиентов на группы по 4 для слайдов
                    $clientChunks = array_chunk($clients, 4);
                    foreach ($clientChunks as $chunk):
                        ?>
                        <div class="slider-slide">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 items-center">
                                <?php foreach ($chunk as $client): ?>
                                    <div class="bg-white/5 rounded-xl p-6 flex items-center justify-center h-28">
                                        <?php if (!empty($client['image_url'])): ?>
                                            <img src="<?= htmlspecialchars($client['image_url']) ?>"
                                                 alt="<?= htmlspecialchars($client['title'] ?? '') ?>"
                                                 class="max-w-full max-h-16 object-contain">
                                        <?php else: ?>
                                            <span class="text-xl font-bold text-highlight"><?= htmlspecialchars($client['title'] ?? '') ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Навигационные кнопки -->
                <button class="slider-nav slider-prev" id="logosPrev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="slider-nav slider-next" id="logosNext">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <!-- Индикаторы -->
                <div class="slider-indicators" id="logosIndicators">
                    <!-- Индикаторы будут добавлены через JS -->
                </div>
            </div>

            <!-- Отзывы из админки -->
            <?php if (!empty($reviews)): ?>
                <div class="slider-container">
                    <div class="slider-track" id="reviewsSlider">
                        <?php foreach ($reviews as $review): ?>
                            <div class="slider-slide">
                                <div class="bg-white/5 rounded-xl p-6">
                                    <div class="flex items-center mb-4">
                                        <?php if (!empty($review['author_avatar'])): ?>
                                            <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                                                <img src="<?= htmlspecialchars($review['author_avatar']) ?>"
                                                     alt="<?= htmlspecialchars($review['author_name'] ?? '') ?>"
                                                     class="w-full h-full object-cover">
                                            </div>
                                        <?php else: ?>
                                            <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center mr-4">
                                            <span class="text-xl font-bold text-highlight">
                                                <?= !empty($review['author_name']) ? mb_substr($review['author_name'], 0, 1) : '?' ?>
                                            </span>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <h4 class="text-lg font-bold"><?= htmlspecialchars($review['author_name'] ?? '') ?></h4>
                                            <?php if (!empty($review['author_position'])): ?>
                                                <p class="text-gray-400"><?= htmlspecialchars($review['author_position']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <p class="text-gray-300 italic">
                                        "<?= htmlspecialchars($review['content'] ?? '') ?>"
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Навигационные кнопки -->
                    <button class="slider-nav slider-prev" id="reviewsPrev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="slider-nav slider-next" id="reviewsNext">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <!-- Индикаторы -->
                    <div class="slider-indicators" id="reviewsIndicators">
                        <!-- Индикаторы будут добавлены через JS -->
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
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

    <script>
        // Инициализация слайдеров
        function initSlider(sliderTrackId, prevBtnId, nextBtnId, indicatorsId) {
            const sliderTrack = document.getElementById(sliderTrackId);
            const sliderPrev = document.getElementById(prevBtnId);
            const sliderNext = document.getElementById(nextBtnId);
            const sliderIndicators = document.getElementById(indicatorsId);

            const slides = document.querySelectorAll(`#${sliderTrackId} .slider-slide`);
            if (slides.length === 0) return;

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
            sliderNext.addEventListener('click', () => {
                currentSlide = (currentSlide + 1) % slides.length;
                goToSlide(currentSlide);
            });

            // Предыдущий слайд
            sliderPrev.addEventListener('click', () => {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                goToSlide(currentSlide);
            });

            // Автопереключение слайдов
            setInterval(() => {
                currentSlide = (currentSlide + 1) % slides.length;
                goToSlide(currentSlide);
            }, 5000);
        }

        // Функции для попапа
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

        // Обработка формы с AJAX
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;

            // Показываем индикатор загрузки
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Отправка...';
            submitBtn.disabled = true;

            const formData = new FormData(this);

            fetch('/contact/submit', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (response.ok) {
                        // Показываем красивый попап
                        showSuccessPopup();
                        // Сбрасываем форму
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
                    // Восстанавливаем кнопку
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                });
        });

        // Инициализация слайдеров при загрузке страницы
        document.addEventListener('DOMContentLoaded', () => {
            initSlider('logosSlider', 'logosPrev', 'logosNext', 'logosIndicators');
            initSlider('reviewsSlider', 'reviewsPrev', 'reviewsNext', 'reviewsIndicators');

            // Закрытие попапа по клику на фон
            document.getElementById('successPopup').addEventListener('click', function(e) {
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
        });
    </script>

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
        // Инициализация слайдеров
        function initSlider(sliderTrackId, prevBtnId, nextBtnId, indicatorsId) {
            const sliderTrack = document.getElementById(sliderTrackId);
            const sliderPrev = document.getElementById(prevBtnId);
            const sliderNext = document.getElementById(nextBtnId);
            const sliderIndicators = document.getElementById(indicatorsId);

            const slides = document.querySelectorAll(`#${sliderTrackId} .slider-slide`);
            if (slides.length === 0) return;

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
            sliderNext.addEventListener('click', () => {
                currentSlide = (currentSlide + 1) % slides.length;
                goToSlide(currentSlide);
            });

            // Предыдущий слайд
            sliderPrev.addEventListener('click', () => {
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

        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/contact/submit', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                    } else if (response.ok) {
                        this.reset();
                    } else {
                        alert('Ошибка отправки формы. Пожалуйста, попробуйте еще раз.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Произошла ошибка при отправке формы');
                });
        });
    </script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>