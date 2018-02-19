<?php 
	session_name("agenda2");
	session_start();

	include('../../../lib/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/conectar.php');
	$conectar = conectar();
	
	if(siEstaLogueado() == false)
	{
		header('Location: '.$HOME);
	}


	$idhora = $_GET['idHora'];
	

	$_SESSION['msj'] = 'Ver Informe publicado...';	
	header('Location: chk_informeEntrevistaSegundaDescargaNuevo.php?id='.$idhora);	
?>