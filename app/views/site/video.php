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
    <section class="py-16 px-4 bg-gradient-to-b from-primary to-secondary">
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
                        <div class="service-card bg-white/5 rounded-xl p-8 transition-all duration-300 hover:shadow-2xl">
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
<section id="portfolio" class="py-16 bg-primary px-4">
    <div class="container mx-auto max-w-6xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Наши работы</h2>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">Примеры созданных нами видеороликов и логотипов</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Работа 1 -->
            <div class="portfolio-item bg-white/5 rounded-xl overflow-hidden transition-all duration-300 hover:transform hover:scale-105">
                <div class="h-48 bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                    <span class="text-white text-xl font-bold text-center px-4">Рекламный ролик "TechGadgets"</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-highlight mb-2">Видео для электроники</h3>
                    <p class="text-gray-300 mb-4">Создание рекламного ролика для запуска новой линейки гаджетов</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-highlight/20 text-highlight px-2 py-1 rounded text-xs">Видео</span>
                        <span class="bg-highlight/20 text-highlight px-2 py-1 rounded text-xs">Моушн-дизайн</span>
                        <span class="bg-highlight/20 text-highlight px-2 py-1 rounded text-xs">4K</span>
                    </div>
                </div>
            </div>
            
            <!-- Работа 2 -->
            <div class="portfolio-item bg-white/5 rounded-xl overflow-hidden transition-all duration-300 hover:transform hover:scale-105">
                <div class="h-48 bg-gradient-to-br from-green-500 to-blue-500 flex items-center justify-center">
                    <span class="text-white text-xl font-bold text-center px-4">Логотип "CoffeeTime"</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-highlight mb-2">Брендинг кофейни</h3>
                    <p class="text-gray-300 mb-4">Разработка логотипа и фирменного стиля для сети кофеен</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-highlight/20 text-highlight px-2 py-1 rounded text-xs">Логотип</span>
                        <span class="bg-highlight/20 text-highlight px-2 py-1 rounded text-xs">Фирменный стиль</span>
                        <span class="bg-highlight/20 text-highlight px-2 py-1 rounded text-xs">Упаковка</span>
                    </div>
                </div>
            </div>
            
            <!-- Работа 3 -->
            <div class="portfolio-item bg-white/5 rounded-xl overflow-hidden transition-all duration-300 hover:transform hover:scale-105">
                <div class="h-48 bg-gradient-to-br from-yellow-500 to-red-500 flex items-center justify-center">
                    <span class="text-white text-xl font-bold text-center px-4">Корпоративное видео "FinCorp"</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-highlight mb-2">Финансовая компания</h3>
                    <p class="text-gray-300 mb-4">Съемка и монтаж корпоративного видео для презентации компании</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-highlight/20 text-highlight px-2 py-1 rounded text-xs">Корпоративное видео</span>
                        <span class="bg-highlight/20 text-highlight px-2 py-1 rounded text-xs">Съемка</span>
                        <span class="bg-highlight/20 text-highlight px-2 py-1 rounded text-xs">Монтаж</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Контактная форма -->
<section id="contact" class="py-16 bg-secondary px-4">
    <div class="container mx-auto max-w-4xl">
        <div class="contact-form bg-white/5 p-8 rounded-xl">
            <h3 class="text-2xl font-bold text-highlight mb-6">Обсудить проект</h3>
            <form action="/video/submit" method="POST">
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
                    <label for="service" class="block mb-2 font-medium">Интересующая услуга</label>
                    <select id="service" name="service" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                        <option value="">Выберите услугу</option>
                        <option value="video">Видеоролики</option>
                        <option value="logo">Логотипы и брендинг</option>
                        <option value="complex">Комплексное решение</option>
                    </select>
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
                              placeholder="Расскажите о вашем проекте, целях, сроках и других деталях..."></textarea>
                </div>
                <button type="submit" class="w-full bg-highlight text-primary font-semibold py-3 px-6 rounded-lg transition-all duration-300 hover:bg-transparent hover:text-highlight border-2 border-highlight">
                    Обсудить проект
                </button>
            </form>
        </div>
    </div>
</section>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>