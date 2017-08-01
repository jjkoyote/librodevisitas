<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title>admin</title>
</head>
<body>
	<form method='post'>
		<textarea rows='5' cols='50' name='comentario'></textarea><br>
		<input type='text' name='filtro'><input type='submit' name='buscar' value='filtro'><br>
	    <input type='submit' name='coment' value='enviar'>
	    <input type='submit' name='traecoment' value='recuperar'>
		<input type='submit' name='verforo' value='ver_foro'>
		<input type="submit" name="unblock" value="ver bloqueados"><br>
		<input type="submit" name="estadist" value="estadisticas">
		<input type='submit' name='salir' value='salir'>
	</form>

<?php
if(isset($_GET["id"])){
		$id=$_GET["id"];}
$usuarioadmin=$_SESSION["usuarioadmin"];
if($usuarioadmin!="jjkoyote@gmail.com"){
	header("location:index.php");
}
if(isset($_POST["verforo"])){
		$servername = "localhost";
		$username = "id2418571_juanjo";
		$password = "34963006";
		$dbname = "id2418571_jjdtb";
		try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT user.nom_complet, tabla.coment, user.iduser, tabla.idcoment FROM usercomenting as user INNER JOIN tabla_coment as tabla ON user.iduser=tabla.id_user"); 
		    $stmt->execute();

		    // set the resulting array to associative
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		    $forocoment=$stmt->fetchAll();
		    echo "<table>";
		    for($y=0;$y<count($forocoment);$y++){
		    	echo "<tr>usuario-" . $forocoment[$y]["iduser"] . $forocoment[$y]["nom_complet"] . "-" . "dice:" . $forocoment[$y]["coment"] . " comentario num" . $forocoment[$y]["idcoment"] . "<a href=" . chr(34) ."javascript:confirmar(" . $forocoment[$y]["iduser"] . ")" . chr(34) . ">borrar usuario</a>". "-" ."<a href=" . chr(34) ."javascript:confirmarmens(" . $forocoment[$y]["idcoment"] . ")" . chr(34) . ">borrar mensaje</a></tr><br>";
		    }
		     echo "</table><br>";
		}catch(PDOException $e) {
			    echo "Error: " . $e->getMessage();
			}
			$conn = null;
	};	



	if(isset($_POST["buscar"])){
		$servername = "localhost";
		$username = "id2418571_juanjo";
		$password = "34963006";
		$dbname = "id2418571_jjdtb";
		$palabra=$_POST["filtro"];
		try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT tabla.coment, user.nom_complet  FROM tabla_coment as tabla LEFT JOIN usercomenting as user ON user.iduser=tabla.id_user WHERE coment LIKE '%$palabra%'"); 
		    $stmt->execute();

		    // set the resulting array to associative
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		    $seleccion=$stmt->fetchAll();
		     echo "<table>";
		   for($c=0;$c<count($seleccion);$c++){
		    	echo "<tr>" . $seleccion[$c]["nom_complet"] . " dice:" . $seleccion[$c]["coment"] . "</tr><br>";
		    }
		    echo "</table><br>";
		}catch(PDOException $e) {
			    echo "Error: " . $e->getMessage();
			}
			$conn = null;
	}
	if(isset($_POST["salir"])){
		header("location:logout.php");
	}	
if(isset($_POST["coment"])){
		$cmt=$_POST["comentario"];
		if($cmt==""){
			echo "debe escribir algun comentario";
		}else{
			try {
				$servername = "localhost";
				$username = "id2418571_juanjo";
				$password = "34963006";
				$dbname = "id2418571_jjdtb";
			    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			    // set the PDO error mode to exception
			    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    $sql = "INSERT INTO tabla_coment (id_user, coment)
			    VALUES ('$id', '$cmt')";
			    // use exec() because no results are returned
			    $conn->exec($sql);
			    echo "New record created successfully";
			    }
			catch(PDOException $e)
			    {
			    echo $sql . "<br>" . $e->getMessage();
			    }

			$conn = null;
		}	
	}

	if(isset($_POST["traecoment"])){
		$servername = "localhost";
		$username = "id2418571_juanjo";
		$password = "34963006";
		$dbname = "id2418571_jjdtb";
		try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT coment FROM tabla_coment WHERE id_user=$id"); 
		    $stmt->execute();

		    // set the resulting array to associative
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		    $miscomen=$stmt->fetchAll();
		    echo "<table>";
		    for($x=0;$x<count($miscomen);$x++){
		    	echo "<tr>usuario" . $id . "_dice:" . $miscomen[$x]["coment"] . "</tr><br>";
		    }
		    echo "</table><br>";
		}catch(PDOException $e) {
			    echo "Error: " . $e->getMessage();
			}
			$conn = null;

	}
	if(isset($_POST["unblock"])){
		$servername = "localhost";
		$username = "id2418571_juanjo";
		$password = "34963006";
		$dbname = "id2418571_jjdtb";
		try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT iduser, intentos  FROM usercomenting where intentos>=3"); 
		    $stmt->execute();

		    // set the resulting array to associative
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		    $bloqueados=$stmt->fetchAll();
		    echo "<table>";
		    for($r=0;$r<count($bloqueados);$r++){
		    	echo "<tr>usuario " . $bloqueados[$r]["iduser"] .  " bloqueado " . "<a href=" . chr(34) ."javascript:confirmardesbloqueo(" . $bloqueados[$r]["iduser"] . ")" . chr(34) . ">desbloquear usuario</a>"."</tr><br>";
		    }
		     echo "</table><br>";
		}catch(PDOException $e) {
			    echo "Error: " . $e->getMessage();
			}
			$conn = null;
	}

	if(isset($_POST["estadist"])){
		$servername = "localhost";
		$username = "id2418571_juanjo";
		$password = "34963006";
		$dbname = "id2418571_jjdtb";
			try{
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $conn->prepare("SELECT nom_complet, count(coment) as nummensajes  FROM tabla_coment as tabla LEFT JOIN usercomenting as user ON tabla.id_user=user.iduser GROUP BY nom_complet ORDER BY nummensajes DESC "); 
		   		$stmt->execute();
		   		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		   		$estad=$stmt->fetchAll();

				echo "<table>";

				for($s=0;$s<count($estad);$s++){
					echo "<tr>" . $estad[$s]["nom_complet"] . " tiene " . $estad[$s]["nummensajes"] . " mensajes</tr><br>";
				}

				echo "</table>";
			}catch(PDOException $e) {
			    echo "Error: " . $e->getMessage();
			}
			$conn = null;	
	}
?> 
<script type="text/javascript">
 /**
     * funcion que confirma si en realidad se desea borrar un usuario
     * @param type int 
     * @return void
     */   
function confirmar(id){
	var r=confirm("Seguro que quiere borrar el usuario?");
	if(r==true){
  	  location.href="delete.php?id=" + id;
	}
}
/**
 * funcion que confirma se en realidad se desea borrar el mensaje seleccionado
 * @param type int
 * @return void
 */
function confirmarmens(mens){
	var r=confirm("Seguro que quiere borrar el mensaje?");
	if(r==true){
  	  location.href="delete.php?mens=" + mens;
	}
}
/**
 * funcion que confirma si en realidad se desea desbloquear al usuario seleccionado
 * @param type int
 * @return viod
 */
function confirmardesbloqueo(idbloq){
	var r=confirm("Seguro que quiere desbloquear el usuario?");
	if(r==true){
  	  location.href="delete.php?idbloq=" + idbloq;
	}
}

    
</script>
</body>
</html>