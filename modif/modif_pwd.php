<?php

    include("../config/database.php");
    session_start();
    if (hash('whirlpool', $_POST['password']) === $_SESSION['passwd']){
        if ($_POST['password'] !== $_POST['password1']){
            if ($_POST['password1'] === $_POST['password2']){
                try {
                    $db = new PDO('mysql:host=localhost', 'root', 'alplumet');
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
                catch (PDOException $err){
                    die('mysql error: ' . $err->getMessage());
                }
                try {
                    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
                catch (PDOException $err){
                    die($err->getMessage());
                }
                $login = $_SESSION['loggued_user'];
                $password = hash('whirlpool', $_POST['password1']);
                $req = $db->prepare("UPDATE user SET passwd = ? WHERE login = ?");
                $req->execute(array ($password, $login));
                $_SESSION['passwd'] = $password;
                echo '<h1>Password successfully changed!</h1>';
                header("Refresh: 1.0, url=../user/account.php");
            }
            else{
                echo '<h1>Sorry type 2 times the same new password.</h1>';
                header("Refresh: 1.0, url=../user/account.php");
            }
        }
        else{
            echo '<h1>Don\'t type the same password o_O .</h1>';
            header("Refresh: 1.0, url=../user/account.php");
        }
    }
    else {
        echo '<h1>Sorry that\'s not your password.</h1>';
        header("Refresh: 1.0, url=../user/account.php");
    }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Change password</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>

<body>
    
</body>

</html>
