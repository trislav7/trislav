<?php
// app/views/components/header_trislav_group.php
?>
<header class="fixed top-0 left-0 w-full py-4 px-4 lg:px-20 bg-primary/90 backdrop-blur-lg z-50 transition-all duration-300">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Название фирмы слева -->
        <a href="/" class="flex items-center space-x-3 text-xl lg:text-2xl font-bold text-light no-underline">
            <div class="w-8 h-8 bg-gradient-to-br from-accent to-highlight rounded-lg flex items-center justify-center">
                <div class="flex space-x-1">
                    <div class="w-1.5 h-1.5 bg-white rounded-full opacity-80"></div>
                    <div class="w-1.5 h-1.5 bg-white rounded-full opacity-80"></div>
                    <div class="w-1.5 h-1.5 bg-white rounded-full opacity-80"></div>
                </div>
            </div>
            <span>ТРИСЛАВ<span class="text-highlight">ГРУПП</span></span>
        </a>

        <!-- Навигация для десктопа -->
        <nav class="hidden lg:flex space-x-8">
            <a href="https://медиа.трислав.рф" target="_blank" class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">
                Трислав Медиа
            </a>
            <a href="https://купикон.рф" target="_blank" class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">
                Молодёжная Карта
            </a>
            <a href="https://народнаяреклама.рф" target="_blank" class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">
                Народная реклама
            </a>
            <a href="#contact" class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">
                Контакты
            </a>
        </nav>

        <!-- Кнопка мобильного меню -->
        <button id="menuToggle" class="lg:hidden text-2xl text-light focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Мобильное меню -->
    <div id="mobileMenu" class="lg:hidden absolute top-full left-0 w-full bg-primary shadow-lg transform -translate-y-2 opacity-0 invisible transition-all duration-300 mobile-menu">
        <div class="flex flex-col space-y-4 p-6">
            <a href="https://медиа.трислав.рф" target="_blank" class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">
                Трислав Медиа
            </a>
            <a href="https://купикон.рф" target="_blank" class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">
                Молодёжная Карта
            </a>
            <a href="https://народнаяреклама.рф" target="_blank" class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">
                Народная реклама
            </a>
            <a href="#contact" class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">
                Контакты
            </a>
        </div>
    </div>
</header>

<script>
    // Мобильное меню для Трислав Групп
    const menuToggle = document.getElementById('menuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    let menuOpen = false;

    menuToggle?.addEventListener('click', () => {
        menuOpen = !menuOpen;
        
        if (menuOpen) {
            mobileMenu.classList.remove('opacity-0', 'invisible', '-translate-y-2');
            mobileMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
            menuToggle.innerHTML = '<i class="fas fa-times"></i>';
        } else {
            mobileMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            mobileMenu.classList.add('opacity-0', 'invisible', '-translate-y-2');
            menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
        }
    });

    // Закрытие меню при клике на ссылку
    document.querySelectorAll('#mobileMenu a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            mobileMenu.classList.add('opacity-0', 'invisible', '-translate-y-2');
            menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
            menuOpen = false;
        });
    });
</script>