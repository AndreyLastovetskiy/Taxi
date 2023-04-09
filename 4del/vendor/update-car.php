<?php
session_start();
require_once("../db/db.php");

$iduser = $_POST['iduser'];
$marka = $_POST['marka'];
$licpalte = $_POST['licpalte'];

mysqli_query($link, "UPDATE `cartaxi` SET `marka`='$marka',`licplate`='$licpalte' WHERE `iduser` = '$iduser'");

header("Location: ../detail.php?id=" . $iduser);
?>