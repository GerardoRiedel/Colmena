<?php 
	session_name("agenda2");
	session_start();

	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/prestadores/funciones.php');
	include('../../../lib/encuesta_peritaje/funciones.php');
	include('../../../lib/informe_entrevista/funciones.php');
	include('../../../lib/conectar.php');
	
	$conectar = conectar();
	
	if($_POST['rut'])
	{
		$rut = SacarPunto($_POST['rut']);
	}
	else
	{
		$rut = SacarPunto($_POST['rut']);
	}
	$idisa= $_POST['idisapre'];
	$nombrepaciente=nombreCompletoPacienterut($rut, $conectar);
 $opcion = $_POST['opcion'];
  $fecha = $_POST['fecha'];
 
	if ($opcion == 1 )
	{
		include ('resultadobusquedaPeritajeisaprerut.php');
	}else{
		include ('resultadobusquedaPeritajeisaprefecpub.php');
	}
 
?>
