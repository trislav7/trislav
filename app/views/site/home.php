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

        <!-- Секция основных направлений -->
    <section id="directions" class="py-20 px-4 bg-gradient-to-b from-primary to-secondary">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-light mb-4">
                    Основные направления
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Комплексные решения для эффективного продвижения вашего бизнеса
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- LED экраны -->
                <div class="group bg-secondary rounded-xl p-8 border border-highlight/30 hover:border-highlight/50 transition-all duration-500 hover:-translate-y-3 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-highlight to-accent rounded-full flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-primary" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"></rect>
                            <path d="M8 12H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                            <path d="M12 8V16" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-light mb-4 group-hover:text-highlight transition-colors duration-300">
                        LED экраны
                    </h3>

                    <p class="text-gray-300 leading-relaxed mb-6">
                        Размещение рекламы на цифровых экранах в торговых центрах и местах скопления целевой аудитории
                    </p>

                    <a href="/led" class="inline-block bg-highlight text-primary font-semibold py-3 px-6 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline">
                        Подробнее
                    </a>
                </div>

                <!-- Видео и лого -->
                <div class="group bg-secondary rounded-xl p-8 border border-highlight/30 hover:border-highlight/50 transition-all duration-500 hover:-translate-y-3 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-highlight to-accent rounded-full flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-primary" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23 7L16 12L23 17V7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <rect x="1" y="5" width="15" height="14" rx="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></rect>
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-light mb-4 group-hover:text-highlight transition-colors duration-300">
                        Видео и лого
                    </h3>

                    <p class="text-gray-300 leading-relaxed mb-6">
                        Создание профессионального визуального контента: видеоролики, логотипы, брендинг и полиграфия
                    </p>

                    <a href="/video" class="inline-block bg-highlight text-primary font-semibold py-3 px-6 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline">
                        Подробнее
                    </a>
                </div>

                <!-- BTL мероприятия -->
                <div class="group bg-secondary rounded-xl p-8 border border-highlight/30 hover:border-highlight/50 transition-all duration-500 hover:-translate-y-3 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-highlight to-accent rounded-full flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-primary" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-light mb-4 group-hover:text-highlight transition-colors duration-300">
                        BTL мероприятия
                    </h3>

                    <p class="text-gray-300 leading-relaxed mb-6">
                        Организация промо-акций, ивентов и мероприятий для прямого взаимодействия с целевой аудиторией
                    </p>

                    <a href="/btl" class="inline-block bg-highlight text-primary font-semibold py-3 px-6 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline">
                        Подробнее
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Последние работы -->
    <section class="py-16 bg-primary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Наши работы</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Примеры успешных проектов для наших клиентов</p>
            </div>

            <?php if (!empty($portfolio) && is_array($portfolio)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($portfolio as $item): ?>
                        <div class="portfolio-item bg-white/5 rounded-xl overflow-hidden transition-all duration-300 hover:transform hover:scale-105">
                            <div class="h-48 bg-gradient-to-br from-accent to-highlight flex items-center justify-center">
                                <span class="text-white text-xl font-bold text-center px-4"><?= htmlspecialchars($item['title'] ?? '') ?></span>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-highlight mb-2"><?= htmlspecialchars($item['client_name'] ?? '') ?></h3>
                                <p class="text-gray-300 mb-4"><?= htmlspecialchars(substr($item['description'] ?? '', 0, 100)) ?>...</p>
                                <div class="flex flex-wrap gap-2">
                                    <?php
                                    $tags = isset($item['tags']) ? json_decode($item['tags'], true) : [];
                                    if (is_array($tags)) {
                                        foreach (array_slice($tags, 0, 3) as $tag):
                                            ?>
                                            <span class="bg-highlight/20 text-highlight px-2 py-1 rounded text-xs"><?= htmlspecialchars($tag) ?></span>
                                        <?php
                                        endforeach;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <p class="text-gray-400">Работы временно недоступны</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Блок "Почему именно мы" для Трислав Медиа -->
    <section id="why-us" class="py-20 px-4 bg-gradient-to-b from-primary to-[#0a0a1a]">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-light mb-4">
                    Почему выбирают Трислав Медиа?
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Мы создаем точечную рекламу, которая доходит до потребителя и приносит реальные результаты
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php if (!empty($advantages) && is_array($advantages)): ?>
                    <?php foreach ($advantages as $advantage): ?>
                        <?php if ($advantage['is_active']): ?>
                            <div class="group bg-[#0a0a1a] rounded-xl p-8 border border-highlight/20 hover:border-highlight/50 transition-all duration-500 hover:-translate-y-3">
                                <div class="w-16 h-16 bg-gradient-to-br from-highlight to-accent rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <?php if ($advantage['icon_class']): ?>
                                        <i class="<?= htmlspecialchars($advantage['icon_class']) ?> text-primary text-xl font-bold"></i>
                                    <?php else: ?>
                                        <i class="fas fa-star text-primary text-xl"></i>
                                    <?php endif; ?>
                                </div>

                                <h3 class="text-xl font-bold text-light mb-4 group-hover:text-highlight transition-colors duration-300">
                                    <?= htmlspecialchars($advantage['title']) ?>
                                </h3>

                                <?php if ($advantage['description']): ?>
                                    <p class="text-gray-300 leading-relaxed group-hover:text-light transition-colors duration-300">
                                        <?= htmlspecialchars($advantage['description']) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Преимущества по умолчанию для Трислав Медиа -->
                    <?php
                    $defaultMediaAdvantages = [
                            [
                                    'title' => 'Мы создаем поток клиентов',
                                    'description' => 'Эффективные рекламные кампании, которые приносят реальных клиентов и увеличивают продажи',
                                    'icon' => 'fas fa-chart-line'
                            ],
                            [
                                    'title' => 'Команда профессионалов',
                                    'description' => 'Сертифицированные специалисты с подтверждённым опытом успешных рекламных кампаний',
                                    'icon' => 'fas fa-users'
                            ],
                            [
                                    'title' => 'Инновационные решения',
                                    'description' => 'Первыми внедрили систему точечного таргетинга через digital-экраны в ключевых ТЦ города',
                                    'icon' => 'fas fa-lightbulb'
                            ],
                            [
                                    'title' => 'Точная аудитория',
                                    'description' => 'Наши экраны размещены в местах максимального скопления вашей целевой аудитории',
                                    'icon' => 'fas fa-bullseye'
                            ],
                            [
                                    'title' => 'Аналитика в реальном времени',
                                    'description' => 'Отслеживаем эффективность каждой кампании и корректируем стратегию для максимального результата',
                                    'icon' => 'fas fa-chart-bar'
                            ],
                            [
                                    'title' => 'Гарантированный результат',
                                    'description' => 'Продуманная медиастратегия и точное размещение рекламы для достижения ваших целей',
                                    'icon' => 'fas fa-award'
                            ]
                    ];
                    ?>

                    <?php foreach ($defaultMediaAdvantages as $advantage): ?>
                        <div class="group bg-[#0a0a1a] rounded-xl p-8 border border-highlight/20 hover:border-highlight/50 transition-all duration-500 hover:-translate-y-3">
                            <div class="w-16 h-16 bg-gradient-to-br from-highlight to-accent rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <i class="<?= $advantage['icon'] ?> text-primary text-xl font-bold"></i>
                            </div>

                            <h3 class="text-xl font-bold text-light mb-4 group-hover:text-highlight transition-colors duration-300">
                                <?= $advantage['title'] ?>
                            </h3>

                            <p class="text-gray-300 leading-relaxed group-hover:text-light transition-colors duration-300">
                                <?= $advantage['description'] ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- CTA блок -->
            <div class="text-center mt-16 pt-8 border-t border-highlight/20">
                <p class="text-gray-300 text-lg mb-6">Готовы увеличить эффективность вашей рекламы?</p>
                <a href="#contact" class="bg-highlight text-primary font-bold py-4 px-8 rounded-lg text-lg border-2 border-highlight hover:bg-transparent hover:text-highlight transition-all duration-300 no-underline inline-block">
                    Начать сотрудничество
                </a>
            </div>
        </div>
    </section>

    <!-- Контактная форма -->
    <section id="contact" class="py-16 bg-secondary px-4">
        <div class="container mx-auto max-w-4xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Свяжитесь с нами</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Готовы обсудить ваш проект? Оставьте заявку и мы свяжемся с вами</p>
            </div>

            <div class="contact-form bg-white/5 p-8 rounded-xl">
                <form action="/contact/submit" method="POST">
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

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>