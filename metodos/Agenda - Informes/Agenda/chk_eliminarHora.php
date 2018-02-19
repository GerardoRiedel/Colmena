<?php 
	session_name("agenda2");
	session_start();

	include('../../../lib/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/conectar.php');
	$conectar = conectar();
	
	if(siEstaLogueado() == false)
	{
		header('Location: '.$HOME);
	}

	$idHora = $_GET['id'];

	$usuario = $_SESSION['idUsuario'];
	$hora = horaHora($idHora, $conectar);
	$idPaciente = idPacienteHora($idHora, $conectar);
	$idPrestador = idPrestadorHora($idHora, $conectar);
	$idIsapre = isapreHora($idHora, $conectar);
		
//METODO PARA ANULAR HORA EN COLMENA, ANTES DE HABER REALIZADO EL PROCESO DE DELETE CORRESPONDIENTE PARA PODER TENER LOS DATOS
        include('../../../ws/colmena/metodos/anularHoraColmena.php');


	eliminarHora($idHora, $usuario, $hora, $idPaciente, $idPrestador, $idIsapre, $conectar);

	agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Eliminar hora - hora: '.$idHora, $conectar);

	$_SESSION['msj'] = 'Hora eliminada';


	


	header('Location: '.$TEMPLATE_DIR2.'/mensajesPopup.php');
?>