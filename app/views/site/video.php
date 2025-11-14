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

    <!-- Блок "Наши работы" со слайдером и попапом -->
    <section id="portfolio" class="py-16 bg-primary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Наши работы</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Примеры созданных нами видеороликов и логотипов</p>
            </div>

            <?php
            // Получаем видео работы из портфолио
            $portfolioModel = new Portfolio();
            $videoWorks = $portfolioModel->getVideosByCategory('video', 10);
            ?>

            <?php if (!empty($videoWorks)): ?>
                <!-- Слайдер для видео работ с превью -->
                <div class="video-works-slider">
                    <?php foreach ($videoWorks as $work): ?>
                        <div class="px-3">
                            <div class="bg-white/5 rounded-xl p-4 mx-auto border border-highlight/20 h-full flex flex-col cursor-pointer video-item"
                                 data-video-id="<?= $work['id'] ?>"
                                 data-video-url="<?= getPortfolioVideoUrl($work) ?>"
                                 data-video-type="<?= !empty($work['video_url']) ? 'iframe' : 'html5' ?>"
                                 data-video-title="<?= htmlspecialchars($work['title']) ?>">

                                <div class="mb-3">
                                    <h3 class="text-lg font-bold text-highlight mb-1">
                                        <?= htmlspecialchars($work['title']) ?>
                                    </h3>
                                    <?php if (!empty($work['client_name'])): ?>
                                        <p class="text-gray-400 text-xs">Клиент: <?= htmlspecialchars($work['client_name']) ?></p>
                                    <?php endif; ?>
                                </div>

                                <!-- Превью изображение с кнопкой воспроизведения -->
                                <div class="video-preview-container mb-3 rounded-lg overflow-hidden flex-grow relative group">
                                    <!-- Canvas для отрисовки последнего кадра -->
                                    <canvas id="previewCanvas_<?= $work['id'] ?>"
                                            class="w-full h-full hidden"></canvas>

                                    <!-- Заглушка пока загружается превью -->
                                    <div id="previewPlaceholder_<?= $work['id'] ?>"
                                         class="w-full h-full bg-gradient-to-br from-highlight/20 to-accent/20 flex items-center justify-center">
                                        <div class="text-center">
                                            <i class="fas fa-play-circle text-4xl text-highlight mb-2"></i>
                                            <p class="text-highlight text-sm font-semibold">Загрузка превью...</p>
                                        </div>
                                    </div>

                                    <!-- Наложение с кнопкой воспроизведения -->
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                        <div class="w-16 h-16 bg-highlight/90 rounded-full flex items-center justify-center transform scale-90 group-hover:scale-100 transition-transform duration-300">
                                            <i class="fas fa-play text-2xl text-white ml-1"></i>
                                        </div>
                                    </div>

                                    <!-- Индикатор длительности -->
                                    <?php if (!empty($work['video_duration'])): ?>
                                        <div class="absolute bottom-2 right-2 bg-black/70 text-white px-2 py-1 rounded text-xs">
                                            <?= htmlspecialchars($work['video_duration']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Описание работы -->
                                <?php if (!empty($work['description'])): ?>
                                    <p class="text-gray-300 mb-3 leading-relaxed text-sm line-clamp-3">
                                        <?= htmlspecialchars($work['description']) ?>
                                    </p>
                                <?php endif; ?>

                                <!-- Теги -->
                                <?php if (!empty($work['tags'])): ?>
                                    <div class="flex flex-wrap gap-1 mt-auto">
                                        <?php
                                        $tags = json_decode($work['tags'], true) ?? [];
                                        foreach ($tags as $tag):
                                            if (trim($tag)):
                                                ?>
                                                <span class="bg-highlight/20 text-highlight px-2 py-1 rounded-full text-xs">
                                                    <?= htmlspecialchars(trim($tag)) ?>
                                                </span>
                                            <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <p class="text-gray-400">Видео работы скоро появятся</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Попап для видео -->
    <div id="videoPopup" class="fixed inset-0 bg-black/95 flex items-center justify-center z-50 hidden">
        <!-- Кнопка закрытия -->
        <button id="closeVideoPopup" class="absolute top-4 right-4 text-white hover:text-highlight transition-colors duration-300 z-50 bg-black/50 rounded-full w-10 h-10 flex items-center justify-center">
            <i class="fas fa-times text-xl"></i>
        </button>

        <!-- Контент попапа -->
        <div class="relative w-full h-full flex items-center justify-center">
            <!-- Видео контейнер -->
            <div class="w-full h-full max-w-6xl max-h-[90vh] mx-4">
                <!-- Заголовок -->
                <div class="absolute top-4 left-4 z-30 bg-black/70 rounded-lg px-4 py-2 max-w-md">
                    <h3 id="videoPopupTitle" class="text-lg font-bold text-white"></h3>
                </div>

                <!-- Видео контейнер -->
                <div id="videoPopupContent" class="w-full h-full bg-black rounded-lg overflow-hidden">
                    <!-- Видео будет загружено динамически -->
                </div>
            </div>
        </div>
    </div>

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
        /* Стили для полноэкранного видеопопапа */
        #videoPopup {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #videoPopup:not(.hidden) {
            opacity: 1;
        }

        #videoPopup > div {
            transform: scale(0.95);
            transition: transform 0.3s ease;
        }

        #videoPopup:not(.hidden) > div {
            transform: scale(1);
        }

        /* Анимация кнопки воспроизведения */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .video-item:hover .fa-play {
            animation: pulse 2s infinite;
        }

        /* Адаптивность попапа */
        @media (max-width: 768px) {
            .video-preview-container {
                min-height: 180px;
                max-height: 220px;
            }

            #videoPopup > div {
                margin: 0.5rem;
            }

            #closeVideoPopup {
                top: 1rem;
                right: 1rem;
                width: 8px;
                height: 8px;
            }
        }

        /* Улучшаем отображение слайдера */
        .video-works-slider .slick-slide {
            padding: 0 8px;
        }

        .video-works-slider .bg-white\\/5 {
            padding: 1rem;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* Вертикальное соотношение сторон 9:16 для видео 1080x1920 */
        .aspect-w-9 {
            position: relative;
        }

        .aspect-w-9::before {
            content: '';
            display: block;
            padding-bottom: 177.78%; /* 16:9 перевернуто = 9:16 = 56.25% -> 177.78% */
        }

        .aspect-w-9 > * {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* Чтобы видео заполняло контейнер */
        }

        /* Для вертикальных видео убираем стандартные контролы и делаем кастомные */
        .portfolio-video {
            background: #000;
        }

        /* Улучшенные контролы для вертикального видео */
        .portfolio-video::-webkit-media-controls-panel {
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
        }

        /* Ограничение текста в 3 строки */
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Уменьшаем отступы в карточках для вертикального видео */
        .video-works-slider .bg-white\\/5 {
            padding: 1rem;
        }

        /* Стрелки слайдера */
        .video-works-slider .slick-prev,
        .video-works-slider .slick-next {
            width: 40px;
            height: 40px;
            background: rgba(0, 183, 194, 0.9) !important;
            border-radius: 50%;
            z-index: 10;
            display: flex !important;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .video-works-slider .slick-prev {
            left: -50px;
        }

        .video-works-slider .slick-next {
            right: -50px;
        }

        .video-works-slider .slick-prev:before,
        .video-works-slider .slick-next:before {
            content: '' !important;
        }

        .video-works-slider .slick-prev:after {
            content: '‹';
            font-size: 20px;
            color: #0a0a1a;
            font-weight: bold;
            line-height: 1;
        }

        .video-works-slider .slick-next:after {
            content: '›';
            font-size: 20px;
            color: #0a0a1a;
            font-weight: bold;
            line-height: 1;
        }

        /* Точки навигации */
        .video-works-slider .slick-dots {
            bottom: -40px;
        }

        .video-works-slider .slick-dots li button:before {
            font-size: 8px;
            color: #00b7c2;
            opacity: 0.3;
        }

        .video-works-slider .slick-dots li.slick-active button:before {
            opacity: 1;
            color: #00b7c2;
        }

        /* Адаптивность */
        @media (max-width: 1280px) {
            .video-works-slider .slick-prev {
                left: -30px;
            }
            .video-works-slider .slick-next {
                right: -30px;
            }
        }

        @media (max-width: 768px) {
            .video-works-slider .slick-prev,
            .video-works-slider .slick-next {
                display: none !important;
            }

            .video-works-slider .slick-list {
                margin: 0 -4px;
            }

            .video-works-slider .slick-slide {
                padding: 0 4px;
            }
        }

        /* Единая высота для карточек */
        .video-works-slider .slick-track {
            display: flex !important;
        }

        .video-works-slider .slick-slide {
            height: inherit !important;
        }

        .video-works-slider .slick-slide > div {
            height: 100%;
        }

        /* Улучшенный внешний вид карточек для вертикального контента */
        .video-works-slider .bg-white\\/5 {
            transition: all 0.3s ease;
        }

        .video-works-slider .bg-white\\/5:hover {
                                             transform: translateY(-2px);
                                             box-shadow: 0 8px 25px rgba(0, 183, 194, 0.15);
                                         }

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
        // Инициализация слайдера видео работ с превью
        document.addEventListener('DOMContentLoaded', function() {
            $('.video-works-slider').slick({
                dots: true,
                arrows: true,
                infinite: false,
                speed: 500,
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: false,
                adaptiveHeight: false,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            arrows: false
                        }
                    },
                    {
                        breakpoint: 640,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            arrows: false
                        }
                    }
                ]
            });

            // Инициализация видеопопапа
            initializeVideoPopup();

            // Генерация превью из последних кадров видео
            setTimeout(() => {
                generateVideoPreviews(); // Используйте эту функцию для последнего кадра
                // ИЛИ generateFirstFramePreviews(); // Используйте эту для первого кадра
            }, 1000);
        });

        // Функция для генерации превью из последнего кадра видео
        function generateVideoPreviews() {
            document.querySelectorAll('.video-item').forEach(item => {
                const videoId = item.dataset.videoId;
                const videoUrl = item.dataset.videoUrl;
                const videoType = item.dataset.videoType;

                // Пропускаем iframe видео (YouTube/Vimeo)
                if (videoType === 'iframe') {
                    // Для iframe можно использовать стандартные превью или оставить заглушку
                    return;
                }

                // Для HTML5 видео генерируем превью
                generateVideoPreview(videoId, videoUrl);
            });
        }

        function generateVideoPreview(videoId, videoUrl) {
            const canvas = document.getElementById(`previewCanvas_${videoId}`);
            const placeholder = document.getElementById(`previewPlaceholder_${videoId}`);

            if (!canvas || !placeholder) return;

            const video = document.createElement('video');
            video.crossOrigin = 'anonymous'; // Важно для CORS
            video.preload = 'metadata';

            video.addEventListener('loadedmetadata', function() {
                // Устанавливаем время на последнюю секунду (или 90% длительности)
                const targetTime = Math.max(0, video.duration - 1);
                video.currentTime = targetTime;
            });

            video.addEventListener('seeked', function() {
                // Когда видео перемоталось на нужный кадр
                const ctx = canvas.getContext('2d');

                // Устанавливаем размеры canvas как у видео
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                // Рисуем кадр на canvas
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                // Показываем canvas, скрываем заглушку
                canvas.classList.remove('hidden');
                placeholder.classList.add('hidden');

                // Очищаем видео из памяти
                video.src = '';
                video.load();
            });

            video.addEventListener('error', function(e) {
                console.warn(`Не удалось загрузить видео для превью ${videoId}:`, e);
                // Можно оставить заглушку или показать стандартную иконку
            });

            // Начинаем загрузку
            video.src = videoUrl;
        }

        // Функция для создания превью из первого кадра (альтернативный вариант)
        function generateFirstFramePreviews() {
            document.querySelectorAll('.video-item').forEach(item => {
                const videoId = item.dataset.videoId;
                const videoUrl = item.dataset.videoUrl;
                const videoType = item.dataset.videoType;

                if (videoType === 'iframe') return;

                generateFirstFramePreview(videoId, videoUrl);
            });
        }

        function generateFirstFramePreview(videoId, videoUrl) {
            const canvas = document.getElementById(`previewCanvas_${videoId}`);
            const placeholder = document.getElementById(`previewPlaceholder_${videoId}`);

            if (!canvas || !placeholder) return;

            const video = document.createElement('video');
            video.crossOrigin = 'anonymous';
            video.preload = 'metadata';

            video.addEventListener('loadeddata', function() {
                // Берем первый кадр (0.1 секунда чтобы избежать черного кадра)
                video.currentTime = 0.1;
            });

            video.addEventListener('seeked', function() {
                const ctx = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                canvas.classList.remove('hidden');
                placeholder.classList.add('hidden');

                video.src = '';
                video.load();
            });

            video.addEventListener('error', function(e) {
                console.warn(`Не удалось загрузить видео для превью ${videoId}:`, e);
            });

            video.src = videoUrl;
        }

        // Функция для управления видеопопапом
        function initializeVideoPopup() {
            const videoPopup = document.getElementById('videoPopup');
            const closeBtn = document.getElementById('closeVideoPopup');
            const videoPopupContent = document.getElementById('videoPopupContent');
            const videoPopupTitle = document.getElementById('videoPopupTitle');

            let currentVideoElement = null;

            // Обработчики кликов на видео элементы
            document.querySelectorAll('.video-item').forEach(item => {
                item.addEventListener('click', function() {
                    const videoId = this.dataset.videoId;
                    const videoUrl = this.dataset.videoUrl;
                    const videoType = this.dataset.videoType;
                    const videoTitle = this.dataset.videoTitle;

                    // Устанавливаем заголовок
                    videoPopupTitle.textContent = videoTitle;

                    // Очищаем предыдущее видео
                    videoPopupContent.innerHTML = '';

                    // Создаем новое видео в зависимости от типа
                    if (videoType === 'iframe') {
                        // YouTube/Vimeo iframe
                        const iframe = document.createElement('iframe');
                        iframe.src = videoUrl + (videoUrl.includes('?') ? '&' : '?') + 'autoplay=1';
                        iframe.frameBorder = '0';
                        iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                        iframe.allowFullscreen = true;
                        iframe.className = 'w-full h-full';
                        videoPopupContent.appendChild(iframe);
                        currentVideoElement = iframe;
                    } else {
                        // HTML5 видео
                        const video = document.createElement('video');
                        video.src = videoUrl;
                        video.controls = true;
                        video.autoplay = true;
                        video.className = 'w-full h-full';
                        video.style.objectFit = 'contain'; // Чтобы видео правильно масштабировалось
                        videoPopupContent.appendChild(video);
                        currentVideoElement = video;
                    }

                    // Показываем попап
                    videoPopup.classList.remove('hidden');
                    setTimeout(() => {
                        videoPopup.classList.add('opacity-100');
                    }, 50);

                    // Предотвращаем прокрутку body
                    document.body.style.overflow = 'hidden';
                });
            });

            // Закрытие попапа
            function closeVideoPopup() {
                // Останавливаем видео
                if (currentVideoElement) {
                    if (currentVideoElement.tagName === 'VIDEO') {
                        currentVideoElement.pause();
                        currentVideoElement.currentTime = 0;
                    } else if (currentVideoElement.tagName === 'IFRAME') {
                        // Для iframe заменяем src чтобы остановить видео
                        const src = currentVideoElement.src;
                        currentVideoElement.src = src.replace('autoplay=1', 'autoplay=0');
                    }
                    currentVideoElement = null;
                }

                // Скрываем попап
                videoPopup.classList.remove('opacity-100');

                setTimeout(() => {
                    videoPopup.classList.add('hidden');
                    videoPopupContent.innerHTML = '';

                    // Восстанавливаем прокрутку body
                    document.body.style.overflow = '';
                }, 300);
            }

            // Обработчики закрытия
            closeBtn.addEventListener('click', closeVideoPopup);

            // Закрытие по клику на фон
            videoPopup.addEventListener('click', function(e) {
                if (e.target === this || e.target === videoPopupContent) {
                    closeVideoPopup();
                }
            });

            // Закрытие по ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !videoPopup.classList.contains('hidden')) {
                    closeVideoPopup();
                }
            });

            // Останавливаем видео при смене слайда
            $('.video-works-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
                if (!videoPopup.classList.contains('hidden')) {
                    closeVideoPopup();
                }
            });
        }

        // Функции для успешного попапа формы
        function showSuccessPopup() {
            const popup = document.getElementById('successPopup');
            popup.classList.remove('hidden');
        }

        function closeSuccessPopup() {
            const popup = document.getElementById('successPopup');
            popup.classList.add('hidden');
        }

        function showErrorPopup() {
            const popup = document.getElementById('errorPopup');
            popup.classList.remove('hidden');
        }

        function closeErrorPopup() {
            const popup = document.getElementById('errorPopup');
            popup.classList.add('hidden');
        }

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

                // Также закрываем видеопопап если он открыт
                const videoPopup = document.getElementById('videoPopup');
                if (!videoPopup.classList.contains('hidden')) {
                    closeVideoPopup();
                }
            }
        });
    </script>


<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>