<div class="space-y-6">
    <!-- Категории новостей -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Категории новостей</h3>
        <ul class="space-y-2">
            <?php if (!empty($sidebar['newsCategories'])): ?>
                <?php foreach ($sidebar['newsCategories'] as $category): ?>
                <li>
                    <a href="/news/category/<?= $category['id'] ?>"
                       class="text-gray-600 hover:text-blue-600 flex items-center py-2 px-3 rounded hover:bg-blue-50 transition-colors">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-3"></span>
                        <?= htmlspecialchars($category['name']) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="text-gray-500 text-sm py-2">Категории пока не добавлены</li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Категории акций -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Категории акций</h3>
        <ul class="space-y-2">
            <?php if (!empty($sidebar['actionCategories'])): ?>
                <?php foreach ($sidebar['actionCategories'] as $category): ?>
                <li>
                    <a href="/actions/category/<?= $category['id'] ?>"
                       class="text-gray-600 hover:text-yellow-600 flex items-center py-2 px-3 rounded hover:bg-yellow-50 transition-colors">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></span>
                        <?= htmlspecialchars($category['name']) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="text-gray-500 text-sm py-2">Категории пока не добавлены</li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Рекламный блок -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-center text-white">
        <h4 class="font-bold text-lg mb-2">Специальное предложение!</h4>
        <p class="text-blue-100 text-sm mb-4">Получите скидку 15% на первую рекламную кампанию</p>
        <button class="bg-white text-blue-600 px-6 py-2 rounded-lg hover:bg-blue-50 font-medium transition-colors">
            Получить скидку
        </button>
    </div>

    <!-- Контакты -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Контакты</h3>
        <div class="space-y-3 text-sm">
            <p class="flex items-center text-gray-600">
                📞 +7 (999) 123-45-67
            </p>
            <p class="flex items-center text-gray-600">
                ✉️ info@agency.ru
            </p>
            <p class="flex items-center text-gray-600">
                📍 г. Москва, ул. Примерная, 123
            </p>
        </div>
    </div>
</div>