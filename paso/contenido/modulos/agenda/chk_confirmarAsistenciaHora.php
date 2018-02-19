<?php 
	session_name("agenda2");
	session_start();

	include('../../../lib/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/conectar.php');
	$conectar = conectar();
	
	if(siEstaLogueado() == false)
	{
		header('Location: '.$HOME);
	}

	$idHora = $_REQUEST['hora'];
	$asiste = $_REQUEST['asiste'];


	$estado =confirmarAsistenciaHora($idHora,$asiste, $conectar);
	
	agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Confirmar asistencia - hora: '.$idHora, $conectar);

	//$_SESSION['msj'] = 'Hora confirmada';
	
	//header('Location: '.$TEMPLATE_DIR2.'/mensajesPopup.php');
 return $estado ;
?>