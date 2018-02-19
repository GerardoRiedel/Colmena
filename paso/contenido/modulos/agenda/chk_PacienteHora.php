<?php 
	session_name("agenda2");
	session_start();

	include('../../../lib/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/conectar.php');
	
	//date_default_timezone_set('America/Santiago');	 
		
	$conectar = conectar();
	
	if(siEstaLogueado() == false)
	{
		header('Location: '.$HOME);
	}

	$idHora = $_POST['idHora'];
	$rut = SacarPunto($_POST['rut']);
	$nombres = $_POST['nombres'];
	$apellidoPaterno =$_POST['apellidoPaterno'];
	$apellidoMaterno =  $_POST['apellidoMaterno'];
	$telefono = $_POST['telefono'];
	$celular = $_POST['celular'];
	$email = $_POST['email'];
	$direccion = $_POST['direccion'];
	$comuna = $_POST['comuna'];
	$isapre = $_POST['isapre'];
	$usuario = $_POST['idUsuario'];
	$numerolicencia = $_POST['numerolicencia'];
	$observacion = $_POST['observacion'];
	$prestador = $_POST['idPrestador'];
	$idCiudad = $_POST['idCiudad'];
		

		$hora = $_POST['fecha'];
		$datosPaciente = datosPacienteRut($rut, $conectar);
		$paciente = $datosPaciente['id'];

//Si el paciente no existe se crea
if($paciente == NULL)
{
    $paciente = crearPaciente($rut, $nombres, $apellidoPaterno, $apellidoMaterno, $direccion, $comuna, $telefono, $celular, $email, $isapre , $conectar);
}else {
    editarPaciente($paciente, $rut, $nombres, $apellidoPaterno, $apellidoMaterno, $direccion, $comuna, $telefono, $celular, $email, $isapre , $conectar);
}


// solo se modifica los datos del paciente por tener hora proxima
//editarHora2($idHora, $paciente, $isapre, $observacion,$numerolicencia, $conectar);
//editarIsapreHora($idHora, $isapre, $conectar);

agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Editar Paciente - hora: '.$idHora, $conectar);

$msj= 'Datos Paciente Modificados';

//header('Location: '.$TEMPLATE_DIR2.'/mensajesPopup.php') ;


echo $msj;
?>