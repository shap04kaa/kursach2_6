<?php
require("connectdb.php");
require("session.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Регистрация</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/auth_reg.css">
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card custom-card">
        <div class="card-header bg-primary">
          Регистрация
        </div>
        <div class="card-body">
          <form action="reg_check.php" method="post">
            <div class="form-group">
              <label for="username">Придумайте логин:</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group mb-0">
              <label for="password">Пароль:</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <small id="passwordHelp" class="form-text text-muted">*минимум 8 символов</small>
            <div class="form-group mt-3">
              <label for="confirm_password">Подтвердите пароль:</label>
              <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Зарегестрироваться</button>
          </form>
        
          <!-- Способы перехода -->
          <div class="row mt-3">
              <div class="col-md-6">
                <a href="auth.php" class="btn btn-secondary btn-block">Войти в аккаунт</a>
              </div>
              <div class="col-md-6">
                <a href="index.php" class="btn btn-secondary btn-block">На главную</a>
              </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  /*Проверка совпадения паролей*/
  document.addEventListener("DOMContentLoaded", function () {
    var password = document.getElementById("password");
    var confirm_password = document.getElementById("confirm_password");

    function validatePassword() {
      if (password.value !== confirm_password.value) {
        confirm_password.setCustomValidity("Пароли не совпадают");
      } else {
        confirm_password.setCustomValidity("");
      }
    }

    password.addEventListener("input", validatePassword);
    confirm_password.addEventListener("input", validatePassword);
  });
</script>
</body>
</html>

