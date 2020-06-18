<?php

    function check_login($login, $db){
        $stmt = $db->query("SELECT login FROM user WHERE login = '$login'")->fetch(PDO::FETCH_ASSOC);
        if (is_array($stmt))
            $stmt = implode($stmt);
        if ($login === $stmt){
            echo '<h1>Login '.$login.' already exist, please find another one.</h1>';
            return(false);
        }
        else if (strlen($login) > 23)
            return(false);
        else
            return(true);
    }

    function check_email($email, $db){
        $stmt = $db->query("SELECT email FROM user WHERE email = '$email'")->fetch(PDO::FETCH_ASSOC);
        if (is_array($stmt))
            $stmt = implode($stmt);
        if ($email === $stmt){
            echo '<h1>Email adress '.$email.' already exist.</h1>';
            return(false);
        }
        else
            return(true);
    }

    function check_reboot($login){
        include("config/database.php");
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
        $stmt = $db->query("SELECT login FROM user WHERE login = '$login'")->fetch(PDO::FETCH_ASSOC);
        if (is_array($stmt))
            $stmt = implode($stmt);
        if ($login === $stmt)
            return(false);
        else
            return(true);
    }

?>