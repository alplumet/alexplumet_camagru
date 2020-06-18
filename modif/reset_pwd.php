<?php

    include("../config/database.php");
    
    $mail = $_POST['reset_pwd'];
    if ($mail !== ""){
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
        $stmt = $db->query("SELECT login FROM user WHERE email = '$mail'")->fetch(PDO::FETCH_ASSOC);
        if (is_array($stmt))
            $stmt = implode($stmt);
        if (!empty($stmt)){
            $new_pwd = kodex_random_strings();
            $req = $db->prepare("UPDATE user SET passwd = :newpwd WHERE login = :login");
            $req->execute(array ('newpwd'=>hash('whirlpool', $new_pwd), 'login' => $stmt));
            $destinataire = $mail;
            $sujet = "Camagru new password" ;
            $entete = "From: admin@camagru" ;
            $message = ''.$stmt.', the new password is '.$new_pwd.'.
            ---------------
            Ceci est un mail automatique, Merci de ne pas y répondre.';
            mail($destinataire, $sujet, $message, $entete);
            echo '<h1>Go check the new password</h1>';
            header("Refresh: 3.0, url=../user/login.php");
        }
        else{
        echo '<h1>Bad adress, try another</h1>';
        header("Refresh: 3.0, url=../user/login.php");
        }
    }
    else{
        echo '<h1>Type something, really.</h1>';
        header("Refresh: 3.0, url=../user/login.php");
    }
    
    
    function kodex_random_strings($length=20){
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