<?php 
session_start();

// if session is not set redirect the user
if(empty($_SESSION['u_name']))
	header("Location:index.html");	

//if logout then destroy the session and redirect the user
if(isset($_GET['logout']))
{
	session_destroy();
	header("Location:index.html");
}	

echo "<br/><center><h4><a href='salir.php?logout'><b>Logout</b></a></h4></center>";
?>
<!doctype html>
<html>
	<head>
		<title>Login ...Correcto con tu Account Using Ajax</title>
		<link href="assets/css/bootstrap.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
	<center>
	<br/>
		<h1> Yuppp! You have Logged In using A ajax Login System</h1>
		<br/>
		<h4> Cetep <a href="www.cetep.cl">Agenda.... </a></h4>
	</center>
	</body>
</html>