<?php
session_start();
if(!isset($_COOKIE["id"])) {
    $_SESSION["errMes"] = 'Вы не авторизованы, авторизуйтесь!';
    header("Location: ./login.php");
}
if($_COOKIE['idgroup'] != 1) {
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
    <div class="create-oper-taxi">
        <div class="cot-oper">
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
        </div>
        
        <div class="cot-taxi">
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
        </div>

        <div class="cot-cartaxi">
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
        </div>
        
        <div class="add-opershift">
            <h4>Добавить оператора на смену</h4>
            <form action="./vendor/add-opershift.php" method="post">
                <?php 
                    $sel_operday = mysqli_query($link, "SELECT user.id, user.login
                                                        FROM user
                                                        LEFT JOIN operatorwd ON user.id = operatorwd.idoper AND operatorwd.end = 0
                                                        WHERE operatorwd.idoper IS NULL AND user.idgroup = '2'");
                    $sel_operday = mysqli_fetch_all($sel_operday);
                    foreach ($sel_operday as $sod) { ?>
                        <div class="check">
                            <input type="checkbox" name="<?php echo $sod[0]; ?>" value="<?php echo $sod[0]; ?>"> <?php echo $sod[1]; ?>
                        </div>
                    <?php } 
                    if(empty($sel_operday)) {
                        $empty = "Все пользователи заняты!"; ?>
                        <p><?= $empty; ?></p>
                    <?php }
                ?>
            <input type="submit" value="Записать на смену">
            </form>
        </div>
        
        <div class="add-dirvershift">
            <h4>Добавить водителя на смену</h4>
            <form action="./vendor/add-drivershift.php" method="post">
                <?php 
                    $sel_driverday = mysqli_query($link, "SELECT user.id, user.login
                                                        FROM user
                                                        LEFT JOIN driverwd ON user.id = driverwd.iddriver AND driverwd.end = 0
                                                        WHERE driverwd.iddriver IS NULL AND user.idgroup = '3'");
                    $sel_driverday = mysqli_fetch_all($sel_driverday);
                    foreach ($sel_driverday as $sdd) { ?>
                        <div class="check">
                            <input type="checkbox" name="<?php echo $sdd[0]; ?>" value="<?php echo $sdd[0]; ?>"> <?php echo $sdd[1]; ?>
                        </div>
                <?php }
                    if(empty($sel_driverday)) {
                        $empty = "Все пользователи заняты!"; ?>
                        <p><?php echo $empty; ?></p>
                    <?php }
                ?>
                <input type="submit" value="Записать на смену">
            </form>
        </div>
    
        <div class="user-shift">
            <h4>Пользователи на смене</h4>
            <form action="./vendor/delete-shift.php" method="post">
                <?php 
                    $sel_opershift = mysqli_query($link, "SELECT user.id, user.login
                                                        FROM user
                                                        LEFT JOIN operatorwd ON user.id = operatorwd.idoper 
                                                        WHERE operatorwd.end = 0 AND user.idgroup = '2'");
                    $sel_opershift = mysqli_fetch_all($sel_opershift);

                    foreach($sel_opershift as $sosh) { ?> 
                        <p><?= $sosh[1]; ?></p>
                        <input type="hidden" name="id_userop" value="<?= $sosh[0]; ?>">
                    <?php } 

                    $sel_drivershift = mysqli_query($link, "SELECT user.id, user.login
                                                        FROM user
                                                        LEFT JOIN driverwd ON user.id = driverwd.iddriver
                                                        WHERE driverwd.end = 0 AND user.idgroup = '3'");
                    $sel_drivershift = mysqli_fetch_all($sel_drivershift);

                    foreach($sel_drivershift as $sdsh) { ?> 
                        <p><?= $sdsh[1]; ?></p>
                        <input type="hidden" name="id_userdr" value="<?= $sdsh[0]; ?>">
                    <?php } 
                ?>
                <input type="submit" value="Закрыть смену">
            </form>
        </div>
    </div>
    <div class="all-oper">
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
    </div>
    <div class="all-taxidriver">
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
    </div>

    <form action="" method="post"></form>
</body>
</html>