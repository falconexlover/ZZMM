<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика бронирований | Гостиница "Лесной дворик"</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <!-- Подключаем Chart.js для графиков -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Боковое меню -->
        <?php include 'sidebar.php'; ?>
        
        <!-- Основное содержимое -->
        <div class="content">
            <div class="header">
                <h1><i class="fas fa-chart-bar"></i> Статистика бронирований</h1>
                <div class="user-info">
                    <span>Администратор</span>
                    <a href="?action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Выйти</a>
                </div>
            </div>
            
            <!-- Фильтры -->
            <div class="stats-filters">
                <form action="" method="get">
                    <input type="hidden" name="action" value="stats">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="period">Период:</label>
                            <select id="period" name="period">
                                <option value="7" <?php echo isset($_GET['period']) && $_GET['period'] == '7' ? 'selected' : ''; ?>>Неделя</option>
                                <option value="30" <?php echo isset($_GET['period']) && $_GET['period'] == '30' ? 'selected' : ''; ?>>Месяц</option>
                                <option value="90" <?php echo isset($_GET['period']) && $_GET['period'] == '90' ? 'selected' : ''; ?>>3 месяца</option>
                                <option value="180" <?php echo isset($_GET['period']) && $_GET['period'] == '180' ? 'selected' : ''; ?>>6 месяцев</option>
                                <option value="365" <?php echo isset($_GET['period']) && $_GET['period'] == '365' ? 'selected' : ''; ?>>Год</option>
                                <option value="all" <?php echo isset($_GET['period']) && $_GET['period'] == 'all' ? 'selected' : ''; ?>>Все время</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="custom_from">Или укажите даты:</label>
                            <input type="date" id="custom_from" name="custom_from" value="<?php echo isset($_GET['custom_from']) ? $_GET['custom_from'] : ''; ?>">
                            <span>—</span>
                            <input type="date" id="custom_to" name="custom_to" value="<?php echo isset($_GET['custom_to']) ? $_GET['custom_to'] : ''; ?>">
                        </div>
                        
                        <div class="filter-group">
                            <button type="submit" class="btn btn-primary">Применить</button>
                            <a href="?action=stats" class="btn btn-secondary">Сбросить</a>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Общая сводка -->
            <div class="stats-summary">
                <div class="stats-container">
                    <div class="stat-card">
                        <i class="fas fa-calendar-check"></i>
                        <div class="stat-value"><?php echo number_format($stats['total'], 0, '.', ' '); ?></div>
                        <div class="stat-label">Всего бронирований</div>
                    </div>
                    
                    <div class="stat-card">
                        <i class="fas fa-bell"></i>
                        <div class="stat-value"><?php echo number_format($stats['new'], 0, '.', ' '); ?></div>
                        <div class="stat-label">Новых бронирований</div>
                    </div>
                    
                    <div class="stat-card">
                        <i class="fas fa-check-circle"></i>
                        <div class="stat-value"><?php echo number_format($stats['confirmed'], 0, '.', ' '); ?></div>
                        <div class="stat-label">Подтвержденных</div>
                    </div>
                    
                    <div class="stat-card">
                        <i class="fas fa-ruble-sign"></i>
                        <div class="stat-value"><?php echo number_format($stats['total_revenue'], 0, '.', ' '); ?> ₽</div>
                        <div class="stat-label">Общая выручка</div>
                    </div>
                </div>
            </div>
            
            <!-- Графики -->
            <div class="stats-charts">
                <div class="chart-container">
                    <h3>Динамика бронирований</h3>
                    <canvas id="bookingsChart"></canvas>
                </div>
                
                <div class="chart-container">
                    <h3>Распределение по типам номеров</h3>
                    <canvas id="roomTypesChart"></canvas>
                </div>
            </div>
            
            <!-- Таблица с популярными номерами -->
            <div class="stats-tables">
                <div class="table-container">
                    <h3>Популярные типы номеров</h3>
                    <table class="stats-table">
                        <thead>
                            <tr>
                                <th>Тип номера</th>
                                <th>Кол-во бронирований</th>
                                <th>Доля, %</th>
                                <th>Выручка, ₽</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Пример данных (в реальном проекте будет запрос к БД)
                            $roomTypeStats = [
                                ['name' => 'Эконом', 'count' => 25, 'share' => 20, 'revenue' => 62500],
                                ['name' => 'Стандарт', 'count' => 40, 'share' => 32, 'revenue' => 140000],
                                ['name' => 'Семейный', 'count' => 30, 'share' => 24, 'revenue' => 135000],
                                ['name' => 'Комфорт', 'count' => 20, 'share' => 16, 'revenue' => 110000],
                                ['name' => 'Люкс', 'count' => 10, 'share' => 8, 'revenue' => 80000],
                            ];
                            
                            foreach ($roomTypeStats as $stat):
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($stat['name']); ?></td>
                                <td><?php echo number_format($stat['count'], 0, '.', ' '); ?></td>
                                <td><?php echo number_format($stat['share'], 1, '.', ' '); ?>%</td>
                                <td><?php echo number_format($stat['revenue'], 0, '.', ' '); ?> ₽</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="table-container">
                    <h3>Статистика по статусам</h3>
                    <table class="stats-table">
                        <thead>
                            <tr>
                                <th>Статус</th>
                                <th>Кол-во бронирований</th>
                                <th>Доля, %</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Пример данных (в реальном проекте будет запрос к БД)
                            $statusStats = [
                                ['name' => 'Новое', 'count' => 15, 'share' => 12],
                                ['name' => 'Подтверждено', 'count' => 35, 'share' => 28],
                                ['name' => 'Оплачено', 'count' => 25, 'share' => 20],
                                ['name' => 'Заселено', 'count' => 10, 'share' => 8],
                                ['name' => 'Завершено', 'count' => 30, 'share' => 24],
                                ['name' => 'Отменено', 'count' => 10, 'share' => 8],
                            ];
                            
                            foreach ($statusStats as $stat):
                            ?>
                            <tr>
                                <td>
                                    <span class="status-badge status-<?php echo strtolower(htmlspecialchars($stat['name'])); ?>">
                                        <?php echo htmlspecialchars($stat['name']); ?>
                                    </span>
                                </td>
                                <td><?php echo number_format($stat['count'], 0, '.', ' '); ?></td>
                                <td><?php echo number_format($stat['share'], 1, '.', ' '); ?>%</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Дополнительные метрики -->
            <div class="stats-metrics">
                <div class="metric-container">
                    <h3>Средняя продолжительность проживания</h3>
                    <div class="metric-value">
                        <span class="large-value">3.5</span>
                        <span class="metric-unit">дней</span>
                    </div>
                </div>
                
                <div class="metric-container">
                    <h3>Средний чек</h3>
                    <div class="metric-value">
                        <span class="large-value">4 200</span>
                        <span class="metric-unit">₽</span>
                    </div>
                </div>
                
                <div class="metric-container">
                    <h3>Конверсия бронирований</h3>
                    <div class="metric-value">
                        <span class="large-value">82</span>
                        <span class="metric-unit">%</span>
                    </div>
                </div>
            </div>
            
            <!-- Кнопки экспорта -->
            <div class="export-buttons">
                <a href="?action=export_csv" class="btn btn-primary">
                    <i class="fas fa-file-csv"></i> Экспорт в CSV
                </a>
                <a href="?action=export_stats_pdf" class="btn btn-secondary">
                    <i class="fas fa-file-pdf"></i> Экспорт в PDF
                </a>
            </div>
        </div>
    </div>
    
    <!-- Скрипты для построения графиков -->
    <script>
        // Данные для графика динамики бронирований (пример)
        const bookingsChartData = {
            labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
            datasets: [
                {
                    label: 'Всего бронирований',
                    data: [12, 19, 25, 32, 45, 55, 50, 60, 42, 30, 25, 20],
                    backgroundColor: 'rgba(90, 143, 123, 0.2)',
                    borderColor: 'rgba(90, 143, 123, 1)',
                    borderWidth: 2,
                    tension: 0.4
                },
                {
                    label: 'Выручка (тыс. ₽)',
                    data: [48, 76, 100, 128, 180, 220, 200, 240, 168, 120, 100, 80],
                    backgroundColor: 'rgba(52, 152, 219, 0.2)',
                    borderColor: 'rgba(52, 152, 219, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    yAxisID: 'y-axis-2'
                }
            ]
        };

        // Данные для графика типов номеров (пример)
        const roomTypesChartData = {
            labels: ['Эконом', 'Стандарт', 'Семейный', 'Комфорт', 'Люкс'],
            datasets: [{
                label: 'Количество бронирований',
                data: [25, 40, 30, 20, 10],
                backgroundColor: [
                    'rgba(241, 196, 15, 0.7)',
                    'rgba(46, 204, 113, 0.7)',
                    'rgba(52, 152, 219, 0.7)',
                    'rgba(155, 89, 182, 0.7)',
                    'rgba(231, 76, 60, 0.7)'
                ],
                borderColor: [
                    'rgba(241, 196, 15, 1)',
                    'rgba(46, 204, 113, 1)',
                    'rgba(52, 152, 219, 1)',
                    'rgba(155, 89, 182, 1)',
                    'rgba(231, 76, 60, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Построение графика динамики бронирований
        const bookingsChart = new Chart(
            document.getElementById('bookingsChart'),
            {
                type: 'line',
                data: bookingsChartData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        'y-axis-2': {
                            beginAtZero: true,
                            position: 'right',
                            grid: {
                                drawOnChartArea: false
                            }
                        }
                    }
                }
            }
        );

        // Построение графика типов номеров
        const roomTypesChart = new Chart(
            document.getElementById('roomTypesChart'),
            {
                type: 'pie',
                data: roomTypesChartData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            }
        );
    </script>
</body>
</html> 