<?php
session_start();

// Уничтожение сессии
session_unset();
session_destroy();

// Перенаправление на страницу входа или другую страницу
header("Location: index.php");
exit;
?>
