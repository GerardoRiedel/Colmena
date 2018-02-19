<?php 
	session_name("agenda2");
	session_start();
	
	include_once('../../../lib/fpdf/fpdf.php');
	include_once('../../../lib/pacientes/funciones.php');
	include_once('../../../lib/isapres/funciones.php');
	include_once('../../../lib/usuarios/funciones.php');
	include_once('../../../lib/horas/funciones.php');
	include_once('../../../lib/prestadores/funciones.php');
	include_once('../../../lib/informe_entrevista/funciones.php');
	include_once('../../../lib/querys/comunas.php');
	include_once('../../../lib/querys/ciudades.php');
	include_once('../../../lib/datos.php');
	include_once('../../../lib/funciones.php');
	include_once('../../../lib/conectar.php');

	$conectar = conectar();
		
	$idHora = $_GET['id'];
	$datos = datosHora($idHora, $conectar);
	$isapre =$datos['isapre'];
	$ciudad = $datos['ciudad'];
	if ($_GET['tiposalida'] == '' ) {
		$tipoSalida = 'I';
	}else{
		$tipoSalida = $_GET['tiposalida'];
	}
	if (($ciudad == '53' ||$ciudad == '1') && ($isapre == '19')){
		crearInformeNuevoEspecial($idHora, $tipoSalida, $carpetaSalida, $conectar);
	}elseif ($ciudad == '53' )  {
		crearInformeNuevoEspecial($idHora, $tipoSalida, $carpetaSalida, $conectar);
	}else {
		crearInformeNuevo($idHora, $tipoSalida, $carpetaSalida, $conectar);
	}

?>