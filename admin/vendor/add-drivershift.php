<?php
if($_COOKIE['idgroup'] != 1) {
    $_SESSION["errMes"] = 'Доступ закрыт!';
    header("Location: ../index.php");
}
require_once("../../db/db.php");
$post = $_POST;
foreach($post as $pt) {
    $select_oper = mysqli_query($link, "SELECT * FROM `user` WHERE `id` = '$pt'");
    $select_oper = mysqli_fetch_assoc($select_oper);

    $select_operid = $select_oper['id'];
    $datenow = date("Y-m-d");
    $end = 0;
    print_r($select_oper);

    mysqli_query($link, "INSERT INTO `driverwd`(`iddriver`, `date`, `end`) VALUES ('$select_operid','$datenow', '$end')");
}
header("Location: ../dashboard.php");
?>