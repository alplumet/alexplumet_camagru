<?php

    include("../config/database.php");
    session_start();

    if ($_SESSION['loggued_user']){
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
        $id = $_GET['id_likes'];
        $stmt = $db->query("SELECT number FROM likes WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
        if (is_array($stmt))
            $stmt = implode($stmt);
        $stmt++;
        $req = $db->prepare("UPDATE likes SET number = :newnb WHERE id = :id");
        $req->execute(array ('newnb'=>$stmt, 'id'=>$id));
        $stmt2 = $db->query("SELECT login FROM likes WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
        if (is_array($stmt2))
            $stmt2 = implode($stmt2);
        $stmt2 .= $_SESSION['loggued_user'] . ";";
        $req = $db->prepare("UPDATE likes SET login = :newlog WHERE id = :id");
        $req->execute(array ('newlog'=>$stmt2, 'id'=>$id));
        header("Refresh: 0.0, url=../index.php");
    }
    else
        header("Refresh: 0.0, url=../index.php");

?>