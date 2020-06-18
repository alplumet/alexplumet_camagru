<?php

    include("../config/database.php");
    include("../user/check.php");
    session_start();
    if ($_POST['login'] === $_SESSION['loggued_user'] && $_POST['login'] !== $_POST['login1']
         && $_POST['login1'] === $_POST['login2'] && strlen($_POST['login1']) < 24){
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
        $login = $_POST['login'];
        $loginn = $_POST['login1'];
        $loginn = htmlspecialchars($loginn);
        if (check_login($loginn, $db)){

            $req = $db->prepare("UPDATE user SET login = :newLogin WHERE login = :oldLogin");
            $req->execute(array ('newLogin'=>$loginn, 'oldLogin' => $login));
            ft_modif_pic_log($db, $login, $loginn);
            ft_modif_pic_com($db, $login, $loginn);
            ft_modif_pic_likes($db, $login, $loginn);
            $_SESSION['loggued_user'] = $loginn;
            echo "<h1>Login is now $loginn </h1>";
            header("Refresh: 0.5, url=../user/account.php");
        }
        else
            header("Refresh: 1.0, url=../user/account.php");
    }
    else {
        echo "<h1> Error to change login, try again! </h1>";
        header("Refresh: 1.0, url=../user/account.php");
    }

    function    ft_modif_pic_log($db, $login, $loginn){
        $req = $db->prepare("UPDATE picture SET login = :newLogin WHERE login = :oldLogin");
        $req->execute(array ('newLogin'=>$loginn, 'oldLogin' => $login));
    }

    function    ft_modif_pic_com($db, $login, $loginn){
        $req = $db->prepare("UPDATE comment SET login = :newLogin WHERE login = :oldLogin");
        $req->execute(array ('newLogin'=>$loginn, 'oldLogin' => $login));
    }

    function    ft_modif_pic_likes($db, $login, $loginn){
        $req = $db->prepare("UPDATE likes SET boss = :newLogin WHERE boss = :oldLogin");
        $req->execute(array ('newLogin'=>$loginn, 'oldLogin' => $login));
    }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Change login</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>

<body>
    
</body>

</html>
