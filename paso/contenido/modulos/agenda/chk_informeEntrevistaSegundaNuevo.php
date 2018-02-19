<?php 
	session_name("agenda2");
	session_start();

	include('../../../lib/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/informe_entrevista/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/conectar.php');


	$conectar = conectar();
	
	if(siEstaLogueado() == false)
	{
		header('Location: '.$HOME);
	}


	$hora = $_POST['idHora'];
	$confirmacion = $_POST['confirmado'];
	$idPaciente = idPacienteHora($hora, $conectar);
	$idPrestador = idPrestadorHora($hora, $conectar);
	$fecha = VueltaFecha($_POST['fecha']);
	$ocupacion = caracteres_html($_POST['ocupacion']);
	$sexo = $_POST['sexo'];
	$edad = $_POST['edad'];
	$tiempoLicencia = $_POST['tiempoLicencia'];
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
	$eje1 = utf8_decode($_POST['eje1']);
	$eje2 = caracteres_html($_POST['eje2']);
	$eje3 = caracteres_html($_POST['eje3']);
	$eje4 = caracteres_html($_POST['eje4']);
	$eje5 = caracteres_html($_POST['eje5']);
	$diasAcumulados = $_POST['diasAcumulados'];
	$fechaInicioUL = VueltaFecha($_POST['fechaInicioUL']);
	$diasReposoIndicados = $_POST['diasReposoIndicados'];
	$correspondeReposo = $_POST['correspondeReposo'];
	$periodo = $_POST['periodo'];
	$diasPeriodo = $_POST['diasReposoIndicados'];
	$pronosticoReintegro = $_POST['pronosticoReintegro'];
	$diasPronostico = $_POST['diasPronostico'];
	$comentarios2 = caracteres_html($_POST['comentarios2']);
	$ttoRedGes =$_POST['ttoRedGes'];
    $lugarRedGes=$_POST['lugarRedGes'];
	$enfermedadlaboral=$_POST['enfermedadlaboral'] ;
	$sqlVerificar = mysql_query("
	SELECT id FROM informe_entrevista i
	WHERE i.`hora`=".$hora."
	", $conectar);
	
	$num = mysql_num_rows($sqlVerificar);
	// la variable $diasPeriodo no estaba seteada se homologa a diasReposoIndicados, en base esta con valor 0
	//Veo si edita
	$id = $_POST['id'];
	if($id != NULL or $num != 0)//edita
	{
		if($id == NULL and $num != 0){
			$rowVerificar = mysql_fetch_array($sqlVerificar);
			$id = $rowVerificar['id'];
		}
		  $rs=editarInformeEntrevistaNuevo($id, $idPaciente, $idPrestador, $hora, $fecha, $ocupacion, $sexo, $edad,$medicoTratante, $nombreMedicoTratante, $numeroLicencia, $antecedentesPersonales, $antecedentesMorbidos, $factoresEstresantes, $anamnesis, $examenMental, $tratamientoActual, $opinionTratamiento, $comentarios, $diagnosticoLicenciaMedica, $opinionSobreDiagnostico, $comentariosDLM, $eje1, $eje2, $eje3, $eje4, $eje5, $diasAcumulados, $fechaInicioUL, $diasReposoIndicados, $correspondeReposo, $periodo, $diasPeriodo,$comentarios2,$ttoRedGes,$lugarRedGes, $enfermedadlaboral,$conectar);
		
		echo $rs ;
		$_SESSION['msj'] = 'Informe editado';
	}	
	else//crea
	{
		$rs=crearInformeEntrevistaNuevo($idPaciente, $idPrestador, $hora, $fecha, $ocupacion, $sexo, $edad,$medicoTratante, $nombreMedicoTratante, $numeroLicencia, $antecedentesPersonales, $antecedentesMorbidos, $factoresEstresantes, $existeEstresLaboral, $evaluacionEspecifica, $anamnesis, $examenMental, $tratamientoActual, $opinionTratamiento, $comentarios, $diagnosticoLicenciaMedica, $opinionSobreDiagnostico, $comentariosDLM, $eje1, $eje2, $eje3, $eje4, $eje5, $diasAcumulados, $fechaInicioUL, $diasReposoIndicados, $correspondeReposo, $periodo, $diasPeriodo,$comentarios2,$ttoRedGes,$lugarRedGes,$enfermedadlaboral, $conectar);
		
		echo $rs ;

		$_SESSION['msj'] = 'Informe agregado';
	}
	
	agregarLog($_SERVER['HTTP_REFERER'], $_SESSION['idUsuario'], nombreUsuario($_SESSION['idUsuario'], $conectar), date('Y-m-d H:i:s'), 'Informe Entrevista - Guardado manual - hora: '.$hora, $conectar);
	
 //header('Location: chk_informeEntrevistaSegundaDescargaNuevo.php?id='.$hora);	
?>