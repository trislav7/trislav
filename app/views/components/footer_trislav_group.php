<?php
// app/views/components/footer_trislav_group.php
?>
<footer class="bg-[#0d0d1a] py-12 lg:py-16 px-4">
    <div class="container mx-auto max-w-6xl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12 mb-8">
            <div class="footer-column">
                <h3 class="text-xl font-bold text-highlight mb-6"><img src="/images/tg_2.png" /></h3>
                <p class="text-gray-400 mb-6 leading-relaxed">
                    Комплексные решения для развития бизнеса через инновационные подходы и креативные стратегии.
                </p>
                <div class="social-links flex space-x-4">
                    <?php if (isset($settings['vk_url'])): ?>
                        <a href="<?= htmlspecialchars($settings['vk_url']) ?>" target="_blank" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-light transition-all duration-300 hover:bg-highlight hover:-translate-y-1">
                            <i class="fab fa-vk"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="footer-column">
                <h3 class="text-xl font-bold text-highlight mb-6">Наши проекты</h3>
                <ul class="space-y-3">
                    <?php if (isset($projects) && !empty($projects)): ?>
                        <?php foreach ($projects as $project): ?>
                            <?php if ($project['is_active'] && $project['project_url']): ?>
                                <li>
                                    <a href="<?= htmlspecialchars($project['project_url']) ?>" target="_blank" class="text-gray-400 no-underline transition-colors duration-300 hover:text-highlight">
                                        <?= htmlspecialchars($project['title']) ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="footer-column">
                <h3 class="text-xl font-bold text-highlight mb-6">Услуги</h3>
                <ul class="space-y-3">
                    <?php if (isset($services) && !empty($services)): ?>
                        <?php foreach ($services as $service): ?>
                            <?php if ($service['is_active']): ?>
                                <li><a href="/<?= $service['category'] ?>" class="text-gray-400 no-underline transition-colors duration-300 hover:text-highlight"><?= htmlspecialchars($service['title']) ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="footer-column">
                <h3 class="text-xl font-bold text-highlight mb-6">Контакты</h3>
                <div class="space-y-3">
                    <?php if (isset($settings['phone'])): ?>
                        <p class="flex items-center text-gray-400">
                            <i class="fas fa-phone text-highlight mr-3"></i>
                            <?= htmlspecialchars($settings['phone']) ?>
                        </p>
                    <?php endif; ?>
                    <?php if (isset($settings['address'])): ?>
                        <p class="flex items-center text-gray-400">
                            <i class="fas fa-map-marker-alt text-highlight mr-3"></i>
                            <?= htmlspecialchars($settings['address']) ?>
                        </p>
                    <?php endif; ?>
                    <?php if (isset($settings['vk_url'])): ?>
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
            <p class="text-gray-500">&copy; <?= date('Y') ?> Трислав Групп. Все права защищены.</p>
        </div>
    </div>
</footer>