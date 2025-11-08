<?php
// Проверяем, было ли уже принято согласие
$cookieAccepted = isset($_COOKIE['cookie_consent']) && $_COOKIE['cookie_consent'] === 'accepted';
?>

<?php if (!$cookieAccepted): ?>
    <div id="cookieNotice" class="fixed bottom-0 left-0 right-0 z-50 transform translate-y-full transition-transform duration-500 ease-in-out">
        <div class="max-w-7xl mx-auto p-4">
            <div class="bg-gradient-to-r from-primary to-secondary border-2 border-highlight/50 rounded-2xl shadow-2xl p-6 backdrop-blur-lg">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                    <!-- Текст уведомления -->
                    <div class="flex-1">
                        <div class="flex items-start space-x-4">
                            <!-- Иконка -->
                            <div class="flex-shrink-0 w-12 h-12 bg-highlight/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-cookie-bite text-highlight text-xl"></i>
                            </div>

                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-light mb-2">
                                    Мы используем файлы cookie
                                </h3>
                                <p class="text-gray-300 text-sm leading-relaxed">
                                    Этот сайт использует файлы cookie для улучшения работы и анализа трафика.
                                    Продолжая использовать сайт, вы соглашаетесь с нашей
                                    <a href="/privacy-policy" class="text-highlight hover:underline transition-colors duration-300">Политикой конфиденциальности</a>.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Кнопки действий -->
                    <div class="flex flex-col sm:flex-row gap-3 lg:gap-2 lg:flex-nowrap">
                        <!-- Кнопка "Принять" -->
                        <button onclick="acceptCookies()"
                                class="bg-highlight text-primary font-semibold px-6 py-3 rounded-lg border-2 border-highlight hover:bg-transparent hover:text-highlight transition-all duration-300 transform hover:scale-105 active:scale-95 whitespace-nowrap flex items-center justify-center">
                            <i class="fas fa-check mr-2"></i>Принять
                        </button>

                        <!-- Кнопка "Отклонить" -->
                        <button onclick="rejectCookies()"
                                class="bg-transparent text-gray-400 font-semibold px-6 py-3 rounded-lg border-2 border-gray-700 hover:border-red-500 hover:text-red-400 transition-all duration-300 transform hover:scale-105 active:scale-95 whitespace-nowrap flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>Отклонить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Анимации для cookie уведомления */
        #cookieNotice.show {
            transform: translateY(0);
        }

        /* Кастомные стили для кнопок */
        .cookie-btn {
            min-width: 120px;
        }
    </style>

    <script>
        // Показываем уведомление при загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const cookieNotice = document.getElementById('cookieNotice');
                if (cookieNotice) {
                    cookieNotice.classList.add('show');
                }
            }, 1000);
        });

        // Функции для работы с cookies
        function setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            const expires = "expires=" + date.toUTCString();
            document.cookie = name + "=" + value + ";" + expires + ";path=/;SameSite=Lax";
        }

        function getCookie(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(';');
            for(let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        // Основные функции
        function acceptCookies() {
            setCookie('cookie_consent', 'accepted', 365);
            hideCookieNotice();

            // Инициализация аналитики после принятия
            initializeAnalytics();

            // Показываем подтверждение
            showAcceptanceMessage();
        }

        function rejectCookies() {
            setCookie('cookie_consent', 'rejected', 30);
            hideCookieNotice();

            // Показываем сообщение об отклонении
            showRejectionMessage();
        }

        function hideCookieNotice() {
            const notice = document.getElementById('cookieNotice');
            notice.classList.remove('show');
            setTimeout(() => {
                notice.style.display = 'none';
            }, 500);
        }

        // Функция для инициализации аналитики
        function initializeAnalytics() {
            // Здесь можно добавить код для Google Analytics, Yandex.Metrica и т.д.
            console.log('Cookies accepted - analytics initialized');

            // Пример для Google Analytics
            // if (typeof gtag !== 'undefined') {
            //     gtag('consent', 'update', {
            //         'analytics_storage': 'granted'
            //     });
            // }
        }

        // Вспомогательные функции для сообщений
        function showAcceptanceMessage() {
            // Можно добавить временное сообщение об успешном принятии
            console.log('Cookies accepted');
        }

        function showRejectionMessage() {
            // Можно добавить временное сообщение об отклонении
            console.log('Cookies rejected');
        }

        // Автоматическое скрытие при клике вне уведомления (опционально)
        document.addEventListener('click', function(e) {
            const cookieNotice = document.getElementById('cookieNotice');
            if (cookieNotice && !cookieNotice.contains(e.target) && cookieNotice.classList.contains('show')) {
                // Автоматически принимаем при клике вне уведомления
                acceptCookies();
            }
        });
    </script>
<?php endif; ?>