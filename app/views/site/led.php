<?php ob_start(); ?>

    <!-- Герой секция -->
    <section class="pt-32 pb-20 bg-gradient-to-br from-secondary to-primary px-4">
        <div class="container mx-auto max-w-6xl text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">LED Экраны в Торговых Центрах</h1>
            <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto mb-8">
                Размещение рекламы на современных LED-экранах в крупнейших торговых центрах с максимальным охватом аудитории
            </p>
            <a href="#screens" class="inline-block bg-highlight text-primary font-semibold py-3 px-8 rounded-full border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline mr-4">
                Наши экраны
            </a>
            <a href="#contact" class="inline-block bg-transparent text-highlight font-semibold py-3 px-8 rounded-full border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline">
                Оставить заявку
            </a>
        </div>
    </section>

    <!-- Блок "Почему LED-экраны эффективны" -->
<?php if (!empty($advantages)): ?>
    <section class="py-16 bg-secondary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Почему LED-экраны эффективны?</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Современный подход к привлечению внимания вашей целевой аудитории</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($advantages as $advantage): ?>
                    <div class="text-center p-6 bg-white/5 rounded-xl">
                        <div class="w-16 h-16 bg-highlight/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <?= $advantage['icon_svg'] ?? '<i class="fas fa-star text-2xl text-highlight"></i>' ?>
                        </div>
                        <h3 class="text-xl font-bold mb-3"><?= htmlspecialchars($advantage['title']) ?></h3>
                        <p class="text-gray-300"><?= htmlspecialchars($advantage['description']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

    <!-- Блок "Наши LED-Экраны" (используем портфолио) -->
    <section id="screens" class="py-16 bg-primary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Наши LED-Экраны</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Премиальные локации в крупнейших торговых центрах города</p>
            </div>

            <?php if (!empty($portfolio)): ?>
                <div class="screens-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($portfolio as $screen):
                        $tags = json_decode($screen['tags'] ?? '[]', true) ?? [];
                        $firstTag = $tags[0] ?? '';
                        $secondTag = $tags[1] ?? '';
                        ?>
                        <div class="bg-white/5 rounded-xl overflow-hidden">
                            <div class="h-48 overflow-hidden">
                                <?php if ($screen['image']): ?>
                                    <img src="<?= htmlspecialchars($screen['image']) ?>" alt="<?= htmlspecialchars($screen['title']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full bg-highlight/20 flex items-center justify-center">
                                        <i class="fas fa-display text-4xl text-highlight/50"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-highlight mb-2"><?= htmlspecialchars($screen['title']) ?></h3>
                                <p class="text-gray-300 mb-4"><?= htmlspecialchars($screen['description']) ?></p>
                                <?php if ($firstTag || $secondTag): ?>
                                    <div class="flex justify-between text-sm">
                                        <?php if ($firstTag): ?>
                                            <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full"><?= htmlspecialchars($firstTag) ?></span>
                                        <?php endif; ?>
                                        <?php if ($secondTag): ?>
                                            <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full"><?= htmlspecialchars($secondTag) ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <p class="text-gray-400">Информация об экранах временно недоступна</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Блок "Тарифы" с адаптивным отображением -->
    <section id="tariffs" class="py-16 bg-secondary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Тарифы на размещение</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Гибкие условия для любого бюджета и целей рекламной кампании</p>
            </div>

            <?php if (!empty($tariffs)): ?>
                <div class="grid grid-cols-1 <?= count($tariffs) <= 2 ? 'md:grid-cols-2 max-w-4xl mx-auto' : 'md:grid-cols-2 lg:grid-cols-'.min(4, count($tariffs)) ?> gap-6">
                    <?php foreach ($tariffs as $tariff): ?>
                        <div class="tariff-card bg-white/5 rounded-xl p-8 text-center transition-all duration-300 border-2 <?= $tariff['is_popular'] ? 'border-highlight' : 'border-gray-700' ?> relative">
                            <?php if ($tariff['is_popular']): ?>
                                <div class="absolute top-0 right-0 bg-highlight text-primary text-sm font-bold px-4 py-1 rounded-bl-lg">ПОПУЛЯРНЫЙ</div>
                            <?php endif; ?>
                            <h3 class="text-2xl font-bold mb-4"><?= htmlspecialchars($tariff['title']) ?></h3>
                            <div class="text-4xl font-bold text-highlight mb-6">
                                <?= number_format($tariff['price'], 0, '', ' ') ?> ₽
                                <span class="text-lg text-gray-400">/<?= $tariff['period'] ?></span>
                            </div>
                            <ul class="space-y-3 mb-8">
                                <?php
                                $features = json_decode($tariff['features'], true) ?? [];
                                foreach ($features as $feature): ?>
                                    <li class="flex items-center justify-center">
                                        <i class="fas fa-check text-highlight mr-3"></i>
                                        <?= htmlspecialchars($feature) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <button onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})"
                                    class="w-full <?= $tariff['is_popular'] ? 'bg-highlight text-primary hover:bg-transparent hover:text-highlight' : 'bg-gray-700 text-light hover:bg-gray-600' ?> font-semibold py-3 rounded-lg transition-colors duration-300 border-2 border-highlight">
                                Выбрать тариф
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-12 text-center">
                    <p class="text-gray-400">* Все цены указаны без учета НДС. Возможна разработка индивидуального тарифа под ваши задачи.</p>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <p class="text-gray-400">Тарифы временно недоступны</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Блок "Требования к видеороликам" -->
<?php if (!empty($requirements['main_requirements']) || !empty($requirements['additional_requirements'])): ?>
    <section class="py-16 bg-primary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4"><?= htmlspecialchars($requirements['title']) ?></h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto"><?= htmlspecialchars($requirements['subtitle']) ?></p>
            </div>

            <div class="bg-white/5 rounded-xl p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php if (!empty($requirements['main_requirements'])): ?>
                        <div>
                            <h3 class="text-2xl font-bold text-highlight mb-6"><?= htmlspecialchars($requirements['main_title']) ?></h3>
                            <ul class="space-y-4">
                                <?php foreach ($requirements['main_requirements'] as $requirement): ?>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-highlight mt-1 mr-3"></i>
                                        <div>
                                            <?= htmlspecialchars($requirement) ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($requirements['additional_requirements'])): ?>
                        <div>
                            <h3 class="text-2xl font-bold text-highlight mb-6"><?= htmlspecialchars($requirements['additional_title']) ?></h3>
                            <ul class="space-y-4">
                                <?php foreach ($requirements['additional_requirements'] as $requirement): ?>
                                    <li class="flex items-start">
                                        <i class="fas fa-lightbulb text-highlight mt-1 mr-3"></i>
                                        <div>
                                            <?= htmlspecialchars($requirement) ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($requirements['info_content'])): ?>
                    <div class="mt-8 p-6 bg-highlight/10 rounded-lg border border-highlight/30">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-highlight text-xl mt-1 mr-4"></i>
                            <div>
                                <h4 class="font-bold text-lg mb-2"><?= htmlspecialchars($requirements['info_title']) ?></h4>
                                <p class="text-gray-300">
                                    <?= htmlspecialchars($requirements['info_content']) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

    <!-- Контактная форма -->
    <section id="contact" class="py-16 bg-secondary px-4">
        <div class="container mx-auto max-w-4xl">
            <div class="contact-form bg-white/5 p-8 rounded-xl">
                <h3 class="text-2xl font-bold text-highlight mb-6">Оставить заявку на LED-рекламу</h3>
                <form action="/led/submit" method="POST">
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
                    <div class="form-group mb-6">
                        <label for="budget" class="block mb-2 font-medium">Примерный бюджет</label>
                        <select id="budget" name="budget" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                            <option value="">Выберите бюджет</option>
                            <option value="low">до 50 000 ₽</option>
                            <option value="medium">50 000 - 150 000 ₽</option>
                            <option value="high">150 000 - 500 000 ₽</option>
                            <option value="premium">свыше 500 000 ₽</option>
                        </select>
                    </div>
                    <div class="form-group mb-6">
                        <label for="message" class="block mb-2 font-medium">О проекте</label>
                        <textarea id="message" name="message" rows="4"
                                  class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                                  placeholder="Расскажите о ваших задачах, желаемых сроках и других деталях..."></textarea>
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