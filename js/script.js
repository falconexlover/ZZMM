document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM загружен, инициализация скриптов...");
    
    // Мобильное меню
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mainMenu = document.querySelector('.main-menu');
    
    if (mobileMenuToggle) {
        console.log("Найдена кнопка мобильного меню");
        mobileMenuToggle.addEventListener('click', function() {
            console.log("Клик по кнопке мобильного меню");
            this.classList.toggle('active');
            mainMenu.classList.toggle('active');
        });
    }
    
    // Константы для расчета стоимости
    const ROOM_PRICES = {
        'econom': 2500,
        'standard': 3500,
        'family': 4500,
        'comfort': 5500,
        'lux': 8000
    };
    
    const ADDITIONAL_SERVICES = {
        'breakfast': 500,
        'dinner': 700,
        'sauna': 1500,
        'transfer': 1000
    };
    
    // Промокоды и скидки (%)
    const PROMO_CODES = {
        'WELCOME': 10,
        'SUMMER2025': 15,
        'FAMILY': 20,
        'LONGSTAY': 25
    };
    
    // Устанавливаем минимальные даты для полей даты
    function setMinDates() {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const formattedToday = `${yyyy}-${mm}-${dd}`;
        
        const arrivalDateInput = document.getElementById('arrival-date');
        const departureDateInput = document.getElementById('departure-date');
        
        if (arrivalDateInput) arrivalDateInput.min = formattedToday;
        if (departureDateInput) departureDateInput.min = formattedToday;
        
        // Обновление минимальной даты выезда при изменении даты заезда
        if (arrivalDateInput && departureDateInput) {
            arrivalDateInput.addEventListener('change', function() {
                departureDateInput.min = this.value;
                // Если дата выезда раньше даты заезда, установить дату выезда равной дате заезда
                if (departureDateInput.value && departureDateInput.value < this.value) {
                    departureDateInput.value = this.value;
                }
            });
        }
    }
    
    // Вызываем функцию установки минимальных дат
    setMinDates();
    
    // Функция расчета стоимости проживания
    function calculatePrice() {
        const arrivalDate = new Date(document.getElementById('arrival-date').value);
        const departureDate = new Date(document.getElementById('departure-date').value);
        const roomType = document.getElementById('room-type').value;
        const promoCode = document.getElementById('promo-code').value.toUpperCase();
        
        // Проверка валидности дат
        if (isNaN(arrivalDate.getTime()) || isNaN(departureDate.getTime())) {
            return 0;
        }
        
        // Расчет количества дней
        const timeDiff = departureDate.getTime() - arrivalDate.getTime();
        const days = Math.ceil(timeDiff / (1000 * 3600 * 24));
        
        if (days <= 0) return 0;
        
        // Базовая стоимость номера
        let price = ROOM_PRICES[roomType] * days;
        
        // Дополнительные услуги
        const additionalServices = document.querySelectorAll('.checkbox-group input[type="checkbox"]:checked');
        additionalServices.forEach(service => {
            const serviceName = service.getAttribute('name');
            if (ADDITIONAL_SERVICES[serviceName]) {
                price += ADDITIONAL_SERVICES[serviceName] * days;
            }
        });
        
        // Применение промокода
        if (promoCode && PROMO_CODES[promoCode]) {
            const discount = price * (PROMO_CODES[promoCode] / 100);
            price = price - discount;
        }
        
        return Math.round(price);
    }
    
    // Обработка кнопки расчета стоимости
    const calculateButton = document.getElementById('calculate-price');
    if (calculateButton) {
        calculateButton.addEventListener('click', function() {
            const price = calculatePrice();
            
            // Отображение информации о бронировании
            const bookingSummary = document.getElementById('booking-summary');
            const summaryContent = bookingSummary.querySelector('.summary-content');
            const estimatedPrice = document.getElementById('estimated-price');
            
            if (price > 0) {
                const arrivalDate = new Date(document.getElementById('arrival-date').value);
                const departureDate = new Date(document.getElementById('departure-date').value);
                const roomType = document.getElementById('room-type').value;
                const guestsCount = document.getElementById('guests').value;
                const promoCode = document.getElementById('promo-code').value.toUpperCase();
                
                // Форматирование дат
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const formattedArrival = arrivalDate.toLocaleDateString('ru-RU', options);
                const formattedDeparture = departureDate.toLocaleDateString('ru-RU', options);
                
                // Расчет количества дней
                const timeDiff = departureDate.getTime() - arrivalDate.getTime();
                const days = Math.ceil(timeDiff / (1000 * 3600 * 24));
                
                // Отображение типа номера
                let roomTypeText = '';
                switch(roomType) {
                    case 'econom': roomTypeText = 'Эконом'; break;
                    case 'standard': roomTypeText = 'Стандарт'; break;
                    case 'family': roomTypeText = 'Семейный'; break;
                    case 'comfort': roomTypeText = 'Комфорт'; break;
                    case 'lux': roomTypeText = 'Люкс'; break;
                }
                
                // Дополнительные услуги
                let additionalServicesText = '';
                const additionalServices = document.querySelectorAll('.checkbox-group input[type="checkbox"]:checked');
                if (additionalServices.length > 0) {
                    additionalServicesText = '<strong>Дополнительные услуги:</strong><br>';
                    additionalServices.forEach(service => {
                        const serviceName = service.getAttribute('name');
                        switch(serviceName) {
                            case 'breakfast': additionalServicesText += '- Завтрак<br>'; break;
                            case 'dinner': additionalServicesText += '- Ужин<br>'; break;
                            case 'sauna': additionalServicesText += '- Сауна<br>'; break;
                            case 'transfer': additionalServicesText += '- Трансфер из города<br>'; break;
                        }
                    });
                }
                
                // Информация о промокоде
                let promoCodeText = '';
                if (promoCode && PROMO_CODES[promoCode]) {
                    promoCodeText = `<strong>Промокод:</strong> ${promoCode} (скидка ${PROMO_CODES[promoCode]}%)<br>`;
                }
                
                // Формирование итоговой информации
                let summaryHTML = `
                    <p><strong>Дата заезда:</strong> ${formattedArrival}</p>
                    <p><strong>Дата выезда:</strong> ${formattedDeparture}</p>
                    <p><strong>Количество ночей:</strong> ${days}</p>
                    <p><strong>Количество гостей:</strong> ${guestsCount}</p>
                    <p><strong>Тип номера:</strong> ${roomTypeText}</p>
                `;
                
                if (additionalServicesText) {
                    summaryHTML += `<p>${additionalServicesText}</p>`;
                }
                
                if (promoCodeText) {
                    summaryHTML += `<p>${promoCodeText}</p>`;
                }
                
                summaryContent.innerHTML = summaryHTML;
                estimatedPrice.textContent = price.toLocaleString('ru-RU');
                bookingSummary.style.display = 'block';
            } else {
                summaryContent.innerHTML = '<p>Пожалуйста, выберите даты заезда и выезда.</p>';
                estimatedPrice.textContent = '0';
                bookingSummary.style.display = 'block';
            }
        });
    }
    
    // Обработка всех кнопок
    const allButtons = document.querySelectorAll('.btn');
    console.log("Найдено кнопок на странице:", allButtons.length);
    
    allButtons.forEach(function(button, index) {
        console.log(`Кнопка ${index}:`, button.textContent.trim(), "Href:", button.getAttribute('href'));
        
        button.addEventListener('click', function(e) {
            console.log(`Клик по кнопке: ${button.textContent.trim()}`);
            
            // Если кнопка имеет href, но не действие формы
            if (button.getAttribute('href') && button.getAttribute('href') !== '#' && !button.closest('form')) {
                // Не блокируем стандартное поведение для перехода
                return;
            }
            
            // Для кнопок с href="#booking"
            if (button.getAttribute('href') === '#booking') {
                e.preventDefault();
                const bookingSection = document.querySelector('#booking');
                if (bookingSection) {
                    bookingSection.scrollIntoView({ behavior: 'smooth' });
                } else {
                    // Перенаправляем на главную страницу с якорем #booking
                    window.location.href = 'index.html#booking';
                }
            }
            
            // Обработка для кнопок "Подробнее"
            if (button.textContent.trim().includes('Подробнее')) {
                const targetHref = button.getAttribute('href');
                if (!targetHref || targetHref === '#') {
                    // Если href не задан, ищем ближайший раздел или родительский блок
                    const parentSection = button.closest('section') || button.closest('.card');
                    if (parentSection && parentSection.id) {
                        e.preventDefault();
                        console.log("Скролл к секции:", parentSection.id);
                        document.querySelector('#' + parentSection.id).scrollIntoView({ behavior: 'smooth' });
                    }
                }
            }
            
            // Для кнопок "Забронировать"
            if (button.textContent.trim().includes('Забронировать')) {
                const bookingForm = document.querySelector('.booking-form');
                if (bookingForm) {
                    e.preventDefault();
                    bookingForm.scrollIntoView({ behavior: 'smooth' });
                    // Выделяем форму для привлечения внимания
                    bookingForm.classList.add('highlight');
                    setTimeout(() => bookingForm.classList.remove('highlight'), 1500);
                } else if (window.location.pathname.includes('special.html') || 
                           window.location.pathname.includes('hotel.html')) {
                    // Если мы на странице спецпредложений или гостиницы, переходим на главную
                    e.preventDefault();
                    window.location.href = 'index.html#booking';
                }
            }
        });
    });
    
    // Плавный скроллинг для якорных ссылок
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            console.log("Клик по якорной ссылке:", this.getAttribute('href'));
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (!targetElement) {
                console.log("Элемент не найден, возможно нужен переход на другую страницу");
                // Если элемент не найден на текущей странице, проверяем, нужно ли перейти на другую
                if (targetId === '#booking' && !document.querySelector('#booking')) {
                    window.location.href = 'index.html' + targetId;
                    return;
                }
                return;
            }
            
            // Закрываем мобильное меню при клике на ссылку
            if (mainMenu && mainMenu.classList.contains('active')) {
                mainMenu.classList.remove('active');
                if (mobileMenuToggle) mobileMenuToggle.classList.remove('active');
            }
            
            // Плавный скроллинг с анимацией
            const headerHeight = document.querySelector('header') ? document.querySelector('header').offsetHeight : 0;
            const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - headerHeight;
            
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        });
    });
    
    // Обработка навигационных ссылок между страницами
    const pageLinks = document.querySelectorAll('a:not([href^="#"])');
    console.log("Найдено ссылок на другие страницы:", pageLinks.length);
    
    pageLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && (href.includes('.html') || href === '/' || href === './')) {
            console.log("Ссылка на страницу:", href);
            // Здесь мы не будем добавлять обработчики, так как хотим чтобы стандартное поведение сохранилось
        }
    });
    
    // Инициализация Яндекс.Карты
    if (typeof ymaps !== 'undefined' && document.getElementById('map')) {
        console.log("Инициализация карты Яндекс");
        ymaps.ready(initMap);
    } else if (document.getElementById('map')) {
        console.log("Яндекс.Карты не загружены или отсутствует API-ключ");
        // Отображаем заглушку вместо карты
        const mapElement = document.getElementById('map');
        mapElement.innerHTML = `
            <div class="map-placeholder">
                <i class="fas fa-map-marked-alt"></i>
                <p>Мы находимся по адресу: г. Москва, ул. Лесная, д. 10</p>
                <p>Телефон: +7 (495) 123-45-67</p>
            </div>
        `;
        
        // Стили для заглушки
        const style = document.createElement('style');
        style.innerHTML = `
            .map-placeholder {
                background-color: #f8f9fa;
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 20px;
                text-align: center;
            }
            .map-placeholder i {
                font-size: 48px;
                color: #5a8f7b;
                margin-bottom: 15px;
            }
        `;
        document.head.appendChild(style);
    }
    
    function initMap() {
        // Проверяем, существует ли элемент карты на странице
        const mapElement = document.getElementById('map');
        if (!mapElement) {
            console.log('Элемент карты не найден на странице');
            return;
        }
        
        try {
            const myMap = new ymaps.Map('map', {
                center: [55.76, 37.64], // Координаты гостиницы (примерные)
                zoom: 15
            });
            
            const myPlacemark = new ymaps.Placemark([55.76, 37.64], {
                hintContent: 'Гостиница "Лесной дворик"',
                balloonContent: 'г. Москва, ул. Лесная, д. 10<br>Тел: +7 (495) 123-45-67'
            }, {
                iconLayout: 'default#image',
                iconImageHref: 'assets/images/map-marker.png',
                iconImageSize: [40, 40],
                iconImageOffset: [-20, -40]
            });
            
            myMap.geoObjects.add(myPlacemark);
            
            // Добавляем элементы управления
            myMap.controls.add('zoomControl');
            myMap.controls.add('typeSelector');
            
            // Запрещаем прокрутку карты при скролле страницы
            myMap.behaviors.disable('scrollZoom');
        } catch (error) {
            console.error('Ошибка при инициализации карты:', error);
        }
    }
    
    // Обработка модального окна политики конфиденциальности
    const privacyLink = document.querySelector('.open-privacy-policy');
    const privacyModal = document.getElementById('privacy-policy-modal');
    const closeModal = document.querySelector('.privacy-modal-close');
    
    if (privacyLink && privacyModal) {
        privacyLink.addEventListener('click', function(e) {
            e.preventDefault();
            privacyModal.style.display = 'block';
        });
        
        closeModal.addEventListener('click', function() {
            privacyModal.style.display = 'none';
        });
        
        // Закрытие модального окна при клике вне его
        window.addEventListener('click', function(e) {
            if (e.target === privacyModal) {
                privacyModal.style.display = 'none';
            }
        });
    }
    
    // Генерация уникального ID для бронирования
    function generateBookingId() {
        return 'BK-' + Math.random().toString(36).substr(2, 9).toUpperCase();
    }
    
    // Сохранение бронирования в localStorage
    function saveBooking(bookingData) {
        let bookings = JSON.parse(localStorage.getItem('hotelBookings') || '[]');
        bookings.push(bookingData);
        localStorage.setItem('hotelBookings', JSON.stringify(bookings));
    }
    
    // Загрузка бронирований из localStorage
    function loadBookings() {
        return JSON.parse(localStorage.getItem('hotelBookings') || '[]');
    }
    
    // Отображение панели администратора
    function toggleAdminPanel() {
        const adminPanel = document.getElementById('admin-panel');
        if (adminPanel) {
            if (adminPanel.style.display === 'block') {
                adminPanel.style.display = 'none';
            } else {
                adminPanel.style.display = 'block';
                renderBookingsList();
            }
        }
    }
    
    // Отображение списка бронирований в панели администратора
    function renderBookingsList() {
        const bookingsContainer = document.getElementById('bookings-container');
        if (!bookingsContainer) return;
        
        const bookings = loadBookings();
        
        if (bookings.length === 0) {
            bookingsContainer.innerHTML = '<p class="empty-list">Нет сохраненных бронирований</p>';
            return;
        }
        
        let html = `
            <table class="bookings-list">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Даты</th>
                        <th>Номер</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
        `;
        
        bookings.forEach((booking, index) => {
            html += `
                <tr>
                    <td>${booking.id}</td>
                    <td>${booking.name}</td>
                    <td>${new Date(booking.arrivalDate).toLocaleDateString('ru-RU')} - ${new Date(booking.departureDate).toLocaleDateString('ru-RU')}</td>
                    <td>${booking.roomTypeText}</td>
                    <td>${booking.status || 'Новое'}</td>
                    <td class="admin-actions">
                        <button class="view-booking" data-index="${index}">Просмотр</button>
                        <button class="delete-booking" data-index="${index}">Удалить</button>
                    </td>
                </tr>
            `;
        });
        
        html += `
                </tbody>
            </table>
        `;
        
        bookingsContainer.innerHTML = html;
        
        // Добавляем обработчики событий для кнопок
        document.querySelectorAll('.view-booking').forEach(button => {
            button.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                const booking = bookings[index];
                alert(`Бронирование #${booking.id}\n\nИмя: ${booking.name}\nТелефон: ${booking.phone}\nEmail: ${booking.email}\nДаты: ${new Date(booking.arrivalDate).toLocaleDateString('ru-RU')} - ${new Date(booking.departureDate).toLocaleDateString('ru-RU')}\nНомер: ${booking.roomTypeText}\nГостей: ${booking.guests}\nДополнительные услуги: ${booking.additionalServices || 'нет'}\nКомментарий: ${booking.comments || 'нет'}`);
            });
        });
        
        document.querySelectorAll('.delete-booking').forEach(button => {
            button.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                if (confirm('Вы уверены, что хотите удалить это бронирование?')) {
                    bookings.splice(index, 1);
                    localStorage.setItem('hotelBookings', JSON.stringify(bookings));
                    renderBookingsList();
                }
            });
        });
    }
    
    // Очистка всех бронирований
    const clearAllBookingsButton = document.getElementById('clear-all-bookings');
    if (clearAllBookingsButton) {
        clearAllBookingsButton.addEventListener('click', function() {
            if (confirm('Вы уверены, что хотите удалить ВСЕ бронирования?')) {
                localStorage.removeItem('hotelBookings');
                renderBookingsList();
            }
        });
    }
    
    // Секретная комбинация для доступа к панели администратора (Alt+A)
    document.addEventListener('keydown', function(e) {
        if (e.altKey && e.key === 'a') {
            toggleAdminPanel();
        }
    });
    
    // Обработка формы бронирования
    const bookingForm = document.querySelector('.booking-form');
    if (bookingForm) {
        console.log("Найдена форма бронирования");
        bookingForm.addEventListener('submit', function(e) {
            console.log("Отправка формы бронирования");
            e.preventDefault();
            
            // Валидация формы
            let isValid = true;
            const requiredFields = this.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                    
                    // Добавляем сообщение об ошибке
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'error-message';
                    errorMessage.textContent = 'Это поле обязательно для заполнения';
                    
                    // Удаляем существующее сообщение, если оно есть
                    const existingError = field.parentNode.querySelector('.error-message');
                    if (existingError) existingError.remove();
                    
                    field.parentNode.appendChild(errorMessage);
                } else {
                    field.classList.remove('error');
                    // Удаляем сообщение об ошибке, если оно есть
                    const existingError = field.parentNode.querySelector('.error-message');
                    if (existingError) existingError.remove();
                }
            });
            
            // Дополнительная валидация для email
            const emailField = document.getElementById('email');
            if (emailField && emailField.value.trim() && !validateEmail(emailField.value.trim())) {
                isValid = false;
                emailField.classList.add('error');
                
                // Добавляем сообщение об ошибке
                const errorMessage = document.createElement('div');
                errorMessage.className = 'error-message';
                errorMessage.textContent = 'Введите корректный email адрес';
                
                // Удаляем существующее сообщение, если оно есть
                const existingError = emailField.parentNode.querySelector('.error-message');
                if (existingError) existingError.remove();
                
                emailField.parentNode.appendChild(errorMessage);
            }
            
            // Дополнительная валидация для телефона
            const phoneField = document.getElementById('phone');
            if (phoneField && phoneField.value.trim() && !validatePhone(phoneField.value.trim())) {
                isValid = false;
                phoneField.classList.add('error');
                
                // Добавляем сообщение об ошибке
                const errorMessage = document.createElement('div');
                errorMessage.className = 'error-message';
                errorMessage.textContent = 'Введите корректный номер телефона';
                
                // Удаляем существующее сообщение, если оно есть
                const existingError = phoneField.parentNode.querySelector('.error-message');
                if (existingError) existingError.remove();
                
                phoneField.parentNode.appendChild(errorMessage);
            }
            
            if (isValid) {
                // Сбор данных формы
                const bookingData = {
                    id: generateBookingId(),
                    name: document.getElementById('name').value,
                    phone: document.getElementById('phone').value,
                    email: document.getElementById('email').value,
                    arrivalDate: document.getElementById('arrival-date').value,
                    departureDate: document.getElementById('departure-date').value,
                    guests: document.getElementById('guests').value,
                    roomType: document.getElementById('room-type').value,
                    comments: document.getElementById('comments').value,
                    paymentMethod: document.getElementById('payment-method') ? document.getElementById('payment-method').value : 'cash',
                    promoCode: document.getElementById('promo-code') ? document.getElementById('promo-code').value : '',
                    date: new Date().toISOString(),
                    status: 'Новое'
                };
                
                // Получаем выбранные дополнительные услуги
                const additionalServices = [];
                document.querySelectorAll('.checkbox-group input[type="checkbox"]:checked').forEach(service => {
                    const serviceName = service.getAttribute('name');
                    switch(serviceName) {
                        case 'breakfast': additionalServices.push('Завтрак'); break;
                        case 'dinner': additionalServices.push('Ужин'); break;
                        case 'sauna': additionalServices.push('Сауна'); break;
                        case 'transfer': additionalServices.push('Трансфер'); break;
                    }
                });
                bookingData.additionalServices = additionalServices.join(', ');
                
                // Добавляем текстовое представление типа номера
                switch(bookingData.roomType) {
                    case 'econom': bookingData.roomTypeText = 'Эконом'; break;
                    case 'standard': bookingData.roomTypeText = 'Стандарт'; break;
                    case 'family': bookingData.roomTypeText = 'Семейный'; break;
                    case 'comfort': bookingData.roomTypeText = 'Комфорт'; break;
                    case 'lux': bookingData.roomTypeText = 'Люкс'; break;
                }
                
                // Расчет стоимости
                bookingData.price = calculatePrice();
                
                // Сохранение данных в localStorage
                saveBooking(bookingData);
                
                // Форматирование дат для отображения
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const formattedArrival = new Date(bookingData.arrivalDate).toLocaleDateString('ru-RU', options);
                const formattedDeparture = new Date(bookingData.departureDate).toLocaleDateString('ru-RU', options);
                
                // Показываем сообщение об успехе
                const successMessage = document.createElement('div');
                successMessage.className = 'success-message';
                successMessage.innerHTML = `
                    <i class="fas fa-check-circle"></i>
                    <h3>Ваша заявка успешно отправлена!</h3>
                    <p>Мы свяжемся с вами в ближайшее время для подтверждения бронирования.</p>
                    
                    <div class="booking-details">
                        <p><strong>Номер бронирования:</strong> <span class="booking-id">${bookingData.id}</span></p>
                        <p><strong>Дата заезда:</strong> ${formattedArrival}</p>
                        <p><strong>Дата выезда:</strong> ${formattedDeparture}</p>
                        <p><strong>Тип номера:</strong> ${bookingData.roomTypeText}</p>
                        <p><strong>Стоимость:</strong> ${bookingData.price.toLocaleString('ru-RU')} ₽</p>
                    </div>
                    
                    <p>Вы можете сохранить номер бронирования для дальнейших обращений.</p>
                `;
                
                // Сохраняем форму и показываем сообщение
                const formHTML = bookingForm.innerHTML;
                bookingForm.innerHTML = '';
                bookingForm.appendChild(successMessage);
                
                // Добавляем кнопку для повторного заполнения формы
                const resetButton = document.createElement('button');
                resetButton.className = 'btn btn-secondary';
                resetButton.textContent = 'Заполнить форму заново';
                resetButton.style.marginTop = '20px';
                bookingForm.appendChild(resetButton);
                
                resetButton.addEventListener('click', function() {
                    bookingForm.innerHTML = formHTML;
                    // Повторно инициализируем форму
                    setMinDates();
                    // Повторно привязываем обработчик события submit
                    const newForm = document.querySelector('.booking-form');
                    if (newForm) {
                        newForm.addEventListener('submit', arguments.callee.caller);
                    }
                });
                
                // Прокрутка к сообщению
                successMessage.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }
    
    // Функция валидации email
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    // Функция валидации телефона
    function validatePhone(phone) {
        // Разрешаем русский формат (+7...) и международный
        const re = /^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/;
        return re.test(phone);
    }
    
    // Анимация элементов при скролле
    const animatedElements = document.querySelectorAll('.service-card, .offer-card, .about-content, .room-card, .special-offer, .seasonal-offer');
    
    function checkIfInView() {
        animatedElements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementBottom = element.getBoundingClientRect().bottom;
            const isVisible = (elementTop < window.innerHeight) && (elementBottom > 0);
            
            if (isVisible) {
                element.classList.add('visible');
            }
        });
    }
    
    // Первоначальная проверка видимости элементов
    window.addEventListener('load', checkIfInView);
    window.addEventListener('scroll', checkIfInView);
    window.addEventListener('resize', checkIfInView);
    
    // Дополнительные стили для анимации при скролле и формы бронирования
    const style = document.createElement('style');
    style.innerHTML = `
        .service-card, .offer-card, .about-content, .room-card, .special-offer, .seasonal-offer {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .service-card.visible, .offer-card.visible, .about-content.visible, 
        .room-card.visible, .special-offer.visible, .seasonal-offer.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .booking-form.highlight {
            animation: highlight-pulse 1.5s;
        }
        
        @keyframes highlight-pulse {
            0% { box-shadow: 0 0 0 0 rgba(90, 143, 123, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(90, 143, 123, 0); }
            100% { box-shadow: 0 0 0 0 rgba(90, 143, 123, 0); }
        }
        
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
        }
        
        .success-message i {
            color: #28a745;
            font-size: 24px;
            margin-right: 10px;
        }
        
        .booking-form input.error, .booking-form select.error, .booking-form textarea.error {
            border-color: #dc3545;
        }
    `;
    document.head.appendChild(style);
    
    // Создаем отсутствующие страницы/заглушки при необходимости
    const currentPage = window.location.pathname.split('/').pop();
    
    // Проверяем ссылки на страницы, которых нет
    const allLinks = document.querySelectorAll('a');
    const availablePages = ['index.html', 'hotel.html', 'special.html', 'sauna.html', 'banquet.html'];
    
    allLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && href.endsWith('.html') && !href.includes('#') && !availablePages.some(page => href.includes(page))) {
            console.log("Ссылка на отсутствующую страницу:", href);
            
            // Добавляем обработчик для создания заглушки
            link.addEventListener('click', function(e) {
                e.preventDefault();
                alert(`Страница "${href}" находится в разработке. Пожалуйста, зайдите позже.`);
            });
        }
    });
}); 