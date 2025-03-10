-- SQL скрипт для создания базы данных для системы бронирования
-- Гостиница "Лесной дворик"

-- Создание таблицы бронирований
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` VARCHAR(20) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `arrival_date` DATE NOT NULL,
  `departure_date` DATE NOT NULL,
  `guests` INT NOT NULL,
  `room_type` VARCHAR(50) NOT NULL,
  `comments` TEXT,
  `payment_method` VARCHAR(50) NOT NULL DEFAULT 'cash',
  `promo_code` VARCHAR(50),
  `additional_services` TEXT,
  `price` DECIMAL(10,2) NOT NULL,
  `status` VARCHAR(50) NOT NULL DEFAULT 'Новое',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_arrival_date` (`arrival_date`),
  INDEX `idx_departure_date` (`departure_date`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Создание таблицы для пользователей админ-панели
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `role` VARCHAR(20) NOT NULL DEFAULT 'admin',
  `last_login` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Добавление демо пользователя (пароль: admin123)
-- ВНИМАНИЕ: В реальном проекте используйте безопасные пароли и хеширование!
INSERT INTO `admin_users` (`username`, `password`, `email`, `full_name`, `role`) 
VALUES ('admin', '$2y$10$1QM9sCcJK4r1bUY4ZDzNT.dD.m4mNcvEH0D5FRQ0xKo9c9EgmJxC6', 'admin@lesnoy-dvorik.ru', 'Администратор', 'admin');

-- Создание таблицы для хранения промокодов
CREATE TABLE IF NOT EXISTS `promo_codes` (
  `code` VARCHAR(50) NOT NULL,
  `discount_percent` INT NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `valid_from` DATE NOT NULL,
  `valid_to` DATE NOT NULL,
  `max_uses` INT DEFAULT NULL,
  `used_count` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Добавление демо промокодов
INSERT INTO `promo_codes` (`code`, `discount_percent`, `description`, `valid_from`, `valid_to`, `max_uses`) 
VALUES 
('WELCOME', 10, 'Скидка для новых гостей', '2023-01-01', '2025-12-31', NULL),
('SUMMER2025', 15, 'Летний отдых 2025', '2025-06-01', '2025-08-31', 100),
('FAMILY', 20, 'Семейная скидка', '2023-01-01', '2025-12-31', NULL),
('LONGSTAY', 25, 'Длительное проживание', '2023-01-01', '2025-12-31', NULL);

-- Создание таблицы для хранения типов номеров
CREATE TABLE IF NOT EXISTS `room_types` (
  `id` VARCHAR(50) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `base_price` DECIMAL(10,2) NOT NULL,
  `max_guests` INT NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Добавление типов номеров
INSERT INTO `room_types` (`id`, `name`, `description`, `base_price`, `max_guests`, `is_active`) 
VALUES 
('econom', 'Эконом', 'Уютный однокомнатный номер со всем необходимым для комфортного проживания.', 2500.00, 2, 1),
('standard', 'Стандарт', 'Просторный номер с двуспальной кроватью или двумя односпальными кроватями.', 3500.00, 2, 1),
('family', 'Семейный', 'Просторный номер для семейного отдыха с двуспальной кроватью и раскладным диваном.', 4500.00, 4, 1),
('comfort', 'Комфорт', 'Улучшенный номер с современным дизайном и повышенной комфортностью.', 5500.00, 2, 1),
('lux', 'Люкс', 'Роскошный двухкомнатный номер с отдельной гостиной и спальней.', 8000.00, 3, 1);

-- Создание таблицы для хранения дополнительных услуг
CREATE TABLE IF NOT EXISTS `additional_services` (
  `id` VARCHAR(50) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `is_per_day` TINYINT(1) NOT NULL DEFAULT 1,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Добавление дополнительных услуг
INSERT INTO `additional_services` (`id`, `name`, `description`, `price`, `is_per_day`, `is_active`) 
VALUES 
('breakfast', 'Завтрак', 'Завтрак (шведский стол) с 07:00 до 10:00', 500.00, 1, 1),
('dinner', 'Ужин', 'Ужин (комплексный) с 18:00 до 21:00', 700.00, 1, 1),
('sauna', 'Сауна', 'Посещение сауны (1 час)', 1500.00, 0, 1),
('transfer', 'Трансфер', 'Трансфер из города и обратно', 1000.00, 0, 1);

-- Создание таблицы для логирования изменений статусов бронирований
CREATE TABLE IF NOT EXISTS `booking_status_log` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `booking_id` VARCHAR(20) NOT NULL,
  `old_status` VARCHAR(50),
  `new_status` VARCHAR(50) NOT NULL,
  `admin_id` INT,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_booking_id` (`booking_id`),
  CONSTRAINT `fk_booking_status_log_booking_id` FOREIGN KEY (`booking_id`) 
  REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_booking_status_log_admin_id` FOREIGN KEY (`admin_id`) 
  REFERENCES `admin_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 