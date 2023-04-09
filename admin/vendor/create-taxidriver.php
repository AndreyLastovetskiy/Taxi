<?php
if($_COOKIE['idgroup'] != 1) {
    $_SESSION["errMes"] = 'Доступ закрыт!';
    header("Location: ../index.php");
}
session_start();
require_once("../../db/db.php");

var_dump($_POST);

$user_group = 3;
$login = $_POST['login'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$fio = $_POST['fio'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$fired = 0;

$pass_hash = password_hash($password, PASSWORD_DEFAULT);

$sel_user = mysqli_query($link, "SELECT * FROM `user` WHERE `login` = '$login'");
$sel_user = mysqli_fetch_assoc($sel_user);
if(empty($sel_user)) {
    if($password != $cpassword) {
        $_SESSION["errMes"] = 'Пароли не совпадают';
        header("Location: ../dashboard.php");
    } else {
        $ins_user = mysqli_query($link, "INSERT INTO `user`(`idgroup`, `login`, `password`, `fio`, `phone`, `email`, `fired`) VALUES ('$user_group','$login','$pass_hash','$fio','$phone','$email','$fired')");
        if($ins_user) {
            mkdir("../../upload/userinfo/" . $login);

            $path_avatar = 'upload/userinfo' . '/' . $login . '/' . time() . $_FILES['avatar']['name'];
            $path_contract = 'upload/userinfo' . '/' . $login . '/' . time() . $_FILES['contract']['name'];
            move_uploaded_file($_FILES['avatar']['tmp_name'], '../../' . $path_avatar);
            move_uploaded_file($_FILES['contract']['tmp_name'], '../../' . $path_contract);

            $sel_path = mysqli_query($link, "SELECT * FROM `user` WHERE `login` = '$login'");
            $sel_path = mysqli_fetch_assoc($sel_path);
            $selpath_id = $sel_path['id'];
    
            mysqli_query($link, "INSERT INTO `usercart`(`iduser`, `avatar`, `contract`) VALUES ('$selpath_id','$path_avatar','$path_contract')");
    
            $_COOKIE["suc"] = "Оператор добавлен!";
            header("Location: ../dashboard.php");
        } else {
            header("Location: ../dashboard.php");
        }
        
    }
} else {
    $_SESSION["errMes"] = 'Такой пользователь уже существует';
    header("Location: ../dashboard.php");
}

?>