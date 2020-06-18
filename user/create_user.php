<?php

    include("../config/database.php");
    include("check.php");
    include("../mail/mail_inscription.php");

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

    if ($_POST['login'] && $_POST['passwd1'] && $_POST['passwd2'] && $_POST['email']){
        if (strlen($_POST['login']) > 23)
            echo "Login is too long, 24 caracters max!";
        else if ($_POST['passwd1'] !== $_POST['passwd2']){
            echo "Please Type Same Password";}
        else if (strlen($_POST['passwd1']) < 4){
            echo "Password is too short my friend.";
        }
        else {
            if (check_login($_POST['login'], $db) && check_email($_POST['email'], $db)){
                $key = kodex_random_string();
                $req = $db->prepare("INSERT INTO user(login,passwd,email) VALUES (:login,:passwd,:email)");
                $req->execute(array ('login'=>$_POST['login'],
                                    'passwd'=>hash('whirlpool', $_POST['passwd1']),
                                    'email'=>$_POST['email']));
                send_the_confirmation_mail($db, $_POST['login'], $_POST['email'], $key);
                echo "<h1>Confirm with the link on your adress mail</h1>";
            }
            else
                header("Refresh: 2.0, url=login.php");
        }
    }
    else
        echo "One or more Fields are empty";
    header("Refresh: 5.0, url=login.php");

    function kodex_random_string($length=20){
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        for($i=0; $i<$length; $i++){
            $string .= $chars[rand(0, strlen($chars)-1)];
        }
        return $string;
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>

<body>
    
</body>

</html>