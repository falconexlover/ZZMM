<h2>Редактирование главной страницы</h2>

<form action="index.php?action=save_content" method="post" enctype="multipart/form-data" class="content-form">
    <input type="hidden" name="page" value="main">
    
    <div class="form-section">
        <h3>Слайдер на главной странице</h3>
        
        <div class="image-editor">
            <div class="image-preview">
                <img src="../assets/images/hotel-main.jpg" id="slider-preview" alt="Превью слайдера">
            </div>
            <div class="image-controls">
                <label for="slider-image">Изображение слайдера:</label>
                <input type="file" id="slider-image" name="slider_image" accept="image/*" onchange="previewImage(this, 'slider-preview')">
                <p class="help-text">Рекомендуемый размер: 1920x1080 пикселей</p>
            </div>
        </div>
        
        <div class="form-group">
            <label for="slider-title">Заголовок слайдера:</label>
            <input type="text" id="slider-title" name="slider_title" value="Добро пожаловать в &quot;Лесной дворик&quot;">
        </div>
        
        <div class="form-group">
            <label for="slider-subtitle">Подзаголовок слайдера:</label>
            <input type="text" id="slider-subtitle" name="slider_subtitle" value="Идеальное место для отдыха в гармонии с природой">
        </div>
    </div>
    
    <div class="form-section">
        <h3>Раздел "О нас"</h3>
        
        <div class="image-editor">
            <div class="image-preview">
                <img src="../assets/images/about.jpg" id="about-preview" alt="Превью раздела О нас">
            </div>
            <div class="image-controls">
                <label for="about-image">Изображение раздела:</label>
                <input type="file" id="about-image" name="about_image" accept="image/*" onchange="previewImage(this, 'about-preview')">
                <p class="help-text">Рекомендуемый размер: 800x600 пикселей</p>
            </div>
        </div>
        
        <div class="form-group">
            <label for="about-title">Заголовок раздела:</label>
            <input type="text" id="about-title" name="about_title" value="О нас">
        </div>
        
        <div class="form-group">
            <label for="about-text">Текст раздела:</label>
            <textarea id="about-text" name="about_text" class="content-editor" rows="6">
                <p>Гостиница "Лесной дворик" - это уютное место, расположенное в живописном уголке природы, где вы сможете насладиться комфортным отдыхом вдали от городской суеты.</p>
                <p>Мы придерживаемся экологичного подхода во всем: наши номера оформлены с использованием натуральных материалов, а в ресторане вы можете насладиться блюдами, приготовленными из локальных продуктов.</p>
                <p>Просторная территория, чистый воздух и близость к природе делают "Лесной дворик" идеальным местом для семейного отдыха, романтического уик-энда или корпоративного мероприятия.</p>
            </textarea>
        </div>
    </div>
    
    <div class="form-section">
        <h3>Раздел "Наши услуги"</h3>
        
        <div class="form-group">
            <label for="services-title">Заголовок раздела:</label>
            <input type="text" id="services-title" name="services_title" value="Наши услуги">
        </div>
        
        <div class="services-editor">
            <h4>Услуга 1</h4>
            <div class="form-group">
                <label for="service-icon-1">Иконка:</label>
                <select id="service-icon-1" name="service_icon_1">
                    <option value="fas fa-bed" selected>Кровать</option>
                    <option value="fas fa-utensils">Ресторан</option>
                    <option value="fas fa-hot-tub">Сауна</option>
                    <option value="fas fa-glass-cheers">Банкет</option>
                    <option value="fas fa-wifi">Wi-Fi</option>
                    <option value="fas fa-car">Парковка</option>
                </select>
            </div>
            <div class="form-group">
                <label for="service-title-1">Название:</label>
                <input type="text" id="service-title-1" name="service_title_1" value="Комфортное проживание">
            </div>
            <div class="form-group">
                <label for="service-desc-1">Описание:</label>
                <input type="text" id="service-desc-1" name="service_desc_1" value="Уютные номера различных категорий для любых потребностей">
            </div>
            
            <h4>Услуга 2</h4>
            <div class="form-group">
                <label for="service-icon-2">Иконка:</label>
                <select id="service-icon-2" name="service_icon_2">
                    <option value="fas fa-bed">Кровать</option>
                    <option value="fas fa-utensils" selected>Ресторан</option>
                    <option value="fas fa-hot-tub">Сауна</option>
                    <option value="fas fa-glass-cheers">Банкет</option>
                    <option value="fas fa-wifi">Wi-Fi</option>
                    <option value="fas fa-car">Парковка</option>
                </select>
            </div>
            <div class="form-group">
                <label for="service-title-2">Название:</label>
                <input type="text" id="service-title-2" name="service_title_2" value="Ресторан">
            </div>
            <div class="form-group">
                <label for="service-desc-2">Описание:</label>
                <input type="text" id="service-desc-2" name="service_desc_2" value="Ресторан с блюдами русской и европейской кухни">
            </div>
            
            <h4>Услуга 3</h4>
            <div class="form-group">
                <label for="service-icon-3">Иконка:</label>
                <select id="service-icon-3" name="service_icon_3">
                    <option value="fas fa-bed">Кровать</option>
                    <option value="fas fa-utensils">Ресторан</option>
                    <option value="fas fa-hot-tub" selected>Сауна</option>
                    <option value="fas fa-glass-cheers">Банкет</option>
                    <option value="fas fa-wifi">Wi-Fi</option>
                    <option value="fas fa-car">Парковка</option>
                </select>
            </div>
            <div class="form-group">
                <label for="service-title-3">Название:</label>
                <input type="text" id="service-title-3" name="service_title_3" value="Сауна">
            </div>
            <div class="form-group">
                <label for="service-desc-3">Описание:</label>
                <input type="text" id="service-desc-3" name="service_desc_3" value="Русская баня и финская сауна с зоной отдыха">
            </div>
            
            <h4>Услуга 4</h4>
            <div class="form-group">
                <label for="service-icon-4">Иконка:</label>
                <select id="service-icon-4" name="service_icon_4">
                    <option value="fas fa-bed">Кровать</option>
                    <option value="fas fa-utensils">Ресторан</option>
                    <option value="fas fa-hot-tub">Сауна</option>
                    <option value="fas fa-glass-cheers" selected>Банкет</option>
                    <option value="fas fa-wifi">Wi-Fi</option>
                    <option value="fas fa-car">Парковка</option>
                </select>
            </div>
            <div class="form-group">
                <label for="service-title-4">Название:</label>
                <input type="text" id="service-title-4" name="service_title_4" value="Банкетный зал">
            </div>
            <div class="form-group">
                <label for="service-desc-4">Описание:</label>
                <input type="text" id="service-desc-4" name="service_desc_4" value="Организация мероприятий любого формата">
            </div>
        </div>
    </div>
    
    <div class="form-section">
        <h3>Контактная информация</h3>
        
        <div class="form-group">
            <label for="contact-address">Адрес:</label>
            <input type="text" id="contact-address" name="contact_address" value="г. Москва, ул. Лесная, д. 10">
        </div>
        
        <div class="form-group">
            <label for="contact-phone">Телефон:</label>
            <input type="text" id="contact-phone" name="contact_phone" value="+7 (495) 123-45-67">
        </div>
        
        <div class="form-group">
            <label for="contact-email">Email:</label>
            <input type="email" id="contact-email" name="contact_email" value="info@lesnoy-dvorik.ru">
        </div>
        
        <div class="form-group">
            <label for="map-coordinates">Координаты на карте (широта, долгота):</label>
            <input type="text" id="map-coordinates" name="map_coordinates" value="55.76, 37.64">
            <p class="help-text">Формат: широта, долгота (например: 55.76, 37.64)</p>
        </div>
    </div>
    
    <div class="form-buttons">
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="../index.html" target="_blank" class="btn btn-secondary">Предварительный просмотр</a>
    </div>
</form> 