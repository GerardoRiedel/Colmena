<?php 
	session_name("agenda2");
	session_start();

	include_once('../../../lib/funciones.php');
	include_once('../../../lib/datos.php');
	include_once('../../../lib/horas/funciones.php');
	include_once('../../../lib/pacientes/funciones.php');
	include_once('../../../lib/informe_trauma/funciones.php');
	include_once('../../../lib/usuarios/funciones.php');
	include_once('../../../lib/conectar.php');
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
	$medicoTratante = caracteres_html($_POST['medicoTratante']);
	$nombreMedicoTratante = caracteres_html($_POST['nombreMedicoTratante']);
	$numeroLicencia = $_POST['numeroLicencia'];
	$antecedentesPersonales = caracteres_html($_POST['antecedentesPersonales']);
	$antecedentesMedicos = caracteres_html($_POST['antecedentesMedicos']);
	$antecedentesTraumatologicos = 	caracteres_html($_POST['antecedentesTraumatologicos']);
	$anamnesis = caracteres_html($_POST['anamnesis']);
	$rxexamenlaboratorio = caracteres_html($_POST['rxexamenlaboratorio']);
	$examenfisico = caracteres_html($_POST['examenfisico']);
	$enfermedadLaboral = $_POST['enfermedadLaboral'];
	$tratamientoActual = caracteres_html($_POST['tratamientoActual']);
	$tratamientoPendiente = caracteres_html($_POST['tratamientoPendiente']);
	$tratamientoSugerido = caracteres_html($_POST['tratamientoSugerido']);
	$diagnosticoLicenciaMedica = caracteres_html($_POST['diagnosticoLicenciaMedica']);
    $diagnosticoTMT = caracteres_html($_POST['diagnosticoTMT']);
	$diagnosticoconcomitantes = caracteres_html($_POST['diagnosticoconcomitantes']);
	$gradolimitacionfuncional = caracteres_html($_POST['gradolimitacionfuncional']);
	$opinionSobreDiagnostico = caracteres_html($_POST['opinionSobreDiagnostico']);
	$comentariosDLM = caracteres_html($_POST['comentariosDLM']);
	$diasAcumulados = $_POST['diasAcumulados'];
	$fechaInicioUL = VueltaFecha($_POST['fechaInicioUL']);
	$diasReposoIndicados = $_POST['diasReposoIndicados'];
	$correspondeReposo = $_POST['correspondeReposo'];
	$periodo = $_POST['periodo'];
	$comentarios2 = caracteres_html($_POST['comentarios2']);

///




	//Veo si edita
	if(existeInformeEntrevista2($hora, $conectar) != NULL)//edita
	{
		$idPaciente = idPacienteHora($hora, $conectar);
		$idPrestador = idPrestadorHora($hora, $conectar);
		$id = idInformeEntrevistaHora($hora, $conectar);
	
   		$x=editarInformeEntrevistaNuevo($id, $idPaciente, $idPrestador,$hora,$fecha ,$ocupacion,$sexo,$edad,$medicoTratante,$nombreMedicoTratante,$numeroLicencia,$antecedentesPersonales,$antecedentesMedicos,$antecedentesTraumatologicos,$anamnesis,$rxexamenlaboratorio,$examenfisico,$enfermedadLaboral,$tratamientoActual,$tratamientoPendiente,$tratamientoSugerido,$diagnosticoLicenciaMedica,$diagnosticoTMT,$diagnosticoconcomitantes,$gradolimitacionfuncional,$opinionSobreDiagnostico,$comentariosDLM,$diasAcumulados,$fechaInicioUL,$diasReposoIndicados,$correspondeReposo,$periodo,$comentarios2,$conectar) ;

	///echo $x ;
        agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Informe Entrevista - Edita y Autoguardado - hora: '.$hora, $conectar);


    }
	else//crea
	{
		$idPaciente = idPacienteHora($hora, $conectar);
		$idPrestador = idPrestadorHora($hora, $conectar);
				
		crearInformeEntrevistaNuevo($idPaciente,$idPrestador,$hora,$fecha,$ocupacion,$sexo,$edad,$medicoTratante,$nombreMedicoTratante,$numeroLicencia,$antecedentesPersonales,$antecedentesMedicos,$antecedentesTraumatologicos,$anamnesis,$rxexamenlaboratorio,$examenfisico,$tratamientoActual,$enfermedadlaboral, $tratamientoPendiente,$tratamientoSugerido,$diagnosticoLicenciaMedica,$opinionSobreDiagnostico,$comentariosDLM,$diasAcumulados,$diasReposoIndicados,$correspondeReposo,$periodo,$comentarios2,$diagnosticoTMT,$diagnosticoconcomitantes,$gradolimitacionfuncional,$fechaInicioUL,$enfermedadLaboral,$conectar);

        agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Informe Entrevista - Crea y Autoguardado - hora: '.$hora, $conectar);
	}

	agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Informe Entrevista - Autoguardado - hora: '.$hora, $conectar);
?>