<?php

    include("../config/database.php");
    session_start();

    try {
        $db = new PDO('mysql:host=localhost', 'root', 'alplumet');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $err){
        die('mysql error: ' . $err->getMessage());
    }
    $db->exec("CREATE DATABASE IF NOT EXISTS camagru");
    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $err){
        die($err->getMessage());
    }
    $login = $_SESSION['loggued_user'];
    $notif = $_SESSION['notif'];
    if ($notif === 'Y')
        $notif = 'N';
    else
        $notif = 'Y';
    $req = $db->prepare("UPDATE user SET notif = ? WHERE login = ?");
    $req->execute(array ($notif, $login));
    $_SESSION['notif'] = $notif;
    header("Refresh: 0.0, url=../user/account.php");

?>