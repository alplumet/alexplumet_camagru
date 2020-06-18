<?PHP

    session_start();
    include("../config/database.php");
    
    $min = $_SESSION['nbmin'];
    $max = $_SESSION['nbmax'];
    for ($i = $min; $i <= $max; $i++)
    {
        if (isset($_POST['comment'.$i.''])){
            $comment = $_POST['comment'.$i.''];
            $comment = htmlspecialchars($comment);
            $img = $_POST['name_pic'.$i.''];
            break;
        }
        $comment = "";
    }
    if ($comment !== "" && $_SESSION['loggued_user']){    
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
        $req = $db->prepare("INSERT INTO comment(picture,login,com) VALUES (:picture,:login,:com)");
        $req->execute(array ('picture'=>$img, 'login'=>$_SESSION['loggued_user'], 'com'=>$comment));
        $stmt = $db->query("SELECT email FROM picture WHERE name = '$img'")->fetch(PDO::FETCH_ASSOC);
        if (is_array($stmt))
            $stmt = implode($stmt);
        if ($_SESSION['email'] !== $stmt){
            $tmp = $db->query("SELECT login FROM picture WHERE name = '$img'")->fetch(PDO::FETCH_ASSOC);
            if (is_array($tmp))
                $tmp = implode($tmp);
            $tmp2 = $db->query("SELECT notif FROM user WHERE login = '$tmp'")->fetch(PDO::FETCH_ASSOC);
            if (is_array($tmp2))
                $tmp2 = implode($tmp2);
            if ($tmp2 === 'Y'){
                $destinataire = $stmt;
                $sujet = "Camagru's comment" ;
                $entete = "From: admin@camagru" ;
                $date = date("d-m-Y H:i:s");
                $message = 'Dude, you have a new comment from '.$_SESSION['loggued_user'].' on your picture at '.$date.'.
                ---------------
                Ceci est un mail automatique, Merci de ne pas y répondre.';
                mail($destinataire, $sujet, $message, $entete);
            }
        }
        header("Refresh: 0.0, url=../index.php");
    }
    else
        header("Refresh: 0.0, url=../index.php");

?>
