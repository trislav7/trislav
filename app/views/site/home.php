<?php ob_start(); ?>

    <!-- Герой секция -->
    <section class="pt-32 pb-20 bg-gradient-to-br from-secondary to-primary px-4">
        <div class="container mx-auto max-w-6xl text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">Трислав Медиа</h1>
            <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto mb-8">
                Элитное рекламное агентство полного цикла
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/led" class="bg-highlight text-primary font-semibold py-3 px-8 rounded-full border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline">
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

    <!-- Направления работы -->
    <section id="services" class="py-16 bg-secondary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Направления работы</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Мы предлагаем полный спектр рекламных услуг для вашего бизнеса</p>
            </div>

            <?php if (!empty($services) && is_array($services)): ?>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php foreach ($services as $service): ?>
                        <div class="service-card bg-white/5 rounded-xl p-8 transition-all duration-300 hover:shadow-2xl">
                            <div class="flex items-start mb-6">
                                <div class="w-16 h-16 bg-highlight/20 rounded-full flex items-center justify-center mr-6">
                                    <i class="<?= htmlspecialchars($service['icon'] ?? 'fas fa-star') ?> text-2xl text-highlight"></i>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-highlight mb-2"><?= htmlspecialchars($service['title'] ?? '') ?></h3>
                                    <p class="text-gray-300"><?= htmlspecialchars($service['short_description'] ?? $service['description'] ?? '') ?></p>
                                </div>
                            </div>
                            <ul class="space-y-3 mb-6">
                                <?php
                                $features = isset($service['features']) ? json_decode($service['features'], true) : [];
                                if (is_array($features)) {
                                    foreach (array_slice($features, 0, 4) as $feature):
                                        ?>
                                        <li class="flex items-center">
                                            <i class="fas fa-check text-highlight mr-3"></i>
                                            <?= htmlspecialchars($feature) ?>
                                        </li>
                                    <?php
                                    endforeach;
                                }
                                ?>
                            </ul>
                            <a href="/<?= $service['category'] ?? 'led' ?>" class="inline-block bg-highlight text-primary font-semibold py-2 px-6 rounded-lg transition-all duration-300 hover:bg-transparent hover:text-highlight border-2 border-highlight no-underline">
                                Подробнее
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <p class="text-gray-400">Услуги временно недоступны</p>
                </div>
            <?php endif; ?>
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