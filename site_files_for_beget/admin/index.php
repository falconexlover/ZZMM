<?php
/**
 * Административная панель для управления бронированиями
 * Гостиница "Лесной дворик"
 */

// Запуск сессии для авторизации
session_start();

// Подключение конфигурации БД
require_once '../db_config.php';

// Проверка авторизации
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Если не авторизованы и отправлена форма авторизации
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'], $_POST['password'])) {
        // Простая проверка логина и пароля (в реальном проекте лучше использовать хеширование)
        // ВНИМАНИЕ: Измените эти значения перед использованием!
        $admin_login = 'admin';
        $admin_password = 'password123';
        
        if ($_POST['login'] === $admin_login && $_POST['password'] === $admin_password) {
            $_SESSION['admin_logged_in'] = true;
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $error = 'Неверный логин или пароль';
        }
    }
    
    // Показать форму авторизации
    include 'login_form.php';
    exit;
}

// Обработка действий
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$message = '';

// Обработка выхода из системы
if ($action === 'logout') {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Обработка обновления статуса бронирования
if ($action === 'update_status' && isset($_POST['booking_id'], $_POST['status'])) {
    $booking_id = sanitize($_POST['booking_id']);
    $status = sanitize($_POST['status']);
    
    if (updateBookingStatus($pdo, $booking_id, $status)) {
        $message = 'Статус бронирования успешно обновлен';
    } else {
        $message = 'Ошибка при обновлении статуса бронирования';
    }
    
    // Перенаправление на список после действия
    header('Location: index.php?message=' . urlencode($message));
    exit;
}

// Обработка удаления бронирования
if ($action === 'delete' && isset($_GET['id'])) {
    $booking_id = sanitize($_GET['id']);
    
    if (deleteBooking($pdo, $booking_id)) {
        $message = 'Бронирование успешно удалено';
    } else {
        $message = 'Ошибка при удалении бронирования';
    }
    
    // Перенаправление на список после действия
    header('Location: index.php?message=' . urlencode($message));
    exit;
}

// Обработка экспорта в CSV
if ($action === 'export_csv') {
    $export = exportBookingsToCSV($pdo);
    
    if ($export) {
        // Установка заголовков для скачивания файла
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $export['filename'] . '"');
        
        // Вывод содержимого CSV
        echo $export['content'];
        exit;
    } else {
        $message = 'Ошибка при экспорте бронирований';
    }
}

// Получение данных из БД в зависимости от действия
switch ($action) {
    case 'view':
        if (isset($_GET['id'])) {
            $booking_id = sanitize($_GET['id']);
            $booking = getBookingById($pdo, $booking_id);
            
            if (!$booking) {
                $message = 'Бронирование не найдено';
                // Перенаправление на список, если бронирование не найдено
                header('Location: index.php?message=' . urlencode($message));
                exit;
            }
        } else {
            header('Location: index.php');
            exit;
        }
        break;
        
    case 'stats':
        $stats = getBookingStats($pdo);
        break;
        
    case 'list':
    default:
        // Получение всех бронирований
        $bookings = getAllBookings($pdo);
        
        // Получение сообщения из URL, если есть
        if (isset($_GET['message'])) {
            $message = $_GET['message'];
        }
        break;
}

// Отображение сообщений
if (!empty($message)) {
    echo '<div class="alert">' . htmlspecialchars($message) . '</div>';
}

// Отображение соответствующего шаблона
switch ($action) {
    case 'view':
        include 'templates/booking_detail.php';
        break;
        
    case 'stats':
        include 'templates/booking_stats.php';
        break;
        
    case 'list':
    default:
        include 'templates/booking_list.php';
        break;
}
?> 