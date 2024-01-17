<?php
    require("connectdb.php");
    require("session.php");

    $login = $_POST['username'];

    $pass = $_POST['password'];

    $pass = md5($pass."qwpfgow234");

    $result = mysqli_query($connect, "SELECT * FROM users 
    WHERE login =  \"".$login."\" AND password = \"".$pass."\";"
    );

    $user = mysqli_fetch_assoc($result);

    if(!$user) {
        echo "Такой пользователь не найден либо неверно введен пароль";
        exit();
    }
    
    $_SESSION["user"] = true;

    $_SESSION["id"] = $user['id'];

    header('Location: account.php');  

?>