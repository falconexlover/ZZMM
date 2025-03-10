<h2>Редактирование страницы спецпредложений</h2>

<form action="index.php?action=save_content" method="post" enctype="multipart/form-data" class="content-form">
    <input type="hidden" name="page" value="special">
    
    <div class="form-section">
        <h3>Заголовок страницы</h3>
        
        <div class="form-group">
            <label for="special-title">Заголовок страницы (тег title):</label>
            <input type="text" id="special-title" name="special_title" value="Спецпредложения гостиницы &quot;Лесной дворик&quot; - Выгодные акции и скидки">
        </div>
        
        <div class="form-group">
            <label for="special-description">Описание страницы (meta description):</label>
            <textarea id="special-description" name="special_description" rows="3">Специальные предложения и акции гостиницы 'Лесной дворик'. Выгодные условия проживания, скидки и бонусы для наших гостей.</textarea>
        </div>
    </div>
    
    <div class="form-section">
        <h3>Баннер страницы</h3>
        
        <div class="image-editor">
            <div class="image-preview">
                <img src="../assets/images/special-banner.jpg" id="banner-preview" alt="Превью баннера">
            </div>
            <div class="image-controls">
                <label for="banner-image">Изображение баннера:</label>
                <input type="file" id="banner-image" name="banner_image" accept="image/*" onchange="previewImage(this, 'banner-preview')">
                <p class="help-text">Рекомендуемый размер: 1920x400 пикселей</p>
            </div>
        </div>
        
        <div class="form-group">
            <label for="banner-title">Заголовок баннера:</label>
            <input type="text" id="banner-title" name="banner_title" value="Специальные предложения">
        </div>
        
        <div class="form-group">
            <label for="banner-subtitle">Подзаголовок баннера:</label>
            <input type="text" id="banner-subtitle" name="banner_subtitle" value="Выгодные акции и скидки для наших гостей">
        </div>
    </div>
    
    <div class="form-section">
        <h3>Вводный текст</h3>
        
        <div class="form-group">
            <label for="special-intro">Вводный текст:</label>
            <textarea id="special-intro" name="special_intro" class="content-editor" rows="4">
                <p>Гостиница "Лесной дворик" предлагает специальные условия проживания для различных категорий гостей. Воспользуйтесь нашими акциями и спецпредложениями, чтобы сделать ваш отдых еще более приятным и выгодным.</p>
                <p>Для бронирования по специальным предложениям, пожалуйста, укажите соответствующий промокод при оформлении заявки или свяжитесь с нами по телефону.</p>
            </textarea>
        </div>
    </div>
    
    <div class="form-section">
        <h3>Специальные предложения</h3>
        
        <!-- Спецпредложение 1 -->
        <div class="special-offer-editor">
            <h4>Спецпредложение 1</h4>
            
            <div class="image-editor">
                <div class="image-preview">
                    <img src="../assets/images/romantic.jpg" id="offer1-preview" alt="Превью спецпредложения">
                </div>
                <div class="image-controls">
                    <label for="offer1-image">Изображение предложения:</label>
                    <input type="file" id="offer1-image" name="offer1_image" accept="image/*" onchange="previewImage(this, 'offer1-preview')">
                    <p class="help-text">Рекомендуемый размер: 800x600 пикселей</p>
                </div>
            </div>
            
            <div class="form-group">
                <label for="offer1-title">Название предложения:</label>
                <input type="text" id="offer1-title" name="offer1_title" value="Романтический уик-энд">
            </div>
            
            <div class="form-group">
                <label for="offer1-badge">Текст бейджа (если есть):</label>
                <input type="text" id="offer1-badge" name="offer1_badge" value="Только до 31 мая">
                <p class="help-text">Оставьте пустым, если бейдж не нужен</p>
            </div>
            
            <div class="form-group">
                <label for="offer1-description">Описание предложения:</label>
                <textarea id="offer1-description" name="offer1_description" class="content-editor" rows="4">
                    <p>Проведите незабываемые выходные вдвоем в гостинице "Лесной дворик". В пакет входит:</p>
                    <ul>
                        <li>Проживание в номере категории "Комфорт" (2 суток)</li>
                        <li>Романтический ужин при свечах в ресторане</li>
                        <li>Бутылка шампанского и фрукты в номер</li>
                        <li>Посещение сауны (1 час)</li>
                        <li>Поздний выезд до 16:00</li>
                    </ul>
                </textarea>
            </div>
            
            <div class="form-group">
                <label for="offer1-price">Цена:</label>
                <input type="text" id="offer1-price" name="offer1_price" value="5900">
                <p class="help-text">Укажите только число, без знака рубля</p>
            </div>
            
            <div class="form-group">
                <label for="offer1-promo">Промокод:</label>
                <input type="text" id="offer1-promo" name="offer1_promo" value="ROMANTIC">
            </div>
            
            <div class="form-group">
                <label for="offer1-valid-until">Действует до:</label>
                <input type="date" id="offer1-valid-until" name="offer1_valid_until" value="2025-05-31">
            </div>
        </div>
        
        <!-- Спецпредложение 2 -->
        <div class="special-offer-editor">
            <h4>Спецпредложение 2</h4>
            
            <div class="image-editor">
                <div class="image-preview">
                    <img src="../assets/images/family.jpg" id="offer2-preview" alt="Превью спецпредложения">
                </div>
                <div class="image-controls">
                    <label for="offer2-image">Изображение предложения:</label>
                    <input type="file" id="offer2-image" name="offer2_image" accept="image/*" onchange="previewImage(this, 'offer2-preview')">
                    <p class="help-text">Рекомендуемый размер: 800x600 пикселей</p>
                </div>
            </div>
            
            <div class="form-group">
                <label for="offer2-title">Название предложения:</label>
                <input type="text" id="offer2-title" name="offer2_title" value="Семейный отдых">
            </div>
            
            <div class="form-group">
                <label for="offer2-badge">Текст бейджа (если есть):</label>
                <input type="text" id="offer2-badge" name="offer2_badge" value="Новинка">
                <p class="help-text">Оставьте пустым, если бейдж не нужен</p>
            </div>
            
            <div class="form-group">
                <label for="offer2-description">Описание предложения:</label>
                <textarea id="offer2-description" name="offer2_description" class="content-editor" rows="4">
                    <p>Идеальное предложение для семейного отдыха с детьми. В пакет входит:</p>
                    <ul>
                        <li>Проживание в семейном номере (от 3 суток)</li>
                        <li>Завтраки для всей семьи</li>
                        <li>Детская анимационная программа (в выходные дни)</li>
                        <li>Скидка 20% на посещение сауны</li>
                        <li>Поздний выезд до 14:00</li>
                    </ul>
                </textarea>
            </div>
            
            <div class="form-group">
                <label for="offer2-price">Цена:</label>
                <input type="text" id="offer2-price" name="offer2_price" value="6500">
                <p class="help-text">Укажите только число, без знака рубля</p>
            </div>
            
            <div class="form-group">
                <label for="offer2-promo">Промокод:</label>
                <input type="text" id="offer2-promo" name="offer2_promo" value="FAMILY">
            </div>
            
            <div class="form-group">
                <label for="offer2-valid-until">Действует до:</label>
                <input type="date" id="offer2-valid-until" name="offer2_valid_until" value="2025-12-31">
            </div>
        </div>
        
        <!-- Кнопки добавления/удаления спецпредложений -->
        <div class="form-buttons offer-buttons">
            <button type="button" class="btn btn-secondary" id="add-special-offer">Добавить спецпредложение</button>
        </div>
    </div>
    
    <div class="form-section">
        <h3>Дополнительная информация</h3>
        
        <div class="form-group">
            <label for="special-additional-info">Дополнительная информация:</label>
            <textarea id="special-additional-info" name="special_additional_info" class="content-editor" rows="4">
                <h3>Условия бронирования по спецпредложениям</h3>
                <ul>
                    <li>Спецпредложения действуют при прямом бронировании через сайт или по телефону</li>
                    <li>Для получения скидки необходимо указать промокод при бронировании</li>
                    <li>Спецпредложения не суммируются с другими акциями и скидками</li>
                    <li>Количество номеров по спецпредложениям ограничено</li>
                    <li>Администрация оставляет за собой право изменять условия акций</li>
                </ul>
            </textarea>
        </div>
    </div>
    
    <div class="form-buttons">
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="../special.html" target="_blank" class="btn btn-secondary">Предварительный просмотр</a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Обработчик для кнопки добавления нового спецпредложения
    document.getElementById('add-special-offer').addEventListener('click', function() {
        const offerEditors = document.querySelectorAll('.special-offer-editor');
        const lastOfferEditor = offerEditors[offerEditors.length - 1];
        
        // Клонируем последний редактор спецпредложения
        const newOfferEditor = lastOfferEditor.cloneNode(true);
        
        // Генерируем уникальный идентификатор для нового предложения
        const newId = 'offer-' + (new Date().getTime());
        
        // Обновляем ID и атрибуты в клонированном элементе
        const inputs = newOfferEditor.querySelectorAll('input, textarea, select');
        inputs.forEach(function(input) {
            const oldName = input.getAttribute('name');
            if (oldName) {
                input.setAttribute('name', 'new_' + oldName);
            }
            
            const oldId = input.getAttribute('id');
            if (oldId) {
                const newInputId = 'new_' + oldId;
                input.setAttribute('id', newInputId);
                
                // Обновляем соответствующие label
                const label = newOfferEditor.querySelector(`label[for="${oldId}"]`);
                if (label) {
                    label.setAttribute('for', newInputId);
                }
            }
            
            // Очищаем значения
            if (input.tagName === 'INPUT') {
                if (input.type !== 'file') {
                    input.value = '';
                }
            } else if (input.tagName === 'TEXTAREA') {
                input.innerHTML = '';
            }
        });
        
        // Обновляем заголовок
        const heading = newOfferEditor.querySelector('h4');
        if (heading) {
            heading.textContent = 'Новое спецпредложение';
        }
        
        // Обновляем превью изображения
        const preview = newOfferEditor.querySelector('.image-preview img');
        if (preview) {
            preview.src = '../assets/images/no-image.jpg';
            preview.id = 'new-offer-preview';
            
            // Обновляем обработчик onchange для input file
            const fileInput = newOfferEditor.querySelector('input[type="file"]');
            if (fileInput) {
                fileInput.setAttribute('onchange', `previewImage(this, 'new-offer-preview')`);
            }
        }
        
        // Вставляем новый редактор перед кнопками
        const offerButtons = document.querySelector('.offer-buttons');
        offerButtons.parentNode.insertBefore(newOfferEditor, offerButtons);
        
        // Инициализируем редактор для новых текстовых областей
        const newTextareas = newOfferEditor.querySelectorAll('.content-editor');
        if (newTextareas.length > 0) {
            newTextareas.forEach(function(textarea) {
                ClassicEditor
                    .create(textarea)
                    .catch(error => {
                        console.error(error);
                    });
            });
        }
    });
});
</script> 