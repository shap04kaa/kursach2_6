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
    <link rel="stylesheet" href="css/allparks.css">
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
                <a class="nav-link text-white" href="#" style="font-size: 20px; ">Все парковки</a>
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

<!-- Карточка с поиском -->
<div class="col-10 m-4 mx-auto">
    <div class="card h-100">
        <div class="card-body">
            <div class="container">
                <h5 class="mt-1 mb-2 text-center">Поиск</h5>
                <form id="searchForm" class="form-inline justify-content-center">
                    <input type="text" id="searchInput" class="form-control mb-2 mr-sm-2 w-100" placeholder="Введите номер парковки, станцию метро или другое">
                    <div class="w-100 d-flex justify-content-center">
                        <button type="button" class="btn btn-primary mb-2 w-50 mx-1" onclick="filterTable()">Искать</button>
                        <button type="button" class="btn btn-secondary mb-2 w-50 mx-1" onclick="resetSearch()">Сбросить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// SQL-запрос для получения данных о парковках
$sql = "SELECT id, MetroStation, MetroLine, Schedule, Price FROM parkings";
$result = $connect->query($sql);

// Проверка результатов запроса
if ($result->num_rows > 0) {
    // Преобразование результатов в массив
    $parkData = array();
    while ($row = $result->fetch_assoc()) {
        $parkData[] = $row;
    }
} else {
    echo "Нет данных о парковках";
}


?>

<div class="px-5">
    <h3 class="text-center m-4">Список парковок</h3>
    <table class="table" style="">
        <thead>
            <tr>
                <th scope="col" class="text-center">Номер парковки</th>
                <th scope="col">Станция метро</th>
                <th scope="col">Линия метро</th>
                <th scope="col">Время работы</th>
                <th scope="col" class="text-center">Стоимость</th>
                <!-- Новый столбец для кнопки "Добавить в избранное" -->
                <?php
                if ($session_user == true) {
                    echo '<th scope="col" class="text-center">';
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < count($parkData); $i++): ?>
                <tr>
                    <th class="text-center" scope="row"><?= $parkData[$i]['id'] ?></th>
                    <td><?= $parkData[$i]['MetroStation'] ?></td>
                    <td><?= str_replace('линия', '', $parkData[$i]['MetroLine']) ?></td>
                    <td><?= $parkData[$i]['Schedule'] ?></td>
                    <td>
                        <?php
                            // Проверка значения столбца 'Price'
                            if ($parkData[$i]['Price'] == 'free2met') {
                                echo 'Бесплатно при использовании городского транспорта';
                            } else {
                                echo $parkData[$i]['Price'];
                            }
                        ?>
                    </td>
                    <?php
                    $query = "CALL GetUsersParkings( \"".$_SESSION["id"]."\" , \"".$parkData[$i]['id']."\" );";
                    $result = mysqli_query($connect, $query);
                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            if ($session_user == true) {
                            echo '<form action="delete_from_favorites.php" method="post">';
                            echo '<input type="hidden" name="parkingId" value="' . $parkData[$i]['id'] . '">';
                            echo '<td class="text-center">';
                            echo '<button type="submit" class="btn btn-danger" id="favoritesButton">Удалить из избранного</button>';
                            echo '</td>';
                            echo '</form>';
                            }
                        } else {
                        if ($session_user == true) {
                            echo '<form action="add_to_favorites.php" method="post">';
                            echo '<input type="hidden" name="parkingId" value="' . $parkData[$i]['id'] . '">';
                            echo '<td class="text-center">';
                            echo '<button type="submit" class="btn btn-primary" id="favoritesButton">Добавить в избранное</button>';
                            echo '</td>';
                            echo '</form>';
                        }
                    }
                        // Завершаем результат
    mysqli_free_result($result);

    // Переходим к следующему результату
    mysqli_next_result($connect);
                    }
                    ?>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>

<!-- Подвал -->
<footer class="py-3 bg-dark">
    <div class="container text-center text-white">
        <p class="mb-0">a.v.shapovalov22@list.ru</p>
        <p class="mb-0">&copy; 2024 ParkNRide</p>
    </div>
</footer>

<!-- Добавляем скрипт для фильтрации таблицы -->
<script>
    function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.querySelector("table");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            var found = false;
            
            // Проверяем, является ли текущая строка первой (с заголовками)
            var isFirstRow = i === 0;

            // Перебираем все ячейки в текущей строке
            for (var j = 0; j < tr[i].cells.length; j++) {
                td = tr[i].cells[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;

                    // Проверяем, является ли текущая строка первой (с заголовками)
                    if (isFirstRow || txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break; // Прекращаем цикл, если текст найден в текущей ячейке
                    }
                }
            }
            // Отображаем или скрываем строку в зависимости от наличия совпадения в любой из ячеек
            tr[i].style.display = found ? "" : "none";
        }
    }

    function resetSearch() {
        document.getElementById("searchInput").value = "";
        filterTable(); // Вызываем функцию фильтрации для скрытия строк после сброса
    }

</script>

<!-- Скрипты Bootstrap (необходимы для работы компонентов) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>