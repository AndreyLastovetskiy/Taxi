<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
</head>
<body>
    <h1>Страница Авторизации</h1>
    <form action="./vendor/login.php" method="post">
        <input type="text" name="login" placeholder="Логин">
        <input type="password" name="password" placeholder="Пароль">
        <input type="submit" value="Вход">
    </form>
    <?php
	if (($_SESSION["errMes"] ?? '') === ''); else {
		print_r($_SESSION["errMes"]);
		session_destroy();
	}
	?>
</body>
</html>