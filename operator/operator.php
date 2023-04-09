<?php
session_start();
if(!isset($_COOKIE["id"])) {
    $_SESSION["errMes"] = 'Вы не авторизованы, авторизуйтесь!';
    header("Location: ../login.php");
}
if($_COOKIE['idgroup'] != 2) {
    $_SESSION["errMes"] = 'Доступ закрыт!';
    header("Location: ../index.php");
}
require_once("../db/db.php");
$id_user = $_COOKIE['id'];
$id_group = $_COOKIE['idgroup'];

$select_user = mysqli_query($link, "SELECT * FROM `user` WHERE `id` = '$id_user'");
$select_user = mysqli_fetch_assoc($select_user);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Панель управления</title>
</head>
<body>
    <h2>Добро Пожаловать, <?php echo $select_user['fio'] ?>!</h2>
    <a href="../logut.php">Выйти</a>
    <?php
    $sel_price = mysqli_query($link, "SELECT * FROM `salary` WHERE `iduser` = '$id_user'");
    $sel_price = mysqli_fetch_assoc($sel_price);
    ?>
    <p>Ваш баланс на сегодня: <?= $sel_price['salary']; ?> руб</p>

    <div class="create-order">
        <h4>Создать заказ</h4>
        <form action="./vendor/create-order.php" method="post" class="create-order">
            <input type="text" name="phone" placeholder="Телефон">
            <input type="text" name="nameuser" placeholder="Имя">
            <input type="text" name="time" placeholder="Время">
            <input type="text" name="timeout" placeholder="Время ожидания">
            <input type="text" name="start" placeholder="Место отправления">
            <input type="text" name="finish" placeholder="Место прибытия">
            <input type="text" name="price" placeholder="Цена">
            <?php 
                $sel_driverday = mysqli_query($link, "SELECT user.id, user.login
                                                    FROM user
                                                    LEFT JOIN driverwd ON user.id = driverwd.iddriver AND driverwd.end = 0
                                                    WHERE user.idgroup = '3'");
                $sel_driverday = mysqli_fetch_all($sel_driverday);
                foreach ($sel_driverday as $sdd) { ?>
                    <div class="check">
                        <input type="radio" name="driver" value="<?php echo $sdd[0]; ?>"> <?php echo $sdd[1]; ?>
                    </div>
                <?php } ?>
            <input type="submit" value="Создать">
        </form>
    </div>

    <div class="all-orders">
        <?php 
        $datenow = date("Y-m-d");
        $sel_order = mysqli_query($link, "SELECT * FROM `ord` WHERE `dateorder` = '$datenow' AND `accept` = 0");
        $sel_order = mysqli_fetch_assoc($sel_order);

        if(!empty($sel_order)) { ?>
            <a href="moreorder.php?id=<?php echo $sel_order['id']; ?>">Заказ № <?php echo $sel_order['id']; ?></a>
            <p>Статус: <?php
            if($sel_order['accept'] == 0) {
                $status = "Исполняется";
            } elseif ($sel_order['accept'] == 1) {
                $status = "Выполнен";
            } elseif($sel_order['accept'] == 2) {
                $status = "Не исполнен";
            }
            echo $status;
            ?></p>
        <?php } ?>
    </div>
</body>
</html>