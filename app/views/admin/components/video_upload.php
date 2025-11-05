<?php
// app/views/admin/components/video_upload.php

$label = $label ?? 'Загрузить видео';
$fieldName = $fieldName ?? 'video_file';
$currentVideo = $currentVideo ?? '';
$accept = $accept ?? 'video/*';
?>

<div class="video-upload-wrapper">
    <label class="block mb-2 font-medium text-light"><?= htmlspecialchars($label) ?></label>
    
    <?php if (!empty($currentVideo)): ?>
    <div class="mb-3 p-3 bg-primary/50 rounded-lg">
        <p class="text-sm text-gray-400">Текущее видео:</p>
        <div class="flex items-center justify-between mt-1">
            <span class="text-light"><?= basename($currentVideo) ?></span>
            <a href="<?= htmlspecialchars($currentVideo) ?>" target="_blank" class="text-highlight hover:text-light">
                <i class="fas fa-external-link-alt"></i>
            </a>
        </div>
    </div>
    <?php endif; ?>

    <div class="flex items-center space-x-4">
        <input type="file" name="<?= htmlspecialchars($fieldName) ?>" 
               accept="<?= htmlspecialchars($accept) ?>" 
               class="video-input hidden">
        
        <button type="button" onclick="this.previousElementSibling.click()" 
                class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight">
            <i class="fas fa-video mr-2"></i>Выбрать видео
        </button>
        
        <span class="text-gray-400 text-sm video-file-name"></span>
    </div>
    
    <div class="video-preview mt-3 hidden">
        <video controls class="max-w-xs rounded-lg border border-highlight/30">
            <source src="" type="video/mp4">
            Ваш браузер не поддерживает видео.
        </video>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoInputs = document.querySelectorAll('.video-input');
    
    videoInputs.forEach(input => {
        input.addEventListener('change', function() {
            const fileName = this.files[0]?.name || 'Файл не выбран';
            const fileNameDisplay = this.parentElement.querySelector('.video-file-name');
            const preview = this.parentElement.querySelector('.video-preview');
            
            fileNameDisplay.textContent = fileName;
            
            if (this.files[0]?.type.startsWith('video/')) {
                const video = preview.querySelector('video');
                const source = video.querySelector('source');
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    source.src = e.target.result;
                    video.load();
                    preview.classList.remove('hidden');
                }
                
                reader.readAsDataURL(this.files[0]);
            } else {
                preview.classList.add('hidden');
            }
        });
    });
});
</script>