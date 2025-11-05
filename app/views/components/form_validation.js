// app/views/components/form_validation.js
document.addEventListener('DOMContentLoaded', function() {
    // Валидация форм с согласием
    const forms = document.querySelectorAll('form[data-require-privacy]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const privacyCheckbox = form.querySelector('input[name="privacy_agreement"]');
            
            if (!privacyCheckbox?.checked) {
                e.preventDefault();
                
                // Показываем сообщение об ошибке
                let errorMsg = form.querySelector('.privacy-error');
                if (!errorMsg) {
                    errorMsg = document.createElement('div');
                    errorMsg.className = 'privacy-error mt-2 p-2 bg-red-500/20 border border-red-500 text-red-300 rounded text-sm';
                    errorMsg.textContent = 'Необходимо согласие с политикой конфиденциальности';
                    privacyCheckbox.parentNode.appendChild(errorMsg);
                }
                
                // Подсвечиваем чекбокс
                privacyCheckbox.classList.add('border-red-500');
                
                // Прокручиваем к чекбоксу
                privacyCheckbox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
        
        // Убираем ошибку при изменении чекбокса
        const privacyCheckbox = form.querySelector('input[name="privacy_agreement"]');
        privacyCheckbox?.addEventListener('change', function() {
            if (this.checked) {
                this.classList.remove('border-red-500');
                const errorMsg = form.querySelector('.privacy-error');
                if (errorMsg) errorMsg.remove();
            }
        });
    });
});