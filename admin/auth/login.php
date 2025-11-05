<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Вход в админку</h1>
    
    <?php if (isset($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= $error ?>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                Логин
            </label>
            <input type="text" id="username" name="username" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Пароль
            </label>
            <input type="password" id="password" name="password" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
        </div>
        
        <button type="submit" 
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
            Войти
        </button>
    </form>
    
    <div class="mt-4 text-center text-sm text-gray-600">
        <p>Демо доступ:</p>
        <p>Логин: <strong>admin</strong></p>
        <p>Пароль: <strong>admin123</strong></p>
    </div>
</div>