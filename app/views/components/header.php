<header class="fixed top-0 left-0 w-full py-5 px-4 lg:px-20 bg-primary/90 backdrop-blur-lg z-50 transition-all duration-300">
    <div class="container mx-auto flex justify-between items-center">
        <a href="/" class="flex items-center space-x-3 text-xl lg:text-2xl font-bold text-light no-underline">
            <div class="w-10 h-10 bg-gradient-to-br from-accent to-highlight rounded-lg flex items-center justify-center">
                <div class="flex space-x-1">
                    <div class="w-2 h-2 bg-white rounded-full opacity-80"></div>
                    <div class="w-2 h-2 bg-white rounded-full opacity-80"></div>
                    <div class="w-2 h-2 bg-white rounded-full opacity-80"></div>
                </div>
            </div>
            <span>ТРИСЛАВ<span class="text-highlight">МЕДИА</span></span>
        </a>

        <nav class="hidden lg:flex space-x-8">
            <a href="/" class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">Главная</a>
            <a href="/led" class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">LED экраны</a>
            <a href="/video" class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">Видео и лого</a>
            <a href="/btl" class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">BTL мероприятия</a>
        </nav>

        <button id="menuToggle" class="lg:hidden text-2xl text-light focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Мобильное меню -->
    <div id="mobileMenu" class="lg:hidden absolute top-full left-0 w-full bg-primary shadow-lg transform -translate-y-2 opacity-0 invisible transition-all duration-300">
        <div class="flex flex-col space-y-4 p-6">
            <a href="/" class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">Главная</a>
            <a href="/led" class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">LED экраны</a>
            <a href="/video" class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">Видео и лого</a>
            <a href="/btl" class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">BTL мероприятия</a>
        </div>
    </div>
</header>