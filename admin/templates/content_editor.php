<div class="content-container">
    <div class="content-header">
        <h1><i class="fas fa-edit"></i> Редактор контента</h1>
        <p>Здесь вы можете редактировать содержимое вашего сайта без знания программирования.</p>
    </div>

    <?php if (!empty($message)): ?>
        <div class="alert <?php echo $message_type; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="content-tabs">
        <ul class="nav-tabs">
            <li class="<?php echo ($content_section == 'main') ? 'active' : ''; ?>">
                <a href="index.php?action=content&section=main">Главная страница</a>
            </li>
            <li class="<?php echo ($content_section == 'hotel') ? 'active' : ''; ?>">
                <a href="index.php?action=content&section=hotel">Гостиница</a>
            </li>
            <li class="<?php echo ($content_section == 'special') ? 'active' : ''; ?>">
                <a href="index.php?action=content&section=special">Спецпредложения</a>
            </li>
            <li class="<?php echo ($content_section == 'sauna') ? 'active' : ''; ?>">
                <a href="index.php?action=content&section=sauna">Сауна</a>
            </li>
            <li class="<?php echo ($content_section == 'banquet') ? 'active' : ''; ?>">
                <a href="index.php?action=content&section=banquet">Банкетный зал</a>
            </li>
            <li class="<?php echo ($content_section == 'contacts') ? 'active' : ''; ?>">
                <a href="index.php?action=content&section=contacts">Контакты</a>
            </li>
        </ul>
    </div>

    <div class="content-editor-container">
        <?php 
        // Подключаем соответствующий шаблон в зависимости от выбранного раздела
        switch ($content_section) {
            case 'main':
                include 'content/main_page.php';
                break;
            case 'hotel':
                include 'content/hotel_page.php';
                break;
            case 'special':
                include 'content/special_page.php';
                break;
            case 'sauna':
                include 'content/sauna_page.php';
                break;
            case 'banquet':
                include 'content/banquet_page.php';
                break;
            case 'contacts':
                include 'content/contacts_page.php';
                break;
            default:
                include 'content/main_page.php';
        }
        ?>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
// Функция для предварительного просмотра изображений
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Инициализация текстового редактора для всех текстовых областей
document.addEventListener('DOMContentLoaded', function() {
    var textareas = document.querySelectorAll('.content-editor');
    if (textareas.length > 0) {
        textareas.forEach(function(textarea) {
            ClassicEditor
                .create(textarea)
                .catch(error => {
                    console.error(error);
                });
        });
    }
});
</script> 