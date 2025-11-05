<?php ob_start(); ?>

<!-- Герой секция -->
<section class="pt-32 pb-20 bg-gradient-to-br from-secondary to-primary px-4">
    <div class="container mx-auto max-w-6xl text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">BTL Мероприятия</h1>
        <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto mb-8">
            Прямой контакт с вашей целевой аудиторией через эффективные промо-акции, дегустации и мероприятия
        </p>
        <a href="#services" class="inline-block bg-highlight text-primary font-semibold py-3 px-8 rounded-full border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline mr-4">
            Наши услуги
        </a>
        <a href="#contact" class="inline-block bg-transparent text-highlight font-semibold py-3 px-8 rounded-full border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline">
            Заказать мероприятие
        </a>
    </div>
</section>

    <!-- Секция услуг -->
    <section class="py-16 px-4 bg-gradient-to-b from-primary to-secondary">
        <div class="container mx-auto max-w-6xl">
            <h2 class="text-3xl lg:text-4xl font-bold text-center text-light mb-12">
                Наши BTL услуги
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

    <!-- Блок "Почему выбирают именно нас?" -->
<?php if (!empty($advantages)): ?>
    <section class="py-16 bg-primary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Почему выбирают именно нас?</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Наши конкурентные преимущества в организации BTL-мероприятий</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($advantages as $advantage): ?>
                    <div class="text-center p-6">
                        <div class="w-20 h-20 bg-highlight/20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <?= $advantage['icon_svg'] ?? '<i class="fas fa-star text-3xl text-highlight"></i>' ?>
                        </div>
                        <h3 class="text-xl font-bold mb-4"><?= htmlspecialchars($advantage['title']) ?></h3>
                        <p class="text-gray-300"><?= htmlspecialchars($advantage['description']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-12 bg-highlight/10 rounded-xl p-8 border border-highlight/30">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-2/3 mb-6 md:mb-0 md:pr-8">
                        <h3 class="text-2xl font-bold mb-4">Готовы обсудить ваше мероприятие?</h3>
                        <p class="text-gray-300">Наши специалисты бесплатно проконсультируют и подготовят индивидуальное предложение для вашего проекта.</p>
                    </div>
                    <div class="md:w-1/3 text-center">
                        <a href="#contact" class="inline-block bg-highlight text-primary font-semibold py-3 px-8 rounded-full border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline">
                            Обсудить проект
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

    <!-- Блок "Наши прошедшие акции" -->
<?php if (!empty($portfolio)): ?>
    <section id="portfolio" class="py-16 bg-secondary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Наши прошедшие акции</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Успешные BTL-проекты, которые мы реализовали для наших клиентов</p>
            </div>

            <div class="portfolio-slider">
                <?php foreach ($portfolio as $item):
                    $tags = json_decode($item['tags'] ?? '[]', true) ?? [];
                    ?>
                    <div class="px-3">
                        <div class="bg-white/5 rounded-xl overflow-hidden h-full border border-highlight/20">
                            <div class="h-80 overflow-hidden">
                                <?php if ($item['image']): ?>
                                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full bg-highlight/20 flex items-center justify-center">
                                        <i class="fas fa-image text-4xl text-highlight/50"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-highlight mb-3"><?= htmlspecialchars($item['title']) ?></h3>
                                <?php if ($item['client_name']): ?>
                                    <p class="text-gray-300 mb-3 text-sm"><?= htmlspecialchars($item['client_name']) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($tags)): ?>
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        <?php foreach ($tags as $tag): ?>
                                            <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-xs"><?= htmlspecialchars($tag) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($item['description']): ?>
                                    <div class="text-highlight font-semibold text-sm">
                                        <i class="fas fa-chart-line mr-2"></i><?= htmlspecialchars($item['description']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <style>
        .portfolio-slider .slick-list {
            margin: 0 -12px;
        }

        .portfolio-slider .slick-slide {
            padding: 0 12px;
        }

        /* Стили для стрелок - БЕЗ АНИМАЦИЙ */
        .portfolio-slider .slick-prev,
        .portfolio-slider .slick-next {
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
        .portfolio-slider .slick-prev:hover,
        .portfolio-slider .slick-next:hover {
            background: rgba(0, 183, 194, 0.9) !important; /* Оставляем тот же цвет */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important; /* Оставляем ту же тень */
        }

        .portfolio-slider .slick-prev {
            left: -60px;
        }

        .portfolio-slider .slick-next {
            right: -60px;
        }

        .portfolio-slider .slick-prev:before,
        .portfolio-slider .slick-next:before {
            content: '' !important; /* Убираем стандартные стрелки */
        }

        .portfolio-slider .slick-prev:after {
            content: '‹';
            font-size: 24px;
            color: #0a0a1a;
            font-weight: bold;
            line-height: 1;
        }

        .portfolio-slider .slick-next:after {
            content: '›';
            font-size: 24px;
            color: #0a0a1a;
            font-weight: bold;
            line-height: 1;
        }

        /* Стили для точек */
        .portfolio-slider .slick-dots {
            bottom: -50px;
        }

        .portfolio-slider .slick-dots li {
            margin: 0 4px;
        }

        .portfolio-slider .slick-dots li button:before {
            font-size: 10px;
            color: #00b7c2;
            opacity: 0.3;
        }

        .portfolio-slider .slick-dots li.slick-active button:before {
            opacity: 1;
            color: #00b7c2;
        }

        .portfolio-slider .slick-dots li button:hover:before {
            opacity: 0.7;
        }

        /* Адаптивность */
        @media (max-width: 1280px) {
            .portfolio-slider .slick-prev {
                left: -40px;
            }

            .portfolio-slider .slick-next {
                right: -40px;
            }
        }

        @media (max-width: 1024px) {
            .portfolio-slider .slick-prev {
                left: -30px;
            }

            .portfolio-slider .slick-next {
                right: -30px;
            }

            .portfolio-slider .slick-prev,
            .portfolio-slider .slick-next {
                width: 40px;
                height: 40px;
            }
        }

        @media (max-width: 768px) {
            .portfolio-slider .slick-prev {
                left: -20px;
            }

            .portfolio-slider .slick-next {
                right: -20px;
            }

            .portfolio-slider .slick-prev,
            .portfolio-slider .slick-next {
                width: 36px;
                height: 36px;
            }

            .portfolio-slider .slick-prev:after,
            .portfolio-slider .slick-next:after {
                font-size: 20px;
            }
        }

        /* Убираем все лишние анимации */
        .portfolio-slider .slick-slide {
            transition: none;
        }

        .portfolio-slider .slick-slide:hover {
            transform: none;
        }

        .portfolio-slider img {
            transition: none;
        }

        .portfolio-slider img:hover {
            transform: none;
        }

    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.portfolio-slider').slick({
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
            $('.portfolio-slider .slick-prev, .portfolio-slider .slick-next').on('mouseenter mouseleave', function(e) {
                e.stopPropagation();
                return false;
            });
        });
    </script>
<?php endif; ?>
<!-- Контактная форма -->
<section id="contact" class="py-16 bg-primary px-4">
    <div class="container mx-auto max-w-4xl">
        <div class="contact-form bg-white/5 p-8 rounded-xl">
            <h3 class="text-2xl font-bold text-highlight mb-6">Заказать BTL мероприятие</h3>
            <form action="/btl/submit" method="POST">
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
                    <label for="event_type" class="block mb-2 font-medium">Тип мероприятия</label>
                    <select id="event_type" name="event_type" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                        <option value="">Выберите тип</option>
                        <option value="leaflets">Раздача листовок</option>
                        <option value="tasting">Дегустация</option>
                        <option value="promo">Промо-акция</option>
                        <option value="concert">Концерт/Мероприятие</option>
                    </select>
                </div>
                <div class="form-group mb-6">
                    <label for="participants" class="block mb-2 font-medium">Ориентировочное количество участников</label>
                    <input type="number" id="participants" name="participants" 
                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                           placeholder="Например: 1000">
                </div>
                <div class="form-group mb-6">
                    <label for="message" class="block mb-2 font-medium">О мероприятии</label>
                    <textarea id="message" name="message" rows="4" 
                              class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                              placeholder="Расскажите о вашем мероприятии, целях, целевой аудитории..."></textarea>
                </div>
                <button type="submit" class="w-full bg-highlight text-primary font-semibold py-3 px-6 rounded-lg transition-all duration-300 hover:bg-transparent hover:text-highlight border-2 border-highlight">
                    Заказать мероприятие
                </button>
            </form>
        </div>
    </div>
</section>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>