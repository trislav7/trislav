<?php ob_start(); ?>

    <!-- Герой секция -->
    <section class="pt-32 pb-20 bg-gradient-to-br from-secondary to-primary px-4">
        <div class="container mx-auto max-w-6xl text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">Видеоролики и Логотипы</h1>
            <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto mb-8">
                Профессиональное создание визуального контента, который рассказывает историю вашего бренда и привлекает клиентов
            </p>
            <a href="#services" class="inline-block bg-highlight text-primary font-semibold py-3 px-8 rounded-full border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline mr-4">
                Наши услуги
            </a>
            <a href="#portfolio" class="inline-block bg-transparent text-highlight font-semibold py-3 px-8 rounded-full border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline">
                Наши работы
            </a>
        </div>
    </section>

    <!-- Секция услуг -->
    <section id="services" class="py-16 px-4 bg-gradient-to-b from-primary to-secondary">
        <div class="container mx-auto max-w-6xl">
            <h2 class="text-3xl lg:text-4xl font-bold text-center text-light mb-12">
                Наши услуги для видео и логотипов
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <?php
                $serviceModel = new Service();
                $videoServices = $serviceModel->getWithFullDataByCategory('video');

                if (!empty($videoServices)):
                    foreach ($videoServices as $service):
                        $features = safe_json_decode($service['features'] ?? '', []);
                        $tags = safe_json_decode($service['tags'] ?? '', []);
                        ?>
                        <div class="service-card bg-white/5 rounded-xl p-8 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl">
                            <div class="flex items-start mb-6">
                                <div class="w-16 h-16 bg-highlight/20 rounded-full flex items-center justify-center mr-6">
                                    <?php if (!empty($service['icon_svg'])): ?>
                                        <?= $service['icon_svg'] ?>
                                    <?php else: ?>
                                        <!-- Иконка по умолчанию -->
                                        <svg class="w-8 h-8 text-highlight" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M23 7L16 12L23 17V7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <rect x="1" y="5" width="15" height="14" rx="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></rect>
                                        </svg>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-highlight mb-2"><?= htmlspecialchars($service['title']) ?></h3>
                                    <p class="text-gray-300"><?= htmlspecialchars($service['short_description']) ?></p>
                                </div>
                            </div>

                            <?php if (!empty($features)): ?>
                                <ul class="space-y-3 mb-6">
                                    <?php foreach ($features as $feature): ?>
                                        <?php if (!empty(trim($feature))): ?>
                                            <li class="flex items-center">
                                                <i class="fas fa-check text-highlight mr-3"></i>
                                                <?= htmlspecialchars(trim($feature)) ?>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <?php if (!empty($tags)): ?>
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach ($tags as $tag): ?>
                                        <?php if (!empty(trim($tag))): ?>
                                            <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm">
                                        <?= htmlspecialchars(trim($tag)) ?>
                                    </span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php
                    endforeach;
                else:
                    ?>
                    <!-- Запасной контент -->
                    <div class="col-span-full text-center py-12 text-gray-400">
                        <i class="fas fa-video text-4xl mb-4"></i>
                        <p>Услуги для видео и логотипов скоро будут добавлены</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Блок "Как мы работаем" -->
    <section class="py-16 bg-primary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-light mb-4">Как мы работаем</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Четкий процесс создания промо-материалов от идеи до реализации</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <?php
                $processModel = new WorkProcess();
                $processes = $processModel->getAllActive();

                if (!empty($processes)):
                    foreach ($processes as $process):
                        ?>
                        <div class="process-step text-center p-6">
                            <div class="w-20 h-20 bg-highlight/20 rounded-full flex items-center justify-center mx-auto mb-6">
                                <span class="text-2xl font-bold text-highlight"><?= $process['step_number'] ?></span>
                            </div>
                            <h3 class="text-xl font-bold text-light mb-4"><?= htmlspecialchars($process['title']) ?></h3>
                            <p class="text-gray-300"><?= htmlspecialchars($process['description']) ?></p>
                        </div>
                    <?php
                    endforeach;
                else:
                    ?>
                    <!-- Запасной контент -->
                    <div class="col-span-4 text-center text-gray-400 py-8">
                        <i class="fas fa-cogs text-4xl mb-4"></i>
                        <p>Информация о процессе работы скоро будет добавлена</p>
                        <p class="text-sm mt-2">Добавьте этапы работы через админ-панель</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- Портфолио -->
<?php if (!empty($portfolio) && is_array($portfolio)): ?>
    <section id="portfolio" class="py-16 bg-primary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Наши работы</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Примеры созданных нами видеороликов и логотипов</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($portfolio as $item): ?>
                    <?php if ($item['is_active']): ?>
                        <div class="portfolio-item bg-white/5 rounded-xl overflow-hidden transition-all duration-300 hover:transform hover:scale-105">
                            <!-- Блок с градиентом и названием -->
                            <div class="h-48 bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                        <span class="text-white text-xl font-bold text-center px-4">
                            <?= !empty($item['client_name']) ? htmlspecialchars($item['client_name']) : htmlspecialchars($item['title']) ?>
                        </span>
                            </div>

                            <div class="p-6">
                                <!-- Заголовок (используем client_name или первую часть title) -->
                                <h3 class="text-xl font-bold text-highlight mb-2">
                                    <?= htmlspecialchars($item['title']) ?>
                                </h3>

                                <!-- Описание -->
                                <?php if (!empty($item['description'])): ?>
                                    <p class="text-gray-300 mb-4"><?= htmlspecialchars($item['description']) ?></p>
                                <?php endif; ?>

                                <!-- Теги -->
                                <?php if (!empty($item['tags'])): ?>
                                    <div class="flex flex-wrap gap-2">
                                        <?php
                                        // Обрабатываем JSON теги
                                        $tags = [];
                                        if (is_string($item['tags'])) {
                                            $tags = json_decode($item['tags'], true) ?? [];
                                        } elseif (is_array($item['tags'])) {
                                            $tags = $item['tags'];
                                        }

                                        // Выводим теги
                                        if (!empty($tags) && is_array($tags)):
                                            foreach ($tags as $tag):
                                                if (!empty(trim($tag))):
                                                    ?>
                                                    <span class="bg-highlight/20 text-highlight px-2 py-1 rounded text-xs">
                                        <?= htmlspecialchars(trim($tag)) ?>
                                    </span>
                                                <?php
                                                endif;
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
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
            <div class="contact-form bg-white/5 p-8 rounded-xl">
                <h3 class="text-2xl font-bold text-highlight mb-6">Обсудить проект</h3>
                <form method="POST" id="contactForm">
                    <input type="hidden" name="source" value="video_page">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="form-group">
                            <label for="name" class="block mb-2 font-medium">Ваше имя *</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                        </div>
                        <div class="form-group">
                            <label for="company" class="block mb-2 font-medium">Компания</label>
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

                    <!-- НОВОЕ ПОЛЕ: Выбор услуги из админки -->
                    <div class="form-group mb-6">
                        <label for="service_id" class="block mb-2 font-medium">Интересует услуга</label>
                        <select id="service_id" name="service_id" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                            <option value="">Выберите услугу (необязательно)</option>
                            <?php if (!empty($videoServices) && is_array($videoServices)): ?>
                                <?php foreach ($videoServices as $service): ?>
                                    <?php if ($service['is_active']): ?>
                                        <option value="<?= $service['id'] ?>">
                                            <?= htmlspecialchars($service['title']) ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group mb-6">
                        <label for="message" class="block mb-2 font-medium">О проекте</label>
                        <textarea id="message" name="message" rows="4"
                                  class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                                  placeholder="Расскажите о вашем проекте, целях, сроках и других деталях..."></textarea>
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
                        Обсудить проект
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
<style>
    select option {
        background: #1a1a2e !important;
        color: #f1f1f1 !important;
        padding: 12px;
    }

    select:focus option {
        background: #16213e !important;
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

            fetch('/video/submit', {
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