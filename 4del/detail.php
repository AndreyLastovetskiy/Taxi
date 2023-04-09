<?php
require_once("./db/db.php");
$id_user = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <title>Доп информация</title>
</head>
<body>
    <?php
    $sel_user = mysqli_query($link, "SELECT * FROM `user` WHERE `id` = '$id_user'");
    $sel_user = mysqli_fetch_assoc($sel_user);

    $sel_avatar = mysqli_query($link, "SELECT * FROM `usercart` WHERE `iduser` = '$id_user'");
    $sel_avatar = mysqli_fetch_assoc($sel_avatar);

    $sel_car = mysqli_query($link, "SELECT * FROM `cartaxi` WHERE `iduser` = '$id_user'");
    $sel_car = mysqli_fetch_assoc($sel_car);

    if($sel_user['idgroup'] == 1) {
        $role = "Администратор";
    } elseif ($sel_user['idgroup'] == 2) {
        $role = "Оператор";
    } elseif ($sel_user['idgroup'] == 3) {
        $role = "Таксист";
    }

    if($sel_user['fired'] == 0) {
        $fire = "Не уволен";
    } else {
        $fire = "Уволен";
    }
    ?>
    <h2>Инфомация о пользователе - <?php echo $sel_user['fio']; ?> (<?php echo $role; ?>)</h2>
    <div class="more-info">
        <img src="<?php print("./" . $sel_avatar['avatar']); ?>" alt="Аватара нет">
        <p>Логин: <?php echo $sel_user['login']; ?></p>
        <p>ФИО: <?php echo $sel_user['fio']; ?></p>
        <p>Тел.: <?php echo $sel_user['phone']; ?></p>
        <p>Email: <?php echo $sel_user['email']; ?></p>
        <?php 
        if($sel_user['idgroup'] == 3) { ?>
        <p>Машина: <?php echo $sel_car['marka'] . " | " . $sel_car['licplate']; ?></p>
        <a href="./update-car.php?id=<?php echo $id_user; ?>">Изменить данные машины</a>
        <?php } ?>
        <img src="<?php print("./" . $sel_avatar['contract']); ?>" alt="Трудового договора нет">
        <p><?php echo $fire; ?></p>
    </div>
    <a href="./dashboard.php">Назад</a>
</body>
</html>