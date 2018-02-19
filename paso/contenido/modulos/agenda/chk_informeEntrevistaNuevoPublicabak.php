<?php 
	session_name("agenda2");
	session_start();

	
		
	include('../../../lib/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/prestadores/funciones.php');
	include('../../../lib/informe_entrevista/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/conectar.php');
		
		
	$conectar = conectar();
	
	if(siEstaLogueado() == false)
	{
		header('Location: '.$HOME);
	}


	$idhora = $_GET['idHora'];

	//publica el informe para isapres
	//20-01-2012
	//fecha actual
	setlocale(LC_ALL,"SP");
	$fechaActual = strftime("%d")." de ".strftime("%B")." de ".strftime("%Y");
	$fechaActual = editames($fechaActual);
	$fechaActual = cambiaf_a_mysql($fechaActual);

	$sqlPublica =  mysql_query("update informe_entrevista set publicado='SI', fechaPublicacion='$fechaActual' where hora='$idhora'", $conectar);
	
	$_SESSION['msj'] = 'Informe publicado';	
	
	$prestador = prestadorUsuario($_SESSION['idUsuario'], $conectar);
	$datosInformeId = datosInformeHora($idhora, $conectar);	
	agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Publica informe - hora: '.$datosInformeId['hora'].' informe: '.$informe, $conectar);
	// crearInformeNuevoBin($idHora, $conectar) ;
	include_once('../envioemail/emailinforme.php');
header('Location: chk_informeEntrevistaSegundaDescargaNuevo.php?id='.$idhora);	        
?>

