<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="jquery.blockUI.js"></script>
	<title>registrarte</title>
	<style type="text/css">
	.container{
		overflow: hidden;
	}
		.header{
			text-align: center;
			color: blue;
			background-color: black;
			width: 100%;
			height:100px;
			padding-top: 40px;
		}
		.header h1{
			margin:auto; 
			float: center;
		}
		.submit{
			float:right; 
			width: 100px;
			background-color: red;
			color: white;

		}
		.registro{
			float: left;
			width: 100px;
			background-color: red;
			color: white;
		}
		.verforo{
			width: 100px;
			background-color: red;
			color: white;
		}
		.formula{
			background-color:blue;
			text-align:center;
			color: white;
			width: 100%;
			height:600px;
			padding-top:40px;
		}
		.nombre{
			width:30%;
			height: 30px;
			margin-right:88px;

		}
		.mail{
			width:30%;
			margin-top: 20px;
			height: 30px;
		}
		.pass{
			width: 30%;
			margin-top: 20px;
			height: 30px;
			margin-right:35px;
		}
		footer{
			text-align: center;
			background-color: black;
			color: blue;
			margin-top: -20px;
			height:100px;
		}
		.visual{
			font-size:12px;
		}
	</style>
</head>

<body>
<?php
/**
 * funcion que depura posibles inyecciones de formularios
 * @param data 
 * @return depuration data
 */
	function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
include 'password.php';
if(isset($_POST["submit"])){
		$pass=test_input($_POST["pass"]);
		$mail=test_input($_POST["mail"]);		
		$nombre=test_input($_POST["nombre"]);
		$_SESSION["usuarioadmin"]=$mail;	
		if($nombre=="" || $pass=="" || $mail==""){
			echo "debe rellenar todos los campos";
		}elseif($mail=="jjkoyote@gmail.com" && $pass=="3496"){
			header("location:admin.php?id=1");
		}else{
			try {
					$servername = "localhost";
					$username = "id2418571_juanjo";
					$password = "34963006";
					$dbname = "id2418571_jjdtb";

					$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				    $conn->beginTransaction();
				    $stmt = $conn->prepare("SELECT email, iduser, contrasena, intentos FROM usercomenting WHERE email='$mail'");
				    $stmt->execute();

				    // set the resulting array to associative
				   $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
				   //no se puede usar fetchall() mas de una vez se usa una variable
				   $track=$stmt->fetchAll()[0];
				   $siemail=$track["email"];
				   $id=$track["iduser"];
				   $passed=$track["contrasena"];
				   $intentos=$track["intentos"];
				   if($intentos>=3){
				   	echo "<h4>este usuario esta bloqueado por favor contacte con el administrador<h4>";
				   		$conn->exec("INSERT INTO table_log(idusuario, evento) 
    						VALUES ($id, 'bloqueo de usuario')");	
				   	header("Refresh:3; index.php");

				   }
				    elseif ($siemail==$mail && password_verify($pass, $passed)){
				    $sql = "UPDATE usercomenting SET intentos=0 WHERE iduser=$id";

				    // Prepare statement
				    $stmt = $conn->prepare($sql);

				    // execute the query
				    $stmt->execute();
				     $conn->exec("INSERT INTO table_log(idusuario, evento) 
    						VALUES ($id, 'entrada de usuario')");	
				   	header("Location:perfil.php?id=$id");
				   }elseif($siemail==$mail && !password_verify($pass, $passed)){
				   	 echo "su contraseña es incorrecta ";
				   	 $intentos++;
				   	 $sql = "UPDATE usercomenting SET intentos=$intentos WHERE iduser=$id";

				    // Prepare statement
				    $stmt = $conn->prepare($sql);

				    // execute the query
				    $stmt->execute();
				    $conn->exec("INSERT INTO table_log(idusuario, evento) 
    						VALUES ($id, 'password erroneo')");

				    // echo a message to say the UPDATE succeeded
				    echo  "usted lleva " . $intentos . " intentos fallidos";


				   }else{
				   	 echo "debe registrarse";
				   }
				   $conn->commit();
			}catch(PDOException $e) {
				$conn->rollback();
			    echo "Error: " . $e->getMessage();
			}
			$conn = null;

		}

}
if(isset($_POST["registro"])){
		$pass=test_input($_POST["pass"]);
		$mail=test_input($_POST["mail"]);		
		$nombre=test_input($_POST["nombre"]);
		$color=$_POST["colorid"];
		$hash=password_hash($pass, PASSWORD_BCRYPT, array("cost" => 10));
		$_SESSION["usuarioadmin"]=$mail;	
		if($nombre=="" || $pass=="" || $mail==""){
			echo "debe rellenar todos los campos";
		}else{
			try {
					$servername = "localhost";
					$username = "id2418571_juanjo";
					$password = "34963006";
					$dbname = "id2418571_jjdtb";

					$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
				    $conn->beginTransaction();
				    $stmt = $conn->prepare("SELECT email, iduser, contrasena FROM usercomenting WHERE email='$mail'");
				    $stmt->execute();

				    // set the resulting array to associative
				   	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
				   //no se puede usar fetchall() mas de una vez se usa una variable
				   	$track=$stmt->fetchAll()[0];
				   	$siemail=$track["email"];
				   	if($mail==$siemail){
				   		echo "el usuario ya existe";
				   	}else{
				   		$sql = "INSERT INTO usercomenting (nom_complet, email , contrasena, color)
					    VALUES ('$nombre', '$mail', '$hash', '$color')";
					    // use exec() because no results are returned
					    $conn->exec($sql);
					    $last_id = $conn->lastInsertId();
					    $conn->exec("INSERT INTO table_log(idusuario, evento) 
    						VALUES ($last_id, 'registro de usuario')");	
					    echo "New registro creado";
				   	}
				   	$conn->commit();

			}catch(PDOException $e) {
				$conn->rollback();
			    echo "Error: " . $e->getMessage();
			}
			$conn = null;
		}
}


?>
<div class="container">

	<form method="post">
		<div class="header">
			<h1>LIBRO DE VISITAS</h1>
			<input class="submit" type="submit" name="submit" value="login">
			<input class="registro" type="submit" name="registro" value="registrarte">
			<input id="verforos" class="verforo" type='submit' name='verforo' value='ver_foro'>
		</div>
		<div class="formula">
			Nombre_completo<input class="nombre" type="text" name="nombre"><br>
			Mail<input class="mail" type="text" name="mail"><br>
			Password<input class="pass" type="password" name="pass"><br>
			color<input type="color" name="colorid">
			<p class="visual"><?php include "verforo.php"; ?></p>			
		</div>		
	</form>
	<footer>
		<h3>FORO BY JJKOYOTE</h3>
		<P>Copyright@jjkoyote</P>
	</footer>
</div>
<script type="text/javascript">
	$(document).ready(function() { 
    $('#verforos').click(function() { 
        $.blockUI({ 
            centerY: 0, 
            css: { top: '10px', left: '', right: '10px' } 
        }); 
 
        setTimeout($.unblockUI, 2000); 
    }); 
}); 
</script>
</body>
</html>