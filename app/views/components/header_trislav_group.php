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
                        <a href="<?= htmlspecialchars($project['project_url']) ?>"
                           class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">
                            <?= htmlspecialchars($project['title']) ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <!-- Новый пункт "Контакты" -->
            <a href="#footerContacts"
               class="nav-link text-light font-medium no-underline relative transition-colors duration-300 hover:text-highlight">
                Контакты
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
                        <a href="<?= htmlspecialchars($project['project_url']) ?>"
                           class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">
                            <?= htmlspecialchars($project['title']) ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <!-- Новый пункт "Контакты" в мобильном меню -->
            <a href="#footerContacts"
               class="text-light font-medium no-underline py-2 transition-colors duration-300 hover:text-highlight border-b border-gray-700">
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

    document.querySelectorAll('#mobileMenu a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            mobileMenu.classList.add('opacity-0', 'invisible', '-translate-y-2');
            menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
            menuOpen = false;
        });
    });

    // Плавный скролл для ссылок с якорями
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                // Учитываем высоту фиксированной шапки
                const headerHeight = document.querySelector('header')?.offsetHeight || 80;
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
</script>