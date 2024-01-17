<?php
require("session.php");
require("connectdb.php");

// Проверка наличия переданных данных
$parkingId = isset($_POST['parkingId']) ? $_POST['parkingId'] : null;
$userId = $_SESSION["id"];

// SQL-запрос для добавления записи в таблицу users_parkings
mysqli_query($connect, "DELETE FROM users_parkings WHERE user_id = \"".$userId."\" AND  park_id = \"".$parkingId."\"");

header('Location: parking.php?id=' . $parkingId);
?>
