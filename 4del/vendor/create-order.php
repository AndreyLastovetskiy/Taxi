<?php 
require_once("../db/db.php");
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

mysqli_query($link, "INSERT INTO `ord`
                    (`phone`, `nameuser`, `timeout`, `dateorder`, `time`, `start`, `finish`, `price`, `driver`) 
                    VALUES ('$phone','$nameuser','$timeout', , , '$start','$finish','$price','$driver')"
                    );

mysqli_query($link, "UPDATE `driverwd` SET `free`='$free' WHERE `iddriver` = '$driver'");
header("Location: ../dashboard.php");
?>