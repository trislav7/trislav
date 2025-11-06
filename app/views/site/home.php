<?php ob_start(); ?>

    <!-- Герой секция -->
    <section class="pt-32 pb-20 bg-gradient-to-br from-secondary to-primary px-4">
        <div class="container mx-auto max-w-6xl text-center">
            <div class="flex justify-center mb-20">
                <div class="w-64 from-accent to-highlight rounded-xl flex items-center justify-center">
                    <img src="/images/tm_.png" />
                </div>
            </div>
            <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto mb-8">
                Мы создаем точечную рекламу, которая доходит до потребителя.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/led" class="bg-transparent text-highlight font-semibold py-3 px-8 rounded-full border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline">
                    LED экраны
                </a>
                <a href="/video" class="bg-transparent text-highlight font-semibold py-3 px-8 rounded-full border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline">
                    Видео и лого
                </a>
                <a href="/btl" class="bg-transparent text-highlight font-semibold py-3 px-8 rounded-full border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline">
                    BTL мероприятия
                </a>
            </div>
        </div>
    </section>

    <section id="services" class="py-20 md:py-24 lg:py-28 bg-secondary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 relative inline-block">
                    Направления работы
                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-20 h-1 bg-highlight mt-4"></div>
                </h2>
                <p class="text-lg md:text-xl text-gray-300 mt-8 max-w-2xl mx-auto">
                    Мы предлагаем полный спектр рекламных услуг для вашего бизнеса
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- LED экраны -->
                <div class="service-card bg-white/5 rounded-xl overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl h-full flex flex-col">
                    <div class="service-image h-48 md:h-56 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1592861956120-8da6360a4c1b?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=800&amp;q=80" alt="LED экраны" class="w-full h-full object-cover transition-transform duration-500">
                    </div>
                    <div class="service-content p-6 flex-grow">
                        <h3 class="text-xl md:text-2xl font-bold text-highlight mb-4">LED экраны в ТЦ</h3>
                        <p class="text-gray-300 mb-4 leading-relaxed">
                            Размещение рекламы на современных LED-экранах в крупнейших торговых центрах города с высоким трафиком.
                        </p>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-300">
                                <i class="fas fa-check text-highlight mr-3"></i>
                                Премиальные локации
                            </li>
                            <li class="flex items-center text-gray-300">
                                <i class="fas fa-check text-highlight mr-3"></i>
                                Высокое качество изображения
                            </li>
                            <li class="flex items-center text-gray-300">
                                <i class="fas fa-check text-highlight mr-3"></i>
                                Аналитика эффективности
                            </li>
                            <li class="flex items-center text-gray-300">
                                <i class="fas fa-check text-highlight mr-3"></i>
                                Гибкие тарифы
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- BTL мероприятия -->
                <div class="service-card bg-white/5 rounded-xl overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl h-full flex flex-col">
                    <div class="service-image h-48 md:h-56 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1531058020387-3be344556be6?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=800&amp;q=80" alt="BTL мероприятия" class="w-full h-full object-cover transition-transform duration-500">
                    </div>
                    <div class="service-content p-6 flex-grow">
                        <h3 class="text-xl md:text-2xl font-bold text-highlight mb-4">BTL мероприятия</h3>
                        <p class="text-gray-300 mb-4 leading-relaxed">
                            Организация и проведение промо-акций, дегустаций, концертов и других мероприятий для прямого контакта с потребителем.
                        </p>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-300">
                                <i class="fas fa-check text-highlight mr-3"></i>
                                Раздача листовок и промо-материалов
                            </li>
                            <li class="flex items-center text-gray-300">
                                <i class="fas fa-check text-highlight mr-3"></i>
                                Организация мероприятий
                            </li>
                            <li class="flex items-center text-gray-300">
                                <i class="fas fa-check text-highlight mr-3"></i>
                                Дегустации и промо-акции
                            </li>
                            <li class="flex items-center text-gray-300">
                                <i class="fas fa-check text-highlight mr-3"></i>
                                Концерты и шоу-программы
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Видеоролики и логотипы -->
                <div class="service-card bg-white/5 rounded-xl overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl h-full flex flex-col">
                    <div class="service-image h-48 md:h-56 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1611224923853-80b023f02d71?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=800&amp;q=80" alt="Видеопроизводство" class="w-full h-full object-cover transition-transform duration-500">
                    </div>
                    <div class="service-content p-6 flex-grow">
                        <h3 class="text-xl md:text-2xl font-bold text-highlight mb-4">Видеоролики и логотипы</h3>
                        <p class="text-gray-300 mb-4 leading-relaxed">
                            Профессиональное создание рекламных роликов, корпоративных видео и разработка уникальных логотипов.
                        </p>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-300">
                                <i class="fas fa-check text-highlight mr-3"></i>
                                Рекламные видеоролики
                            </li>
                            <li class="flex items-center text-gray-300">
                                <i class="fas fa-check text-highlight mr-3"></i>
                                Корпоративные видео
                            </li>
                            <li class="flex items-center text-gray-300">
                                <i class="fas fa-check text-highlight mr-3"></i>
                                Разработка логотипов
                            </li>
                            <li class="flex items-center text-gray-300">
                                <i class="fas fa-check text-highlight mr-3"></i>
                                Брендинг и айдентика
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Блок "Наши преимущества" для Трислав Медиа -->
<?php if (!empty($advantages) && is_array($advantages)): ?>
    <section id="advantages" class="py-20 md:py-24 lg:py-28 bg-primary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 relative inline-block text-light">
                    Наши преимущества
                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-20 h-1 bg-highlight mt-4"></div>
                </h2>
                <p class="text-lg md:text-xl text-gray-300 mt-8 max-w-2xl mx-auto">
                    Почему выбирают именно нас
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <?php foreach ($advantages as $advantage): ?>
                    <?php if ($advantage['is_active']): ?>
                        <div class="advantage-card text-center p-6 lg:p-8 bg-white/5 rounded-xl transition-all duration-300 hover:-translate-y-1 hover:bg-white/10">
                            <div class="advantage-icon text-5xl text-highlight mb-6">
                                <?php if (!empty($advantage['icon_class'])): ?>
                                    <i class="<?= htmlspecialchars($advantage['icon_class']) ?>"></i>
                                <?php elseif (!empty($advantage['icon_svg'])): ?>
                                    <?= $advantage['icon_svg'] ?>
                                <?php else: ?>
                                    <i class="fas fa-star"></i>
                                <?php endif; ?>
                            </div>
                            <h3 class="text-xl font-bold mb-4 text-light">
                                <?= htmlspecialchars($advantage['title'] ?? 'Преимущество') ?>
                            </h3>
                            <?php if (!empty($advantage['description'])): ?>
                                <p class="text-gray-300"><?= htmlspecialchars($advantage['description']) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

    <!-- Контактная форма -->
    <section id="contact" class="py-16 bg-secondary px-4">
        <div class="container mx-auto max-w-4xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Свяжитесь с нами</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Готовы обсудить ваш проект? Оставьте заявку и мы свяжемся с вами</p>
            </div>

            <div class="contact-form bg-white/5 p-8 rounded-xl">
                <form method="POST" id="contactForm">
                    <input type="hidden" name="source" value="general">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="form-group">
                            <label for="name" class="block mb-2 font-medium">Ваше имя *</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                        </div>
                        <div class="form-group">
                            <label for="phone" class="block mb-2 font-medium">Телефон *</label>
                            <input type="tel" id="phone" name="phone" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                        </div>
                    </div>
                    <div class="form-group mb-6">
                        <label for="email" class="block mb-2 font-medium">Email *</label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                    </div>
                    <div class="form-group mb-6">
                        <label for="message" class="block mb-2 font-medium">Сообщение</label>
                        <textarea id="message" name="message" rows="5"
                                  class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                                  placeholder="Расскажите о вашем проекте..."></textarea>
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
        <div class="bg-gradient-to-br from-primary to-secondary rounded-2xl p-8 mx-4 max-w-md w-full border-2 border-highlight/50">
            <div class="text-center">
                <!-- Анимированная иконка -->
                <div class="w-20 h-20 bg-highlight/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-highlight mb-4">Спасибо за вашу заявку!</h3>
                <p class="text-light mb-6">
                    Мы свяжемся с вами в ближайшее время для обсуждения вашего проекта.
                </p>

                <button onclick="closeSuccessPopup()"
                        class="bg-highlight text-primary font-semibold py-3 px-8 rounded-lg transition-all duration-300 hover:bg-transparent hover:text-highlight border-2 border-highlight">
                    Понятно
                </button>
            </div>
        </div>
    </div>

    <!-- ПОПАП ДЛЯ ОШИБОК -->
    <div id="errorPopup" class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">
        <div class="bg-gradient-to-br from-red-900 to-red-700 rounded-2xl p-8 mx-4 max-w-md w-full border-2 border-red-500/50">
            <div class="text-center">
                <!-- Иконка ошибки -->
                <div class="w-20 h-20 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-red-400 mb-4">Ошибка отправки</h3>
                <p class="text-light mb-6">
                    Произошла ошибка при отправке формы. Пожалуйста, попробуйте еще раз.
                </p>

                <button onclick="closeErrorPopup()"
                        class="bg-red-500 text-white font-semibold py-3 px-8 rounded-lg transition-all duration-300 hover:bg-transparent hover:text-red-400 border-2 border-red-500">
                    Понятно
                </button>
            </div>
        </div>
    </div>

    <script>
        // Функции для успешного попапа
        function showSuccessPopup() {
            const popup = document.getElementById('successPopup');
            popup.classList.remove('hidden');
        }

        function closeSuccessPopup() {
            const popup = document.getElementById('successPopup');
            popup.classList.add('hidden');
        }

        // Функции для попапа с ошибкой
        function showErrorPopup() {
            const popup = document.getElementById('errorPopup');
            popup.classList.remove('hidden');
        }

        function closeErrorPopup() {
            const popup = document.getElementById('errorPopup');
            popup.classList.add('hidden');
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
                        // Показываем красивый попап УСПЕХА
                        showSuccessPopup();
                        // Сбрасываем форму
                        this.reset();
                    } else {
                        // Показываем попап ОШИБКИ
                        showErrorPopup();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Показываем попап ОШИБКИ
                    showErrorPopup();
                })
                .finally(() => {
                    // Восстанавливаем кнопку
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                });
        });

        // Закрытие попапов по клику на фон
        document.getElementById('successPopup').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSuccessPopup();
            }
        });

        document.getElementById('errorPopup').addEventListener('click', function(e) {
            if (e.target === this) {
                closeErrorPopup();
            }
        });

        // Закрытие попапов по ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSuccessPopup();
                closeErrorPopup();
            }
        });
    </script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>