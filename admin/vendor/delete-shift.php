<?php
if($_COOKIE['idgroup'] != 1) {
    $_SESSION["errMes"] = 'Доступ закрыт!';
    header("Location: ../index.php");
}
session_start();
require_once("../../db/db.php");
$id_userop = $_POST['id_userop'];
$id_userdr = $_POST['id_userdr'];

$sum_salary = mysqli_query($link, "SELECT iduser, SUM(salary) AS driver_sum FROM `salary` GROUP BY `iduser`");
$sum_salary = mysqli_fetch_assoc($sum_salary);

$oper_salary = $sum_salary['driver_sum'];
$minus_tax = round($sum_salary['driver_sum']) - 300;

mysqli_query($link, "UPDATE `salary` SET `tax_salary`='$oper_salary' WHERE `iduser` = '$id_userop'");
mysqli_query($link, "UPDATE `salary` SET `tax_salary`='$minus_tax' WHERE `iduser` = '$id_userdr'");

mysqli_query($link, "UPDATE `operatorwd` SET `end` = '1' WHERE `operatorwd`.`end` = '0'");
mysqli_query($link, "UPDATE `driverwd` SET `end` = '1' WHERE `driverwd`.`end` = '0'");
header("Location: ../dashboard.php");
?>