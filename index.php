<?php

if($_COOKIE['idgroup'] == 1) {
    header("Location: ./admin/dashboard.php");
} elseif($_COOKIE['idgroup'] == 2) {
    header("Location: ./operator/operator.php");
} elseif($_COOKIE['idgroup'] == 3) {
    header("Location: ./taxidriver/taxidriver.php");
} else {
    header("Location: ./login.php");
}

?>