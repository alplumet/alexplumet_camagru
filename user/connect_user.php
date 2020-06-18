<?php

include("auth.php");
session_start();

$_SESSION['loggued_user'] = "";
$_SESSION['email'] = "";
if ($_POST['login'] && $_POST['passwd'])
{
    if (auth($_POST['login'], $_POST['passwd']))
        header("Refresh: 0.0, url=../index.php");
    else {
        echo "WRONG LOGIN OR PASSWORD !<BR/>";
        header("Refresh: 1, url=login.php");}
}
else
{
	echo "ERROR: one or more fields are empty... <BR/>";
	header("Refresh: 1, url=login.php");
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
