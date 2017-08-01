<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title>perfil</title>
	<style type="text/css">
		body{
			overflow: hidden;
			width: 100%;
			margin:auto;
		}
		.conteiner{
			position: absolute;
			width: 100%;
			height: auto;
		}
		header{
			background-color: black;
			color: blue;
			height: 100px;
			width: 100%;
			text-align: center;
			padding:20px;

		}
		footer{
			text-align: center;
			background-color: black;
			color: blue;
			margin-top: -20px;
			height:100px;
			width: 100%;
		}
		.bienvenido{
			color:yellow;
		}
		.content{
			text-align: center;
			background-color: blue;
			color: white;
			height: 680px;

		}
		.textoforo{
			float: left;
			margin-left: 10px;
			margin-top: 10px;
		}
		.mandarcom{
			float: left;
			position: relative;
			left:-513px;
			top:170px;
			width: 100px;
			color: white;
			background-color: red;
		}
		#pdf{
			position: relative;
			float: right;
			width: 100px;
			margin-right: 10px;
			color: white;
			background-color: red;
		}
		.filtros{
			float;
			position: relative;
			top: 350px;
			left: -700px;
		}
		#verforo{
			float: left;
			width: 100px;
			color: white;
			background-color: red;
			margin-left: 10px;
		}
		#salir{
			width: 100px;
			color: white;
			background-color: red;
		}
		#traecoment{
			position: relative;
			top: 170px;
			left: -534px;
			width: 100px;
			color: white;
			background-color: red;
		}
		.escribir{
			width: 100%;
		}
		.camdatos{
			float: left;
			position: relative;
			text-align: center;
			top: 120px;
			left: -500px;
		}
		#cambiar{
			width: 170px;
			color: white;
			background-color: red;
		}
		#camnombre{
			margin-left: 20px;
			margin-bottom:10px;
			height: 30px;
		}
		#campasw{
			height: 30px;
			margin-bottom:10px;
		}
		#xfecha{
			width: 140px;
			color: white;
			background-color: red;
			margin-bottom:10px;
		}
		#desde{
			margin-right: 142px;
			margin-bottom:10px;
		}
		#xpalabra{
			margin-left: 42px;
		}
		#btxpalabra{
			color: white;
			background-color: red;
		}
		.mostrarmensajes{
			width: 25%;
			height: 400px;
			background-color: white;
			float: right;
			position:relative;
			right: 200px;
			top:-50px;
			color: black;

		}
		.seleccion{
			position: relative;
			right: 250px;
			top:20px;
		}
		.colores{
			margin-top: 0px;
			margin-bottom: 0px;
		}
	</style>
</head>
<body>
	<div class="container">
	<header>
		<h1>PROYECTO FORO</h1>
	<p class="bienvenido">	
		<?php
		include "password.php";
		//recojo id de usuario y doy saludo de entrada	
	if(isset($_GET["id"])){
		$id=$_GET["id"];
		$servername = "localhost";
		$username = "id2418571_juanjo";
		$password = "34963006";
		$dbname = "id2418571_jjdtb";
		try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT nom_complet FROM usercomenting WHERE iduser=$id"); 
		    $stmt->execute();

		    // set the resulting array to associative
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		    $nombrecompleto=$stmt->fetchAll()[0]["nom_complet"];

		    echo "hola de nuevo usuario" . "-" . $nombrecompleto . " puede modificar su nombre y contraseña en el boton (cambiar datos personales) e introducirlo en las casillas anteriores<br>";
		   		   
		}catch(PDOException $e) {
			    echo "Error: " . $e->getMessage();
			}
			$conn = null;
		}



		?>
		</p>
	</header>
	<div class="content">
		<form method='post'>
			<div class="escribir">
			<select class="seleccion" name="seleccion">
				<option selected>filtro x nombre</option>
		<?php		
		$servername = "localhost";
		$username = "id2418571_juanjo";
		$password = "34963006";
		$dbname = "id2418571_jjdtb";
		try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT nom_complet, iduser FROM usercomenting INNER JOIN tabla_coment ON id_user=iduser GROUP BY nom_complet"); 
		    $stmt->execute();
		    // set the resulting array to associative
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		    $miscomen=$stmt->fetchAll();
		    for($q=0;$q<count($miscomen);$q++){
		    	echo "<option>" . $miscomen[$q]["iduser"] . " " . $miscomen[$q]["nom_complet"] . "</option>";		    		    	 
		    }		   
		}catch(PDOException $e){
			    echo "Error: " . $e->getMessage();
			}
			$conn = null;
			?>
			</select>
			<textarea class="textoforo" rows='10' cols='70' name='comentario'></textarea>
			
			<input class="mandarcom" type='submit' name='coment' value='enviar'>
			<input id="traecoment" type='submit' name='traecoment' value='recuperar'>
			</div>
			<div class="filtros">				
				fecha desde<input id="desde" type='text' name='desde'><br>
				fecha limite<input id="hasta" type='text' name='hasta'><input id="xfecha" type='submit' name='busfech' value='buscar por fecha'><br>
				<input id="xpalabra" type='text' name='filtro'><input id="btxpalabra" type='submit' name='buscar' value='filtro por palabra'>
			</div>
			<div class="camdatos">
				Cambie  su nombre<input id="camnombre" type="text" name="camnombre"><br>Cambie su contraseña<input id="campasw" type="password" name="campasw"><br>
				<input id="cambiar" type="submit" name="cambiar" value="cambiar datos personales"><br>
			</div>	

	<div class="mostrarmensajes">
		
	<?php



	///aqui traigo todos los mensajes de todos los usuarios

	if(isset($_POST["verforo"])){
		$servername = "localhost";
		$username = "id2418571_juanjo";
		$password = "34963006";
		$dbname = "id2418571_jjdtb";
		try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $conn->beginTransaction();
		    $stmt = $conn->prepare("SELECT user.nom_complet, user.color, tabla.coment FROM usercomenting as user INNER JOIN tabla_coment as tabla ON user.iduser=tabla.id_user"); 
		    $stmt->execute();

		    // set the resulting array to associative
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		    $forocoment=$stmt->fetchAll();
		    echo "<table>";
		    for($y=0;$y<count($forocoment);$y++){
		    	echo "<tr><p class='colores' style='color:" . $forocoment[$y]["color"] . "'>" . $forocoment[$y]["nom_complet"] . "-" . "dice:" . $forocoment[$y]["coment"] . "</p></tr><br>";
		    }
		    $conn->exec("INSERT INTO table_log(idusuario, evento) 
    						VALUES ($id, 'visualizo el foro')");
		    	$conn->commit();
		     echo "</table><br>";		    
		}catch(PDOException $e) {
				$conn->rollback();
			    echo "Error: " . $e->getMessage();
			}
			$conn = null;
	}	
		///aqui recojo solo los comentarios que hace el usuario unicamente

	if(isset($_POST["traecoment"])){
		$servername = "localhost";
		$username = "id2418571_juanjo";
		$password = "34963006";
		$dbname = "id2418571_jjdtb";
		try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $conn->beginTransaction();
		     if($_POST["seleccion"]!="filtro x nombre"){
		    	$id=(int)$_POST["seleccion"];
		    }
		    $stmt = $conn->prepare("SELECT user.color, tabla.coment FROM usercomenting as user INNER JOIN tabla_coment as tabla ON user.iduser=tabla.id_user WHERE iduser=$id");
		    $stmt->execute();
		    // set the resulting array to associative
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		    $miscomen=$stmt->fetchAll();
		    echo "<table>";
		    for($x=0;$x<count($miscomen);$x++){
		    	echo "<tr><p class='colores' style='color:" . $miscomen[$x]["color"] . "'>usuario" . $id . "_dice:" . $miscomen[$x]["coment"] . "</p></tr><br>";			    	 
		    }
		    $conn->commit();
		    echo "</table><br>";		   
		}catch(PDOException $e) {
				$conn->rollback();
			    echo "Error: " . $e->getMessage();
			}
			$conn = null;

	}
	


////aqui recojo los mensajes por filtro de palabras

	if(isset($_POST["buscar"])){
		$servername = "localhost";
		$username = "id2418571_juanjo";
		$password = "34963006";
		$dbname = "id2418571_jjdtb";
		$palabra=$_POST["filtro"];
		try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $conn->beginTransaction();
		    $stmt = $conn->prepare("SELECT tabla.coment, user.nom_complet, user.color  FROM tabla_coment as tabla LEFT JOIN usercomenting as user ON user.iduser=tabla.id_user WHERE coment LIKE '%$palabra%'"); 
		    $stmt->execute();

		    // set the resulting array to associative
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		    $seleccion=$stmt->fetchAll();
		     echo "<table>";
		   for($c=0;$c<count($seleccion);$c++){
		    	echo "<tr><p class='colores' style='color:" . $seleccion[$c]["color"] . "'>" . $seleccion[$c]["nom_complet"] . "-" . "dice:" . $seleccion[$c]["coment"] . "</p></tr><br>";
		    }
		    $conn->exec("INSERT INTO table_log(idusuario, evento) 
    						VALUES ($id, 'filtro por la palabra $palabra' )");
		    echo "</table><br>";
		    $conn->commit();		    
		}catch(PDOException $e) {
				$conn->rollback();
			    echo "Error: " . $e->getMessage();
			}
			$conn = null;
	}



///aqui recojo los mensajes por filtro de fechas

	if(isset($_POST["busfech"])){
		$servername = "localhost";
		$username = "id2418571_juanjo";
		$password = "34963006";
		$dbname = "id2418571_jjdtb";
		$fecha=str_replace("/","-",$_POST["desde"]);
		$fecha=date('Ymd', strtotime($fecha));
		$limite=str_replace("/","-",$_POST["hasta"]);
		$limite=date('Ymd', strtotime($limite));
		try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $conn->beginTransaction();
		    $stmt = $conn->prepare("SELECT tabla.coment, user.nom_complet, user.color  FROM tabla_coment as tabla INNER JOIN usercomenting as user ON user.iduser=tabla.id_user WHERE tabla.fecha >= '$fecha'  AND  tabla.fecha <='$limite.23:59:59'");
		    $stmt->execute();
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		    $mensfech=$stmt->fetchAll();
		     echo "<table>";
		   for($t=0;$t<count($mensfech);$t++){
		    	echo "<tr><p class='colores' style='color:" . $mensfech[$t]["color"] . "'>" . $mensfech[$t]["nom_complet"] . "-" . "dice:" . $mensfech[$t]["coment"] . "</p></tr><br>";
		    }
		    echo "</table><br>";
		     $conn->exec("INSERT INTO table_log(idusuario, evento) 
    						VALUES ($id, 'filtro por fecha' )");		   
		     $conn->commit();
		}catch(PDOException $e) {
				$conn->rollback();
			    echo "Error: " . $e->getMessage();
			}
			$conn = null;    	
	}



	?>
		
	</div>
		</div>
	<footer>
		<h3>FORO BY JJKOYOTE</h3>
		<P>Copyright@jjkoyote</P>
		<input id="pdf" type="submit" name="pdf" value="crear pdf">
		<input id="verforo" type='submit' name='verforo' value='ver_foro'>
		<input id="salir" type='submit' name='salir' value='salir'>
	</footer>	
	</form>
	</div>		
<?php


		



//aqui se hace el comentario normal del usuario
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
			    $conn->beginTransaction();
			    $sql = "INSERT INTO tabla_coment (id_user, coment)
			    VALUES ('$id', '$cmt')";
			    // use exec() because no results are returned
			    $conn->exec($sql);
			    echo "mensaje enviado";
			     $conn->exec("INSERT INTO table_log(idusuario, evento) 
    						VALUES ($id, 'mensaje enviado')");	
			    $conn->commit();			   		 	
			    }
			catch(PDOException $e)
			    {
			    $conn->rollback();
			    echo $sql . "<br>" . $e->getMessage();
			    }

			$conn = null;
		}	
	}


	


	


	
////aqui redirijo a logout para salir de la aplicacion al menu principal de login o registro

	if(isset($_POST["salir"])){
		$servername = "localhost";
		$username = "id2418571_juanjo";
		$password = "34963006";
		$dbname = "id2418571_jjdtb";
		try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $sql = "INSERT INTO table_log(idusuario, evento) 
		    VALUES ($id, 'el usuario salio' )";
		    // use exec() because no results are returned
		    $conn->exec($sql);
		    echo "New record created successfully";
		    }
		catch(PDOException $e)
		    {
		    echo $sql . "<br>" . $e->getMessage();
		    }

		$conn = null;
		header("location:logout.php");
	}







	///aqui se cambia los datos del usuario nombre y contraseña unicamente

	if(isset($_POST["cambiar"])){
	$servername = "localhost";
	$username = "id2418571_juanjo";
	$password = "34963006";
	$dbname = "id2418571_jjdtb";
	$newnombre=$_POST["camnombre"];
	$newpass=$_POST["campasw"];
	$hash=password_hash($newpass, PASSWORD_BCRYPT, array("cost" => 10));

	try {
	    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $conn->beginTransaction();

	    $sql = "UPDATE usercomenting SET nom_complet='$newnombre', contrasena='$hash' WHERE iduser=$id";

	    // Prepare statement
	    $stmt = $conn->prepare($sql);

	    // execute the query
	    $stmt->execute();

	    // echo a message to say the UPDATE succeeded
	    echo $stmt->rowCount() . " datos cambiados correctamente";
	     $conn->exec("INSERT INTO table_log(idusuario, evento) 
    						VALUES ($id, 'modifico sus datos' )");
	     $conn->commit();
	    }
	catch(PDOException $e)
	    {
	    $conn->rollback();	
	    echo $sql . "<br>" . $e->getMessage();
	    }

	$conn = null;	
		}

/////////////////////////////////////aqui creamos pdf////////////////////////////////////////////////////////


if(isset($_POST["pdf"])){
		  if($_POST["seleccion"]!="filtro x nombre"){
		    	$id=(int)$_POST["seleccion"];
		    	$nombrecom=split(" ", $_POST["seleccion"]);
		    	$nombrecompleto=$nombrecom[1];
		    }
		$_SESSION["id"]=$id;
		$_SESSION["username"]=$nombrecompleto;
		header("location:mensajespdf.php");		
}


?>

</body>
</html>