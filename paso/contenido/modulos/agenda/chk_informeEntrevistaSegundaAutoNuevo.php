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
	
	//date_default_timezone_set('America/Santiago');	
	
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
	$numeroLicencia = $_POST['numeroLicencia'];
	$antecedentesPersonales = caracteres_html($_POST['antecedentesPersonales']);
	$antecedentesMorbidos = caracteres_html($_POST['antecedentesMorbidos']);
	$factoresEstresantes = caracteres_html($_POST['factoresEstresantes']);
	$existeEstresLaboral = caracteres_html($_POST['existeEstresLaboral']);
	$evaluacionEspecifica = caracteres_html($_POST['evaluacionEspecifica']);
	$anamnesis = caracteres_html($_POST['anamnesis']);
	$examenMental = caracteres_html($_POST['examenMental']);
	$tratamientoActual = caracteres_html($_POST['tratamientoActual']);
	$opinionTratamiento = caracteres_html($_POST['opinionTratamiento']);
	$comentarios = caracteres_html($_POST['comentarios']);
	$diagnosticoLicenciaMedica = caracteres_html($_POST['diagnosticoLicenciaMedica']);
	$opinionSobreDiagnostico = caracteres_html($_POST['opinionSobreDiagnostico']);
	$comentariosDLM = caracteres_html($_POST['comentariosDLM']);
	$eje1 = caracteres_html($_POST['eje1']);
	$eje2 = caracteres_html($_POST['eje2']);
	$eje3 = caracteres_html($_POST['eje3']);
	$eje4 = caracteres_html($_POST['eje4']);
	$eje5 = caracteres_html($_POST['eje5']);
	$diasAcumulados = $_POST['diasAcumulados'];
	$fechaInicioUL = VueltaFecha($_POST['fechaInicioUL']);
	$diasReposoIndicados = $_POST['diasReposoIndicados'];
	$correspondeReposo = $_POST['correspondeReposo'];
	$periodo = $_POST['periodo'];
	$diasPeriodo = $_POST['diasPeriodo'];
	$pronosticoReintegro = $_POST['pronosticoReintegro'];
//	$diasPronostico = $_POST['diasPronostico'];
$diasPronostico = 0 ;
	$comentarios2 = caracteres_html($_POST['comentarios2']);
    $ttoRedGes= $_POST['ttoRedGes'];
  	$lugarRedGes = $_POST['lugarRedGes'] ; 
	$enfermedadlaboral=$_POST['enfermedadlaboral'] ;
	//Veo si edita
	if(existeInformeEntrevista($hora, $conectar) != false)//edita
	{
		$idPaciente = idPacienteHora($hora, $conectar);
		$idPrestador = idPrestadorHora($hora, $conectar);
		$id = idInformeEntrevistaHora($hora, $conectar);

		///$rs=editarInformeEntrevistaNuevo($id, $idPaciente, $idPrestador, $hora, $fecha, $ocupacion, $sexo, $edad, $tiempoLicencia, $medicoTratante, $nombreMedicoTratante, $numeroLicencia, $antecedentesPersonales, $antecedentesMorbidos, $factoresEstresantes, $existeEstresLaboral, $evaluacionEspecifica, $anamnesis, $examenMental, $tratamientoActual, $opinionTratamiento, $comentarios, $diagnosticoLicenciaMedica, $opinionSobreDiagnostico, $comentariosDLM, $eje1, $eje2, $eje3, $eje4, $eje5, $diasAcumulados, $fechaInicioUL, $diasReposoIndicados, $correspondeReposo, $periodo, $diasPeriodo, $pronosticoReintegro, $diasPronostico, $comentarios2 ,$ttoRedGes,$lugarRedGes,$enfermedadlaboral, $conectar);
        $rs=editarInformeEntrevistaNuevo($id, $idPaciente, $idPrestador, $hora, $fecha, $ocupacion, $sexo, $edad, $medicoTratante, $nombreMedicoTratante, $numeroLicencia, $antecedentesPersonales, $antecedentesMorbidos, $factoresEstresantes, $anamnesis, $examenMental, $tratamientoActual, $opinionTratamiento, $comentarios, $diagnosticoLicenciaMedica, $opinionSobreDiagnostico, $comentariosDLM, $eje1, $eje2, $eje3, $eje4, $eje5, $diasAcumulados, $fechaInicioUL, $diasReposoIndicados, $correspondeReposo, $periodo, $diasPeriodo, $comentarios2 ,$ttoRedGes,$lugarRedGes,$enfermedadlaboral, $conectar);		
        agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Informe Entrevista - Autoguardado Edita - hora: '.$hora, $conectar);
		echo $rs;	
	}	
	else//crea
	{
		$idPaciente = idPacienteHora($hora, $conectar);
		$idPrestador = idPrestadorHora($hora, $conectar);
				
		$rs=crearInformeEntrevistaNuevo($idPaciente, $idPrestador, $hora, $fecha, $ocupacion, $sexo, $edad, $tiempoLicencia, $medicoTratante, $nombreMedicoTratante, $numeroLicencia, $antecedentesPersonales, $antecedentesMorbidos, $factoresEstresantes, $existeEstresLaboral, $evaluacionEspecifica, $anamnesis, $examenMental, $tratamientoActual, $opinionTratamiento, $comentarios, $diagnosticoLicenciaMedica, $opinionSobreDiagnostico, $comentariosDLM, $eje1, $eje2, $eje3, $eje4, $eje5, $diasAcumulados, $fechaInicioUL, $diasReposoIndicados, $correspondeReposo, $periodo, $diasPeriodo, $pronosticoReintegro, $diasPronostico, $comentarios2,$ttoRedGes,$lugarRedGes,$enfermedadlaboral, $conectar);
	     agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Informe Entrevista - Autoguardado Nuevo - hora: '.$hora, $conectar);		
		echo $rs;
	}

	//agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Informe Entrevista - grabaCampos - hora: '.$hora, $conectar);

?>