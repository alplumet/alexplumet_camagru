<?php

    include("../config/database.php");
    session_start();

    var_dump($_GET);
    $min = $_SESSION['nbmin'];
    $max = $_SESSION['nbmax'];
    echo $min . "\n" . $max . "\n";
    for ($i = $min; $i <= $max; $i++)
    {
        if (isset($_GET['del'.$i.''])){
            $picture = $_GET['del_pic'.$i.''];
            break;
        }
        $picture = "";
    }
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
    $db->exec("DELETE FROM comment WHERE picture = '$picture'");
    $db->exec("DELETE FROM likes WHERE picture = '$picture'");
    $db->exec("DELETE FROM picture WHERE name = '$picture'");
    unlink("/Users/alplumet/MAMP/apache2/htdocs/camagru/image/" . $picture);
    header("Refresh: 0.0, url=account.php");

?>
