<?php
if($_COOKIE['idgroup'] != 1) {
    $_SESSION["errMes"] = 'Доступ закрыт!';
    header("Location: ../index.php");
}
session_start();
require_once("../../db/db.php");

$marka = $_POST['marka'];
$license_plate = $_POST['license_plate'];
$taxidrivers = $_POST['taxidrivers'];

mysqli_query($link, "INSERT INTO `cartaxi`(`iduser`, `marka`, `licplate`) VALUES ('$taxidrivers','$marka','$license_plate')");
header("Location: ../dashboard.php");

?>