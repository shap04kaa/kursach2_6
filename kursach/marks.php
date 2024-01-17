<?php
require("connectdb.php");

// Получение всех данных из базы данных
$query = "SELECT id, latitude, longitude, price FROM parkings";
$result = $connect->query($query);

// Создание массивов для хранения данных
$points_id = [];
$points_lat = [];
$points_long = [];
$points_price = [];

while ($row = $result->fetch_assoc()) {
    $points_id[] = $row['id'];
    $points_lat[] = $row['latitude'];
    $points_long[] = $row['longitude'];
    $points_price[] = $row['price'];
}
?>