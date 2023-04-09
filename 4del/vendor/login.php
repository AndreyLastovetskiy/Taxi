<?php
session_start();
require_once("../db/db.php");

$login = $_POST['login'];
$password = $_POST['password'];

$sel_user = mysqli_query($link, "SELECT * FROM `user` WHERE `login` = '$login'");
$sel_user = mysqli_fetch_assoc($sel_user);

$idus = $sel_user['id'];
$idgr = $sel_user['idgroup'];
$seluser_pass = $sel_user['password'];

$datenow = date("Y-m-d");

$sel_operday = mysqli_query($link, "SELECT * FROM `operatorwd` WHERE `idoper` = '$idus' AND `date` = '$datenow'");
$sel_operday = mysqli_fetch_assoc($sel_operday);

$sel_driverday = mysqli_query($link, "SELECT * FROM `driverwd` WHERE `iddriver` = '$idus' AND `date` = '$datenow'");
$sel_driverday = mysqli_fetch_assoc($sel_driverday);

if(!empty($sel_user)) {
    if(password_verify($password, $seluser_pass)) {
        if($sel_user['idgroup'] == 1) {
            setcookie("id", $idus, time()+23760, "/");
            setcookie("idgroup", $idgr, time()+23760, "/");
            header("Location: ../index.php");
            exit();
        } 
        if ($sel_user['fired'] == 1) {
            $_SESSION["errMes"] = 'Вы уволены!';
            header("Location: ../login.php");
            exit();
        } elseif (empty($sel_operday) && empty($sel_driverday)) {
            $_SESSION["errMes"] = 'Вы не добавленны в смену!';
            header("Location: ../login.php");
            exit();
        } else {
            setcookie("id", $idus, time()+23760, "/");
            setcookie("idgroup", $idgr, time()+23760, "/");
            header("Location: ../index.php");
        }
    } else {
        $_SESSION["errMes"] = 'Пароль неверный!';
        header("Location: ../login.php");
    }
} else {
    $_SESSION["errMes"] = 'Такого пользователя не существует';
    header("Location: ../login.php");
} 

?>