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
$message_type = '';

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

// Обработка редактора контента
if ($action === 'content') {
    // Определяем раздел контента (по умолчанию - главная страница)
    $content_section = isset($_GET['section']) ? $_GET['section'] : 'main';
    
    // Подключаем шаблон редактора контента
    include 'templates/content_editor.php';
    exit;
}

// Обработка сохранения контента
if ($action === 'save_content') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $page = isset($_POST['page']) ? sanitize($_POST['page']) : '';
        
        // Проверяем, что страница указана
        if (empty($page)) {
            $message = 'Ошибка: не указана страница для сохранения';
            $message_type = 'error';
        } else {
            // Обработка загруженных изображений
            $uploaded_images = [];
            
            // Перебираем все загруженные файлы
            foreach ($_FILES as $field_name => $file_info) {
                if ($file_info['error'] === UPLOAD_ERR_OK && !empty($file_info['tmp_name'])) {
                    $file_name = $file_info['name'];
                    $file_tmp = $file_info['tmp_name'];
                    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                    
                    // Проверяем расширение файла
                    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    if (in_array($file_ext, $allowed_extensions)) {
                        // Генерируем уникальное имя файла
                        $new_file_name = uniqid() . '.' . $file_ext;
                        $upload_path = '../assets/images/' . $new_file_name;
                        
                        // Перемещаем файл в папку с изображениями
                        if (move_uploaded_file($file_tmp, $upload_path)) {
                            $uploaded_images[$field_name] = $new_file_name;
                        }
                    }
                }
            }
            
            // Сохраняем данные в JSON-файл
            $content_data = [];
            
            // Собираем все данные из POST-запроса
            foreach ($_POST as $key => $value) {
                if ($key !== 'page') {
                    $content_data[$key] = sanitize($value);
                }
            }
            
            // Добавляем информацию о загруженных изображениях
            foreach ($uploaded_images as $field_name => $file_name) {
                $content_data[$field_name] = $file_name;
            }
            
            // Добавляем дату обновления
            $content_data['updated_at'] = date('Y-m-d H:i:s');
            
            // Создаем директорию для хранения данных, если она не существует
            $data_dir = '../data';
            if (!is_dir($data_dir)) {
                mkdir($data_dir, 0755, true);
            }
            
            // Сохраняем данные в JSON-файл
            $json_file = $data_dir . '/content_' . $page . '.json';
            $json_data = json_encode($content_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
            if (file_put_contents($json_file, $json_data)) {
                // Обновляем HTML-файлы на основе шаблонов и данных
                updateHtmlFiles($page, $content_data);
                
                $message = 'Контент успешно сохранен';
                $message_type = 'success';
            } else {
                $message = 'Ошибка при сохранении контента';
                $message_type = 'error';
            }
        }
        
        // Перенаправляем обратно на страницу редактирования
        header('Location: index.php?action=content&section=' . $page . '&message=' . urlencode($message) . '&message_type=' . $message_type);
        exit;
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

// Функция для обновления HTML-файлов на основе шаблонов и данных
function updateHtmlFiles($page, $content_data) {
    // В зависимости от страницы обновляем соответствующие HTML-файлы
    switch ($page) {
        case 'main':
            updateMainPage($content_data);
            break;
        case 'hotel':
            updateHotelPage($content_data);
            break;
        case 'special':
            updateSpecialPage($content_data);
            break;
        case 'sauna':
            updateSaunaPage($content_data);
            break;
        case 'banquet':
            updateBanquetPage($content_data);
            break;
        case 'contacts':
            updateContactsInfo($content_data);
            break;
    }
}

// Функция для обновления главной страницы
function updateMainPage($content_data) {
    // Здесь должен быть код для обновления index.html
    // В реальном проекте это может быть более сложная логика с использованием шаблонизатора
    
    // Пример простой замены контента:
    $html_file = '../index.html';
    $html_content = file_get_contents($html_file);
    
    // Заменяем заголовок и подзаголовок слайдера
    if (isset($content_data['slider_title'])) {
        $html_content = preg_replace('/<h1>(.*?)<\/h1>/s', '<h1>' . $content_data['slider_title'] . '</h1>', $html_content);
    }
    
    if (isset($content_data['slider_subtitle'])) {
        $html_content = preg_replace('/<p>Идеальное место для отдыха(.*?)<\/p>/s', '<p>' . $content_data['slider_subtitle'] . '</p>', $html_content);
    }
    
    // Обновляем контактную информацию
    if (isset($content_data['contact_address'])) {
        $html_content = preg_replace('/г\. Москва, ул\. Лесная, д\. 10/', $content_data['contact_address'], $html_content);
    }
    
    if (isset($content_data['contact_phone'])) {
        $html_content = preg_replace('/\+7 \(495\) 123-45-67/', $content_data['contact_phone'], $html_content);
    }
    
    if (isset($content_data['contact_email'])) {
        $html_content = preg_replace('/info@lesnoy-dvorik\.ru/', $content_data['contact_email'], $html_content);
    }
    
    // Сохраняем обновленный HTML
    file_put_contents($html_file, $html_content);
}

// Функция для обновления страницы гостиницы
function updateHotelPage($content_data) {
    // Здесь должен быть код для обновления hotel.html
}

// Функция для обновления страницы спецпредложений
function updateSpecialPage($content_data) {
    // Здесь должен быть код для обновления special.html
}

// Функция для обновления страницы сауны
function updateSaunaPage($content_data) {
    // Здесь должен быть код для обновления sauna.html
}

// Функция для обновления страницы банкетного зала
function updateBanquetPage($content_data) {
    // Здесь должен быть код для обновления banquet.html
}

// Функция для обновления контактной информации на всех страницах
function updateContactsInfo($content_data) {
    // Обновляем контактную информацию на всех страницах
    $pages = ['index.html', 'hotel.html', 'special.html', 'sauna.html', 'banquet.html'];
    
    foreach ($pages as $page) {
        $html_file = '../' . $page;
        if (file_exists($html_file)) {
            $html_content = file_get_contents($html_file);
            
            // Обновляем адрес
            if (isset($content_data['contact_address'])) {
                $html_content = preg_replace('/г\. Москва, ул\. Лесная, д\. 10/', $content_data['contact_address'], $html_content);
            }
            
            // Обновляем телефон
            if (isset($content_data['contact_phone'])) {
                $html_content = preg_replace('/\+7 \(495\) 123-45-67/', $content_data['contact_phone'], $html_content);
            }
            
            // Обновляем email
            if (isset($content_data['contact_email'])) {
                $html_content = preg_replace('/info@lesnoy-dvorik\.ru/', $content_data['contact_email'], $html_content);
            }
            
            // Обновляем API-ключ Яндекс.Карт
            if (isset($content_data['map_api_key'])) {
                $html_content = preg_replace('/apikey=([^&]*)/', 'apikey=' . $content_data['map_api_key'], $html_content);
            }
            
            // Обновляем координаты на карте
            if (isset($content_data['map_coordinates'])) {
                $coordinates = explode(',', $content_data['map_coordinates']);
                if (count($coordinates) === 2) {
                    $lat = trim($coordinates[0]);
                    $lng = trim($coordinates[1]);
                    $html_content = preg_replace('/center: \[\d+\.\d+, \d+\.\d+\]/', 'center: [' . $lat . ', ' . $lng . ']', $html_content);
                    $html_content = preg_replace('/\[\d+\.\d+, \d+\.\d+\], {/', '[' . $lat . ', ' . $lng . '], {', $html_content);
                }
            }
            
            // Сохраняем обновленный HTML
            file_put_contents($html_file, $html_content);
        }
    }
}
?> 