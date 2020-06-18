<?php

session_start();
$_SESSION['loggued_user'] = "";
$_SESSION['passwd'] = "";
$_SESSION['email'] = "";
$_SESSION['id'] = "";
$_SESSION['notif'] = "";
header("Refresh: 0.0, url=../index.php");

?>
