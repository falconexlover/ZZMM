<?php
/**
 * Страница подтверждения бронирования
 * Гостиница "Лесной дворик"
 */

// Запуск сессии для получения данных
session_start();

// Проверка наличия данных о бронировании
if (!isset($_SESSION['booking_success']) || !isset($_SESSION['booking_data'])) {
    // Если данных нет, перенаправляем на главную страницу
    header('Location: ../index.html');
    exit;
}

// Получение данных о бронировании
$bookingData = $_SESSION['booking_data'];

// Форматирование дат
$arrival_date = new DateTime($bookingData['arrival_date']);
$departure_date = new DateTime($bookingData['departure_date']);

$formatted_arrival = $arrival_date->format('d.m.Y');
$formatted_departure = $departure_date->format('d.m.Y');

// Расчет количества дней
$interval = $arrival_date->diff($departure_date);
$days = $interval->days;

// Определение названия типа номера
$room_types = [
    'econom' => 'Эконом',
    'standard' => 'Стандарт',
    'family' => 'Семейный',
    'comfort' => 'Комфорт',
    'lux' => 'Люкс'
];

$room_type_name = isset($room_types[$bookingData['room_type']]) 
    ? $room_types[$bookingData['room_type']] 
    : $bookingData['room_type'];

// Определение способа оплаты
$payment_methods = [
    'card' => 'Банковская карта',
    'cash' => 'Наличными при заселении',
    'bank-transfer' => 'Банковский перевод'
];

$payment_method_name = isset($payment_methods[$bookingData['payment_method']]) 
    ? $payment_methods[$bookingData['payment_method']] 
    : $bookingData['payment_method'];

// Очистка данных сессии после использования
unset($_SESSION['booking_success']);
unset($_SESSION['booking_data']);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подтверждение бронирования | Гостиница "Лесной дворик"</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .confirmation-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        
        .confirmation-header {
            text-align: center;
            margin-bottom: 30px;
            color: #5a8f7b;
        }
        
        .confirmation-header i {
            font-size: 60px;
            margin-bottom: 20px;
            color: #5a8f7b;
        }
        
        .booking-id {
            display: inline-block;
            padding: 10px 20px;
            background-color: #5a8f7b;
            color: white;
            font-weight: bold;
            border-radius: 4px;
            margin: 15px 0;
            font-size: 18px;
        }
        
        .booking-details {
            margin: 30px 0;
            border: 1px solid #eee;
            border-radius: 5px;
            padding: 20px;
        }
        
        .booking-details h3 {
            margin-bottom: 20px;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 15px;
            align-items: baseline;
        }
        
        .detail-row strong {
            width: 200px;
            flex-shrink: 0;
        }
        
        .price {
            font-size: 24px;
            color: #5a8f7b;
            font-weight: bold;
        }
        
        .next-steps {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-top: 30px;
        }
        
        .next-steps h3 {
            margin-bottom: 15px;
        }
        
        .next-steps ul {
            margin-left: 20px;
            margin-bottom: 20px;
        }
        
        .next-steps li {
            margin-bottom: 10px;
        }
        
        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        @media print {
            .no-print {
                display: none;
            }
            
            body {
                font-size: 14px;
            }
            
            .confirmation-container {
                box-shadow: none;
                padding: 0;
            }
        }
        
        @media (max-width: 768px) {
            .detail-row {
                flex-direction: column;
            }
            
            .detail-row strong {
                width: 100%;
                margin-bottom: 5px;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .actions .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <a href="index.html">
                    <img src="assets/images/logo.png" alt="Лесной дворик">
                </a>
            </div>
            <nav class="main-menu">
                <ul>
                    <li><a href="index.html#about">О нас</a></li>
                    <li class="dropdown">
                        <a href="hotel.html">Гостиница</a>
                        <div class="dropdown-content">
                            <a href="hotel.html#econom">Эконом</a>
                            <a href="hotel.html#standard">Стандарт</a>
                            <a href="hotel.html#family">Семейные</a>
                            <a href="hotel.html#comfort">Комфорт</a>
                            <a href="hotel.html#lux">Люкс</a>
                        </div>
                    </li>
                    <li><a href="sauna.html">Сауна</a></li>
                    <li><a href="banquet.html">Банкетный зал</a></li>
                    <li><a href="special.html">Спецпредложения</a></li>
                    <li><a href="index.html#contacts">Контакты</a></li>
                </ul>
            </nav>
            <div class="booking-button">
                <a href="index.html#booking" class="btn btn-primary">Забронировать</a>
            </div>
            <button class="mobile-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>
    
    <main>
        <div class="confirmation-container">
            <div class="confirmation-header">
                <i class="fas fa-check-circle"></i>
                <h1>Бронирование успешно оформлено!</h1>
                <p>Благодарим вас за выбор гостиницы "Лесной дворик"</p>
                <div class="booking-id"><?php echo htmlspecialchars($bookingData['id']); ?></div>
            </div>
            
            <p>Уважаемый(ая) <strong><?php echo htmlspecialchars($bookingData['name']); ?></strong>, ваша заявка на бронирование номера успешно принята. В ближайшее время наш менеджер свяжется с вами для подтверждения деталей бронирования.</p>
            
            <div class="booking-details">
                <h3>Информация о бронировании</h3>
                
                <div class="detail-row">
                    <strong>Дата заезда:</strong>
                    <span><?php echo $formatted_arrival; ?></span>
                </div>
                
                <div class="detail-row">
                    <strong>Дата выезда:</strong>
                    <span><?php echo $formatted_departure; ?></span>
                </div>
                
                <div class="detail-row">
                    <strong>Количество ночей:</strong>
                    <span><?php echo $days; ?></span>
                </div>
                
                <div class="detail-row">
                    <strong>Количество гостей:</strong>
                    <span><?php echo htmlspecialchars($bookingData['guests']); ?></span>
                </div>
                
                <div class="detail-row">
                    <strong>Тип номера:</strong>
                    <span><?php echo htmlspecialchars($room_type_name); ?></span>
                </div>
                
                <?php if (!empty($bookingData['additional_services'])): ?>
                <div class="detail-row">
                    <strong>Дополнительные услуги:</strong>
                    <span><?php echo htmlspecialchars($bookingData['additional_services']); ?></span>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($bookingData['promo_code'])): ?>
                <div class="detail-row">
                    <strong>Промокод:</strong>
                    <span><?php echo htmlspecialchars($bookingData['promo_code']); ?></span>
                </div>
                <?php endif; ?>
                
                <div class="detail-row">
                    <strong>Способ оплаты:</strong>
                    <span><?php echo htmlspecialchars($payment_method_name); ?></span>
                </div>
                
                <div class="detail-row">
                    <strong>Стоимость:</strong>
                    <span class="price"><?php echo number_format($bookingData['price'], 0, '.', ' '); ?> ₽</span>
                </div>
            </div>
            
            <div class="next-steps">
                <h3>Что дальше?</h3>
                <ul>
                    <li>Сохраните номер бронирования для дальнейших обращений</li>
                    <li>Мы свяжемся с вами по телефону <?php echo htmlspecialchars($bookingData['phone']); ?> для подтверждения деталей бронирования</li>
                    <li>После подтверждения вы получите электронное письмо с подробной информацией о бронировании на указанный email</li>
                    <?php if ($bookingData['payment_method'] === 'bank-transfer'): ?>
                    <li>Для оплаты банковским переводом, в письме будут указаны реквизиты для оплаты</li>
                    <?php endif; ?>
                    <li>Заезд осуществляется после 14:00, выезд до 12:00</li>
                </ul>
                
                <p>По любым вопросам вы можете связаться с нами:</p>
                <p><i class="fas fa-phone"></i> <a href="tel:+74951234567">+7 (495) 123-45-67</a></p>
                <p><i class="fas fa-envelope"></i> <a href="mailto:info@lesnoy-dvorik.ru">info@lesnoy-dvorik.ru</a></p>
            </div>
            
            <div class="actions no-print">
                <button onclick="window.print()" class="btn btn-secondary"><i class="fas fa-print"></i> Распечатать</button>
                <a href="index.html" class="btn btn-primary">Вернуться на главную</a>
            </div>
        </div>
    </main>
    
    <footer class="no-print">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="assets/images/logo.png" alt="Лесной дворик">
                    <p>Гостиница "Лесной дворик" - уютное место для отдыха в гармонии с природой</p>
                </div>
                <div class="footer-links">
                    <h3>Навигация</h3>
                    <ul>
                        <li><a href="index.html#about">О нас</a></li>
                        <li><a href="hotel.html">Гостиница</a></li>
                        <li><a href="sauna.html">Сауна</a></li>
                        <li><a href="banquet.html">Банкетный зал</a></li>
                        <li><a href="special.html">Спецпредложения</a></li>
                        <li><a href="index.html#contacts">Контакты</a></li>
                    </ul>
                </div>
                <div class="footer-contacts">
                    <h3>Свяжитесь с нами</h3>
                    <p><i class="fas fa-phone"></i> <a href="tel:+74951234567">+7 (495) 123-45-67</a></p>
                    <p><i class="fas fa-envelope"></i> <a href="mailto:info@lesnoy-dvorik.ru">info@lesnoy-dvorik.ru</a></p>
                    <p><i class="fas fa-map-marker-alt"></i> г. Москва, ул. Лесная, д. 10</p>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 Гостиница "Лесной дворик". Все права защищены.</p>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html> 