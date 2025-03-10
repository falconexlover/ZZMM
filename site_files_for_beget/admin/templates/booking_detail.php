<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детали бронирования #<?php echo htmlspecialchars($booking['id']); ?> | Гостиница "Лесной дворик"</title>
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
                <h1><i class="fas fa-info-circle"></i> Детали бронирования</h1>
                <div class="user-info">
                    <span>Администратор</span>
                    <a href="?action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Выйти</a>
                </div>
            </div>
            
            <div class="back-to-list">
                <a href="index.php"><i class="fas fa-arrow-left"></i> Вернуться к списку бронирований</a>
            </div>
            
            <div class="booking-details">
                <div class="booking-header">
                    <h2>Бронирование #<?php echo htmlspecialchars($booking['id']); ?></h2>
                    <div class="booking-status">
                        <span class="status-badge status-<?php echo strtolower(htmlspecialchars($booking['status'])); ?>">
                            <?php echo htmlspecialchars($booking['status']); ?>
                        </span>
                    </div>
                </div>
                
                <!-- Форма изменения статуса -->
                <div class="status-change-form">
                    <form action="?action=update_status" method="post">
                        <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['id']); ?>">
                        <div class="form-group inline-form">
                            <label for="status">Изменить статус:</label>
                            <select id="status" name="status" class="status-select">
                                <option value="Новое" <?php echo ($booking['status'] == 'Новое') ? 'selected' : ''; ?>>Новое</option>
                                <option value="Подтверждено" <?php echo ($booking['status'] == 'Подтверждено') ? 'selected' : ''; ?>>Подтверждено</option>
                                <option value="Оплачено" <?php echo ($booking['status'] == 'Оплачено') ? 'selected' : ''; ?>>Оплачено</option>
                                <option value="Заселено" <?php echo ($booking['status'] == 'Заселено') ? 'selected' : ''; ?>>Заселено</option>
                                <option value="Завершено" <?php echo ($booking['status'] == 'Завершено') ? 'selected' : ''; ?>>Завершено</option>
                                <option value="Отменено" <?php echo ($booking['status'] == 'Отменено') ? 'selected' : ''; ?>>Отменено</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
                
                <div class="booking-sections">
                    <!-- Информация о бронировании -->
                    <div class="detail-section">
                        <h3>Информация о бронировании</h3>
                        <div class="detail-row">
                            <strong>Номер бронирования:</strong>
                            <span><?php echo htmlspecialchars($booking['id']); ?></span>
                        </div>
                        <div class="detail-row">
                            <strong>Создано:</strong>
                            <span><?php echo date('d.m.Y H:i', strtotime($booking['created_at'])); ?></span>
                        </div>
                        <div class="detail-row">
                            <strong>Последнее обновление:</strong>
                            <span><?php echo $booking['updated_at'] ? date('d.m.Y H:i', strtotime($booking['updated_at'])) : 'Нет обновлений'; ?></span>
                        </div>
                        <div class="detail-row">
                            <strong>Статус:</strong>
                            <span class="status-badge status-<?php echo strtolower(htmlspecialchars($booking['status'])); ?>">
                                <?php echo htmlspecialchars($booking['status']); ?>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Информация о госте -->
                    <div class="detail-section">
                        <h3>Информация о госте</h3>
                        <div class="detail-row">
                            <strong>Имя:</strong>
                            <span><?php echo htmlspecialchars($booking['name']); ?></span>
                        </div>
                        <div class="detail-row">
                            <strong>Телефон:</strong>
                            <span>
                                <a href="tel:<?php echo htmlspecialchars($booking['phone']); ?>">
                                    <?php echo htmlspecialchars($booking['phone']); ?>
                                </a>
                            </span>
                        </div>
                        <div class="detail-row">
                            <strong>Email:</strong>
                            <span>
                                <a href="mailto:<?php echo htmlspecialchars($booking['email']); ?>">
                                    <?php echo htmlspecialchars($booking['email']); ?>
                                </a>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Детали проживания -->
                    <div class="detail-section">
                        <h3>Детали проживания</h3>
                        <div class="detail-row">
                            <strong>Тип номера:</strong>
                            <span><?php echo htmlspecialchars($booking['room_type']); ?></span>
                        </div>
                        <div class="detail-row">
                            <strong>Дата заезда:</strong>
                            <span><?php echo date('d.m.Y', strtotime($booking['arrival_date'])); ?></span>
                        </div>
                        <div class="detail-row">
                            <strong>Дата выезда:</strong>
                            <span><?php echo date('d.m.Y', strtotime($booking['departure_date'])); ?></span>
                        </div>
                        <div class="detail-row">
                            <strong>Количество ночей:</strong>
                            <span>
                                <?php 
                                    $arrivalDate = new DateTime($booking['arrival_date']);
                                    $departureDate = new DateTime($booking['departure_date']);
                                    $interval = $arrivalDate->diff($departureDate);
                                    echo $interval->days;
                                ?>
                            </span>
                        </div>
                        <div class="detail-row">
                            <strong>Количество гостей:</strong>
                            <span><?php echo htmlspecialchars($booking['guests']); ?></span>
                        </div>
                    </div>
                    
                    <!-- Дополнительная информация -->
                    <div class="detail-section">
                        <h3>Дополнительная информация</h3>
                        <div class="detail-row">
                            <strong>Способ оплаты:</strong>
                            <span>
                                <?php
                                    $paymentMethod = $booking['payment_method'];
                                    $paymentMethods = [
                                        'card' => 'Банковская карта',
                                        'cash' => 'Наличными при заселении',
                                        'bank-transfer' => 'Банковский перевод'
                                    ];
                                    echo isset($paymentMethods[$paymentMethod]) ? $paymentMethods[$paymentMethod] : $paymentMethod;
                                ?>
                            </span>
                        </div>
                        <?php if (!empty($booking['promo_code'])): ?>
                        <div class="detail-row">
                            <strong>Промокод:</strong>
                            <span><?php echo htmlspecialchars($booking['promo_code']); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($booking['additional_services'])): ?>
                        <div class="detail-row">
                            <strong>Дополнительные услуги:</strong>
                            <span><?php echo htmlspecialchars($booking['additional_services']); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($booking['comments'])): ?>
                        <div class="detail-row">
                            <strong>Комментарии:</strong>
                            <div class="comments-block">
                                <?php echo nl2br(htmlspecialchars($booking['comments'])); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Финансовая информация -->
                    <div class="detail-section">
                        <h3>Финансовая информация</h3>
                        <div class="detail-row">
                            <strong>Стоимость:</strong>
                            <span class="price-highlight"><?php echo number_format($booking['price'], 0, '.', ' '); ?> ₽</span>
                        </div>
                    </div>
                </div>
                
                <!-- Кнопки действий -->
                <div class="action-buttons">
                    <a href="?action=edit&id=<?php echo urlencode($booking['id']); ?>" class="btn btn-secondary">
                        <i class="fas fa-edit"></i> Редактировать
                    </a>
                    <a href="?action=print&id=<?php echo urlencode($booking['id']); ?>" class="btn btn-info" target="_blank">
                        <i class="fas fa-print"></i> Печать
                    </a>
                    <a href="?action=email&id=<?php echo urlencode($booking['id']); ?>" class="btn btn-primary">
                        <i class="fas fa-envelope"></i> Отправить подтверждение
                    </a>
                    <a href="?action=delete&id=<?php echo urlencode($booking['id']); ?>" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить это бронирование?');">
                        <i class="fas fa-trash"></i> Удалить
                    </a>
                </div>
            </div>
            
            <!-- История изменений статуса -->
            <div class="booking-history">
                <h3>История изменений</h3>
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Дата и время</th>
                            <th>Статус изменен</th>
                            <th>Пользователь</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Здесь будет код для вывода истории изменений из БД
                        // Пример:
                        $history = []; // В реальном проекте здесь будет запрос к БД
                        if (empty($history)):
                        ?>
                        <tr>
                            <td colspan="3" class="empty-history">История изменений пуста</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach($history as $record): ?>
                            <tr>
                                <td><?php echo date('d.m.Y H:i', strtotime($record['created_at'])); ?></td>
                                <td>
                                    <span class="status-change">
                                        <span class="status-badge status-<?php echo strtolower($record['old_status']); ?>">
                                            <?php echo $record['old_status']; ?>
                                        </span>
                                        <i class="fas fa-arrow-right"></i>
                                        <span class="status-badge status-<?php echo strtolower($record['new_status']); ?>">
                                            <?php echo $record['new_status']; ?>
                                        </span>
                                    </span>
                                </td>
                                <td><?php echo $record['admin_name']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html> 