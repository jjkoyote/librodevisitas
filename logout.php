<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>logout</title>
</head>
<body>
	<h1>abandonando sesion</h1>
	<?php
// remove all session variables


// destroy the session 
session_unset();
session_destroy(); 
header("Refresh:3; index.php");
?>
</body>
</html>