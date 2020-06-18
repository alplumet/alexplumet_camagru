<?PHP

    function get_pictures($login){
        include("database.php");

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
        $stmt = $db->query("SELECT * FROM picture ORDER BY id");
        $stmt2 = $db->query("SELECT * FROM picture ORDER BY id");
        $min = $stmt2->fetch();
        $_SESSION['nbmin'] = $min['id']; 
        while ($img = $stmt->fetch()){
            $_SESSION['nbmax'] = $img['id'];
            display_picture($img['id'], $img['name'], $img['login'], $img['email'], $login, $db);
        }
    }

    function display_picture($id, $name, $imglogin, $email, $login, $db){
        echo '<BR/>';
        echo '<div class="picture_div">';
        echo    '<div class="title">';
        echo        '<B>By: '.$imglogin.'  </B>';
        echo    '</div>';
        echo    '<div>';
        echo        '<img src="image/'.$name.'" style="max-width: 100%;">';
        echo    '</div>';
        echo    '<div class="likes_div">';
                    display_likes($id, $name, $login, $db);
        echo    '</div>';
        echo    '<div class="comment_div">';
                     display_com($id, $login, $name, $imglogin, $db);
        echo    '</div>';
        echo    '<form action="comment/add_com.php" method="POST">';
        echo        '<input type="hidden" name="name_pic'.$id.'" value="'.$name.'" />';
        echo        '<input class="mt-1 custom-input" placeholder="Comment here" type="text" name="comment'.$id.'" value="" />';
        echo        '<div class="text-align-right mt-3">';
        echo            '<input class="custom-button" type="submit" name="submit'.$id.'" value="Add"/>';
        echo        '</div>';
        echo    '</form>';
        echo '</div>';
        echo '<BR/>';
    }

    function    display_likes($id, $name, $login, $db){
        if ($login !== ""){
            $tmp = $db->query("SELECT * FROM likes WHERE picture = '$name'");
            $like = $tmp->fetch();
            $arr = explode(';', $like['login']);
            $j = 0;
            foreach ($arr as $value) {
                if (strcmp($login, $value) == 0){
                    $j = 1;
                }
            }
            if ($j == 1){
                echo '<div>';
                echo    '<form action="like/dislike.php" method="GET">';
                echo        '<div>';
                echo            '<input type="hidden" name="id_likes" value="'.$id.'" />';
                echo            '<input class="dislike_button" type="submit" name="submit'.$id.'" value="♡ '. $like['number'] .' likes"/>';
                echo        '</div>';
                echo    '</form>';
                echo '</div>';
            }
            if ($j == 0){
                echo '<div>';
                echo    '<form action="like/like.php" method="GET">';
                echo        '<div>';
                echo            '<input type="hidden" name="id_likes" value="'.$id.'" />';
                echo            '<input class="like_button" type="submit" name="submit'.$id.'" value="♡ '. $like['number'] .' likes"/>';
                echo        '</div>';
                echo    '</form>';
                echo '</div>';
            }
        }
        else{
            $tmp = $db->query("SELECT * FROM likes WHERE picture = '$name'");
            $like = $tmp->fetch();
            echo '<div>';
            echo    '<form action="like/like.php" method="GET">';
            echo        '<div>';
            echo            '<input class="like_button" type="submit" name="submit'.$id.'" value="♡ '. $like['number'] .' likes"/>';
            echo        '</div>';
            echo    '</form>';
            echo '</div>';
        }

    }

    function display_com($id, $login, $img, $imglogin, $db){
        $tmp = $db->query("SELECT * FROM comment WHERE picture = '$img' ORDER BY id");
        while ($com = $tmp->fetch()){
            if (!(isset($_SESSION['comin'])) && !(isset($_SESSION['comax']))){
                $_SESSION['comax'] = $com['id'];
                $_SESSION['comin'] = $com['id'];
            }
            if ($_SESSION['comax'] < $com['id']){
                $_SESSION['comax'] = $com['id'];
            }
            if ($_SESSION['comin'] > $com['id']){
                $_SESSION['comin'] = $com['id'];
            }
            echo '<div class="com_class">';
            echo    "<B>" . $com['login'] . ': </B> ' . $com['com'];
            if ($com['login'] === $_SESSION['loggued_user']){
                echo    '<form action="comment/del_com.php" method="POST">';
                echo        '<div>';
                echo            '<input class="del-button" type="submit" name="submit'.$com['id'].'" value="delete"/>';
                echo        '</div>';
                echo    '</form>';
            }
            echo '</div>';
        }
    }

    function    get_my_pictures($login){
        include("database.php");

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

        $stmt = $db->query("SELECT * FROM picture WHERE login = '$login'");
        $stmt2 = $db->query("SELECT * FROM picture WHERE login = '$login'");
        $min = $stmt2->fetch();
        $_SESSION['nbmin'] = $min['id']; 
        while ($img = $stmt->fetch()){
            $_SESSION['nbmax'] = $img['id'];
            display_my_picture($img['id'], $img['name'], $img['login'], $img['email'], $login, $db);
        }
    }

    function display_my_picture($id, $name, $imglogin, $email, $login, $db){
        echo '<BR/>';
        echo '<div class="picture_div">';
        echo    '<div class="title">';
        echo        '<div><B>By: '.$imglogin.'  </B></div>';
        echo        '<div>';
        echo            '<form action="../user/delete_picture.php" method="GET">';
        echo                '<input type="hidden" name="del_pic'.$id.'" value="'.$name.'" />';
        echo                '<input class="del_pic" type="submit" name="del'.$id.'" value="Delete"/>';
        echo            '</form>';
        echo        '</div>';
        echo    '</div>';
        echo    '<div>';
        echo        '<img src="../image/'.$name.'" style="max-width: 100%;">';
        echo    '</div>';
        echo    '<div class="comment_div">';
                     display_my_com($id, $login, $name, $imglogin, $db);
        echo    '</div>';
        echo    '<form action="../comment/add_my_com.php" method="POST">';
        echo        '<input type="hidden" name="name_pic'.$id.'" value="'.$name.'" />';
        echo        '<input class="mt-1 custom-input2" placeholder="Comment here" type="text" name="comment'.$id.'" value="" />';
        echo        '<div class="text-align-right mt-3">';
        echo            '<input class="custom-button" type="submit" name="submit'.$id.'" value="Add"/>';
        echo        '</div>';
        echo    '</form>';
        echo '</div>';
        echo '<BR/>';
    }

    function display_my_com($id, $login, $img, $imglogin, $db){
        $tmp = $db->query("SELECT * FROM comment WHERE picture = '$img' ORDER BY id");
        while ($com = $tmp->fetch()){
            if (!(isset($_SESSION['comin'])) && !(isset($_SESSION['comax']))){
                $_SESSION['comax'] = $com['id'];
                $_SESSION['comin'] = $com['id'];
            }
            if ($_SESSION['comax'] < $com['id']){
                $_SESSION['comax'] = $com['id'];
            }
            if ($_SESSION['comin'] > $com['id']){
                $_SESSION['comin'] = $com['id'];
            }
            echo '<div class="com_class">';
            echo    "<B>" . $com['login'] . ': </B> ' . $com['com'];
            if ($com['login'] === $_SESSION['loggued_user']){
                echo    '<form action="../comment/del_my_com.php" method="POST">';
                echo        '<div>';
                echo            '<input class="del-button" type="submit" name="submit'.$com['id'].'" value="delete"/>';
                echo        '</div>';
                echo    '</form>';
            }

            echo '</div>';
        }
    }

?>
