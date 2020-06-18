<?php
 
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

    $login = $_GET['log'];
    $cle = $_GET['cle'];
    
    // Récupération de la clé correspondant au $login dans la base de données
    $stmt = $db->prepare("SELECT keymail,actif FROM user WHERE login like :login ");
    if($stmt->execute(array(':login' => $login)) && $row = $stmt->fetch())
      {
        $clebdd = $row['keymail'];    // Récupération de la clé
        $actif = $row['actif']; // $actif contiendra alors 0 ou 1
      }
  
    if($actif == '1')
         echo "Votre compte est déjà actif !";
    else{
         if($cle == $clebdd){   
              echo "Votre compte a bien été activé !";
        
              // La requête qui va passer notre champ actif de 0 à 1
              $stmt = $db->prepare("UPDATE user SET actif = 1 WHERE login like :login ");
              $stmt->execute(array ('login'=>$login));
        }
         else
              echo "Erreur ! Votre compte ne peut être activé...";
    }
    header("Refresh: 3.0, url=../user/login.php");

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="../css/camagru.css">
</head>

<body>
    
</body>

</html>
