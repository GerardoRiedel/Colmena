<?php 
	session_name("agenda2");
session_start();

	include('../../../lib/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/encuesta_peritaje/funciones.php');
	include('../../../lib/conectar.php');
	$conectar = conectar();
	
	if(siEstaLogueado() == false)
	{
		header('Location: '.$HOME);
	}

	$hora = $_POST['idHora'];
	$paciente = idPacienteHora($hora, $conectar);
	$prestador = idPrestadorHora($hora, $conectar);
	$sexo = $_POST['sexo'];
	$edad = $_POST['edad'];
	$isapre = isaprePaciente($paciente, $conectar);
	$comuna = idComunaPaciente($paciente, $conectar);
	$actividad = caracteres_html($_POST['actividad']);
	$tiempoDeLM = $_POST['tiempoDeLM'];
	$diagnosticoLM = caracteres_html($_POST['diagnosticoLM']);
	$opinionDiagnostico = caracteres_html($_POST['opinionDiagnostico']);
	$correspondeReposo = caracteres_html($_POST['correspondeReposo']);
	$tratante = caracteres_html($_POST['tratante']);
	$opinionTratamiento = caracteres_html($_POST['opinionTratamiento']);
	
	//Veo si edita
	$id = $_POST['id'];
	if($id != NULL)//edita
	{
		editarEncuestaPeritaje($id, $paciente, $prestador, $hora, $sexo, $edad, $isapre, $comuna, $actividad, $tiempoDeLM, $diagnosticoLM, $opinionDiagnostico, $correspondeReposo, $tratante, $opinionTratamiento, $conectar);

		$_SESSION['msj'] = 'Encuesta editada';

	}	
	else//crea
	{
		crearEncuestaPeritaje($paciente, $prestador, $hora, $sexo, $edad, $isapre, $comuna, $actividad, $tiempoDeLM, $diagnosticoLM, $opinionDiagnostico, $correspondeReposo, $tratante, $opinionTratamiento, $conectar);

		$_SESSION['msj'] = 'Encuesta agregada';
	}
	
		
	header('Location: agregarInformeEntrevistaDescarga.php?hora='.$hora);	
?>