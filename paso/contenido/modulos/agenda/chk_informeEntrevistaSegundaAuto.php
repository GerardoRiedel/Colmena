<?php 
	session_name("agenda2");
	session_start();

	include_once('../../../lib/funciones.php');
	include_once('../../../lib/datos.php');
	include_once('../../../lib/horas/funciones.php');
	include_once('../../../lib/pacientes/funciones.php');
	include_once('../../../lib/informe_entrevista/funciones.php');
	include_once('../../../lib/usuarios/funciones.php');
	include_once('../../../lib/conectar.php');

	date_default_timezone_set('America/Santiago');	
	
	$conectar = conectar();
	
	if(siEstaLogueado() == false)
	{
		header('Location: '.$HOME);
	}


	$hora = $_POST['idHora'];
	$fecha = VueltaFecha($_POST['fecha']);
	$ocupacion = caracteres_html($_POST['ocupacion']);
	$sexo = $_POST['sexo'];
	$edad = $_POST['edad'];
	$tiempoLicencia = caracteres_html($_POST['tiempoLicencia']);
	$medicoTratante = caracteres_html($_POST['medicoTratante']);
	$nombreMedicoTratante = caracteres_html($_POST['nombreMedicoTratante']);
	$antecedentesPersonales = caracteres_html($_POST['antecedentesPersonales']);
	$antecedentesMorbidos = caracteres_html($_POST['antecedentesMorbidos']);
	$factoresEstresantes = caracteres_html($_POST['factoresEstresantes']);
	$existeEstresLaboral = caracteres_html($_POST['existeEstresLaboral']);
	$anamnesis = caracteres_html($_POST['anamnesis']);
	$examenMental = caracteres_html($_POST['examenMental']);
	$tratamientoActual = caracteres_html($_POST['tratamientoActual']);
	$opinionTratamiento = caracteres_html($_POST['opinionTratamiento']);
	$comentarios = caracteres_html($_POST['comentarios']);
	$diagnosticoLicenciaMedica = caracteres_html($_POST['diagnosticoLicenciaMedica']);
	$opinionSobreDiagnostico = caracteres_html($_POST['opinionSobreDiagnostico']);
	$eje1 = caracteres_html($_POST['eje1']);
	$eje2 = caracteres_html($_POST['eje2']);
	$eje3 = caracteres_html($_POST['eje3']);
	$eje4 = caracteres_html($_POST['eje4']);
	$eje5 = caracteres_html($_POST['eje5']);
	$opinionReposoMedico = caracteres_html($_POST['opinionReposoMedico']);
	$siReposoCorresponde = caracteres_html($_POST['siReposoCorresponde']);
	$cuantosDiasReposo = $_POST['cuantosDiasReposo'];
	$comentarios2 = caracteres_html($_POST['comentarios2']);

	
	//Veo si edita
	if(existeInformeEntrevista($hora, $conectar) != false)//edita
	{
		$idPaciente = idPacienteHora($hora, $conectar);
		$idPrestador = idPrestadorHora($hora, $conectar);
		$id = idInformeEntrevistaHora($hora, $conectar);

		editarInformeEntrevista($id, $idPaciente, $idPrestador, $hora, $fecha, $ocupacion, $sexo, $edad, $tiempoLicencia, $medicoTratante, $nombreMedicoTratante, $antecedentesPersonales, $antecedentesMorbidos, $factoresEstresantes, $existeEstresLaboral, $anamnesis, $examenMental, $tratamientoActual, $opinionTratamiento, $comentarios, $diagnosticoLicenciaMedica, $opinionSobreDiagnostico, $eje1, $eje2, $eje3, $eje4, $eje5, $opinionReposoMedico, $siReposoCorresponde, $cuantosDiasReposo, $comentarios2, $conectar);

	}	
	else//crea
	{
		$idPaciente = idPacienteHora($hora, $conectar);
		$idPrestador = idPrestadorHora($hora, $conectar);

		crearInformeEntrevista($idPaciente, $idPrestador, $hora, $fecha, $ocupacion, $sexo, $edad, $tiempoLicencia, $medicoTratante, $nombreMedicoTratante, $antecedentesPersonales, $antecedentesMorbidos, $factoresEstresantes, $existeEstresLaboral, $anamnesis, $examenMental, $tratamientoActual, $opinionTratamiento, $comentarios, $diagnosticoLicenciaMedica, $opinionSobreDiagnostico, $eje1, $eje2, $eje3, $eje4, $eje5, $opinionReposoMedico, $siReposoCorresponde, $cuantosDiasReposo, $comentarios2, $conectar);
	}

	agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Informe Entrevista - Autoguardado - hora: '.$hora, $conectar);
?>