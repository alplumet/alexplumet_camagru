<?php

    session_start();
    if (!($_SESSION['loggued_user'])){
        header("Refresh: 0.0, url=../user/login.php");
    }

?>

<!DOCTYPE html">
<html>
    <head>
            <meta charset="utf-8" />
            <title>Account User</title>
            <link rel="stylesheet" type="text/css" href="../css/account.css">
    </head>
<body>
    <div class="home_butt">
        <a href="../index.php">
            <img style="width: 50px;" src="../ressources/home.png" alt="home page">
        </a>
    </div>
    <?php
    if ($_SESSION['notif'] === 'N')
        $bg = "#FF0000";
    else
        $bg = "#00FF49";
    if (isset($_SESSION['loggued_user']) && $_SESSION['loggued_user'] !== ""){
        echo '<br/>';
        echo '<div id="loggued_user">';
        echo    '<form action="logout.php">';
        echo        '<button class="button">Log Out!</button>';
        echo    '</form>';
        echo    '<form action="confirm_delete.php">';
        echo        '<button class="button">Delete!</button>';
        echo    '</form>';
        echo    '<form action="../modif/modif_notif.php">';
        echo        '<button style="background-color:'.$bg.'" class="button_notif">Notif mail</button>';
        echo    '</form>';
        echo '</div>';
    }
    ?>
    <?php 
        echo '<div class="hed">' . $_SESSION['loggued_user'] . '</div>';
    ?>
    </br>
    <div class="big">
        <div class="change_profil">
            <div style="font-size: 26px; text-align: center;"><B>Update your login</B></div>
            <br/>
            <form action="../modif/modif_login.php" method="POST">
                <label for="login" class="update-label">Login: </label>    
                <input id="login" placeholder="" class="mt-1 custom-input" type="text" name="login" value="" />
                <br/><br/>
                <label for="newLogin" class="update-label">New login: </label>
                <input id="newLogin" class="mt-1 custom-input" type="text" name="login1" value="" />
                <br/><br/>
                <label for="newLoginConfirm" class="update-label">New login confirm: </label>
                <input id="newLoginConfirm" class="mt-1 custom-input" type="text" name="login2" value="" />
                <div class="text-align-right mt-3">
                    <input class="custom-button" type="submit" name="submit" value="Update" />
                </div>
            </form>
        </div>
        <div class="change_profil">
            <div style="font-size: 26px; text-align: center;"><B>Change your password:</B></div>
            <br/>
            <form action="../modif/modif_pwd.php" method="POST">
                <label for="mdp" class="update-label">Password: </label>
                <input id="mdp" class="mt-1 custom-input" type="password" name="password" value="" />
                <br/><br/>
                <label for="newmdp" class="update-label">New Password: </label>
                <input id="newmdp" class="mt-1 custom-input" type="password" name="password1" value="" />
                <br/><br/>
                <label for="newmdpc" class="update-label">New Password confirm: </label>
                <input id="newmdpc" class="mt-1 custom-input" type="password" name="password2" value="" />
                <div class="text-align-right mt-3">
                    <input class="custom-button" type="submit" name="submit" value="Change"/>
                </div>
            </form>
        </div>
        <div class="change_profil">
            <div style="font-size: 26px; text-align: center;"><B>Change your email:</B></div>
            <br/>
            <form action="../modif/modif_email.php" method="POST">
                <label for="email" class="update-label">Email:</label>
                <input id="email" class="mt-1 custom-input" type="email" name="email" value="" />
                <br/><br/>
                <label for="newemail" class="update-label">New Email:</label>
                <input id="newemail" class="mt-1 custom-input" type="email" name="email1" value="" />
                <br/><br/>
                <label for="newemailc" class="update-label">New Email Confirm:</label>
                <input id="newemailc" class="mt-1 custom-input" type="email" name="email2" value="" />
                <div class="text-align-right mt-3">
                    <input class="custom-button" type="submit" name="submit" value="Change"/>
                </div>
            </form>
        </div>
    </div>
    <BR/>
    <div class="galerie">My Galerie</div>
    <div class="pictures_bigdiv">
        <?php

            include("../config/display_pictures.php");
            get_my_pictures($_SESSION['loggued_user']);


        ?>
    </div>

</body>
</html>
