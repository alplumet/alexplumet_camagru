<?php

    session_start();
    var_dump($_FILES);

    if ($_SESSION['loggued_user'] !== ""){
        $tmp_name = $_FILES['image']['tmp_name'];
        $FilterPath = $_FILES['sticker']['tmp_name'];
        $imgcadre = $_POST['imgcadre'];
        $keycode = uniqid();
        if (strcmp($_POST['name'], "camera") !== 0){
            echo "extern pic" . "\n";
            if (mime_content_type($tmp_name) == "image/gif")
                $type = ".gif";
            else if (mime_content_type($tmp_name) == "image/jpeg")
                $type = ".jpg";
            else if (mime_content_type($tmp_name) == "image/png")
                $type = ".png";
            else
                $type = "exit";
            echo "type: " . $type . "\n";
        }
        else
            $type = ".png";
        if (strcmp($type, "exit") == 0)
        return;
        $file = $keycode . $type;
        echo "file name: " . $file . "\n";
        montageImg($file, $type, $imgcadre, $FilterPath, $tmp_name);
        send_img_to_db($file, $_SESSION['loggued_user'], $_SESSION['id'], $_SESSION['email']);
    }

    // function    analyse_type_image($name){
    //     if (stristr($name, '.png'))
    //         return (".png");
    //     if (stristr($name, '.jpg'))
    //         return (".jpg");
    //     if (stristr($name, '.gif'))
    //         return (".gif");
    //     return ("exit");
    // }

    function montageImg($file, $imageFileType, $imgcadre, $FilterPath, $ImgPath){
        echo "montage" . "\n";
        if ($imageFileType == '.jpg') {
            echo "montage jpeg" . "\n";
            $base = imagecreatefromjpeg($ImgPath);
        }
        elseif ($imageFileType == '.png') {
            $base = imagecreatefrompng($ImgPath);
        }
        elseif ($imageFileType == '.gif') {
            $base = imagecreatefromgif($ImgPath);
        }
        $filtername = imagecreatefrompng($FilterPath);
        list($swidth, $sheight) = getimagesize($FilterPath);
        if ($imgcadre === "image")
            imagecopyresized($base, $filtername, 0, 15, 0, 0, 115, 165, $swidth, $sheight);
        else if ($imgcadre === "cadre")
            imagecopyresized($base, $filtername, 0, 0, 0, 0, 350, 350, $swidth, $sheight);
        $filtername = NULL;
        if ($imageFileType == '.gif')
            imagegif($base, "/Users/alplumet/MAMP/apache2/htdocs/camagru/image/" . $file);
        else if ($imageFileType == '.png')
            imagepng($base, "/Users/alplumet/MAMP/apache2/htdocs/camagru/image/" . $file);
        else
            imagejpeg($base, "/Users/alplumet/MAMP/apache2/htdocs/camagru/image/" . $file);
    }

    function send_img_to_db($file, $login, $id, $mail){
        include("../config/database.php");
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
        $req = $db->prepare("INSERT INTO picture(name,login,email) VALUES (:name,:login,:email)");
        $req->execute(array ('name'=>$file, 'login'=>$login, 'email'=>$mail));
        $like = $db->prepare("INSERT INTO likes(picture,boss) VALUES (:picture,:boss)");
        $like->execute(array ('picture'=>$file, 'boss'=>$login));
        echo "image send to db";
    }
?>
