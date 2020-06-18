<?PHP

    session_start();
    include("../config/database.php");
    
    $min = $_SESSION['comin'];
    $max = $_SESSION['comax'];
    echo "min: " . $min . "\n";
    echo "max: " . $max . "\n";
    for ($i = $min; $i <= $max; $i++)
    {
        if (isset($_POST['submit'.$i.''])){
            $del = $i;
            break;
        }
        $del = "";
    }
    echo "del id: " . $del . "\n";
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
    $db->exec("DELETE FROM comment WHERE id = '$del'");
    header("Refresh: 0.0, url=../index.php");

?>
