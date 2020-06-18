<?php

session_start();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>

<body>
    <div class="home_butt">
        <a href="../index.php">
            <img style="width: 50px;" src="../ressources/home.png" alt="home page">
        </a>
    </div>
    <?php
    if (isset($_SESSION['loggued_user']) && $_SESSION['loggued_user'] !== ""){
        echo '<div id="loggued_user">';
        echo "Connected: " . $_SESSION['loggued_user'];
        echo '<form action="logout.php">';
        echo '<button class="button">Log Out!</button>';
        echo '</form>';
        echo '</div>';
    }
    ?>
    <div class="big">
        <div class="sign" style="height: fit-content;">
             <div style="font-size: 26px; text-align: center;"><B>Sign In:</B></div>
            <br/>
            <form action="connect_user.php" method="POST">
                <label for="login" class="update-label">Login: </label>    
                <input id="login" placeholder="" class="mt-1 custom-input" type="text" name="login" value="" />
                <br/><br/>
                <label for="mdp" class="update-label">Password: </label>
                <input id="mdp" class="mt-1 custom-input" type="password" name="passwd" value="" />
                <div class="text-align-right mt-3">
                    <input class="custom-button" type="submit" name="submit" value="Connect" />
                </div>
            </form>
            <form action="../modif/reset_pwd.php" method="POST">
                <label for="email_reset" class="update-label">Can't sign in?</label>
                <input id="email_reset" class="mt-1 custom-input" placeholder="Type your email adress" type="email" name="reset_pwd" value="" />
                <div class="text-align-right mt-3">
                    <input class="reset-button" type="submit" name="submit" value="Reset password" />
                </div>
            </form>
        </div>
        <br/>

        <div class="sign">
            <div style="font-size: 26px; text-align: center;"><B>Sign up:</B></div>
            <form action="create_user.php" method="POST">
                <label for="login1" class="update-label">Login: </label>    
                <input id="login1" placeholder="" class="mt-1 custom-input" type="text" name="login" value="" />
                <br/><br/>
                <label for="email" class="update-label">Email: </label>    
                <input id="email" placeholder="" class="mt-1 custom-input" type="email" name="email" value="" />
                <br/><br/>
                <label for="Pwd" class="update-label">Password: </label>    
                <input id="Pwd" placeholder="" class="mt-1 custom-input" type="password" name="passwd1" value="" />
                <br/><br/>
                <label for="Pwdc" class="update-label">Password Confirmation: </label>    
                <input id="Pwdc" placeholder="" class="mt-1 custom-input" type="password" name="passwd2" value="" />
                 <div class="text-align-right mt-3">
                    <input class="custom-button" type="submit" name="submit" value="Create" />
                </div>
            </form>
        </div>
    </div>
</body>

</html>
