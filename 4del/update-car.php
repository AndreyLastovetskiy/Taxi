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
    <title>Document</title>
</head>
<body>
    <?php
    $select_car = mysqli_query($link, "SELECT * FROM `cartaxi` WHERE `iduser` = '$id_user'");
    $select_car = mysqli_fetch_assoc($select_car);

    $select_driver = mysqli_query($link, "SELECT * FROM `user` WHERE `id` = '$id_user'");
    $select_driver = mysqli_fetch_assoc($select_driver);
    ?>
    <p>Данные машины таксиста - <?php echo $select_driver['fio']; ?></p>
    <form action="./vendor/update-car.php" method="post">
        <input type="hidden" name="iduser" value="<?php echo $id_user; ?>">
        <input type="text" name="marka" value="<?php echo $select_car['marka']; ?>">
        <input type="text" name="licpalte" value="<?php echo $select_car['licplate']; ?>">
        <input type="submit" value="Изменить">
    </form>
</body>
</html>