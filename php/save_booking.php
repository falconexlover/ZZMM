<?php
/**
 * Обработка данных формы бронирования
 * Гостиница "Лесной дворик"
 */

// Запуск сессии для передачи сообщений между страницами
session_start();

// Подключение конфигурации БД
require_once '../includes/db_config.php';

// Проверка метода запроса
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Если это не POST-запрос, перенаправляем на главную страницу
    header('Location: index.html');
    exit;
}

// Обработка данных формы
try {
    // Проверяем, что все обязательные поля заполнены
    $required_fields = ['name', 'phone', 'email', 'arrival_date', 'departure_date', 'guests', 'room_type', 'privacy_agreed'];
    
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            throw new Exception("Поле " . $field . " обязательно для заполнения");
        }
    }
    
    // Проверка политики конфиденциальности
    if (!isset($_POST['privacy_agreed']) || $_POST['privacy_agreed'] !== '1') {
        throw new Exception("Необходимо согласиться с политикой конфиденциальности");
    }
    
    // Проверка дат
    $arrival_date = new DateTime($_POST['arrival_date']);
    $departure_date = new DateTime($_POST['departure_date']);
    $today = new DateTime();
    $today->setTime(0, 0, 0); // Сбрасываем время, чтобы сравнивать только даты
    
    if ($arrival_date < $today) {
        throw new Exception("Дата заезда не может быть в прошлом");
    }
    
    if ($departure_date <= $arrival_date) {
        throw new Exception("Дата выезда должна быть после даты заезда");
    }
    
    // Проверка количества гостей
    $guests = (int)$_POST['guests'];
    if ($guests <= 0 || $guests > 10) {
        throw new Exception("Некорректное количество гостей");
    }
    
    // Санитизация входных данных
    $name = sanitize($_POST['name']);
    $phone = sanitize($_POST['phone']);
    $email = sanitize($_POST['email']);
    $arrival_date = $_POST['arrival_date'];
    $departure_date = $_POST['departure_date'];
    $room_type = sanitize($_POST['room_type']);
    $comments = isset($_POST['comments']) ? sanitize($_POST['comments']) : '';
    $payment_method = isset($_POST['payment_method']) ? sanitize($_POST['payment_method']) : 'cash';
    $promo_code = isset($_POST['promo_code']) ? sanitize($_POST['promo_code']) : '';
    
    // Получение дополнительных услуг
    $additional_services = [];
    $available_services = ['breakfast', 'dinner', 'sauna', 'transfer'];
    
    foreach ($available_services as $service) {
        if (isset($_POST[$service]) && $_POST[$service] === '1') {
            $additional_services[] = $service;
        }
    }
    
    // Формирование строки с дополнительными услугами
    $additional_services_str = implode(', ', $additional_services);
    
    // Рассчитываем стоимость бронирования
    $price = calculatePrice(
        $arrival_date, 
        $departure_date, 
        $room_type, 
        $additional_services, 
        $promo_code
    );
    
    // Генерация уникального ID бронирования
    $booking_id = 'BK-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
    
    // Формирование данных для сохранения в БД
    $bookingData = [
        'id' => $booking_id,
        'name' => $name,
        'phone' => $phone,
        'email' => $email,
        'arrival_date' => $arrival_date,
        'departure_date' => $departure_date,
        'guests' => $guests,
        'room_type' => $room_type,
        'comments' => $comments,
        'payment_method' => $payment_method,
        'promo_code' => $promo_code,
        'additional_services' => $additional_services_str,
        'price' => $price,
        'status' => 'Новое'
    ];
    
    // Сохранение данных в БД
    $saved = addBooking($pdo, $bookingData);
    
    if (!$saved) {
        throw new Exception("Произошла ошибка при сохранении бронирования. Попробуйте позже или свяжитесь с нами по телефону.");
    }
    
    // Отправка уведомления администратору (опционально)
    $to = 'admin@lesnoy-dvorik.ru'; // Замените на свой email
    $subject = 'Новое бронирование: ' . $booking_id;
    $message = "Новое бронирование номера:\n\n";
    $message .= "ID: " . $booking_id . "\n";
    $message .= "Имя: " . $name . "\n";
    $message .= "Телефон: " . $phone . "\n";
    $message .= "Email: " . $email . "\n";
    $message .= "Заезд: " . $arrival_date . "\n";
    $message .= "Выезд: " . $departure_date . "\n";
    $message .= "Гостей: " . $guests . "\n";
    $message .= "Тип номера: " . $room_type . "\n";
    $message .= "Стоимость: " . $price . " руб.\n";
    
    // Отправка email (закомментировано для тестирования)
    // mail($to, $subject, $message);
    
    // Сохранение данных в сессии для отображения на странице подтверждения
    $_SESSION['booking_success'] = true;
    $_SESSION['booking_data'] = $bookingData;
    
    // Перенаправление на страницу подтверждения
    header('Location: booking-confirmation.php');
    exit;
    
} catch (Exception $e) {
    // В случае ошибки сохраняем сообщение об ошибке в сессию
    $_SESSION['booking_error'] = $e->getMessage();
    
    // Сохраняем введенные данные для возможности их восстановления
    $_SESSION['form_data'] = $_POST;
    
    // Перенаправление назад на страницу с формой
    header('Location: index.html#booking');
    exit;
}

/**
 * Функция расчета стоимости проживания
 */
function calculatePrice($arrival_date, $departure_date, $room_type, $additional_services, $promo_code = '') {
    // Базовые цены номеров
    $room_prices = [
        'econom' => 2500,
        'standard' => 3500,
        'family' => 4500,
        'comfort' => 5500,
        'lux' => 8000
    ];
    
    // Стоимость дополнительных услуг
    $service_prices = [
        'breakfast' => 500,
        'dinner' => 700,
        'sauna' => 1500,
        'transfer' => 1000
    ];
    
    // Промокоды и скидки (в процентах)
    $promo_codes = [
        'WELCOME' => 10,
        'SUMMER2025' => 15,
        'FAMILY' => 20,
        'LONGSTAY' => 25
    ];
    
    // Рассчитываем количество дней
    $date1 = new DateTime($arrival_date);
    $date2 = new DateTime($departure_date);
    $interval = $date1->diff($date2);
    $days = $interval->days;
    
    // Проверка на корректность дат
    if ($days <= 0) {
        return 0;
    }
    
    // Базовая стоимость номера
    $base_price = isset($room_prices[$room_type]) ? $room_prices[$room_type] : 3500;
    $total_price = $base_price * $days;
    
    // Добавляем стоимость дополнительных услуг
    foreach ($additional_services as $service) {
        if (isset($service_prices[$service])) {
            // Дополнительные услуги добавляются за каждый день
            $total_price += $service_prices[$service] * $days;
        }
    }
    
    // Применяем промокод, если он действителен
    $promo_code = strtoupper($promo_code);
    if (!empty($promo_code) && isset($promo_codes[$promo_code])) {
        $discount_percentage = $promo_codes[$promo_code];
        $discount_amount = ($total_price * $discount_percentage) / 100;
        $total_price -= $discount_amount;
    }
    
    // Скидка в будние дни (с понедельника по четверг)
    $weekday = $date1->format('N'); // 1 (понедельник) до 7 (воскресенье)
    if ($weekday >= 1 && $weekday <= 4) {
        $weekday_discount = ($total_price * 10) / 100; // 10% скидка
        $total_price -= $weekday_discount;
    }
    
    // Скидка при длительном проживании
    if ($days >= 7) {
        $long_stay_discount = ($total_price * 5) / 100; // 5% дополнительная скидка
        $total_price -= $long_stay_discount;
    }
    
    return round($total_price); // Округляем до целого числа
}
?> 