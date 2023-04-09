<?php
require_once("../db/db.php");
$post = $_POST;
foreach($post as $pt) {
    $select_oper = mysqli_query($link, "SELECT * FROM `user` WHERE `id` = '$pt'");
    $select_oper = mysqli_fetch_assoc($select_oper);

    $select_operid = $select_oper['id'];
    $datenow = date("Y-m-d");
    print_r($select_oper);

    mysqli_query($link, "INSERT INTO `operatorwd`(`idoper`, `date`) VALUES ('$select_operid','$datenow')");
}
header("Location: ../dashboard.php");
?>