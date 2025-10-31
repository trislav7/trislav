<?php
http_response_code(404);
ob_start();
?>

<div class="min-h-screen bg-primary flex items-center justify-center px-4">
    <div class="text-center">
        <div class="mb-8">
            <div class="text-9xl font-bold text-highlight mb-4">404</div>
            <h1 class="text-3xl font-bold text-light mb-4">Страница не найдена</h1>
            <p class="text-gray-300 mb-8 max-w-md mx-auto">
                Запрашиваемая страница в админ-панели не существует или была перемещена.
            </p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/admin.php" class="bg-highlight text-primary font-semibold py-3 px-6 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight no-underline">
                <i class="fas fa-tachometer-alt mr-2"></i>В дашборд
            </a>
            <a href="/admin.php?action=services_list" class="bg-transparent text-highlight font-semibold py-3 px-6 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-highlight hover:text-primary no-underline">
                <i class="fas fa-cog mr-2"></i>К услугам
            </a>
            <button onclick="history.back()" class="bg-transparent text-gray-300 font-semibold py-3 px-6 rounded-lg border-2 border-gray-500 transition-all duration-300 hover:bg-gray-500 hover:text-light">
                <i class="fas fa-arrow-left mr-2"></i>Назад
            </button>
        </div>
        
        <div class="mt-12 text-gray-500">
            <p class="text-sm">Админ-панель Трислав Медиа • Ошибка 404</p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>
