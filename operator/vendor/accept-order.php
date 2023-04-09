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
$id = $_POST['id'];
$comment = $_POST['comment'];
$diss = $_POST['diss'];
$rating = $_POST['rating'];
$salary = $_POST['salary'] / 2;
$driver = $_POST['driver'];
$oper = $_COOKIE["id"];
$datenow = date("Y-m-d");


$sel_diss = mysqli_query($link, "SELECT * FROM `dissatisfaction` WHERE `id` = '$diss'");
$sel_diss = mysqli_fetch_assoc($sel_diss);

$diss_text = $sel_diss['diss'];

mysqli_query($link, "INSERT INTO `acceptord`(`idord`, `comment`, `rating`, `dissatisfaction`) VALUES ('$id','$comment', '$rating', '$diss_text')");
mysqli_query($link, "INSERT INTO `salary`(`iduser`, `date`, `salary`) VALUES ('$driver','$datenow','$salary')");
mysqli_query($link, "INSERT INTO `salary`(`iduser`, `date`, `salary`) VALUES ('$oper','$datenow','$salary')");
mysqli_query($link, "UPDATE `ord` SET `accept` = 1 WHERE `id` = '$id'");

header("Location: ../operator.php");
?>