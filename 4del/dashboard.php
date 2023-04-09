<?php
session_start();
if(!isset($_COOKIE["id"])) {
    $_SESSION["errMes"] = 'Вы не авторизованы, авторизуйтесь!';
    header("Location: ./login.php");
}
require_once("./db/db.php");
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
    <link rel="stylesheet" href="./style/style.css">
    <title>Панель управления</title>
</head>
<body>
    <h2>Добро Пожаловать, <?php echo $select_user['fio'] ?>!</h2>
    <a href="logut.php">Выйти</a>
    <div class="create-oper-taxi">
        <div class="cot-oper">
            <?php
            if($_COOKIE['idgroup'] == 1) { ?>
                <h4>Добавить оператора</h4>
                <form action="./vendor/create-operator.php" enctype="multipart/form-data" method="post" class="create-operator">
                    <input type="text" name="login" placeholder="Логин" required>
                    <input type="password" name="password" placeholder="Пароль" required>
                    <input type="password" name="cpassword" placeholder="Подтверждение пароля" required>
                    <input type="text" name="fio" placeholder="ФИО" required>
                    <input type="text" name="phone" placeholder="Телефон" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="file" name="avatar" required>
                    <label for="avatar">Аватар</label>
                    <input type="file" name="contract" required>
                    <label for="contract">Трудовой договор</label>
                    <input type="submit" value="Создать">
                </form>
                <?php
                if (($_SESSION["errMes"] ?? '') === ''); else {
                    print_r($_SESSION["errMes"]);
                    session_destroy();
                }
                ?>
                <?php
                if (($_SESSION["suc"] ?? '') === ''); else {
                    print_r($_SESSION["suc"]);
                    session_destroy();
                }
                ?>
            <?php } ?>
        </div>
        
        <div class="cot-taxi">
            <?php
            if($_COOKIE['idgroup'] == 1) { ?>
                <h4>Добавить таксиста</h4>
                <form action="./vendor/create-taxidriver.php" enctype="multipart/form-data" method="post" class="create-operator">
                    <input type="text" name="login" placeholder="Логин" required>
                    <input type="password" name="password" placeholder="Пароль" required>
                    <input type="password" name="cpassword" placeholder="Подтверждение пароля" required>
                    <input type="text" name="fio" placeholder="ФИО" required>
                    <input type="text" name="phone" placeholder="Телефон" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="file" name="avatar" required>
                    <label for="avatar">Аватар</label>
                    <input type="file" name="contract" required>
                    <label for="contract">Трудовой договор</label>
                    <input type="submit" value="Создать">
                </form>
                <?php
                if (($_SESSION["errMes"] ?? '') === ''); else {
                    print_r($_SESSION["errMes"]);
                    session_destroy();
                }
                ?>
                <?php
                if (($_SESSION["suc"] ?? '') === ''); else {
                    print_r($_SESSION["suc"]);
                    session_destroy();
                }
                ?>
            <?php } ?>
        </div>

        <div class="cot-cartaxi">
            <?php
            if($_COOKIE['idgroup'] == 1) { ?>
                <h4>Добавить машину таксиста</h4>
                <form action="./vendor/create-cartaxi.php" enctype="multipart/form-data" method="post" class="create-operator">
                    <input type="text" name="marka" placeholder="Марка" required>
                    <input type="text" name="license_plate" placeholder="Номерной знак" required>
                    <?php 
                    $sel_taxidriver = mysqli_query($link, "SELECT * FROM `user` LEFT JOIN `cartaxi` ON `user`.`id`=`cartaxi`.`iduser` WHERE `cartaxi`.`iduser` IS NULL AND`user`.`idgroup` = 3 ORDER BY `user`.`id`");
                    $sel_taxidriver = mysqli_fetch_all($sel_taxidriver);
                    foreach ($sel_taxidriver as $str) { ?>
                        <div class="radio">
                            <input type="radio" name="taxidrivers" value="<?php echo $str[0]; ?>"> <?php echo $str[2]; ?>
                        </div>
                    <?php } ?>
                    <input type="submit" value="Прикрепить">
                </form>
                <?php
                if (($_SESSION["errMes"] ?? '') === ''); else {
                    print_r($_SESSION["errMes"]);
                    session_destroy();
                }
                ?>
                <?php
                if (($_SESSION["suc"] ?? '') === ''); else {
                    print_r($_SESSION["suc"]);
                    session_destroy();
                }
                ?>
            <?php } ?>
        </div>
        <div class="add-opershift">
            <?php
            if($_COOKIE['idgroup'] == 1) { ?>
                <h4>Добавить оператора на смену</h4>
                <form action="./vendor/add-opershift.php" method="post">
                <?php 
                    $datenow = date("Y-m-d");
                    $sel_operday = mysqli_query($link, "SELECT * FROM `user` LEFT JOIN `operatorwd` ON `user`.`id`=`operatorwd`.`idoper` WHERE `operatorwd`.`date` > '$datenow' OR `operatorwd`.`date` IS NULL AND `user`.`idgroup` = 2 AND `user`.`fired` != 1 ORDER BY `user`.`id`");
                    $sel_operday = mysqli_fetch_all($sel_operday);
                    foreach ($sel_operday as $sod) { ?>
                        <div class="check">
                            <input type="checkbox" name="<?php echo $sod[0]; ?>" value="<?php echo $sod[0]; ?>"> <?php echo $sod[2]; ?>
                        </div>
                <?php } 
                    if(empty($sel_operday)) { 
                        $empty = "Все пользователи заняты!"; ?>
                        <p><?php echo $empty; ?></p>
                    <?php }
                ?>
                <input type="submit" value="Записать на смену">
                </form>
            <?php } ?>
        </div>
        <div class="add-dirvershift">
            <?php
            if($_COOKIE['idgroup'] == 1) { ?>
                <h4>Добавить водителя на смену</h4>
                <form action="./vendor/add-drivershift.php" method="post">
                <?php 
                    $datenow = date("Y-m-d");
                    //$sel_driverday = mysqli_query($link, "SELECT * FROM `user` LEFT JOIN `driverwd` ON `user`.`id`=`driverwd`.`iddriver` WHERE `driverwd`.`date` != '$datenow' OR `driverwd`.`date` IS NULL AND `user`.`idgroup` = 3 AND `user`.`fired` != 1 ORDER BY `user`.`id`");
                    $sel_driverday = mysqli_query($link, "SELECT * FROM `user` LEFT JOIN `driverwd` ON `user`.`id`=`driverwd`.`iddriver` WHERE `driverwd`.`date` > '$datenow' OR `driverwd`.`date` IS NULL AND `user`.`idgroup` = 3 AND `user`.`fired` != 1 ORDER BY `user`.`id`");
                    $sel_driverday = mysqli_fetch_all($sel_driverday);
                    foreach ($sel_driverday as $sdd) { ?>
                        <div class="check">
                            <input type="checkbox" name="<?php echo $sdd[0]; ?>" value="<?php echo $sdd[0]; ?>"> <?php echo $sdd[2]; ?>
                        </div>
                <?php }
                    if(empty($sel_driverday)) {
                        $empty = "Все пользователи заняты!"; ?>
                        <p><?php echo $empty; ?></p>
                    <?php }
                ?>
                <input type="submit" value="Записать на смену">
                </form>
            <?php } ?>
        </div>
    </div>
    <div class="all-oper">
        <?php
        if($_COOKIE['idgroup'] == 1) { ?>
            <h4>Все операторы</h4>
            <?php 
            $select_all = mysqli_query($link, "SELECT * FROM `user` WHERE `idgroup` = 2 ORDER BY `id` DESC");
            $select_all = mysqli_fetch_all($select_all);

            foreach($select_all as $sa) { ?> 
                <div class="au-cart">
                    <div class="auc-info">
                        <?php 

                        if($sa[7] == 0) {
                            $fire = "Не уволен";
                        } else {
                            $fire = "Уволен";
                        }
                        ?>
                        <p>ФИО: <?php echo $sa[4]; ?></p>
                        <p>Тел.: <?php echo $sa[5]; ?></p>
                        <p>Должность: оператор</p>
                        <p><?php echo $fire; ?></p>
                    </div>
                    <div class="auc-urls">
                        <a href="./detail.php?id=<?php echo $sa[0]; ?>">Подробнее</a>
                        <a href="./dismiss.php?id=<?php echo $sa[0]; ?>" style="color: red;">Уволить</a>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="all-taxidriver">
        <?php
        if($_COOKIE['idgroup'] == 1) { ?> 
            <h4>Все таксисты</h4>
            <?php
            $select_taxidriver = mysqli_query($link, "SELECT * FROM `user` WHERE `idgroup` = 3 ORDER BY `id` DESC");
            $select_taxidriver = mysqli_fetch_all($select_taxidriver);

            foreach($select_taxidriver as $st) { ?>
                <div class="au-cart">
                    <div class="auc-info">
                        <?php 
                        if($st[7] == 0) {
                            $fire = "Не уволен";
                        } else {
                            $fire = "Уволен";
                        }
                        ?>
                        <p>ФИО: <?php echo $st[4]; ?></p>
                        <p>Тел.: <?php echo $st[5]; ?></p>
                        <p>Должность: таксист</p>
                        <p><?php echo $fire; ?></p>
                    </div>
                    <div class="auc-urls">
                        <a href="./detail.php?id=<?php echo $st[0]; ?>">Подробнее</a>
                        <a href="./dismiss.php?id=<?php echo $st[0]; ?>" style="color: red;">Уволить</a>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>

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

    <div class="create-order">
        <?php 
        if($_COOKIE['idgroup'] == 2) { ?>
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
                $datenow = date("Y-m-d");
                $sel_driverday = mysqli_query($link, "SELECT * FROM `user` LEFT JOIN `driverwd` ON `user`.`id`=`driverwd`.`iddriver` WHERE `driverwd`.`date` = '$datenow' AND `user`.`idgroup` = 3 AND `driverwd`.`free` = 0 ORDER BY `user`.`id`");
                $sel_driverday = mysqli_fetch_all($sel_driverday);
                foreach ($sel_driverday as $sdd) { ?>
                    <div class="radio">
                        <input type="radio" name="driver" value="<?php echo $sdd[0]; ?>"> <?php echo $sdd[2]; ?>
                    </div>
            <?php } ?>
            <input type="submit" value="Создать">
        </form>
        <?php } ?>
    </div>

    <div class="all-orders">
        <?php 
        if($_COOKIE['idgroup'] == 2) { 
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
        <?php } ?>
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