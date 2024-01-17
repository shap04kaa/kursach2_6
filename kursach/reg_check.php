<?php
    require("connectdb.php");
    require("session.php");

    $login = $_POST['username'];

    $email = $_POST['email'];

    $pass = $_POST['password'];

    $role = 'user';
    
    
    if(strlen($login) < 3) {
        echo "Слишком маленький логин";
        exit();
    } elseif(strlen($login) > 50) {
        echo "Слишком большой логин";
        exit();
    } elseif(strlen($pass) < 8) {
        echo "Слишком маленький пароль";
        exit();
    } elseif(strlen($pass) > 50) {
        echo "Слишком большой пароль";
        exit();
    }

    $pass = md5($pass."qwpfgow234");

    $result1 = mysqli_query($connect, "SELECT * FROM users WHERE login =  \"".$login."\";");
    $user1 = mysqli_fetch_assoc($result1);

    $result2 = mysqli_query($connect, "SELECT * FROM users WHERE email = \"".$email."\";");
    $email1 = mysqli_fetch_assoc($result2);

    if ($user1) {
        echo "Такой логин уже существует";
        exit();
    } elseif ($email1) {
        echo "Такая почта уже привязана";
        exit();
    }

    mysqli_query($connect, "INSERT INTO users (login, password, email, role) VALUES (
        \"".$login."\", 
        \"".$pass."\",
        \"".$email."\",
        \"".$role."\"
        )"
    );
    
    $session_user = true;

    header('Location: auth.php');   
?>