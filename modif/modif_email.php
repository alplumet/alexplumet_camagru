<?php

    include("../config/database.php");
    include("../user/check.php");
    session_start();
    if ($_POST['email'] === $_SESSION['email'] && $_POST['email'] !== $_POST['email1'] && $_POST['email1'] === $_POST['email2']){
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
        if (check_email($_POST['email1'], $db)){
            $login = $_SESSION['loggued_user'];
            $email = $_SESSION['email'];
            $new = $_POST['email1'];
            $req = $db->prepare("UPDATE user SET email = ? WHERE login = ?");
            $req->execute(array ($new, $login));
            echo '<h1>Email is now '.$new.' </h1>';
            $_SESSION['email'] = $new;
            header("Refresh: 1.0, url=../user/account.php");
        }
        else
            header("Refresh: 1.0, url=../user/account.php");
    }
    else {
        echo '<h1>Error try again</h1>';
        header("Refresh: 2, url=../user/account.php");
    }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Change email</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>

<body>
    
</body>

</html>
