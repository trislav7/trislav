<?php
// app/views/components/header.php
?>
<header class="fixed top-0 left-0 w-full py-5 px-4 lg:px-20 bg-primary/90 backdrop-blur-lg z-50 transition-all duration-300">
    <div class="container mx-auto flex justify-between items-center">
        <a href="/" class="flex items-center space-x-3 text-xl lg:text-2xl font-bold text-light no-underline">
            <div class="w-32 h-10 from-accent to-highlight rounded-lg flex items-center justify-center">
                <img src="/images/tm_.png" />
            </div>
        </a>

        <nav class="hidden lg:flex space-x-8">
            <a href="https://xn--80aeqmxhe.xn--p1ai/" class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">
                Trislav Group
            </a>
            <!-- Основные направления Трислав Медиа -->
            <a href="/led" class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">
                LED экраны
            </a>
            <a href="/video" class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">
                Видео и лого
            </a>
            <a href="/btl" class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">
                BTL мероприятия
            </a>
        </nav>

        <button id="menuToggle" class="lg:hidden text-2xl text-light focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Мобильное меню -->
    <div id="mobileMenu" class="lg:hidden absolute top-full left-0 w-full bg-primary shadow-lg transform -translate-y-2 opacity-0 invisible transition-all duration-300">
        <div class="flex flex-col space-y-4 p-6">
            <a href="https://xn--80aeqmxhe.xn--p1ai/" class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">
                Trislav Group
            </a>
            <!-- Основные направления Трислав Медиа -->
            <a href="/led" class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">
                LED экраны
            </a>
            <a href="/video" class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">
                Видео и лого
            </a>
            <a href="/btl" class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">
                BTL мероприятия
            </a>
        </div>
    </div>
</header>

<script>
    // Мобильное меню
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