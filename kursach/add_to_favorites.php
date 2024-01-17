<?php
require("session.php");
require("connectdb.php");

// Проверка наличия переданных данных
$parkingId = isset($_POST['parkingId']) ? $_POST['parkingId'] : null;
$userId = $_SESSION["id"];

// SQL-запрос для добавления записи в таблицу users_parkings
mysqli_query($connect, "INSERT INTO users_parkings (user_id, park_id) VALUES (\"".$userId."\", \"".$parkingId."\")");

header('Location: parking.php?id=' . $parkingId);
?>
