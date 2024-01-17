<?php
require("connectdb.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Авторизация</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/auth_reg.css">
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card custom-card">
        <div class="card-header bg-primary">
          Авторизация
        </div>
        <?php if (isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $error_message; ?>
        </div>
        <?php endif; ?>


        <div class="card-body">
          <form action="auth_check.php" method="post">
            <div class="form-group">
              <label for="username">Имя пользователя:</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
              <label for="password">Пароль:</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Войти</button>
          </form>

          <!-- Способы перехода -->
          <div class="row mt-3">
              <div class="col-md-6">
                <a href="register.php" class="btn btn-secondary btn-block">Создать новый аккаунт</a>
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
</body>
</html>