<?php

if(isset($_POST["verforo"])){
		$servername = "localhost";
		$username = "id2418571_juanjo";
		$password = "34963006";
		$dbname = "id2418571_jjdtb";
		try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT user.nom_complet, tabla.coment FROM usercomenting as user INNER JOIN tabla_coment as tabla ON user.iduser=tabla.id_user"); 
		    $stmt->execute();

		    // set the resulting array to associative
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		    $forocoment=$stmt->fetchAll();
		    echo "<table>";
		    for($y=0;$y<count($forocoment);$y++){
		    	echo "<tr>" . $forocoment[$y]["nom_complet"] . "-" . "dice:" . $forocoment[$y]["coment"] . "</tr><br>";
		    }
		     echo "</table><br>";
		}catch(PDOException $e) {
			    echo "Error: " . $e->getMessage();
			}
			$conn = null;
	};

?>			