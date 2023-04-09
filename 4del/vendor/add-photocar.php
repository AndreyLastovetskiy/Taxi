<?php
session_start();
require_once("../db/db.php");

$id_driver = $_COOKIE['id'];

$select_driver = mysqli_query($link, "SELECT * FROM `user` WHERE `id` = '$id_driver'");
$select_driver = mysqli_fetch_assoc($select_driver);

$date = date("Y-m-d");
$login_driver = $select_driver['login'];

mkdir("../upload/cars/" . $date);
mkdir("../upload/cars/" . $date . '/' . $login_driver);

$path_car = 'upload/cars' . '/' . $date . '/' . $login_driver . '/' . time() . $_FILES['car']['name'];
move_uploaded_file($_FILES['car']['tmp_name'], '../' . $path_car);

mysqli_query($link, "INSERT INTO `carphoto`(`iddriver`, `carpath`, `postdate`) VALUES ('$id_driver','$path_car','$date')");
header("Location: ../dashboard.php");

?>