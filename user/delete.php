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
    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $err){
        die($err->getMessage());
    }
    $login = $_SESSION['loggued_user'];
    $likes = $db->query("SELECT id,login,number FROM likes")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($likes as $like){
        $search = $login . ";";
        $nb = $like['number'];
        $nb--;
        $tmp = str_replace($search, '', $like['login']);
        if (strcmp($tmp, $like['login']) != 0){
            $req = $db->prepare("UPDATE likes SET login = :newlog WHERE id = :id");
            $req->execute(array ('newlog'=>$tmp, 'id'=>$like['id']));
            $stmt = $db->prepare("UPDATE likes SET number = :newnb WHERE id = :id");
            $stmt->execute(array ('newnb'=>$nb, 'id'=>$like['id'])); 
        }
    }
    $pictures = $db->query("SELECT name FROM picture WHERE login = '$login'")->fetchAll(PDO::FETCH_ASSOC);
    foreach($pictures as $picture){
        unlink("/Users/alplumet/MAMP/apache2/htdocs/camagru/image/" . $picture['name']);
    }
    $db->exec("DELETE FROM comment WHERE login = '$login'");
    $db->exec("DELETE FROM likes WHERE boss = '$login'");
    $db->exec("DELETE FROM picture WHERE login = '$login'");
    $db->exec("DELETE FROM user WHERE login = '$login'");
    $_SESSION['loggued_user'] = "";
    $_SESSION['passwd'] = "";
    $_SESSION['email'] = "";
    $_SESSION['id'] = "";
    echo '<h1>Account '.$login.' is now delete, adios amigos!</h1>';
    header("Refresh: 2.0, url=login.php");

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>delete</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>

<body>

</body>

</html>
