<?php 
	session_name("agenda2");
session_start();

	include('../../../lib/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/conectar.php');
	$conectar = conectar();
	//fecha actual
	setlocale(LC_ALL,"SP");
	$fechaActual = strftime("%d")." de ".strftime("%B")." de ".strftime("%Y");
	$fechaActual = editames($fechaActual);
	$fechaActual = cambiaf_a_mysql($fechaActual);
	//hora actual
	$horaActual = date("H:i:s");
	

	$fechoraConfirmacion = $fechaActual." ".$horaActual;
	

	
	if(siEstaLogueado() == false)
	{
		header('Location: '.$HOME);
	}

	$idHora = $_GET['hora'];

	confirmarHora($idHora, $fechoraConfirmacion, $conectar);
//	confirmarHora($idHora, $conectar);
		
	$_SESSION['msj'] = 'Hora confirmada';
	
	header('Location: '.$TEMPLATE_DIR2.'/mensajesPopup.php');

?>