<?php 
	session_name("agenda2");
	session_start();

	include('../../../lib/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/prestadores/funciones.php');
	include('../../../lib/conectar.php');
	$conectar = conectar();
	
	if(siEstaLogueado() == false)
	{
		header('Location: '.$HOME);
	}

	$idHoraPrestador = $_POST['hora'];
     
	mysql_query("DELETE FROM isapres_hora WHERE hora=$idHoraPrestador ", $conectar);
	//Recibo las isapres seleccionadas
	if($_POST['isapre'])
	{
		$arrayIsapres = NULL;
		foreach($_POST['isapre'] as $isapres)
		{
			vincularIsapreHora($isapres, $idHoraPrestador, $conectar);
		}
	}
	
	$_SESSION['msj'] = 'Vinculación creada. Refresque la ventana';
		
	header('Location: '.$TEMPLATE_DIR2.'/mensajesCerrarVent.php');	
?>