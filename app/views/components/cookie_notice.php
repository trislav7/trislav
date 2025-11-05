<?php
// app/views/components/cookie_notice.php
?>
<div id="cookieNotice" class="cookie-notice" style="display: none;">
    <div class="cookie-content">
        <p>Мы используем файлы cookie для улучшения работы сайта. Продолжая использовать сайт, вы соглашаетесь с нашей <a href="/privacy-policy">Политикой конфиденциальности</a>.</p>
        <button id="acceptCookies" class="btn btn-primary">Принять</button>
    </div>
</div>

<style>
.cookie-notice {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #1a1a2e;
    color: white;
    padding: 15px;
    z-index: 1000;
    border-top: 2px solid #00b7c2;
}

.cookie-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.cookie-content p {
    margin: 0;
    flex: 1;
}

.cookie-content a {
    color: #00b7c2;
    text-decoration: underline;
}

@media (max-width: 768px) {
    .cookie-content {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (!localStorage.getItem('cookiesAccepted')) {
        document.getElementById('cookieNotice').style.display = 'block';
    }

    document.getElementById('acceptCookies').addEventListener('click', function() {
        localStorage.setItem('cookiesAccepted', 'true');
        document.getElementById('cookieNotice').style.display = 'none';
    });
});
</script>