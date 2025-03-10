<h2>Редактирование страницы гостиницы</h2>

<form action="index.php?action=save_content" method="post" enctype="multipart/form-data" class="content-form">
    <input type="hidden" name="page" value="hotel">
    
    <div class="form-section">
        <h3>Заголовок страницы</h3>
        
        <div class="form-group">
            <label for="hotel-title">Заголовок страницы (тег title):</label>
            <input type="text" id="hotel-title" name="hotel_title" value="Номера гостиницы &quot;Лесной дворик&quot; - Комфортное проживание">
        </div>
        
        <div class="form-group">
            <label for="hotel-description">Описание страницы (meta description):</label>
            <textarea id="hotel-description" name="hotel_description" rows="3">Номерной фонд гостиницы 'Лесной дворик'. Комфортабельные номера различных категорий для отдыха семьей, парой или компанией.</textarea>
        </div>
    </div>
    
    <div class="form-section">
        <h3>Баннер страницы</h3>
        
        <div class="image-editor">
            <div class="image-preview">
                <img src="../assets/images/hotel-banner.jpg" id="banner-preview" alt="Превью баннера">
            </div>
            <div class="image-controls">
                <label for="banner-image">Изображение баннера:</label>
                <input type="file" id="banner-image" name="banner_image" accept="image/*" onchange="previewImage(this, 'banner-preview')">
                <p class="help-text">Рекомендуемый размер: 1920x400 пикселей</p>
            </div>
        </div>
        
        <div class="form-group">
            <label for="banner-title">Заголовок баннера:</label>
            <input type="text" id="banner-title" name="banner_title" value="Номера гостиницы">
        </div>
        
        <div class="form-group">
            <label for="banner-subtitle">Подзаголовок баннера:</label>
            <input type="text" id="banner-subtitle" name="banner_subtitle" value="Комфорт и уют для вашего отдыха">
        </div>
    </div>
    
    <div class="form-section">
        <h3>Общая информация о номерах</h3>
        
        <div class="form-group">
            <label for="hotel-intro">Вводный текст:</label>
            <textarea id="hotel-intro" name="hotel_intro" class="content-editor" rows="4">
                <p>Гостиница "Лесной дворик" предлагает комфортабельные номера различных категорий, оформленные в экологичном стиле с использованием натуральных материалов.</p>
                <p>Все номера оснащены современной мебелью, телевизором, холодильником, кондиционером и бесплатным Wi-Fi. В каждом номере есть собственная ванная комната с душем, феном и комплектом туалетных принадлежностей.</p>
            </textarea>
        </div>
    </div>
    
    <div class="form-section">
        <h3>Категории номеров</h3>
        
        <!-- Номер категории "Эконом" -->
        <div class="room-editor">
            <h4>Номер "Эконом"</h4>
            
            <div class="image-editor">
                <div class="image-preview">
                    <img src="../assets/images/room-econom.jpg" id="econom-preview" alt="Превью номера Эконом">
                </div>
                <div class="image-controls">
                    <label for="econom-image">Изображение номера:</label>
                    <input type="file" id="econom-image" name="econom_image" accept="image/*" onchange="previewImage(this, 'econom-preview')">
                    <p class="help-text">Рекомендуемый размер: 800x600 пикселей</p>
                </div>
            </div>
            
            <div class="form-group">
                <label for="econom-title">Название категории:</label>
                <input type="text" id="econom-title" name="econom_title" value="Эконом">
            </div>
            
            <div class="form-group">
                <label for="econom-price">Цена за сутки:</label>
                <input type="text" id="econom-price" name="econom_price" value="2500">
                <p class="help-text">Укажите только число, без знака рубля</p>
            </div>
            
            <div class="form-group">
                <label for="econom-description">Описание номера:</label>
                <textarea id="econom-description" name="econom_description" class="content-editor" rows="4">
                    <p>Уютный номер площадью 15 м² с одной двуспальной или двумя односпальными кроватями. Идеально подходит для бюджетного размещения пары или двух друзей.</p>
                    <p>В номере: телевизор, холодильник, кондиционер, бесплатный Wi-Fi, собственная ванная комната с душем.</p>
                </textarea>
            </div>
            
            <div class="form-group">
                <label for="econom-features">Особенности номера (через запятую):</label>
                <input type="text" id="econom-features" name="econom_features" value="Площадь 15 м², Двуспальная кровать, Телевизор, Холодильник, Кондиционер, Wi-Fi, Душ">
            </div>
        </div>
        
        <!-- Номер категории "Стандарт" -->
        <div class="room-editor">
            <h4>Номер "Стандарт"</h4>
            
            <div class="image-editor">
                <div class="image-preview">
                    <img src="../assets/images/room-standard.jpg" id="standard-preview" alt="Превью номера Стандарт">
                </div>
                <div class="image-controls">
                    <label for="standard-image">Изображение номера:</label>
                    <input type="file" id="standard-image" name="standard_image" accept="image/*" onchange="previewImage(this, 'standard-preview')">
                    <p class="help-text">Рекомендуемый размер: 800x600 пикселей</p>
                </div>
            </div>
            
            <div class="form-group">
                <label for="standard-title">Название категории:</label>
                <input type="text" id="standard-title" name="standard_title" value="Стандарт">
            </div>
            
            <div class="form-group">
                <label for="standard-price">Цена за сутки:</label>
                <input type="text" id="standard-price" name="standard_price" value="3500">
                <p class="help-text">Укажите только число, без знака рубля</p>
            </div>
            
            <div class="form-group">
                <label for="standard-description">Описание номера:</label>
                <textarea id="standard-description" name="standard_description" class="content-editor" rows="4">
                    <p>Комфортабельный номер площадью 20 м² с одной двуспальной или двумя односпальными кроватями. Оптимальный выбор для комфортного отдыха пары или двух гостей.</p>
                    <p>В номере: телевизор, холодильник, кондиционер, бесплатный Wi-Fi, собственная ванная комната с душем, фен, письменный стол.</p>
                </textarea>
            </div>
            
            <div class="form-group">
                <label for="standard-features">Особенности номера (через запятую):</label>
                <input type="text" id="standard-features" name="standard_features" value="Площадь 20 м², Двуспальная кровать, Телевизор, Холодильник, Кондиционер, Wi-Fi, Душ, Фен, Письменный стол">
            </div>
        </div>
        
        <!-- Номер категории "Семейный" -->
        <div class="room-editor">
            <h4>Номер "Семейный"</h4>
            
            <div class="image-editor">
                <div class="image-preview">
                    <img src="../assets/images/room-family.jpg" id="family-preview" alt="Превью номера Семейный">
                </div>
                <div class="image-controls">
                    <label for="family-image">Изображение номера:</label>
                    <input type="file" id="family-image" name="family_image" accept="image/*" onchange="previewImage(this, 'family-preview')">
                    <p class="help-text">Рекомендуемый размер: 800x600 пикселей</p>
                </div>
            </div>
            
            <div class="form-group">
                <label for="family-title">Название категории:</label>
                <input type="text" id="family-title" name="family_title" value="Семейный">
            </div>
            
            <div class="form-group">
                <label for="family-price">Цена за сутки:</label>
                <input type="text" id="family-price" name="family_price" value="4500">
                <p class="help-text">Укажите только число, без знака рубля</p>
            </div>
            
            <div class="form-group">
                <label for="family-description">Описание номера:</label>
                <textarea id="family-description" name="family_description" class="content-editor" rows="4">
                    <p>Просторный номер площадью 30 м² с одной двуспальной и одной односпальной кроватью или диваном. Идеальный вариант для семьи с ребенком или компании из трех человек.</p>
                    <p>В номере: телевизор, холодильник, кондиционер, бесплатный Wi-Fi, собственная ванная комната с душем, фен, письменный стол, чайник, набор посуды.</p>
                </textarea>
            </div>
            
            <div class="form-group">
                <label for="family-features">Особенности номера (через запятую):</label>
                <input type="text" id="family-features" name="family_features" value="Площадь 30 м², Двуспальная кровать, Односпальная кровать/диван, Телевизор, Холодильник, Кондиционер, Wi-Fi, Душ, Фен, Чайник, Набор посуды">
            </div>
        </div>
        
        <!-- Кнопки добавления/удаления категорий номеров -->
        <div class="form-buttons room-buttons">
            <button type="button" class="btn btn-secondary" id="add-room-category">Добавить категорию номера</button>
        </div>
    </div>
    
    <div class="form-section">
        <h3>Дополнительная информация</h3>
        
        <div class="form-group">
            <label for="hotel-additional-info">Дополнительная информация:</label>
            <textarea id="hotel-additional-info" name="hotel_additional_info" class="content-editor" rows="4">
                <h3>Правила проживания</h3>
                <ul>
                    <li>Заезд с 14:00, выезд до 12:00</li>
                    <li>Ранний заезд и поздний выезд возможны за дополнительную плату</li>
                    <li>Завтрак включен в стоимость номера</li>
                    <li>Дети до 6 лет размещаются бесплатно без предоставления отдельного места</li>
                    <li>Размещение с домашними животными не допускается</li>
                </ul>
                
                <h3>Способы оплаты</h3>
                <ul>
                    <li>Наличными при заселении</li>
                    <li>Банковской картой</li>
                    <li>Банковским переводом</li>
                </ul>
            </textarea>
        </div>
    </div>
    
    <div class="form-buttons">
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="../hotel.html" target="_blank" class="btn btn-secondary">Предварительный просмотр</a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Обработчик для кнопки добавления новой категории номера
    document.getElementById('add-room-category').addEventListener('click', function() {
        const roomEditors = document.querySelectorAll('.room-editor');
        const lastRoomEditor = roomEditors[roomEditors.length - 1];
        
        // Клонируем последний редактор номера
        const newRoomEditor = lastRoomEditor.cloneNode(true);
        
        // Генерируем уникальный идентификатор для новой категории
        const newId = 'room-' + (new Date().getTime());
        
        // Обновляем ID и атрибуты в клонированном элементе
        const inputs = newRoomEditor.querySelectorAll('input, textarea, select');
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
                const label = newRoomEditor.querySelector(`label[for="${oldId}"]`);
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
        const heading = newRoomEditor.querySelector('h4');
        if (heading) {
            heading.textContent = 'Новая категория номера';
        }
        
        // Обновляем превью изображения
        const preview = newRoomEditor.querySelector('.image-preview img');
        if (preview) {
            preview.src = '../assets/images/no-image.jpg';
            preview.id = 'new-room-preview';
            
            // Обновляем обработчик onchange для input file
            const fileInput = newRoomEditor.querySelector('input[type="file"]');
            if (fileInput) {
                fileInput.setAttribute('onchange', `previewImage(this, 'new-room-preview')`);
            }
        }
        
        // Вставляем новый редактор перед кнопками
        const roomButtons = document.querySelector('.room-buttons');
        roomButtons.parentNode.insertBefore(newRoomEditor, roomButtons);
        
        // Инициализируем редактор для новых текстовых областей
        const newTextareas = newRoomEditor.querySelectorAll('.content-editor');
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