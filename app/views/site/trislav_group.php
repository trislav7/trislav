<?php
// app/views/site/trislav_group.php
ob_start();
?>

    <!-- Первый блок - Логотип и название (уменьшенный) -->
    <section class="pt-24 pb-16 flex items-center justify-center bg-gradient-to-br from-secondary to-primary px-4">
        <div class="container mx-auto max-w-4xl text-center">
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-gradient-to-br from-accent to-highlight rounded-xl flex items-center justify-center">
                    <div class="flex space-x-1">
                        <div class="w-2.5 h-2.5 bg-white rounded-full opacity-80"></div>
                        <div class="w-2.5 h-2.5 bg-white rounded-full opacity-80"></div>
                        <div class="w-2.5 h-2.5 bg-white rounded-full opacity-80"></div>
                    </div>
                </div>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">ТРИСЛАВ ГРУПП</h1>
            <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto">
                Комплексные решения для развития бизнеса через инновационные подходы и креативные стратегии
            </p>
        </div>
    </section>

    <!-- Второй блок - Проекты -->
    <section class="py-16 bg-secondary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Наши проекты</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Успешные бизнес-решения, которые уже доказали свою эффективность</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Проект 1 - Медиа групп -->
                <div id="media" class="project-card bg-white/5 rounded-xl overflow-hidden">
                    <div class="h-40 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Трислав Медиа"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-highlight mb-3">Трислав Медиа</h3>
                        <p class="text-gray-300 mb-4">Полносервисное рекламное агентство, предоставляющее комплексные решения для продвижения брендов. От LED-экранов до BTL-мероприятий и создания промо-материалов.</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm">Реклама</span>
                            <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm">Маркетинг</span>
                            <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm">Брендинг</span>
                        </div>
                    </div>
                </div>

                <!-- Проект 2 - Молодёжная карта -->
                <div id="card" class="project-card bg-white/5 rounded-xl overflow-hidden">
                    <div class="h-40 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1551833996-8c8c43c8d134?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Молодёжная карта"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-highlight mb-3">Молодёжная карта</h3>
                        <p class="text-gray-300 mb-4">Инновационная программа лояльности для студентов и молодых специалистов. Скидки и специальные предложения от партнеров в сфере образования, развлечений и услуг.</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm">Лояльность</span>
                            <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm">Студенты</span>
                            <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm">Партнерства</span>
                        </div>
                    </div>
                </div>

                <!-- Проект 3 - Народная реклама -->
                <div id="ad" class="project-card bg-white/5 rounded-xl overflow-hidden">
                    <div class="h-40 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1551833996-8c8c43c8d134?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Народная реклама"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-highlight mb-3">Народная реклама</h3>
                        <p class="text-gray-300 mb-4">Платформа для локального продвижения малого и среднего бизнеса. Эффективные рекламные решения, доступные даже начинающим предпринимателям с ограниченным бюджетом.</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm">Малый бизнес</span>
                            <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm">Локальная реклама</span>
                            <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm">Доступность</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Третий блок - Нам доверяют -->
    <section class="py-16 bg-primary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Нам доверяют</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Компании, которые уже оценили эффективность наших решений</p>
            </div>

            <!-- Слайдер с логотипами -->
            <div class="slider-container mb-12">
                <div class="slider-track" id="logosSlider">
                    <div class="slider-slide">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 items-center">
                            <div class="bg-white/5 rounded-xl p-6 flex items-center justify-center h-28">
                                <span class="text-xl font-bold text-highlight">TechCorp</span>
                            </div>
                            <div class="bg-white/5 rounded-xl p-6 flex items-center justify-center h-28">
                                <span class="text-xl font-bold text-highlight">GlobalRetail</span>
                            </div>
                            <div class="bg-white/5 rounded-xl p-6 flex items-center justify-center h-28">
                                <span class="text-xl font-bold text-highlight">FinSecure</span>
                            </div>
                            <div class="bg-white/5 rounded-xl p-6 flex items-center justify-center h-28">
                                <span class="text-xl font-bold text-highlight">EcoLife</span>
                            </div>
                        </div>
                    </div>
                    <div class="slider-slide">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 items-center">
                            <div class="bg-white/5 rounded-xl p-6 flex items-center justify-center h-28">
                                <span class="text-xl font-bold text-highlight">AutoDrive</span>
                            </div>
                            <div class="bg-white/5 rounded-xl p-6 flex items-center justify-center h-28">
                                <span class="text-xl font-bold text-highlight">BuildMaster</span>
                            </div>
                            <div class="bg-white/5 rounded-xl p-6 flex items-center justify-center h-28">
                                <span class="text-xl font-bold text-highlight">FoodExpress</span>
                            </div>
                            <div class="bg-white/5 rounded-xl p-6 flex items-center justify-center h-28">
                                <span class="text-xl font-bold text-highlight">HealthPlus</span>
                            </div>
                        </div>
                    </div>
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

            <!-- Отзывы -->
            <div class="slider-container">
                <div class="slider-track" id="reviewsSlider">
                    <!-- Отзыв 1 -->
                    <div class="slider-slide">
                        <div class="bg-white/5 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-xl font-bold text-highlight">Т</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold">Александр Иванов</h4>
                                    <p class="text-gray-400">Генеральный директор TechCorp</p>
                                </div>
                            </div>
                            <p class="text-gray-300 italic">
                                "Сотрудничество с Трислав Групп позволило нам увеличить узнаваемость бренда на 45% за полгода.
                                Их креативный подход и глубокое понимание рынка помогли вывести наш продукт на новый уровень."
                            </p>
                        </div>
                    </div>

                    <!-- Отзыв 2 -->
                    <div class="slider-slide">
                        <div class="bg-white/5 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-xl font-bold text-highlight">Е</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold">Елена Смирнова</h4>
                                    <p class="text-gray-400">Маркетинг-директор GlobalRetail</p>
                                </div>
                            </div>
                            <p class="text-gray-300 italic">
                                "Благодаря решениям от Трислав Групп мы смогли оптимизировать рекламный бюджет и увеличить
                                конверсию на 30%. Их команда всегда предлагает нестандартные и эффективные подходы."
                            </p>
                        </div>
                    </div>

                    <!-- Отзыв 3 -->
                    <div class="slider-slide">
                        <div class="bg-white/5 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-xl font-bold text-highlight">Д</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold">Дмитрий Петров</h4>
                                    <p class="text-gray-400">Владелец сети кофеен "CoffeeTime"</p>
                                </div>
                            </div>
                            <p class="text-gray-300 italic">
                                "Как малый бизнес, мы ценим индивидуальный подход и доступные решения. Трислав Групп помогли
                                нам создать эффективную рекламную кампанию, которая привлекла новых клиентов без больших затрат."
                            </p>
                        </div>
                    </div>
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
        </div>
    </section>

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

    <!-- Пятый блок - Преимущества -->
    <section class="py-16 bg-primary px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="advantage-card text-center p-6 bg-white/5 rounded-xl">
                    <div class="w-16 h-16 bg-highlight/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-highlight" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 1V23" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M17 5H9.5C8.57174 5 7.6815 5.36875 7.02513 6.02513C6.36875 6.6815 6 7.57174 6 8.5C6 9.42826 6.36875 10.3185 7.02513 10.9749C7.6815 11.6313 8.57174 12 9.5 12H14.5C15.4283 12 16.3185 12.3687 16.9749 13.0251C17.6313 13.6815 18 14.5717 18 15.5C18 16.4283 17.6313 17.3185 16.9749 17.9749C16.3185 18.6313 15.4283 19 14.5 19H6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-3">Помогаем увеличить Вашу прибыль</h3>
                    <p class="text-gray-300 text-sm">Эффективные маркетинговые стратегии, которые напрямую влияют на ваш доход</p>
                </div>

                <div class="advantage-card text-center p-6 bg-white/5 rounded-xl">
                    <div class="w-16 h-16 bg-highlight/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-highlight" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M17 3.13C17.8604 3.35031 18.623 3.85071 19.1676 4.55232C19.7122 5.25392 20.0078 6.11683 20.0078 7.005C20.0078 7.89318 19.7122 8.75608 19.1676 9.45769C18.623 10.1593 17.8604 10.6597 17 10.88" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-3">Помогаем собрать базу новых клиентов для Вас</h3>
                    <p class="text-gray-300 text-sm">Целевые маркетинговые кампании, которые привлекают именно вашу аудиторию</p>
                </div>

                <div class="advantage-card text-center p-6 bg-white/5 rounded-xl">
                    <div class="w-16 h-16 bg-highlight/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-highlight" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M7 3H8C8.79565 3 9.55871 3.31607 10.1213 3.87868C10.6839 4.44129 11 5.20435 11 6V18C11 18.7957 10.6839 19.5587 10.1213 20.1213C9.55871 20.6839 8.79565 21 8 21H7" stroke="currentColor" stroke-width="2"/>
                            <path d="M17 3H16C15.2044 3 14.4413 3.31607 13.8787 3.87868C13.3161 4.44129 13 5.20435 13 6V18C13 18.7957 13.3161 19.5587 13.8787 20.1213C14.4413 20.6839 15.2044 21 16 21H17" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-3">Помогаем малому и среднему бизнесу</h3>
                    <p class="text-gray-300 text-sm">Доступные решения, разработанные специально для предпринимателей</p>
                </div>

                <div class="advantage-card text-center p-6 bg-white/5 rounded-xl">
                    <div class="w-16 h-16 bg-highlight/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-highlight" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 16V8.00002C20.9996 7.6493 20.9071 7.30483 20.7315 7.00119C20.556 6.69754 20.3037 6.44539 20 6.27002L13 2.27002C12.696 2.09449 12.3511 2.00208 12 2.00208C11.6489 2.00208 11.304 2.09449 11 2.27002L4 6.27002C3.69626 6.44539 3.44398 6.69754 3.26846 7.00119C3.09294 7.30483 3.00036 7.6493 3 8.00002V16C3.00036 16.3508 3.09294 16.6952 3.26846 16.9989C3.44398 17.3025 3.69626 17.5547 4 17.73L11 21.73C11.304 21.9056 11.6489 21.998 12 21.998C12.3511 21.998 12.696 21.9056 13 21.73L20 17.73C20.3037 17.5547 20.556 17.3025 20.7315 16.9989C20.9071 16.6952 20.9996 16.3508 21 16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3.27002 6.96002L12 12L20.73 6.96002" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 22.08V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 13L15 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-3">Индивидуальные предложения для каждого клиента</h3>
                    <p class="text-gray-300 text-sm">Уникальные стратегии, разработанные с учетом особенностей вашего бизнеса</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Шестой блок - Форма обратной связи -->
    <section id="contact" class="py-16 bg-secondary px-4">
        <div class="container mx-auto max-w-4xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Свяжитесь с нами</h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">Готовы обсудить развитие вашего бизнеса? Оставьте заявку!</p>
            </div>

            <div class="bg-white/5 rounded-xl p-6 md:p-8">
                <form id="contactForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="form-group">
                            <label for="name" class="block mb-2 font-medium">ФИО *</label>
                            <input type="text" id="name" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                        </div>
                        <div class="form-group">
                            <label for="company" class="block mb-2 font-medium">Название компании</label>
                            <input type="text" id="company"
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="form-group">
                            <label for="phone" class="block mb-2 font-medium">Телефон *</label>
                            <input type="tel" id="phone" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                        </div>
                        <div class="form-group">
                            <label for="email" class="block mb-2 font-medium">Email *</label>
                            <input type="email" id="email" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight">
                        </div>
                    </div>
                    <div class="form-group mb-6">
                        <label for="message" class="block mb-2 font-medium">Сообщение</label>
                        <textarea id="message" rows="4"
                                  class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-light transition-colors duration-300 focus:outline-none focus:border-highlight"
                                  placeholder="Расскажите о вашем бизнесе и задачах..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-highlight text-primary font-semibold py-3 px-6 rounded-lg transition-all duration-300 hover:bg-transparent hover:text-highlight border-2 border-highlight">
                        Отправить заявку
                    </button>
                </form>
            </div>
        </div>
    </section>

    <script>
        // Инициализация слайдеров
        function initSlider(sliderTrackId, prevBtnId, nextBtnId, indicatorsId) {
            const sliderTrack = document.getElementById(sliderTrackId);
            const sliderPrev = document.getElementById(prevBtnId);
            const sliderNext = document.getElementById(nextBtnId);
            const sliderIndicators = document.getElementById(indicatorsId);

            const slides = document.querySelectorAll(`#${sliderTrackId} .slider-slide`);
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

            // Обработка формы
            document.getElementById('contactForm').addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Спасибо за вашу заявку! Мы свяжемся с вами в ближайшее время для обсуждения сотрудничества.');
                this.reset();
            });
        });
    </script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>