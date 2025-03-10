<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление бронированиями | Гостиница "Лесной дворик"</title>
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
                <h1><i class="fas fa-calendar-check"></i> Управление бронированиями</h1>
                <div class="user-info">
                    <span>Администратор</span>
                    <a href="?action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Выйти</a>
                </div>
            </div>
            
            <div class="toolbar">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Поиск по бронированиям...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="tools">
                    <a href="?action=export_csv" class="btn btn-secondary"><i class="fas fa-file-export"></i> Экспорт в CSV</a>
                    <a href="?action=stats" class="btn btn-info"><i class="fas fa-chart-bar"></i> Статистика</a>
                </div>
            </div>
            
            <div class="bookings-container">
                <?php if (empty($bookings)): ?>
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <h2>Нет активных бронирований</h2>
                        <p>На данный момент бронирования отсутствуют в системе.</p>
                    </div>
                <?php else: ?>
                    <table class="bookings-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Имя гостя</th>
                                <th>Даты</th>
                                <th>Номер</th>
                                <th>Гостей</th>
                                <th>Стоимость</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr class="booking-row" data-id="<?php echo htmlspecialchars($booking['id']); ?>">
                                    <td><?php echo htmlspecialchars($booking['id']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['name']); ?></td>
                                    <td>
                                        <?php 
                                            $arrivalDate = date('d.m.Y', strtotime($booking['arrival_date']));
                                            $departureDate = date('d.m.Y', strtotime($booking['departure_date']));
                                            echo $arrivalDate . ' — ' . $departureDate;
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($booking['room_type']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['guests']); ?></td>
                                    <td><?php echo number_format($booking['price'], 0, '.', ' ') . ' ₽'; ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo strtolower(htmlspecialchars($booking['status'])); ?>">
                                            <?php echo htmlspecialchars($booking['status']); ?>
                                        </span>
                                    </td>
                                    <td class="actions">
                                        <a href="?action=view&id=<?php echo urlencode($booking['id']); ?>" class="action-btn view-btn">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="action-btn status-btn" data-booking-id="<?php echo htmlspecialchars($booking['id']); ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="?action=delete&id=<?php echo urlencode($booking['id']); ?>" class="action-btn delete-btn" onclick="return confirm('Вы уверены, что хотите удалить это бронирование?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Модальное окно для изменения статуса -->
    <div id="statusModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Изменить статус бронирования</h2>
            <form id="statusForm" action="?action=update_status" method="post">
                <input type="hidden" id="booking_id" name="booking_id" value="">
                <div class="form-group">
                    <label for="status">Статус:</label>
                    <select id="status" name="status">
                        <option value="Новое">Новое</option>
                        <option value="Подтверждено">Подтверждено</option>
                        <option value="Оплачено">Оплачено</option>
                        <option value="Заселено">Заселено</option>
                        <option value="Завершено">Завершено</option>
                        <option value="Отменено">Отменено</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        </div>
    </div>
    
    <script>
        // Функционал поиска
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('.booking-row');
            
            rows.forEach(row => {
                let found = false;
                
                // Поиск по всем ячейкам строки
                row.querySelectorAll('td').forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchText)) {
                        found = true;
                    }
                });
                
                if (found) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
        // Модальное окно для изменения статуса
        const modal = document.getElementById('statusModal');
        const statusButtons = document.querySelectorAll('.status-btn');
        const closeModal = document.querySelector('.close-modal');
        const statusForm = document.getElementById('statusForm');
        const bookingIdInput = document.getElementById('booking_id');
        
        statusButtons.forEach(button => {
            button.addEventListener('click', function() {
                const bookingId = this.getAttribute('data-booking-id');
                const currentStatus = this.closest('tr').querySelector('.status-badge').textContent.trim();
                
                bookingIdInput.value = bookingId;
                
                // Устанавливаем текущий статус в селекте
                const statusSelect = document.getElementById('status');
                for (let i = 0; i < statusSelect.options.length; i++) {
                    if (statusSelect.options[i].value === currentStatus) {
                        statusSelect.selectedIndex = i;
                        break;
                    }
                }
                
                modal.style.display = 'block';
            });
        });
        
        closeModal.addEventListener('click', function() {
            modal.style.display = 'none';
        });
        
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>
</body>
</html> 