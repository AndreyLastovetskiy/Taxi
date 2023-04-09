<?php 
session_start();
if(!isset($_COOKIE["id"])) {
    $_SESSION["errMes"] = 'Вы не авторизованы, авторизуйтесь!';
    header("Location: ../../login.php");
}
if($_COOKIE['idgroup'] != 2) {
    $_SESSION["errMes"] = 'Доступ закрыт!';
    header("Location: ../../index.php");
}

require_once("../../db/db.php");
var_dump($_POST);
$phone = $_POST['phone'];
$nameuser = $_POST['nameuser'];
$timeout = $_POST['timeout'];
$start = $_POST['start'];
$finish = $_POST['finish'];
$price = $_POST['price'];
$driver = $_POST['driver'];
$free = 1;

$datenow = date("Y-m-d");
$time = $_POST['time'];
$accept = 0;

mysqli_query($link, "INSERT INTO `ord`
                    (`phone`, `nameuser`, `timeout`, `dateorder`, `time`, `start`, `finish`, `price`, `driver`, `accept`) 
                    VALUES ('$phone','$nameuser','$timeout', '$datenow', '$time','$start','$finish','$price','$driver', '$accept')"
                    );

mysqli_query($link, "UPDATE `driverwd` SET `free`='$free' WHERE `iddriver` = '$driver'");
header("Location: ../operator.php");
?>