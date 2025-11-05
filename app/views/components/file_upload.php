<?php
// app/views/admin/components/file_upload.php

// Получаем параметры
$label = $label ?? 'Загрузить файл';
$fieldName = $fieldName ?? 'file';
$currentFile = $currentFile ?? '';
$accept = $accept ?? '*';
$previewId = $previewId ?? 'filePreview';
?>

<div class="file-upload-wrapper">
    <label class="block mb-2 font-medium text-light"><?= htmlspecialchars($label) ?></label>
    
    <?php if (!empty($currentFile)): ?>
    <div class="mb-3 p-3 bg-primary/50 rounded-lg">
        <p class="text-sm text-gray-400">Текущий файл:</p>
        <div class="flex items-center justify-between mt-1">
            <span class="text-light"><?= basename($currentFile) ?></span>
            <a href="<?= htmlspecialchars($currentFile) ?>" target="_blank" class="text-highlight hover:text-light">
                <i class="fas fa-external-link-alt"></i>
            </a>
        </div>
    </div>
    <?php endif; ?>

    <div class="flex items-center space-x-4">
        <input type="file" name="<?= htmlspecialchars($fieldName) ?>" 
               accept="<?= htmlspecialchars($accept) ?>" 
               class="file-input hidden" 
               onchange="previewFile(this, '<?= $previewId ?>')">
        
        <button type="button" onclick="this.previousElementSibling.click()" 
                class="bg-highlight text-primary font-semibold py-2 px-4 rounded-lg border-2 border-highlight transition-all duration-300 hover:bg-transparent hover:text-highlight">
            <i class="fas fa-upload mr-2"></i>Выбрать файл
        </button>
        
        <span class="text-gray-400 text-sm" id="fileName"></span>
    </div>
    
    <?php if ($previewId): ?>
    <div id="<?= $previewId ?>" class="mt-3 hidden">
        <img src="" class="max-w-xs rounded-lg border border-highlight/30" alt="Preview">
    </div>
    <?php endif; ?>
</div>

<script>
function previewFile(input, previewId) {
    const fileName = input.files[0]?.name || 'Файл не выбран';
    document.getElementById('fileName').textContent = fileName;
    
    if (previewId && input.files[0]?.type.startsWith('image/')) {
        const preview = document.getElementById(previewId);
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>