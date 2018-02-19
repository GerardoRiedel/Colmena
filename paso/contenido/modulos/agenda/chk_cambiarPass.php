<?php 
	session_name("agenda2");
session_start();

	include('../../../lib/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/conectar.php');
	$conectar = conectar();
	
	if(siEstaLogueado() == false)
	{
		header('Location: '.$HOME);
	}

	$antigua = md5($_POST['antigua']);
	$nueva = md5($_POST['nueva']);
	$repite = md5($_POST['repite']);
	
	if($antigua != passUsuario($_SESSION['idUsuario'], $conectar))
	{
		$_SESSION['msj'] = 'Las contrase&ntilde;a no coincide';
		header('Location: '.$TEMPLATE_DIR2.'/mensajes.php');
		die();	
	}
	elseif($nueva == $repite)
	{
		cambiarPassUsuario($_SESSION['idUsuario'], $nueva, $conectar);
	}

	$_SESSION['msj'] = 'Contrase&ntilde;a cambiada';
		
	header('Location: '.$TEMPLATE_DIR2.'/mensajes.php');	
?>