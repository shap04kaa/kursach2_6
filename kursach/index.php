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
    <link rel="stylesheet" href="css/styles.css">
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
                <a class="nav-link text-white" href="#" style="font-size: 20px; ">Главная</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="allparks.php" style="font-size: 20px; ">Все парковки</a>
            </li>
            <li class="nav-item">
                <?php
                if ($session_user == true) {
                    $page = "Мой кабинет";
                    $link = "account.php";
                } else {
                    $page = "Авторизация";
                    $link = "auth.php";
                }
                ?>
                <a class="nav-link text-white" href="<?= $link ?>" style="font-size: 20px; "><?= $page ?></a>
            </li>
            </ul>
        </div>
    </nav>
</div>
</header>

<!-- Блок с основными особенностями/преимуществами -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Особенность 1: Находи пересадки -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="card-title text-center">Находи пересадки</h2>
                        <p class="card-text text-center">Находи удобные для тебя автостоянки рядом с метро, пересаживайся и не стой в пробках в центре Москвы</p>
                    </div>
                </div>
            </div>
            <!-- Особенность 2: Парковки для всех -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="card-title text-center">Парковки для всех</h2>
                        <p class="card-text text-center">На сайте представлены как платные, так и бесплатные парковки, поэтому каждый найдет подходящий вариант для себя </p>
                    </div>
                </div>
            </div>
            <!-- Особенность 3: Добавляй парковки -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="card-title text-center">Добавляй парковки</h2>
                        <p class="card-text text-center">Регестрируйся на сайте, добавляй парковки и помоги другим пользователям находить удобные места для автомобилей</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<h3 class="text-center"> ВСЕ ПАРКОВКИ НА КАРТЕ </h3>

<div id="map" class="map"></div>
<script src="https://api-maps.yandex.ru/2.1/?apikey=3d8e5ed6-c333-4ed0-a350-0c1b6e3957c5&lang=ru_RU"></script>
<script>
    let center = [55.727892212784184,37.583109902444946];

    // Создаем массивы с координатами точек из PHP массивов
    var points_lat = [<?= implode(',', $points_lat) ?>];
    var points_long = [<?= implode(',', $points_long) ?>];
    var points_id = [<?= implode(',', $points_id) ?>];
    var points_price = <?= json_encode($points_price) ?>;

    function init() {
        var map = new ymaps.Map('map', {
            center: center,
            zoom: 10
        });

        map.controls.remove('geolocationControl');
        map.controls.remove('searchControl');
        map.controls.remove('trafficControl');
        map.controls.remove('typeSelector');
        map.controls.remove('fullscreenControl');
        map.controls.remove('zoomControl');
        map.controls.remove('rulerControl');
        // map.behaviors.disable(['scrollZoom']);

        // Добавляем метки на карту для каждой точки из массивов
        for (let i = 0; i < points_price.length; i++) {
        let currentPoint = [points_lat[i], points_long[i]];
        let placemarkOptions = {};

        if (points_price[i] === "free2met") {
            placemarkOptions.iconLayout = 'default#image';
            placemarkOptions.iconImageHref = 'images/marker1_blue.svg';
            placemarkOptions.iconImageSize = [30, 30];
            placemarkOptions.iconImageOffset = [-17, -25];
        } else if (points_price[i] === "free") {
            placemarkOptions.iconLayout = 'default#image';
            placemarkOptions.iconImageHref = 'images/marker1_green.svg';
            placemarkOptions.iconImageSize = [30, 30];
            placemarkOptions.iconImageOffset = [-17, -25];
        }
        else {
            placemarkOptions.iconLayout = 'default#image';
            placemarkOptions.iconImageHref = 'images/marker1_red.svg';
            placemarkOptions.iconImageSize = [30, 30];
            placemarkOptions.iconImageOffset = [-17, -25];
        }

        let placemark = new ymaps.Placemark(currentPoint, {
            balloonContentBody: 'Номер парковки: ' + points_id[i],
        }, placemarkOptions);

    map.geoObjects.add(placemark);
    }
    }

    ymaps.ready(init);
</script>

<div class="container1">
    <div class="flex1">
        <p class="text-success text-center">бесплатные парковки</p>
        <p class="text-primary text-center">парковки, бесплатные при использовании городского транспорта</p>
        <p class="text-danger text-center">платные парковки</p>
    </div>
</div>    
    
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