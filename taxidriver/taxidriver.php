<?php
session_start();
if(!isset($_COOKIE["id"])) {
    $_SESSION["errMes"] = 'Вы не авторизованы, авторизуйтесь!';
    header("Location: ../login.php");
}
if($_COOKIE['idgroup'] != 3) {
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
    $sel_salary = mysqli_query($link, "SELECT * FROM `salary` WHERE `iduser` = '$id_user'");
    $sel_salary = mysqli_fetch_assoc($sel_salary);
    ?>
    <p>Ваш баланс на сегодня: <?= $sel_salary['salary']; ?> руб</p>

    <div class="add-photocar">
        <?php 
        $datenow = date("Y-m-d");
        $sel_carphoto = mysqli_query($link, "SELECT * FROM `carphoto` WHERE `iddriver` = '$id_user' AND `postdate` = '$datenow'");
        $sel_carphoto = mysqli_fetch_assoc($sel_carphoto);

        
        if($_COOKIE['idgroup'] == 3) {
            if(empty($sel_carphoto)) { ?>
                <h4>Загрузить фото машины</h4>
                <form action="./vendor/add-photocar.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="car" required>
                    <label for="car">Фото машины</label>
                    <input type="submit" value="Добавить">
                </form>
            <?php } 
        } ?>
    </div>

    <div class="orders">
        <?php 
        if($_COOKIE['idgroup'] == 3) { 
            $sel_order = mysqli_query($link, "SELECT * FROM `ord` WHERE `driver` = '$id_user' AND `accept` = 0");
            $sel_order = mysqli_fetch_assoc($sel_order);

            if(!empty($sel_order)) { ?>
                <h4>Заказ</h4>
                <p>Телефон клиента: <?php echo $sel_order['phone']; ?></p>
                <p>Имя клиента: <?php echo $sel_order['nameuser']; ?></p>
                <p>Время ожидания: <?php echo $sel_order['timeout']; ?></p>
                <p>Откуда: <?php echo $sel_order['start']; ?></p>
                <p>Куда: <?php echo $sel_order['finish']; ?></p>
                <p>Цена: <?php echo $sel_order['price']; ?></p>
            <?php } ?>
        <?php } ?>
    </div> 
</body>
</html>