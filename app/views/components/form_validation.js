// app/views/components/form_validation.js
document.addEventListener('DOMContentLoaded', function() {
    // Маска для телефона - работает для всех полей с name="phone" или type="tel"
    function initPhoneMask() {
        const phoneInputs = document.querySelectorAll('input[name="phone"], input[type="tel"]');

        phoneInputs.forEach(input => {
            let lastValue = '';

            input.addEventListener('input', function(e) {
                // Получаем значение без форматирования
                let value = e.target.value.replace(/\D/g, '');

                // Если значение не изменилось (был удален разделитель) - выходим
                if (value === lastValue.replace(/\D/g, '')) {
                    return;
                }

                // Если поле пустое, устанавливаем базовый формат
                if (value === '') {
                    e.target.value = '+7 (';
                    lastValue = '+7 (';
                    return;
                }

                // Нормализуем номер (оставляем только 11 цифр)
                if (value.startsWith('7') || value.startsWith('8')) {
                    value = value.substring(0, 11);
                } else if (value.startsWith('9')) {
                    value = '7' + value.substring(0, 10);
                } else {
                    value = '7' + value.substring(0, 10);
                }

                // Форматируем номер
                let formattedValue = '+7 (';

                if (value.length > 1) {
                    formattedValue += value.substring(1, 4);
                }
                if (value.length >= 4) {
                    formattedValue += ') ' + value.substring(4, 7);
                }
                if (value.length >= 7) {
                    formattedValue += '-' + value.substring(7, 9);
                }
                if (value.length >= 9) {
                    formattedValue += '-' + value.substring(9, 11);
                }

                // Устанавливаем отформатированное значение
                e.target.value = formattedValue;
                lastValue = formattedValue;

                // Устанавливаем курсор в конец
                const cursorPosition = formattedValue.length;
                e.target.setSelectionRange(cursorPosition, cursorPosition);
            });

            // ПРОСТАЯ обработка Backspace - позволяем браузеру самому обработать
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace') {
                    const value = this.value;
                    const selectionStart = this.selectionStart;
                    const selectionEnd = this.selectionEnd;

                    // Если выделен текст - разрешаем стандартное поведение
                    if (selectionStart !== selectionEnd) {
                        return;
                    }

                    // Если курсор стоит сразу после разделителя - перемещаем его перед разделителем
                    if ((selectionStart === 7 && value[6] === ')') ||
                        (selectionStart === 11 && value[10] === '-') ||
                        (selectionStart === 14 && value[13] === '-')) {
                        this.setSelectionRange(selectionStart - 1, selectionStart - 1);
                        e.preventDefault();
                    }

                    // Если остался только базовый формат - очищаем поле
                    if (value === '+7 (' && selectionStart === 4) {
                        this.value = '';
                        e.preventDefault();
                    }
                }

                // Запрещаем удаление символов "+7 ("
                if (e.key === 'Backspace' && this.selectionStart <= 4 && this.value.startsWith('+7 (')) {
                    if (this.selectionStart <= 4) {
                        e.preventDefault();
                        this.setSelectionRange(4, 4);
                    }
                }
            });

            // Обработка вставки текста
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedText = (e.clipboardData || window.clipboardData).getData('text');
                const numbers = pastedText.replace(/\D/g, '');

                if (numbers) {
                    let phoneValue = numbers;

                    // Нормализуем номер
                    if (phoneValue.startsWith('7') || phoneValue.startsWith('8')) {
                        phoneValue = phoneValue.substring(0, 11);
                    } else if (phoneValue.startsWith('9')) {
                        phoneValue = '7' + phoneValue.substring(0, 10);
                    } else {
                        phoneValue = '7' + phoneValue.substring(0, 10);
                    }

                    // Форматируем
                    let formattedValue = '+7 (';

                    if (phoneValue.length > 1) {
                        formattedValue += phoneValue.substring(1, 4);
                    }
                    if (phoneValue.length >= 4) {
                        formattedValue += ') ' + phoneValue.substring(4, 7);
                    }
                    if (phoneValue.length >= 7) {
                        formattedValue += '-' + phoneValue.substring(7, 9);
                    }
                    if (phoneValue.length >= 9) {
                        formattedValue += '-' + phoneValue.substring(9, 11);
                    }

                    this.value = formattedValue;
                    lastValue = formattedValue;
                }
            });

            // Валидация при потере фокуса
            input.addEventListener('blur', function(e) {
                const value = e.target.value.replace(/\D/g, '');

                if (value.length !== 11) {
                    e.target.classList.add('input-error');
                } else {
                    e.target.classList.remove('input-error');
                }

                // Если поле содержит только базовый формат, очищаем его
                if (e.target.value === '+7 (') {
                    e.target.value = '';
                }
            });

            // Убираем ошибку при фокусе
            input.addEventListener('focus', function(e) {
                e.target.classList.remove('input-error');

                // Если поле пустое, устанавливаем базовый формат
                if (!this.value.trim()) {
                    this.value = '+7 (';
                    lastValue = '+7 (';
                }
            });
        });
    }

    // Остальной код без изменений
    // Валидация формы
    function validateForm(form) {
        const phoneInput = form.querySelector('input[name="phone"], input[type="tel"]');
        const emailInput = form.querySelector('input[type="email"]');
        const nameInput = form.querySelector('input[name="name"]');
        const privacyCheckbox = form.querySelector('input[name="privacy_agreement"]');

        let isValid = true;

        // Валидация телефона
        if (phoneInput) {
            const phoneValue = phoneInput.value.replace(/\D/g, '');
            if (phoneValue.length !== 11) {
                phoneInput.classList.add('input-error');
                isValid = false;

                let phoneError = form.querySelector('.phone-error');
                if (!phoneError) {
                    phoneError = document.createElement('div');
                    phoneError.className = 'phone-error mt-1 text-red-400 text-sm';
                    phoneError.textContent = 'Введите корректный номер телефона';
                    phoneInput.parentNode.appendChild(phoneError);
                }
            } else {
                phoneInput.classList.remove('input-error');
                const phoneError = form.querySelector('.phone-error');
                if (phoneError) phoneError.remove();
            }
        }

        // Валидация email
        if (emailInput && emailInput.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailInput.value)) {
                emailInput.classList.add('input-error');
                isValid = false;
            } else {
                emailInput.classList.remove('input-error');
            }
        }

        // Валидация имени
        if (nameInput && !nameInput.value.trim()) {
            nameInput.classList.add('input-error');
            isValid = false;
        } else if (nameInput) {
            nameInput.classList.remove('input-error');
        }

        // Валидация согласия
        if (privacyCheckbox && !privacyCheckbox.checked) {
            privacyCheckbox.classList.add('checkbox-error');
            isValid = false;

            let errorMsg = form.querySelector('.privacy-error');
            if (!errorMsg) {
                errorMsg = document.createElement('div');
                errorMsg.className = 'privacy-error mt-2 p-2 bg-red-500/20 border border-red-500 text-red-300 rounded text-sm';
                errorMsg.textContent = 'Необходимо согласие с политикой конфиденциальности';
                privacyCheckbox.parentNode.appendChild(errorMsg);
            }

            privacyCheckbox.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else if (privacyCheckbox) {
            privacyCheckbox.classList.remove('checkbox-error');
            const errorMsg = form.querySelector('.privacy-error');
            if (errorMsg) errorMsg.remove();
        }

        return isValid;
    }

    // Инициализация reCAPTCHA
    function initializeRecaptcha() {
        console.log('Initializing reCAPTCHA...');

        grecaptcha.ready(function() {
            console.log('reCAPTCHA ready, getting token...');

            grecaptcha.execute('6LfCAAksAAAAANvHXlyuTBk4sDmsIhRBOWw7n5QO', {action: 'submit'})
                .then(function(token) {
                    console.log('reCAPTCHA token received');

                    // Устанавливаем токен во все скрытые поля reCAPTCHA
                    document.querySelectorAll('input[name="recaptcha_token"]').forEach(function(input) {
                        input.value = token;
                    });
                })
                .catch(function(error) {
                    console.error('reCAPTCHA error:', error);
                });
        });
    }

    // Обработка отправки формы
    function handleFormSubmit(form) {
        // Защита от повторной отправки
        if (form.classList.contains('submitting')) {
            console.log('Form already submitting, skipping...');
            return false;
        }

        form.classList.add('submitting');

        if (!validateForm(form)) {
            form.classList.remove('submitting');
            return false;
        }

        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Отправка...';
        submitBtn.disabled = true;

        const formData = new FormData(form);
        const submitUrl = getFormSubmitUrl(form);

        console.log('Submitting form to:', submitUrl);

        fetch(submitUrl, {
            method: 'POST',
            body: formData
        })
            .then(response => {
                console.log('Response status:', response.status);

                // ВАЖНО: проверяем Content-Type для правильной обработки
                const contentType = response.headers.get('content-type');

                if (contentType && contentType.includes('application/json')) {
                    return response.json().then(data => {
                        console.log('JSON response:', data);

                        if (data.success) {
                            if (typeof showSuccessPopup === 'function') {
                                showSuccessPopup();
                            } else {
                                // Фолбэк если функции нет
                                alert('Заявка успешно отправлена!');
                            }
                            form.reset();
                            refreshRecaptchaToken();
                        } else {
                            if (typeof showErrorPopup === 'function') {
                                showErrorPopup(data.message || 'Ошибка отправки');
                            } else {
                                alert(data.message || 'Ошибка отправки формы');
                            }
                        }
                    });
                } else {
                    // Если ответ не JSON, считаем успешным при статусе 200
                    if (response.ok) {
                        if (typeof showSuccessPopup === 'function') {
                            showSuccessPopup();
                        } else {
                            alert('Заявка успешно отправлена!');
                        }
                        form.reset();
                        refreshRecaptchaToken();
                    } else {
                        if (typeof showErrorPopup === 'function') {
                            showErrorPopup();
                        } else {
                            alert('Ошибка отправки формы');
                        }
                    }
                    return response.text(); // Прочитаем ответ чтобы избе警告
                }
            })
            .catch(error => {
                console.error('Form submission error:', error);
                if (typeof showErrorPopup === 'function') {
                    showErrorPopup();
                } else {
                    alert('Произошла ошибка при отправке формы');
                }
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                form.classList.remove('submitting');
            });

        return true;
    }

    function getFormSubmitUrl(form) {
        const formId = form.id || '';

        if (formId.includes('led') || form.action.includes('led')) {
            return '/led/submit';
        } else if (formId.includes('video') || form.action.includes('video')) {
            return '/video/submit';
        } else if (formId.includes('btl') || form.action.includes('btl')) {
            return '/btl/submit';
        } else if (form.action && form.action !== '') {
            return form.action;
        } else {
            return '/contact/submit';
        }
    }

    function refreshRecaptchaToken() {
        grecaptcha.ready(function() {
            grecaptcha.execute('6LfCAAksAAAAANvHXlyuTBk4sDmsIhRBOWw7n5QO', {action: 'submit'})
                .then(function(token) {
                    document.querySelectorAll('input[name="recaptcha_token"]').forEach(function(input) {
                        input.value = token;
                    });
                });
        });
    }

    // Инициализация маски телефона
    initPhoneMask();
    initializeRecaptcha();

    // Валидация всех форм
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                handleFormSubmit(this);
            });
        });
    });

    setInterval(refreshRecaptchaToken, 120000);

    // Отладочная функция
    window.debugRecaptcha = function() {
        console.log('=== reCAPTCHA DEBUG ===');
        const tokenFields = document.querySelectorAll('input[name="recaptcha_token"]');
        console.log('Token fields found:', tokenFields.length);
        tokenFields.forEach((field, index) => {
            console.log(`Token field ${index}:`, field.value ? field.value.substring(0, 20) + '...' : 'EMPTY');
        });
    };
});