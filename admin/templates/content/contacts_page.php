<h2>Редактирование контактной информации</h2>

<form action="index.php?action=save_content" method="post" enctype="multipart/form-data" class="content-form">
    <input type="hidden" name="page" value="contacts">
    
    <div class="form-section">
        <h3>Основная контактная информация</h3>
        
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
            <label for="contact-working-hours">Режим работы:</label>
            <input type="text" id="contact-working-hours" name="contact_working_hours" value="Круглосуточно, без выходных">
        </div>
    </div>
    
    <div class="form-section">
        <h3>Карта и координаты</h3>
        
        <div class="form-group">
            <label for="map-coordinates">Координаты на карте (широта, долгота):</label>
            <input type="text" id="map-coordinates" name="map_coordinates" value="55.76, 37.64">
            <p class="help-text">Формат: широта, долгота (например: 55.76, 37.64)</p>
        </div>
        
        <div class="form-group">
            <label for="map-zoom">Масштаб карты:</label>
            <select id="map-zoom" name="map_zoom">
                <option value="14">14 - Район</option>
                <option value="15" selected>15 - Улицы</option>
                <option value="16">16 - Здания</option>
                <option value="17">17 - Детально</option>
                <option value="18">18 - Максимально детально</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="map-api-key">API-ключ Яндекс.Карт:</label>
            <input type="text" id="map-api-key" name="map_api_key" value="c5d63a69-5e76-4362-9b61-4247b5349ac9">
            <p class="help-text">Получите API-ключ на <a href="https://developer.tech.yandex.ru/" target="_blank">developer.tech.yandex.ru</a></p>
        </div>
        
        <div class="map-preview">
            <h4>Предварительный просмотр карты</h4>
            <div id="map-preview-container" style="width: 100%; height: 400px;"></div>
            <button type="button" class="btn btn-secondary" id="update-map-preview">Обновить карту</button>
        </div>
    </div>
    
    <div class="form-section">
        <h3>Социальные сети</h3>
        
        <div class="form-group">
            <label for="social-vk">ВКонтакте:</label>
            <input type="text" id="social-vk" name="social_vk" value="https://vk.com/lesnoy_dvorik">
        </div>
        
        <div class="form-group">
            <label for="social-telegram">Telegram:</label>
            <input type="text" id="social-telegram" name="social_telegram" value="https://t.me/lesnoy_dvorik">
        </div>
        
        <div class="form-group">
            <label for="social-whatsapp">WhatsApp:</label>
            <input type="text" id="social-whatsapp" name="social_whatsapp" value="https://wa.me/74951234567">
        </div>
        
        <div class="form-group">
            <label for="social-instagram">Instagram:</label>
            <input type="text" id="social-instagram" name="social_instagram" value="">
        </div>
    </div>
    
    <div class="form-section">
        <h3>Дополнительная информация</h3>
        
        <div class="form-group">
            <label for="contacts-additional-info">Дополнительная информация:</label>
            <textarea id="contacts-additional-info" name="contacts_additional_info" class="content-editor" rows="4">
                <h3>Как добраться</h3>
                <p><strong>На общественном транспорте:</strong></p>
                <ul>
                    <li>От станции метро "Лесная" автобусы №23, №45 до остановки "Санаторий"</li>
                    <li>От железнодорожной станции "Лесная" пешком 15 минут</li>
                </ul>
                
                <p><strong>На автомобиле:</strong></p>
                <ul>
                    <li>По Лесному шоссе 10 км от МКАД, поворот на указателе "Лесной дворик"</li>
                    <li>На территории гостиницы есть бесплатная парковка</li>
                </ul>
                
                <h3>Трансфер</h3>
                <p>Мы можем организовать трансфер от аэропорта или вокзала до гостиницы. Для заказа трансфера, пожалуйста, свяжитесь с нами по телефону заранее.</p>
            </textarea>
        </div>
    </div>
    
    <div class="form-buttons">
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="../index.html#contacts" target="_blank" class="btn btn-secondary">Предварительный просмотр</a>
    </div>
</form>

<script src="https://api-maps.yandex.ru/2.1/?apikey=c5d63a69-5e76-4362-9b61-4247b5349ac9&lang=ru_RU"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация карты
    let myMap;
    
    function initMap() {
        const coordinatesInput = document.getElementById('map-coordinates');
        const zoomInput = document.getElementById('map-zoom');
        
        if (!coordinatesInput || !zoomInput) return;
        
        const coordinatesValue = coordinatesInput.value;
        const zoomValue = parseInt(zoomInput.value);
        
        // Парсим координаты
        let coordinates = [55.76, 37.64]; // Значения по умолчанию
        if (coordinatesValue) {
            const parts = coordinatesValue.split(',');
            if (parts.length === 2) {
                const lat = parseFloat(parts[0].trim());
                const lng = parseFloat(parts[1].trim());
                if (!isNaN(lat) && !isNaN(lng)) {
                    coordinates = [lat, lng];
                }
            }
        }
        
        // Если карта уже инициализирована, удаляем ее
        if (myMap) {
            myMap.destroy();
        }
        
        // Создаем новую карту
        myMap = new ymaps.Map('map-preview-container', {
            center: coordinates,
            zoom: zoomValue || 15
        });
        
        // Добавляем метку
        const myPlacemark = new ymaps.Placemark(coordinates, {
            hintContent: 'Гостиница "Лесной дворик"',
            balloonContent: document.getElementById('contact-address').value + '<br>Тел: ' + document.getElementById('contact-phone').value
        }, {
            iconLayout: 'default#image',
            iconImageHref: '../assets/images/map-marker.png',
            iconImageSize: [40, 40],
            iconImageOffset: [-20, -40]
        });
        
        myMap.geoObjects.add(myPlacemark);
        
        // Добавляем элементы управления
        myMap.controls.add('zoomControl');
        myMap.controls.add('typeSelector');
        
        // Запрещаем прокрутку карты при скролле страницы
        myMap.behaviors.disable('scrollZoom');
    }
    
    // Обработчик кнопки обновления карты
    document.getElementById('update-map-preview').addEventListener('click', function() {
        ymaps.ready(initMap);
    });
    
    // Инициализация карты при загрузке страницы
    ymaps.ready(initMap);
});
</script> 