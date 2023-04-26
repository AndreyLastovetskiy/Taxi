<?php
if($_COOKIE['idgroup'] != 1) {
    $_SESSION["errMes"] = 'Доступ закрыт!';
    header("Location: ../index.php");
}
require_once("../db/db.php");
$user_id = $_GET['id'];

mysqli_query($link, "UPDATE `user` SET `fired`='1' WHERE `id` = '$user_id'");

header("Location: ./dashboard.php");

?>