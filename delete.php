<?php
$servername = "localhost";
$username = "id2418571_juanjo";
$password = "34963006";
$dbname = "id2418571_jjdtb";
if(isset($_GET["id"])){
    $id=$_GET["id"];
    
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to delete a record
    $sql = "DELETE FROM usercomenting WHERE iduser=$id";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "usuario borrado correctamente";
    

    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;

}

if(isset($_GET["mens"])){
    $mens=$_GET["mens"];
    
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to delete a record
    $sql = "DELETE FROM tabla_coment WHERE idcoment=$mens";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "mensaje borrado correctamente";
    

    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;

}

if(isset($_GET["idbloq"])){
    $servername = "localhost";
    $username = "id2418571_juanjo";
    $password = "34963006";
    $dbname = "id2418571_jjdtb";
    $id=$_GET["idbloq"];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE usercomenting SET intentos=0 WHERE iduser=$id";

        // Prepare statement
        $stmt = $conn->prepare($sql);

        // execute the query
        $stmt->execute();

        // echo a message to say the UPDATE succeeded
        echo $stmt->rowCount() . " usuario desbloqueado";
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }

    $conn = null;   
}
header("Refresh:3; admin.php");
?>
