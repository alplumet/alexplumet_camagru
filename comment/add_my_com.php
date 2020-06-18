<?PHP

    session_start();
    include("../config/database.php");
    
    $min = $_SESSION['nbmin'];
    $max = $_SESSION['nbmax'];
    for ($i = $min; $i <= $max; $i++)
    {
        if (isset($_POST['comment'.$i.''])){
            $comment = $_POST['comment'.$i.''];
            $img = $_POST['name_pic'.$i.''];
            break;
        }
        $comment = "";
    }
    if ($comment !== ""){
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
        header("Refresh: 0.0, url=../user/account.php");
    }
    else
        header("Refresh: 0.0, url=../user/account.php");

?>
