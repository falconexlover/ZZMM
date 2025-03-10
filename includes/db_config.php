<?php
/**
 * Конфигурационный файл для подключения к базе данных на хостинге Beget
 * Используется для управления бронированиями в гостинице "Лесной дворик"
 */

// Параметры подключения к базе данных на Beget
// ВНИМАНИЕ: Перед загрузкой на хостинг замените эти значения на реальные
$db_host = 'localhost'; // Обычно для Beget это localhost
$db_name = 'db_hotel'; // Замените на имя базы данных, обычно начинается с вашего логина на Beget
$db_user = 'db_user'; // Замените на пользователя БД (обычно также начинается с логина на Beget)
$db_pass = 'db_password'; // Замените на пароль от базы данных

// Создание соединения с базой данных
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    // Установка режима обработки ошибок
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Установка режима получения данных по умолчанию
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // В реальном проекте лучше логировать ошибки, а не выводить их напрямую
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

// Функция для защиты от SQL-инъекций (дополнительная защита, PDO уже использует подготовленные запросы)
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Функция для проверки авторизации администратора
function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Функция для добавления нового бронирования в БД
function addBooking($pdo, $bookingData) {
    try {
        $sql = "INSERT INTO bookings (
                id, name, phone, email, 
                arrival_date, departure_date, guests, 
                room_type, comments, payment_method, 
                promo_code, price, status, created_at
            ) VALUES (
                :id, :name, :phone, :email, 
                :arrival_date, :departure_date, :guests, 
                :room_type, :comments, :payment_method, 
                :promo_code, :price, :status, NOW()
            )";
            
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':id', $bookingData['id']);
        $stmt->bindParam(':name', $bookingData['name']);
        $stmt->bindParam(':phone', $bookingData['phone']);
        $stmt->bindParam(':email', $bookingData['email']);
        $stmt->bindParam(':arrival_date', $bookingData['arrival_date']);
        $stmt->bindParam(':departure_date', $bookingData['departure_date']);
        $stmt->bindParam(':guests', $bookingData['guests']);
        $stmt->bindParam(':room_type', $bookingData['room_type']);
        $stmt->bindParam(':comments', $bookingData['comments']);
        $stmt->bindParam(':payment_method', $bookingData['payment_method']);
        $stmt->bindParam(':promo_code', $bookingData['promo_code']);
        $stmt->bindParam(':price', $bookingData['price']);
        $stmt->bindParam(':status', $bookingData['status']);
        
        return $stmt->execute();
    } catch (PDOException $e) {
        // Логирование ошибки
        error_log("Ошибка при добавлении бронирования: " . $e->getMessage());
        return false;
    }
}

// Функция для получения всех бронирований из БД
function getAllBookings($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM bookings ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Ошибка при получении бронирований: " . $e->getMessage());
        return [];
    }
}

// Функция для получения бронирования по ID
function getBookingById($pdo, $id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Ошибка при получении бронирования: " . $e->getMessage());
        return null;
    }
}

// Функция для обновления статуса бронирования
function updateBookingStatus($pdo, $id, $status) {
    try {
        $stmt = $pdo->prepare("UPDATE bookings SET status = :status, updated_at = NOW() WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Ошибка при обновлении статуса бронирования: " . $e->getMessage());
        return false;
    }
}

// Функция для удаления бронирования
function deleteBooking($pdo, $id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Ошибка при удалении бронирования: " . $e->getMessage());
        return false;
    }
}

// Функция для получения статистики бронирований
function getBookingStats($pdo) {
    try {
        $stats = [];
        
        // Общее количество бронирований
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM bookings");
        $stmt->execute();
        $stats['total'] = $stmt->fetch()['total'];
        
        // Количество новых бронирований
        $stmt = $pdo->prepare("SELECT COUNT(*) as new FROM bookings WHERE status = 'Новое'");
        $stmt->execute();
        $stats['new'] = $stmt->fetch()['new'];
        
        // Количество подтвержденных бронирований
        $stmt = $pdo->prepare("SELECT COUNT(*) as confirmed FROM bookings WHERE status = 'Подтверждено'");
        $stmt->execute();
        $stats['confirmed'] = $stmt->fetch()['confirmed'];
        
        // Общая сумма от бронирований
        $stmt = $pdo->prepare("SELECT SUM(price) as total_revenue FROM bookings WHERE status != 'Отменено'");
        $stmt->execute();
        $stats['total_revenue'] = $stmt->fetch()['total_revenue'];
        
        // Самый популярный тип номера
        $stmt = $pdo->prepare("SELECT room_type, COUNT(*) as count FROM bookings GROUP BY room_type ORDER BY count DESC LIMIT 1");
        $stmt->execute();
        $popularRoom = $stmt->fetch();
        $stats['popular_room'] = $popularRoom ? $popularRoom['room_type'] : '';
        
        return $stats;
    } catch (PDOException $e) {
        error_log("Ошибка при получении статистики: " . $e->getMessage());
        return [];
    }
}

// Функция для экспорта бронирований в CSV
function exportBookingsToCSV($pdo) {
    try {
        $filename = 'bookings_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        // Получение всех бронирований
        $stmt = $pdo->prepare("SELECT * FROM bookings ORDER BY created_at DESC");
        $stmt->execute();
        $bookings = $stmt->fetchAll();
        
        // Формирование заголовков CSV
        $headers = [
            'ID', 'Имя', 'Телефон', 'Email', 
            'Дата заезда', 'Дата выезда', 'Гостей', 
            'Тип номера', 'Комментарии', 'Способ оплаты', 
            'Промокод', 'Цена', 'Статус', 'Создано'
        ];
        
        // Открываем файл для записи
        $fp = fopen('php://temp', 'w');
        
        // Добавляем заголовки
        fputcsv($fp, $headers);
        
        // Добавляем данные
        foreach ($bookings as $booking) {
            fputcsv($fp, [
                $booking['id'],
                $booking['name'],
                $booking['phone'],
                $booking['email'],
                $booking['arrival_date'],
                $booking['departure_date'],
                $booking['guests'],
                $booking['room_type'],
                $booking['comments'],
                $booking['payment_method'],
                $booking['promo_code'],
                $booking['price'],
                $booking['status'],
                $booking['created_at']
            ]);
        }
        
        // Перемещаем указатель в начало
        rewind($fp);
        
        // Считываем содержимое
        $output = stream_get_contents($fp);
        fclose($fp);
        
        return [
            'filename' => $filename,
            'content' => $output
        ];
    } catch (PDOException $e) {
        error_log("Ошибка при экспорте бронирований: " . $e->getMessage());
        return null;
    }
} 