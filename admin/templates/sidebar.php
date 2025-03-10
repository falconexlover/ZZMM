<div class="sidebar">
    <div class="sidebar-header">
        <img src="../assets/images/logo.png" alt="Лесной дворик">
        <h2>Панель управления</h2>
    </div>
    
    <ul class="sidebar-menu">
        <li>
            <a href="index.php" <?php echo ($action == 'list') ? 'class="active"' : ''; ?>>
                <i class="fas fa-calendar-check"></i> Бронирования
            </a>
        </li>
        <li>
            <a href="index.php?action=stats" <?php echo ($action == 'stats') ? 'class="active"' : ''; ?>>
                <i class="fas fa-chart-bar"></i> Статистика
            </a>
        </li>
        <li>
            <a href="index.php?action=rooms" <?php echo ($action == 'rooms') ? 'class="active"' : ''; ?>>
                <i class="fas fa-bed"></i> Номера
            </a>
        </li>
        <li>
            <a href="index.php?action=content" <?php echo ($action == 'content') ? 'class="active"' : ''; ?>>
                <i class="fas fa-edit"></i> Редактор контента
            </a>
        </li>
        <li>
            <a href="index.php?action=promo" <?php echo ($action == 'promo') ? 'class="active"' : ''; ?>>
                <i class="fas fa-percent"></i> Промокоды
            </a>
        </li>
        <li>
            <a href="index.php?action=services" <?php echo ($action == 'services') ? 'class="active"' : ''; ?>>
                <i class="fas fa-concierge-bell"></i> Услуги
            </a>
        </li>
        <li>
            <a href="index.php?action=settings" <?php echo ($action == 'settings') ? 'class="active"' : ''; ?>>
                <i class="fas fa-cog"></i> Настройки
            </a>
        </li>
        <li>
            <a href="index.php?action=users" <?php echo ($action == 'users') ? 'class="active"' : ''; ?>>
                <i class="fas fa-users"></i> Пользователи
            </a>
        </li>
        <li>
            <a href="index.php?action=export_csv">
                <i class="fas fa-file-export"></i> Экспорт CSV
            </a>
        </li>
        <li>
            <a href="index.php?action=logs" <?php echo ($action == 'logs') ? 'class="active"' : ''; ?>>
                <i class="fas fa-history"></i> Журнал действий
            </a>
        </li>
        <li class="sidebar-divider"></li>
        <li>
            <a href="../index.html" target="_blank">
                <i class="fas fa-home"></i> Перейти на сайт
            </a>
        </li>
        <li>
            <a href="index.php?action=logout" class="logout-link">
                <i class="fas fa-sign-out-alt"></i> Выйти
            </a>
        </li>
    </ul>
</div> 