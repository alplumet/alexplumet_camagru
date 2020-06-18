<?php

function auth($login, $passwd)
{
    include("../config/database.php");
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
    $stmt = $db->query("SELECT passwd FROM user WHERE login = '$login'")->fetch(PDO::FETCH_ASSOC);
    if (is_array($stmt))
        $stmt = implode($stmt);
    if (hash('whirlpool', $passwd) == $stmt){
        $tmp = $db->prepare("SELECT actif FROM user WHERE login like :login ");
        if($tmp->execute(array(':login' => $login))  && $row = $tmp->fetch())
             $actif = $row['actif']; // $actif contiendra alors 0 ou 1
        if ($actif == 1){
            $stmt2 = $db->query("SELECT email FROM user WHERE login = '$login'")->fetch(PDO::FETCH_ASSOC);
            $stmt3 = $db->query("SELECT id FROM user WHERE login = '$login'")->fetch(PDO::FETCH_ASSOC);
            $stmt4 = $db->query("SELECT notif FROM user WHERE login = '$login'")->fetch(PDO::FETCH_ASSOC);
            if (is_array($stmt2))
            $stmt2 = implode($stmt2);
            if (is_array($stmt3))
            $stmt3 = implode($stmt3);
            if (is_array($stmt4))
            $stmt4 = implode($stmt4);
            $_SESSION['loggued_user'] = $_POST['login'];
            $_SESSION['passwd'] = $stmt;
            $_SESSION['email'] = $stmt2;
            $_SESSION['id'] = $stmt3;
            $_SESSION['notif'] = $stmt4;
            return (TRUE);
        }
        else {
        echo "GO CHECK YOUR MAIL AND ACTIVATE YOUR ACCOUNT!";
        header("Refresh: 1, url=login.php");}

    }
	return (FALSE);
}
?>
