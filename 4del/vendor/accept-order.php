<?php
require_once("../db/db.php");
var_dump($_POST);
$id = $_POST['id'];
$comment = $_POST['comment'];
$diss = $_POST['diss'];

$sel_diss = mysqli_query($link, "SELECT * FROM `dissatisfaction` WHERE `id` = '$diss'");
$sel_diss = mysqli_fetch_assoc($sel_diss);

$diss_text = $sel_diss['diss'];

mysqli_query($link, "INSERT INTO `acceptord`(`idord`, `comment`, `dissatisfaction`) VALUES ('$id','$comment','$diss_text')");
mysqli_query($link, "UPDATE `ord` SET `accept` = 1 WHERE `id` = '$id'");

header("Location: ../dashboard.php");
?>