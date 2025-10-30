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

<!-- Наши BTL услуги -->
<section id="services" class="py-16 bg-secondary px-4">
    <div class="container mx-auto max-w-6xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Наши BTL услуги</h2>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">Комплексные решения для прямого взаимодействия с потребителями</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Раздача листовок -->
            <div class="service-card bg-white/5 rounded-xl p-8 transition-all duration-300 hover:shadow-2xl">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-highlight/20 rounded-full flex items-center justify-center mr-6">
                        <i class="fas fa-newspaper text-2xl text-highlight"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-highlight mb-2">Раздача листовок и флаеров</h3>
                        <p class="text-gray-300">Эффективное распространение промо-материалов в местах с высокой проходимостью</p>
                    </div>
                </div>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-center">
                        <i class="fas fa-check text-highlight mr-3"></i>
                        Таргетированная раздача по целевой аудитории
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-highlight mr-3"></i>
                        Профессиональные промо-персоналы
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-highlight mr-3"></i>
                        Стратегический выбор локаций
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-highlight mr-3"></i>
                        Подробная отчетность и аналитика
                    </li>
                </ul>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm">Торговые центры</span>
                    <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm">Метро</span>
                    <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm">Улицы города</span>
                </div>
            </div>
            
            <!-- Дегустации и промо-стойки -->
            <div class="service-card bg-white/5 rounded-xl p-8 transition-all duration-300 hover:shadow-2xl">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-highlight/20 rounded-full flex items-center justify-center mr-6">
                        <i class="fas fa-wine-glass-alt text-2xl text-highlight"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-highlight mb-2">Дегустации и промо-стойки</h3>
                        <p class="text-gray-300">Прямое знакомство потребителей с вашим продуктом через профессиональные дегустации</p>
                    </div>
                </div>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-center">
                        <i class="fas fa-check text-highlight mr-3"></i>
                        Организация промо-стоек в ТЦ и супермаркетах
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-highlight mr-3"></i>
                        Профессиональные дегустаторы и консультанты
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-highlight mr-3"></i>
                        Привлекательный дизайн промо-зон
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-highlight mr-3"></i>
                        Сбор контактных данных и обратной связи
                    </li>
                </ul>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm">Продуктовые ритейлеры</span>
                    <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm">Торговые центры</span>
                    <span class="bg-highlight/20 text-highlight px-3 py-1 rounded-full text-sm">Фестивали</span>
                </div>
            </div>
        </div>
    </div>
</section>

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