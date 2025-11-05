<?php
// app/views/components/header_trislav_group.php
?>
<header class="fixed top-0 left-0 w-full py-4 px-4 lg:px-20 bg-primary/90 backdrop-blur-lg z-50 transition-all duration-300">
    <div class="container mx-auto flex justify-between items-center">
        <a href="/" class="flex items-center space-x-3 text-xl lg:text-2xl font-bold text-light no-underline">
            <div class="w-32 from-accent to-highlight rounded-lg flex items-center justify-center">
                <img src="/images/tg_2.png" />
            </div>
        </a>

        <nav class="hidden lg:flex space-x-8">
            <?php if (isset($projects) && !empty($projects)): ?>
                <?php foreach ($projects as $project): ?>
                    <?php if ($project['is_active'] && $project['project_url']): ?>
                        <a href="<?= htmlspecialchars($project['project_url']) ?>" target="_blank"
                           class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">
                            <?= htmlspecialchars($project['title']) ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <a href="#clients" class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">
                Клиенты
            </a>
            <a href="#reviews" class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">
                Отзывы
            </a>
            <a href="/privacy-policy" class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">
                Политика конфиденциальности
            </a>
        </nav>

        <button id="menuToggle" class="lg:hidden text-2xl text-light focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Мобильное меню -->
    <div id="mobileMenu" class="lg:hidden absolute top-full left-0 w-full bg-primary shadow-lg transform -translate-y-2 opacity-0 invisible transition-all duration-300 mobile-menu">
        <div class="flex flex-col space-y-4 p-6">
            <?php if (isset($projects) && !empty($projects)): ?>
                <?php foreach ($projects as $project): ?>
                    <?php if ($project['is_active'] && $project['project_url']): ?>
                        <a href="<?= htmlspecialchars($project['project_url']) ?>" target="_blank"
                           class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">
                            <?= htmlspecialchars($project['title']) ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <a href="#clients" class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">
                Клиенты
            </a>
            <a href="#reviews" class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">
                Отзывы
            </a>
            <a href="/privacy-policy" class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">
                Политика конфиденциальности
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

    document.querySelectorAll('#mobileMenu a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            mobileMenu.classList.add('opacity-0', 'invisible', '-translate-y-2');
            menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
            menuOpen = false;
        });
    });
</script>