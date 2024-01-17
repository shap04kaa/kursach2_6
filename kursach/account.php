<?php
require("marks.php");
require("session.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <title>ParkNRide</title>
    <link rel="stylesheet" href="css/account.css">
</head>
<body>

<!-- Блок с названием проекта и описанием -->
<header class="bg-primary text-white text-center">
    <div class="container">
        <h1 class="display-4">ParkNRide</h1>
        <p class="lead">Удобные пересадки с машины на метро!</p>
        
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a class="nav-link text-white" href="index.php" style="font-size: 20px; ">Главная</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="allparks.php" style="font-size: 20px; ">Все парковки</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#" style="font-size: 20px; ">Мой кабинет</a>
            </li>
            </ul>
        </div>
    </nav>
</div>
</header>

<?php

$userId = $_SESSION["id"];
$query = "SELECT * FROM users WHERE id = \"".$userId."\"";
$result = mysqli_query($connect, $query);
if ($user = mysqli_fetch_assoc($result)) {
    echo '<div class="container ml-5 my-1">';
    echo '<div class="row">';

    echo '<div class="col-lg-4 ml-5 my-5">';
    echo '<div class="card h-100">';
    echo '<div class="card-body">';
    
    // Первый блок
    echo '<div class="mb-5">';
    echo '<h5 class="text-muted">логин</h5>';
    echo '<h3>' . $user['login'] . '</h3>';
    echo '</div>';
    
    // Второй блок
    echo '<div class="mb-5">';
    echo '<h5 class="text-muted">email</h5>';
    echo '<h3>' . $user['email'] . '</h3>';
    echo '</div>';
    
    // Третий блок
    echo '<div class="mt-3">';
    echo '<a href="logout.php" class="btn btn-secondary">Выйти из аккаунта</a>';
    echo '</div>';

    echo '</div></div></div>';

    $query1 = "CALL GetUserParkingInfo(\"" . $userId . "\")";
    $result1 = mysqli_query($connect, $query1);

    echo '<div class="col-lg-8 mt-4">';
    echo '<div class="card h-100 w-100 border-0">';
    echo '<div class="card-body">';

    echo '<h4 class="card-title text-center">Избранные парковки</h4>';

    if (mysqli_fetch_assoc($result1)) {
    
        echo '<ul class="list-group" style="max-height: 270px; overflow-y: auto;">';
        while ($favorite = mysqli_fetch_assoc($result1)) {
            echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
            echo '<span> Парковка номер ' . $favorite['id'] . ' у станции метро ' . $favorite['MetroStation'] . '</span>';
            echo '<a href="parking.php?id=' . $favorite['id'] . '" class="btn btn-primary btn-sm ml-auto">Перейти</a>'; // Кнопка "Перейти" с ml-auto
            echo '<input type="hidden" name="back2" value="1">';
            echo '</li>';
        }
        echo '</ul>';
    
        mysqli_free_result($result1);
        echo '</div>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<h5 class="text-center mt-3 text-muted">Пока нет избранных парковок</h5>';
    }


    echo '</div></div></div>';

    echo '</div></div>';
}
?>
    

<!-- Подвал -->
<footer class="py-3 bg-dark">
    <div class="container text-center text-white">
        <p class="mb-0">a.v.shapovalov22@list.ru</p>
        <p class="mb-0">&copy; 2024 ParkNRide</p>
    </div>
</footer>

<!-- Скрипты Bootstrap (необходимы для работы компонентов) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>