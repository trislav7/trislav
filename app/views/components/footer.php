<footer class="bg-[#0d0d1a] py-12 lg:py-16 px-4">
    <div class="container mx-auto max-w-6xl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12 mb-8">
            <div class="footer-column">
                <h3 class="w-40 mb-6"><img src="/images/tm_.png" /></h3>
                <p class="text-gray-400 mb-6 leading-relaxed">
                    Мы создаем точечную рекламу, которая доходит до потребителя.
                </p>
            </div>
            <div class="footer-column">

            </div>
            <div class="footer-column">
                <h3 class="text-xl font-bold text-highlight mb-6">Направления</h3>
                <ul class="space-y-3">
                    <li><a href="/led" class="text-gray-400 no-underline transition-colors duration-300 hover:text-highlight">LED экраны в ТЦ</a></li>
                    <li><a href="/btl" class="text-gray-400 no-underline transition-colors duration-300 hover:text-highlight">BTL мероприятия</a></li>
                    <li><a href="/video" class="text-gray-400 no-underline transition-colors duration-300 hover:text-highlight">Видеоролики и логотипы</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3 class="text-xl font-bold text-highlight mb-6">Контакты</h3>
                <div class="space-y-3">
                    <?php if (!empty($settings['phone'])): ?>
                        <p class="flex items-center text-gray-400">
                            <i class="fas fa-phone text-highlight mr-3"></i>
                            <?= htmlspecialchars($settings['phone']) ?>
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($settings['address'])): ?>
                        <p class="flex items-center text-gray-400">
                            <i class="fas fa-map-marker-alt text-highlight mr-3"></i>
                            <?= htmlspecialchars($settings['address']) ?>
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($settings['email'])): ?>
                        <p class="flex items-center text-gray-400">
                            <i class="fas fa-envelope text-highlight mr-3"></i>
                            <?= htmlspecialchars($settings['email']) ?>
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($settings['telegram'])): ?>
                        <p class="flex items-center text-gray-400">
                            <i class="fab fa-telegram text-highlight mr-3"></i>
                            <a href="https://t.me/<?= htmlspecialchars(ltrim($settings['telegram'], '@')) ?>" target="_blank" class="text-gray-400 no-underline hover:text-highlight">
                                <?= htmlspecialchars($settings['telegram']) ?>
                            </a>
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($settings['vk_url'])): ?>
                        <p class="flex items-center text-gray-400">
                            <i class="fab fa-vk text-highlight mr-3"></i>
                            <a href="<?= htmlspecialchars($settings['vk_url']) ?>" target="_blank" class="text-gray-400 no-underline hover:text-highlight">
                                Мы ВКонтакте
                            </a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="copyright text-center pt-8 border-t border-gray-800">
            <p class="text-gray-500">&copy; 2024 Трислав Медиа. Все права защищены.</p>
        </div>
    </div>
</footer>