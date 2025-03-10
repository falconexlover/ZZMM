<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление номерами | Гостиница "Лесной дворик"</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Боковое меню -->
        <?php include 'sidebar.php'; ?>
        
        <!-- Основное содержимое -->
        <div class="content">
            <div class="header">
                <h1><i class="fas fa-bed"></i> Управление номерами</h1>
                <div class="user-info">
                    <span>Администратор</span>
                    <a href="?action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Выйти</a>
                </div>
            </div>
            
            <!-- Вкладки -->
            <div class="room-tabs">
                <a href="?action=rooms&tab=list" class="tab <?php echo (!isset($_GET['tab']) || $_GET['tab'] == 'list') ? 'active' : ''; ?>">
                    <i class="fas fa-list"></i> Список номеров
                </a>
                <a href="?action=rooms&tab=types" class="tab <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'types') ? 'active' : ''; ?>">
                    <i class="fas fa-tags"></i> Типы номеров
                </a>
                <a href="?action=rooms&tab=prices" class="tab <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'prices') ? 'active' : ''; ?>">
                    <i class="fas fa-ruble-sign"></i> Цены и сезоны
                </a>
                <a href="?action=rooms&tab=availability" class="tab <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'availability') ? 'active' : ''; ?>">
                    <i class="fas fa-calendar-alt"></i> Доступность
                </a>
            </div>
            
            <!-- Список номеров (по умолчанию) -->
            <?php if (!isset($_GET['tab']) || $_GET['tab'] == 'list'): ?>
                <div class="tab-content">
                    <div class="action-bar">
                        <div class="search-bar">
                            <input type="text" placeholder="Поиск по номеру или типу...">
                            <button><i class="fas fa-search"></i></button>
                        </div>
                        <a href="?action=rooms&tab=list&add=1" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Добавить номер
                        </a>
                    </div>
                    
                    <!-- Таблица номеров -->
                    <div class="table-responsive">
                        <table class="admin-table rooms-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Номер</th>
                                    <th>Тип</th>
                                    <th>Этаж</th>
                                    <th>Вместимость</th>
                                    <th>Базовая цена</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Пример данных (в реальном проекте будет запрос к БД)
                                $roomsList = [
                                    ['id' => 1, 'number' => '101', 'type' => 'Эконом', 'floor' => 1, 'capacity' => 2, 'price' => 2500, 'status' => 'Свободен'],
                                    ['id' => 2, 'number' => '102', 'type' => 'Стандарт', 'floor' => 1, 'capacity' => 2, 'price' => 3500, 'status' => 'Занят'],
                                    ['id' => 3, 'number' => '103', 'type' => 'Семейный', 'floor' => 1, 'capacity' => 4, 'price' => 4500, 'status' => 'Свободен'],
                                    ['id' => 4, 'number' => '201', 'type' => 'Комфорт', 'floor' => 2, 'capacity' => 2, 'price' => 5500, 'status' => 'Уборка'],
                                    ['id' => 5, 'number' => '202', 'type' => 'Люкс', 'floor' => 2, 'capacity' => 2, 'price' => 8000, 'status' => 'Свободен'],
                                ];
                                
                                foreach ($roomsList as $room):
                                    $statusClass = strtolower($room['status']);
                                    switch ($room['status']) {
                                        case 'Свободен': $statusClass = 'available'; break;
                                        case 'Занят': $statusClass = 'occupied'; break;
                                        case 'Уборка': $statusClass = 'cleaning'; break;
                                        case 'Ремонт': $statusClass = 'maintenance'; break;
                                    }
                                ?>
                                <tr>
                                    <td><?php echo $room['id']; ?></td>
                                    <td><?php echo htmlspecialchars($room['number']); ?></td>
                                    <td><?php echo htmlspecialchars($room['type']); ?></td>
                                    <td><?php echo $room['floor']; ?></td>
                                    <td><?php echo $room['capacity']; ?> чел.</td>
                                    <td><?php echo number_format($room['price'], 0, '.', ' '); ?> ₽</td>
                                    <td>
                                        <span class="status-badge status-<?php echo $statusClass; ?>">
                                            <?php echo htmlspecialchars($room['status']); ?>
                                        </span>
                                    </td>
                                    <td class="actions">
                                        <a href="?action=rooms&tab=list&edit=<?php echo $room['id']; ?>" class="btn-icon" title="Редактировать">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?action=rooms&tab=list&gallery=<?php echo $room['id']; ?>" class="btn-icon" title="Фотогалерея">
                                            <i class="fas fa-images"></i>
                                        </a>
                                        <a href="?action=rooms&tab=list&view=<?php echo $room['id']; ?>" class="btn-icon" title="Просмотр">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="?action=rooms&tab=list&delete=<?php echo $room['id']; ?>" class="btn-icon btn-danger" title="Удалить" 
                                           onclick="return confirm('Вы уверены, что хотите удалить этот номер?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Пагинация -->
                    <div class="pagination">
                        <a href="#" class="page-link disabled">&laquo;</a>
                        <a href="#" class="page-link active">1</a>
                        <a href="#" class="page-link">2</a>
                        <a href="#" class="page-link">3</a>
                        <a href="#" class="page-link">&raquo;</a>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Типы номеров -->
            <?php if (isset($_GET['tab']) && $_GET['tab'] == 'types'): ?>
                <div class="tab-content">
                    <div class="action-bar">
                        <div class="search-bar">
                            <input type="text" placeholder="Поиск по типу номера...">
                            <button><i class="fas fa-search"></i></button>
                        </div>
                        <a href="?action=rooms&tab=types&add=1" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Добавить тип
                        </a>
                    </div>
                    
                    <!-- Таблица типов номеров -->
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Описание</th>
                                    <th>Макс. вместимость</th>
                                    <th>Базовая цена</th>
                                    <th>Кол-во номеров</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Пример данных (в реальном проекте будет запрос к БД)
                                $roomTypes = [
                                    ['id' => 1, 'name' => 'Эконом', 'description' => 'Бюджетный номер со всеми удобствами', 'capacity' => 2, 'price' => 2500, 'count' => 5],
                                    ['id' => 2, 'name' => 'Стандарт', 'description' => 'Стандартный номер с балконом', 'capacity' => 2, 'price' => 3500, 'count' => 8],
                                    ['id' => 3, 'name' => 'Семейный', 'description' => 'Просторный номер для всей семьи', 'capacity' => 4, 'price' => 4500, 'count' => 3],
                                    ['id' => 4, 'name' => 'Комфорт', 'description' => 'Улучшенный номер с дополнительными удобствами', 'capacity' => 2, 'price' => 5500, 'count' => 4],
                                    ['id' => 5, 'name' => 'Люкс', 'description' => 'Роскошный номер с отдельной гостиной', 'capacity' => 2, 'price' => 8000, 'count' => 2],
                                ];
                                
                                foreach ($roomTypes as $type):
                                ?>
                                <tr>
                                    <td><?php echo $type['id']; ?></td>
                                    <td><?php echo htmlspecialchars($type['name']); ?></td>
                                    <td><?php echo htmlspecialchars($type['description']); ?></td>
                                    <td><?php echo $type['capacity']; ?> чел.</td>
                                    <td><?php echo number_format($type['price'], 0, '.', ' '); ?> ₽</td>
                                    <td><?php echo $type['count']; ?></td>
                                    <td class="actions">
                                        <a href="?action=rooms&tab=types&edit=<?php echo $type['id']; ?>" class="btn-icon" title="Редактировать">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?action=rooms&tab=types&features=<?php echo $type['id']; ?>" class="btn-icon" title="Особенности">
                                            <i class="fas fa-clipboard-list"></i>
                                        </a>
                                        <a href="?action=rooms&tab=types&delete=<?php echo $type['id']; ?>" class="btn-icon btn-danger" title="Удалить" 
                                           onclick="return confirm('Вы уверены, что хотите удалить этот тип номера? Это может повлиять на существующие номера.');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Цены и сезоны -->
            <?php if (isset($_GET['tab']) && $_GET['tab'] == 'prices'): ?>
                <div class="tab-content">
                    <div class="action-bar">
                        <div class="filter-group">
                            <label for="price-year">Год:</label>
                            <select id="price-year">
                                <option value="2024" selected>2024</option>
                                <option value="2025">2025</option>
                            </select>
                        </div>
                        <div class="action-buttons">
                            <a href="?action=rooms&tab=prices&add_season=1" class="btn btn-secondary">
                                <i class="fas fa-plus"></i> Добавить сезон
                            </a>
                            <a href="?action=rooms&tab=prices&copy_prices=1" class="btn btn-secondary">
                                <i class="fas fa-copy"></i> Копировать цены
                            </a>
                        </div>
                    </div>
                    
                    <!-- Таблица сезонов -->
                    <div class="seasons-section">
                        <h3>Сезоны</h3>
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Название</th>
                                        <th>Период</th>
                                        <th>Множитель цены</th>
                                        <th>Цветовой код</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Низкий сезон</td>
                                        <td>10.01.2024 — 30.04.2024</td>
                                        <td>x1.0</td>
                                        <td><span class="color-sample" style="background-color: #4CAF50;"></span> #4CAF50</td>
                                        <td class="actions">
                                            <a href="#" class="btn-icon" title="Редактировать"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="btn-icon btn-danger" title="Удалить"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Средний сезон</td>
                                        <td>01.05.2024 — 15.06.2024</td>
                                        <td>x1.2</td>
                                        <td><span class="color-sample" style="background-color: #2196F3;"></span> #2196F3</td>
                                        <td class="actions">
                                            <a href="#" class="btn-icon" title="Редактировать"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="btn-icon btn-danger" title="Удалить"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Высокий сезон</td>
                                        <td>16.06.2024 — 31.08.2024</td>
                                        <td>x1.5</td>
                                        <td><span class="color-sample" style="background-color: #F44336;"></span> #F44336</td>
                                        <td class="actions">
                                            <a href="#" class="btn-icon" title="Редактировать"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="btn-icon btn-danger" title="Удалить"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Таблица цен по типам номеров -->
                    <div class="prices-section">
                        <h3>Цены по типам номеров</h3>
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Тип номера</th>
                                        <th>Базовая цена</th>
                                        <th>Низкий сезон</th>
                                        <th>Средний сезон</th>
                                        <th>Высокий сезон</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Эконом</td>
                                        <td>2 500 ₽</td>
                                        <td>2 500 ₽</td>
                                        <td>3 000 ₽</td>
                                        <td>3 750 ₽</td>
                                        <td class="actions">
                                            <a href="#" class="btn-icon" title="Редактировать"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Стандарт</td>
                                        <td>3 500 ₽</td>
                                        <td>3 500 ₽</td>
                                        <td>4 200 ₽</td>
                                        <td>5 250 ₽</td>
                                        <td class="actions">
                                            <a href="#" class="btn-icon" title="Редактировать"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Семейный</td>
                                        <td>4 500 ₽</td>
                                        <td>4 500 ₽</td>
                                        <td>5 400 ₽</td>
                                        <td>6 750 ₽</td>
                                        <td class="actions">
                                            <a href="#" class="btn-icon" title="Редактировать"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Комфорт</td>
                                        <td>5 500 ₽</td>
                                        <td>5 500 ₽</td>
                                        <td>6 600 ₽</td>
                                        <td>8 250 ₽</td>
                                        <td class="actions">
                                            <a href="#" class="btn-icon" title="Редактировать"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Люкс</td>
                                        <td>8 000 ₽</td>
                                        <td>8 000 ₽</td>
                                        <td>9 600 ₽</td>
                                        <td>12 000 ₽</td>
                                        <td class="actions">
                                            <a href="#" class="btn-icon" title="Редактировать"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Календарь сезонов -->
                    <div class="seasons-calendar">
                        <h3>Календарь сезонов на 2024 год</h3>
                        <div class="calendar-wrapper">
                            <!-- Здесь можно использовать библиотеку для календаря или сделать свой -->
                            <div class="calendar-placeholder">
                                <p>Здесь будет календарь с отмеченными сезонами</p>
                                <p><strong>Легенда:</strong></p>
                                <div class="legend-item">
                                    <span class="color-sample" style="background-color: #4CAF50;"></span> Низкий сезон
                                </div>
                                <div class="legend-item">
                                    <span class="color-sample" style="background-color: #2196F3;"></span> Средний сезон
                                </div>
                                <div class="legend-item">
                                    <span class="color-sample" style="background-color: #F44336;"></span> Высокий сезон
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Доступность номеров -->
            <?php if (isset($_GET['tab']) && $_GET['tab'] == 'availability'): ?>
                <div class="tab-content">
                    <div class="action-bar">
                        <div class="filter-group">
                            <label for="month-select">Месяц:</label>
                            <select id="month-select">
                                <option value="1">Январь 2024</option>
                                <option value="2">Февраль 2024</option>
                                <option value="3" selected>Март 2024</option>
                                <option value="4">Апрель 2024</option>
                                <!-- другие месяцы -->
                            </select>
                        </div>
                        <div class="action-buttons">
                            <a href="#" class="btn btn-secondary" id="toggle-all-rooms">
                                <i class="fas fa-eye"></i> Показать все номера
                            </a>
                            <a href="#" class="btn btn-secondary" id="block-rooms">
                                <i class="fas fa-ban"></i> Блокировать номера
                            </a>
                        </div>
                    </div>
                    
                    <!-- Календарь доступности -->
                    <div class="availability-calendar">
                        <div class="calendar-header">
                            <div class="room-column">Номер</div>
                            <?php for ($i = 1; $i <= 31; $i++): ?>
                            <div class="day-column"><?php echo $i; ?></div>
                            <?php endfor; ?>
                        </div>
                        
                        <div class="calendar-body">
                            <!-- Пример данных для календаря доступности -->
                            <?php 
                            $rooms = ['101', '102', '103', '201', '202'];
                            $statusSamples = ['available', 'occupied', 'cleaning', 'maintenance'];
                            
                            foreach ($rooms as $roomNum): 
                            ?>
                            <div class="room-row">
                                <div class="room-column"><?php echo $roomNum; ?></div>
                                <?php for ($day = 1; $day <= 31; $day++): 
                                    // Генерируем случайный статус для примера
                                    $randomStatus = $statusSamples[array_rand($statusSamples)];
                                    if ($day > 28 && $randomStatus == 'available') $randomStatus = 'disabled';
                                ?>
                                <div class="day-column day-status <?php echo $randomStatus; ?>" 
                                     data-room="<?php echo $roomNum; ?>" 
                                     data-day="<?php echo $day; ?>"
                                     title="<?php echo $roomNum; ?>, <?php echo $day; ?> марта">
                                </div>
                                <?php endfor; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="calendar-legend">
                        <h4>Обозначения:</h4>
                        <div class="legend-items">
                            <div class="legend-item">
                                <span class="status-sample available"></span> Свободен
                            </div>
                            <div class="legend-item">
                                <span class="status-sample occupied"></span> Занят
                            </div>
                            <div class="legend-item">
                                <span class="status-sample cleaning"></span> Уборка
                            </div>
                            <div class="legend-item">
                                <span class="status-sample maintenance"></span> Ремонт/Тех. обслуживание
                            </div>
                            <div class="legend-item">
                                <span class="status-sample disabled"></span> Неактивен/Не существует
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Модальное окно для добавления/редактирования номера (пример) -->
            <?php if (isset($_GET['add']) || isset($_GET['edit'])): ?>
                <div class="modal" id="roomModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2><?php echo isset($_GET['add']) ? 'Добавление нового номера' : 'Редактирование номера'; ?></h2>
                            <a href="?action=rooms&tab=list" class="close-btn">&times;</a>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" class="admin-form">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="room_number">Номер комнаты</label>
                                        <input type="text" id="room_number" name="room_number" value="<?php echo isset($_GET['edit']) ? '101' : ''; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="room_type">Тип номера</label>
                                        <select id="room_type" name="room_type" required>
                                            <option value="1" <?php echo isset($_GET['edit']) ? 'selected' : ''; ?>>Эконом</option>
                                            <option value="2">Стандарт</option>
                                            <option value="3">Семейный</option>
                                            <option value="4">Комфорт</option>
                                            <option value="5">Люкс</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="room_floor">Этаж</label>
                                        <input type="number" id="room_floor" name="room_floor" value="<?php echo isset($_GET['edit']) ? '1' : ''; ?>" min="1" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="room_capacity">Вместимость (чел.)</label>
                                        <input type="number" id="room_capacity" name="room_capacity" value="<?php echo isset($_GET['edit']) ? '2' : ''; ?>" min="1" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="room_price">Базовая цена (₽)</label>
                                        <input type="number" id="room_price" name="room_price" value="<?php echo isset($_GET['edit']) ? '2500' : ''; ?>" min="0" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="room_status">Статус</label>
                                        <select id="room_status" name="room_status" required>
                                            <option value="available" <?php echo isset($_GET['edit']) ? 'selected' : ''; ?>>Свободен</option>
                                            <option value="occupied">Занят</option>
                                            <option value="cleaning">Уборка</option>
                                            <option value="maintenance">Ремонт</option>
                                            <option value="disabled">Отключен</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="room_description">Описание</label>
                                    <textarea id="room_description" name="room_description" rows="4"><?php echo isset($_GET['edit']) ? 'Уютный номер экономкласса с одной двуспальной кроватью, собственной ванной комнатой, телевизором и мини-холодильником.' : ''; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="room_features">Особенности и удобства</label>
                                    <div class="checkbox-group">
                                        <div class="checkbox-item">
                                            <input type="checkbox" id="feature_wifi" name="features[]" value="wifi" <?php echo isset($_GET['edit']) ? 'checked' : ''; ?>>
                                            <label for="feature_wifi">Wi-Fi</label>
                                        </div>
                                        <div class="checkbox-item">
                                            <input type="checkbox" id="feature_tv" name="features[]" value="tv" <?php echo isset($_GET['edit']) ? 'checked' : ''; ?>>
                                            <label for="feature_tv">Телевизор</label>
                                        </div>
                                        <div class="checkbox-item">
                                            <input type="checkbox" id="feature_conditioning" name="features[]" value="conditioning" <?php echo isset($_GET['edit']) ? 'checked' : ''; ?>>
                                            <label for="feature_conditioning">Кондиционер</label>
                                        </div>
                                        <div class="checkbox-item">
                                            <input type="checkbox" id="feature_fridge" name="features[]" value="fridge" <?php echo isset($_GET['edit']) ? 'checked' : ''; ?>>
                                            <label for="feature_fridge">Холодильник</label>
                                        </div>
                                        <div class="checkbox-item">
                                            <input type="checkbox" id="feature_balcony" name="features[]" value="balcony">
                                            <label for="feature_balcony">Балкон</label>
                                        </div>
                                        <div class="checkbox-item">
                                            <input type="checkbox" id="feature_safe" name="features[]" value="safe">
                                            <label for="feature_safe">Сейф</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="room_photos">Фотографии номера</label>
                                    <input type="file" id="room_photos" name="room_photos[]" multiple>
                                    <p class="form-help">Можно загрузить до 10 фотографий (JPEG, PNG). Максимальный размер одного файла: 5MB.</p>
                                </div>
                                
                                <div class="form-buttons">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Сохранить
                                    </button>
                                    <a href="?action=rooms&tab=list" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Отмена
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        // Пример JavaScript для календаря доступности
        document.addEventListener('DOMContentLoaded', function() {
            // Обработка клика по ячейке календаря
            const dayStatuses = document.querySelectorAll('.day-status');
            dayStatuses.forEach(function(day) {
                day.addEventListener('click', function() {
                    // В реальном проекте здесь будет модальное окно для изменения статуса
                    const room = this.getAttribute('data-room');
                    const dayNum = this.getAttribute('data-day');
                    alert(`Изменение статуса для номера ${room} на ${dayNum} марта`);
                    
                    // Пример смены статуса (в реальности должен быть AJAX-запрос)
                    const statuses = ['available', 'occupied', 'cleaning', 'maintenance'];
                    let currentIndex = statuses.indexOf(this.classList[2]);
                    let nextIndex = (currentIndex + 1) % statuses.length;
                    
                    // Удаляем текущий статус
                    this.classList.remove(statuses[currentIndex]);
                    // Добавляем следующий статус
                    this.classList.add(statuses[nextIndex]);
                });
            });
            
            // Кнопка "Показать все номера"
            document.getElementById('toggle-all-rooms').addEventListener('click', function(e) {
                e.preventDefault();
                // В реальном проекте здесь будет логика для отображения всех номеров
                alert('Показать все номера');
            });
            
            // Кнопка "Блокировать номера"
            document.getElementById('block-rooms').addEventListener('click', function(e) {
                e.preventDefault();
                // В реальном проекте здесь будет модальное окно для блокировки номеров
                alert('Открыть форму блокировки номеров');
            });
        });
    </script>
</body>
</html> 