<?php 
	session_name("agenda2");
	session_start();

	include('../../../lib/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/informe_trauma/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/conectar.php');
	$conectar = conectar();
	
	if(siEstaLogueado() == false)
	{
		header('Location: '.$HOME);
	}


	$hora = $_REQUEST['idHora'];
	$confirmacion = $_REQUEST['confirmado'];
	$idPaciente = idPacienteHora($hora, $conectar);
	$idPrestador = idPrestadorHora($hora, $conectar);
$fecha = VueltaFecha($_REQUEST['fecha']);
$ocupacion = caracteres_html($_REQUEST['ocupacion']);
$sexo = $_REQUEST['sexo'];
$edad = $_REQUEST['edad'];
$tiempoLicencia = caracteres_html($_REQUEST['tiempoLicencia']);
$medicoTratante = $_REQUEST['medicoTratante'];
$nombreMedicoTratante = caracteres_html($_REQUEST['nombreMedicoTratante']);
$numeroLicencia = $_REQUEST['numeroLicencia'];
$antecedentesPersonales = caracteres_html($_REQUEST['antecedentesPersonales']);
$antecedentesMedicos = caracteres_html($_REQUEST['antecedentesMedicos']);
$antecedentesTraumatologicos = 	caracteres_html($_REQUEST['antecedentesTraumatologicos']);
$anamnesis = caracteres_html($_REQUEST['anamnesis']);
$rxexamenlaboratorio = caracteres_html($_REQUEST['rxexamenlaboratorio']);
$examenfisico = caracteres_html($_REQUEST['examenfisico']);
$enfermedadLaboral = caracteres_html($_REQUEST['enfermedadLaboral']);
$tratamientoActual = caracteres_html($_REQUEST['tratamientoActual']);
$tratamientoPendiente = caracteres_html($_REQUEST['tratamientoPendiente']);
$tratamientoSugerido = caracteres_html($_REQUEST['tratamientoSugerido']);
$diagnosticoLicenciaMedica = caracteres_html($_REQUEST['diagnosticoLicenciaMedica']);
$diagnosticoTMT = caracteres_html($_REQUEST['diagnosticoTMT']);
$diagnosticoconcomitantes = caracteres_html($_REQUEST['diagnosticoconcomitantes']);
$gradolimitacionfuncional = caracteres_html($_REQUEST['gradolimitacionfuncional']);
$opinionSobreDiagnostico = caracteres_html($_REQUEST['opinionSobreDiagnostico']);
$comentariosDLM = caracteres_html($_REQUEST['comentariosDLM']);
$diasAcumulados = $_REQUEST['diasAcumulados'];
$fechaInicioUL = VueltaFecha($_REQUEST['fechaInicioUL']);

$diasReposoIndicados = $_REQUEST['diasReposoIndicados'];
$correspondeReposo = $_REQUEST['correspondeReposo'];
$periodo = $_REQUEST['periodo'];
$comentarios2 = caracteres_html($_REQUEST['comentarios2']);
	$sqlVerificar = mysql_query("
	SELECT id FROM informe_traumatologico i
	WHERE i.`hora`=".$hora."
	", $conectar);
	
	$num = mysql_num_rows($sqlVerificar);
	// la variable $diasPeriodo no estaba seteada se homologa a diasReposoIndicados, en base esta con valor 0
	//Veo si edita
	$id = $_REQUEST['id'];
	if($id != NULL or $num != 0)//edita
	{
		if($id == NULL and $num != 0){
			$rowVerificar = mysql_fetch_array($sqlVerificar);
			$id = $rowVerificar['id'];
		}

		$x=editarInformeEntrevistaNuevo($id, $idPaciente, $idPrestador,$hora,$fecha ,$ocupacion,$sexo,$edad,$medicoTratante,$nombreMedicoTratante,$numeroLicencia,$antecedentesPersonales,$antecedentesMedicos,$antecedentesTraumatologicos,$anamnesis,$rxexamenlaboratorio,$examenfisico,$enfermedadLaboral,$tratamientoActual,$tratamientoPendiente,$tratamientoSugerido,$diagnosticoLicenciaMedica,$diagnosticoTMT,$diagnosticoconcomitantes,$gradolimitacionfuncional,$opinionSobreDiagnostico,$comentariosDLM,$diasAcumulados,$fechaInicioUL,$diasReposoIndicados,$correspondeReposo,$periodo,$comentarios2,$conectar) ;

		//$_SESSION['msj'] = 'Informe editado';
	}	
	else//crea
	{
		$x=crearInformeEntrevistaNuevo($idPaciente,$idPrestador,$hora,$fecha,$ocupacion,$sexo,$edad,$medicoTratante,$nombreMedicoTratante,$numeroLicencia,$antecedentesPersonales,$antecedentesMedicos,$antecedentesTraumatologicos,$anamnesis,$rxexamenlaboratorio,$examenfisico,$tratamientoActual,$enfermedadLaboral,$tratamientoPendiente,$tratamientoSugerido,$diagnosticoLicenciaMedica,$opinionSobreDiagnostico,$comentariosDLM,$diasAcumulados,$diasReposoIndicados,$correspondeReposo,$periodo,$comentarios2,$diagnosticoTMT,$diagnosticoconcomitantes,$gradolimitacionfuncional,$fechaInicioUL,$enfermedadLaboral,$conectar);

	 //$_SESSION['msj'] = 'Informe agregado';
	}
	
	agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Informe Entrevista - Guardado manual - hora: '.$hora, $conectar);
	
//header('Location: chk_informeEntrevistaTraumatologicoDescarga.php?id='.$hora);
return $x;
?>