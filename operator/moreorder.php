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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="all-orders">
        <?php 
        $datenow = date("Y-m-d");
        if($_COOKIE['idgroup'] == 2) { 
            $sel_order = mysqli_query($link, "SELECT * FROM `ord` WHERE `dateorder` = '$datenow' AND `accept` = 0");
            $sel_order = mysqli_fetch_assoc($sel_order);

            if(!empty($sel_order)) { ?>
                <h4>Заказ № <?php echo $sel_order['id']; ?></h4>
                <p>Телефон клиента: <?php echo $sel_order['phone']; ?></p>
                <p>Имя клиента: <?php echo $sel_order['nameuser']; ?></p>
                <p>Время ожидания: <?php echo $sel_order['timeout']; ?></p>
                <p>Откуда: <?php echo $sel_order['start']; ?></p>
                <p>Куда: <?php echo $sel_order['finish']; ?></p>
                <p>Цена: <?php echo $sel_order['price']; ?> руб</p>
                <form action="./vendor/accept-order.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $sel_order['id']; ?>">
                    <input type="hidden" name="salary" value="<?php echo $sel_order['price']; ?>">
                    <input type="hidden" name="driver" value="<?php echo $sel_order['driver']; ?>">
                    <textarea name="comment"cols="30" rows="10" placeholder="Отзыв"></textarea>
                    <p><strong>Оценка поездки</strong></p>
                    <div class="radio">
                        <input type="radio" name="rating" value="1"> 1
                    </div>
                    <div class="radio">
                        <input type="radio" name="rating" value="2"> 2
                    </div>
                    <div class="radio">
                        <input type="radio" name="rating" value="3"> 3
                    </div>
                    <div class="radio">
                        <input type="radio" name="rating" value="4"> 4
                    </div>
                    <div class="radio">
                        <input type="radio" name="rating" value="5"> 5
                    </div>
                    <p><strong>Жалоба</strong></p>
                    <?php 
                    $sel_diss = mysqli_query($link, "SELECT * FROM `dissatisfaction`");
                    $sel_diss = mysqli_fetch_all($sel_diss);
                    foreach($sel_diss as $sd) { ?>
                        <div class="radio">
                            <input type="radio" name="diss" value="<?php echo $sd[0]; ?>"> <?php echo $sd[1]; ?>
                        </div>
                    <?php } ?>
                    <input type="submit" value="Завершить">
                </form>
            <?php } ?>
        <?php } ?>
    </div>
</body>
</html>