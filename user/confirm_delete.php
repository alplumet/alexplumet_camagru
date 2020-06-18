<?php

    session_start();
    

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Confirm delete</title>
    <link rel="stylesheet" type="text/css" href="../css/account.css">
</head>

<body>
    <?php 

        echo '<div id="delete_user">';
        echo "Hey " . $_SESSION['loggued_user'] . ". You really want to delete you're fabolous account??";
        echo '<form action="delete.php">';
        echo '<button class="button">Delete!</button>';
        echo '</form>' . '</br>';
        echo '<form action="account.php">';
        echo '<button class="button">No finally i love this site!</button>';
        echo '</form>';
        echo '</div>';
    ?>
</html>
