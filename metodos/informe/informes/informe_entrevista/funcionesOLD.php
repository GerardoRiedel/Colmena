<?php
//modificado 09-01-2014

function datosInformeId($id, $conectar){
	$sql = mysql_query("
	SELECT 
		* 
	FROM 
		informe_entrevista i
	WHERE 
		i.`id`=".$id, $conectar);
	return mysql_fetch_array($sql);
}
function datosInformeHora($hora, $conectar){
	$sql = mysql_query("
	SELECT 
		* 
	FROM 
		informe_entrevista i
	WHERE 
		i.`hora`=".$hora, $conectar);
	return mysql_fetch_array($sql);
}
function datosInformeHoraTrauma($hora, $conectar){
    $sql = mysql_query("
	SELECT 
		* 
	FROM 
		informe_traumatologico i
	WHERE 
		i.`hora`=".$hora, $conectar);
    return mysql_fetch_array($sql);
}
///////////////////////////////////////////////////////////////////////////////
//////////////////////////NUEVO 2009-07-14/////////////////////////////////////

function crearInformeEntrevistaNuevo($idPaciente, $idPrestador, $hora, $fecha, $ocupacion, $sexo, $edad,$medicoTratante, $nombreMedicoTratante, $numeroLicencia, $antecedentesPersonales, $antecedentesMorbidos, $factoresEstresantes, $existeEstresLaboral, $evaluacionEspecifica, $anamnesis, $examenMental, $tratamientoActual, $opinionTratamiento, $comentarios, $diagnosticoLicenciaMedica, $opinionSobreDiagnostico, $comentariosDLM, $eje1, $eje2, $eje3, $eje4, $eje5, $diasAcumulados, $fechaInicioUL, $diasReposoIndicados, $correspondeReposo, $periodo, $diasPeriodo, $comentarios2,$ttoRedGes,$lugarRedGes,$enfermedadlaboral, $conectar)
{
	$sql = "
	INSERT INTO
		informe_entrevista
		    (paciente, prestador, hora, fecha, ocupacion, sexo, edad, medicoTratante, nombreMedicoTratante, numeroLicencia, antecedentesPersonales, antecedentesMorbidos, factoresEstresantes, anamnesis, examenMental, tratamientoActual, opinionTratamiento, comentarios, diagnosticoLicenciaMedica, opinionSobreDiagnostico, comentariosDLM, eje1, eje2, eje3, eje4, eje5, diasAcumulados, fechaInicioUL, diasReposoIndicados, correspondeReposo, periodo, diasPeriodo,  comentarios2,ttoRedGes,lugarRedGes,enfermedadlaboral)
	VALUES
		('$idPaciente', '$idPrestador', '$hora', '$fecha', '$ocupacion', '$sexo', '$edad', '$medicoTratante', '$nombreMedicoTratante', '$numeroLicencia', '$antecedentesPersonales', '$antecedentesMorbidos', '$factoresEstresantes', '$anamnesis', '$examenMental', '$tratamientoActual', '$opinionTratamiento', '$comentarios', '$diagnosticoLicenciaMedica', '$opinionSobreDiagnostico', '$comentariosDLM', '$eje1', '$eje2', '$eje3', '$eje4', '$eje5', '$diasAcumulados', '$fechaInicioUL', '$diasReposoIndicados', '$correspondeReposo', '$periodo', '$diasPeriodo', '$comentarios2','$ttoRedGes','$lugarRedGes','$enfermedadlaboral')
	";
   
    $result=mysql_query($sql,$conectar);

	if (!$result) {
		die('Invalid query: ' . mysql_error());
		return 0 ;
	}else{
		return 1 ;
	}
}
         
function editarInformeEntrevistaNuevo($id, $idPaciente, $idPrestador, $hora, $fecha, $ocupacion, $sexo, $edad,$medicoTratante, $nombreMedicoTratante, $numeroLicencia, $antecedentesPersonales, $antecedentesMorbidos, $factoresEstresantes, $anamnesis, $examenMental, $tratamientoActual, $opinionTratamiento, $comentarios, $diagnosticoLicenciaMedica, $opinionSobreDiagnostico, $comentariosDLM, $eje1, $eje2, $eje3, $eje4, $eje5, $diasAcumulados, $fechaInicioUL, $diasReposoIndicados, $correspondeReposo, $periodo, $diasPeriodo,$comentarios2,$ttoRedGes,$lugarRedGes,$enfermedadlaboral, $conectar)
{
	$confirmado = 0;
	$sql ="
	UPDATE
		informe_entrevista
	SET
		confirmado=".$confirmado.",
		paciente='$idPaciente', 
		prestador='$idPrestador', 
		hora='$hora', 
		fecha='$fecha', 
		ocupacion='$ocupacion', 
		sexo='$sexo',
		edad='$edad', 
		medicoTratante='$medicoTratante', 
		nombreMedicoTratante='$nombreMedicoTratante', 
		numeroLicencia='$numeroLicencia', 
		antecedentesPersonales='$antecedentesPersonales', 
		antecedentesMorbidos='$antecedentesMorbidos', 
		factoresEstresantes='$factoresEstresantes', 
		anamnesis='$anamnesis',
		examenMental='$examenMental', 
		tratamientoActual='$tratamientoActual', 
		opinionTratamiento='$opinionTratamiento', 
		comentarios='$comentarios', 
		diagnosticoLicenciaMedica='$diagnosticoLicenciaMedica',
		opinionSobreDiagnostico='$opinionSobreDiagnostico', 
		comentariosDLM='$comentariosDLM', 
		eje1='$eje1', 
		eje2='$eje2', 
		eje3='$eje3', 
		eje4='$eje4', 
		eje5='$eje5', 
		diasAcumulados='$diasAcumulados', 
		fechaInicioUL='$fechaInicioUL', 
		diasReposoIndicados='$diasReposoIndicados', 
		correspondeReposo='$correspondeReposo', 
		periodo='$periodo', 
		diasPeriodo=0, 
		comentarios2='$comentarios2',
		ttoRedGes='".$ttoRedGes."',
		lugarRedGes= '$lugarRedGes',
		enfermedadlaboral='$enfermedadlaboral'
	WHERE id='$id' ";
	//echo $sql ;
     $result =mysql_query($sql,$conectar);
	
    if (!$result) {
        //die('Invalid query: ' . mysql_error());
	    return 0 ;
    }else{
	    return 1 ;
    }
}
/////////////////////////////////////NUEVO 2009-07-14/////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
function crearInformeEntrevista($idPaciente, $idPrestador, $hora, $fecha, $ocupacion, $sexo, $edad, $tiempoLicencia, $medicoTratante, $nombreMedicoTratante, $antecedentesPersonales, $antecedentesMorbidos, $factoresEstresantes, $existeEstresLaboral, $anamnesis, $examenMental, $tratamientoActual, $opinionTratamiento, $comentarios, $diagnosticoLicenciaMedica, $opinionSobreDiagnostico, $eje1, $eje2, $eje3, $eje4, $eje5, $opinionReposoMedico, $siReposoCorresponde, $cuantosDiasReposo, $comentarios2,$ttoRedGes,$lugarRedGes,$enfermedadlaboral, $conectar)
{
	$sql = mysql_query("
	INSERT INTO
		informe_entrevista
		(paciente, prestador, hora, fecha, ocupacion, sexo, edad, tiempoLicencia, medicoTratante, nombreMedicoTratante, antecedentesPersonales, antecedentesMorbidos, factoresEstresantes, existeEstresLaboral, anamnesis, examenMental, tratamientoActual, opinionTratamiento, comentarios, diagnosticoLicenciaMedica, opinionSobreDiagnostico, eje1, eje2, eje3, eje4, eje5, opinionReposoMedico, siReposoCorresponde, cuantosDiasReposo, comentarios2,$ttoRedGes,$lugarRedGes,enfermedadlaboral)
	VALUES
		('$idPaciente', '$idPrestador', '$hora', '$fecha', '$ocupacion', '$sexo', '$edad', '$tiempoLicencia', '$medicoTratante', '$nombreMedicoTratante', '$antecedentesPersonales', '$antecedentesMorbidos', '$factoresEstresantes', '$existeEstresLaboral', '$anamnesis', '$examenMental', '$tratamientoActual', '$opinionTratamiento', '$comentarios', '$diagnosticoLicenciaMedica', '$opinionSobreDiagnostico', '$eje1', '$eje2', '$eje3', '$eje4', '$eje5', '$opinionReposoMedico', '$siReposoCorresponde', '$cuantosDiasReposo', '$comentarios2','$ttoRedGes','$lugarRedGes','$enfermedadlaboral')
	",$conectar);
	var_dump($sql);
	if(!$sql)
	{
		die('No se ingres&oacute; el informe'.mysql_errno());
	}	
}
function editarInformeEntrevista($id, $idPaciente, $idPrestador, $hora, $fecha, $ocupacion, $sexo, $edad, $tiempoLicencia, $medicoTratante, $nombreMedicoTratante, $antecedentesPersonales, $antecedentesMorbidos, $factoresEstresantes, $existeEstresLaboral, $anamnesis, $examenMental, $tratamientoActual, $opinionTratamiento, $comentarios, $diagnosticoLicenciaMedica, $opinionSobreDiagnostico, $eje1, $eje2, $eje3, $eje4, $eje5, $opinionReposoMedico, $siReposoCorresponde, $cuantosDiasReposo, $comentarios2,$enfermedadlaboral,$ttoRedGES,$lugarRedGES,$enfermedadlaboral, $conectar)
{
	
	$sql =mysql_query("
	UPDATE
		informe_entrevista
	SET
		paciente='$idPaciente', 
    	prestador='$idPrestador', 
		hora='$hora', 
		fecha='$fecha', 
		ocupacion='$ocupacion', 
		sexo='$sexo', 
		edad='$edad', 
    	tiempoLicencia='$tiempoLicencia', 
		medicoTratante='$medicoTratante', 
		nombreMedicoTratante='$nombreMedicoTratante', 
		antecedentesPersonales='$antecedentesPersonales', 
		antecedentesMorbidos='$antecedentesMorbidos', 
		factoresEstresantes='$factoresEstresantes', 
		existeEstresLaboral='$existeEstresLaboral', 
		anamnesis='$anamnesis', 
		examenMental='$examenMental', 
		tratamientoActual='$tratamientoActual', 
		opinionTratamiento='$opinionTratamiento', 
		comentarios='$comentarios', 
		diagnosticoLicenciaMedica='$diagnosticoLicenciaMedica', 
		opinionSobreDiagnostico='$opinionSobreDiagnostico', 
		eje1='$eje1', 
		eje2='$eje2', 
		eje3='$eje3', 
		eje4='$eje4', 
		eje5='$eje5', 
		opinionReposoMedico='$opinionReposoMedico', 
		siReposoCorresponde='$siReposoCorresponde', 
		cuantosDiasReposo='$cuantosDiasReposo', 
		comentarios2='$comentarios2',
		ttoRedGES= '$ttoRedGES' ,
		lugarRedGES='$lugarRedGES',
		enfermedadlaboral='$enfermedadlaboral'

	WHERE 	id=$id	",$conectar);
   $x="UPDATE
		informe_entrevista
	SET
		paciente='$idPaciente',
    	prestador='$idPrestador',
		hora='$hora',
		fecha='$fecha',
		ocupacion='$ocupacion',
		sexo='$sexo',
		edad='$edad',
    	tiempoLicencia='$tiempoLicencia',
		medicoTratante='$medicoTratante',
		nombreMedicoTratante='$nombreMedicoTratante',
		antecedentesPersonales='$antecedentesPersonales',
		antecedentesMorbidos='$antecedentesMorbidos',
		factoresEstresantes='$factoresEstresantes',
		existeEstresLaboral='$existeEstresLaboral',
		anamnesis='$anamnesis',
		examenMental='$examenMental',
		tratamientoActual='$tratamientoActual',
		opinionTratamiento='$opinionTratamiento',
		comentarios='$comentarios',
		diagnosticoLicenciaMedica='$diagnosticoLicenciaMedica',
		opinionSobreDiagnostico='$opinionSobreDiagnostico',
		eje1='$eje1',
		eje2='$eje2',
		eje3='$eje3',
		eje4='$eje4',
		eje5='$eje5',
		opinionReposoMedico='$opinionReposoMedico',
		siReposoCorresponde='$siReposoCorresponde',
		cuantosDiasReposo='$cuantosDiasReposo',
		comentarios2='$comentarios2',
		ttoRedGES= '$ttoRedGES' ,
		lugarRedGES='$lugarRedGES',
		enfermedadlaboral='$enfermedadlaboral'

	WHERE 	id=$id";
    var_dump($x);
    if($sql == false)
	{
		die('No se edit&oacute; el informe');
    }	
}
function eliminarInformeEntrevista($id, $conectar)
{
	$sql = mysql_query("
	DELETE FROM
		informe_entrevista
	WHERE
		id=$id
	", $conectar);
	if($sql == false)
	{
		die('No se elimin&oacute; el informe');
	}
}
function siInformesNoConfirmados($conectar){
	$sql = mysql_query("
	SELECT id 
	FROM informe_entrevista
	WHERE confirmado='0'
	and fecha != '0000-00-00'
	ORDER BY fecha ASC", $conectar);
	
	if(mysql_num_rows($sql) != 0){
		while($row = mysql_fetch_array($sql)){
			$array[] = $row["id"];
		}
		
		return $array;
	}
	else{
		return NULL;	
	}
}
function siInformesNoConfirmadosPrestador($prestador, $conectar){
	$sql = mysql_query("
	SELECT id 
	FROM informe_entrevista 
	WHERE 	prestador='".$prestador."' AND confirmado=0
	ORDER BY fecha ASC", $conectar);
	if(mysql_num_rows($sql) != 0){
		while($row = mysql_fetch_array($sql)){
			$array[] = $row["id"];
 	}
	return $array;
	}
	else{
		return NULL;	
	}
	
}
function existeInformeEntrevista($hora, $conectar)
{
	$sql = mysql_query("
	SELECT 
		e.`id` 
	FROM 
		informe_entrevista e
	WHERE 
		e.`hora`=$hora 
	", $conectar);
	if(mysql_num_rows($sql) != 0)
	{
		$row = mysql_fetch_array($sql);
		return $row['id'];
	}
	else
	{
		return false;
	}
}


function existeInformeEntrevista2($hora, $conectar)
{
    $sql = mysql_query("
	SELECT count(*)as numreg
    FROM informe_entrevista e
	WHERE e.`hora`=$hora ", $conectar);
    $row = mysql_fetch_array($sql);

	$numreg =$row['numreg'];

	return $numreg ;
/*
    if($numreg == 0)
    {
        return false ;
    }
    else
    {
        return true;

    }
*/	
}



function idInformeEntrevistaHora($hora, $conectar)
{
	$sql = mysql_query("
	SELECT 
		e.`id` 
	FROM 
		informe_entrevista e
	WHERE
		e.hora=$hora
	", $conectar);
	$row = mysql_fetch_array($sql);
	
	return $row['id'];
}
function sexoEntrevistaHora($idInforme, $conectar)
{
	$sql = mysql_query("
	SELECT 
		e.`sexo` 
	FROM 
		informe_entrevista e
	WHERE
		e.id=$idInforme
	", $conectar);
	$row = mysql_fetch_array($sql);
	
	return $row['sexo'];
}
function edadEntrevistaHora($idInforme, $conectar)
{
	$sql = mysql_query("
	SELECT 
		e.`edad` 
	FROM 
		informe_entrevista e
	WHERE
		e.id=$idInforme
	", $conectar);
	$row = mysql_fetch_array($sql);
	
	return $row['edad'];
}

function numeroLicencia($idInforme, $conectar)
{
    $sql = mysql_query("
	SELECT
		e.`numeroLicencia`
	FROM
		informe_entrevista e
	WHERE
		e.id=$idInforme
	", $conectar);
    $row = mysql_fetch_array($sql);

    return $row['numeroLicencia'];
}

function ocupacionEntrevistaHora($idInforme, $conectar)
{
	$sql = mysql_query("
	SELECT 
		e.`ocupacion` 
	FROM 
		informe_entrevista e
	WHERE
		e.id=$idInforme
	", $conectar);
	$row = mysql_fetch_array($sql);
	
	return $row['ocupacion'];
}


///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
//CREAR INFORME NUEVO
//Crea el informe NUEVO
function crearInformeNuevoEntrevista($idHora, $tipoSalida, $carpetaSalida, $conectar='')
{	
$db = getConnection();
//require 'horas/funciones.php';
	$sqlDatos = "
	SELECT 
		i.`id`, 
		i.`paciente`, 
		`f_html_encode`(`f_ciudadhora`(i.`hora`)) AS ciudad,
		i.`prestador`, 
		i.`hora`,
		DATEDIFF(i.`fecha`, '2011-10-19') AS diferenciaFecha,
		i.`fecha`, 
		i.`ocupacion`, 
		i.`sexo`, 
		i.`edad`, 
		i.`tiempoLicencia`, 
                i.`medicoTratante`, 
		i.`nombreMedicoTratante`, 
		i.`numeroLicencia`, 
		i.`antecedentesPersonales`, 
		i.`antecedentesMorbidos`, 
		i.`factoresEstresantes`, 
		i.`existeEstresLaboral`, 
		i.`evaluacionEspecifica`, 
		i.`anamnesis`, 
		i.`examenMental`, 
		i.`tratamientoActual`, 
		i.`opinionTratamiento`, 
		i.`comentarios`, 
		i.`diagnosticoLicenciaMedica`, 
		i.`opinionSobreDiagnostico`, 
		i.`comentariosDLM`, 
		i.`eje1`, 
		i.`eje2`, 
		i.`eje3`, 
		i.`eje4`, 
		i.`eje5`, 
		i.`diasAcumulados`, 
		i.`fechaInicioUL`, 
		i.`diasReposoIndicados`, 
		i.`correspondeReposo`, 
		i.`periodo`, 
		i.`pronosticoReintegro`, 
		i.`diasPronostico`, 
		i.`comentarios2`,
                i.`ttoRedGES`,
		i.`lugarRedGES`,
		i.`enfermedadlaboral`
	FROM 	informe_entrevista i
	WHERE  i.`hora`=".$idHora;
        
        
        $stmt = $db->prepare($sqlDatos);
        $stmt->execute();
        $rowDatos = $stmt->fetch(PDO::FETCH_ASSOC);
        $hora = $rowDatos['hora'];
        //die('aca');
        if (empty($hora)){
            echo 'Sin Informe';
        }
        $codisapre = isapreHora($hora, $conectar) ;
	$isapre = nombreIsapre(isapreHora($hora, $conectar), $conectar);
	$idPaciente = $rowDatos['paciente'];
	$idPrestador = $rowDatos['prestador'];
	$diferenciaFecha = $rowDatos['diferenciaFecha'];
	$fecha = fechaFormateadaHora($hora, $conectar);
	$ocupacion = $rowDatos['ocupacion'];
	$sexo = $rowDatos['sexo'];
	$edad = $rowDatos['edad'];
	$tiempoLicencia = $rowDatos['tiempoLicencia'];
	$medicoTratante = utf8_decode(caracteres_html_inversa($rowDatos['medicoTratante']));
	$nombreMedicoTratante = utf8_decode(caracteres_html_inversa($rowDatos['nombreMedicoTratante']));
	$numeroLicencia = $rowDatos['numeroLicencia'];
	$antecedentesPersonales = caracteres_html_inversa($rowDatos['antecedentesPersonales']);
	$antecedentesMorbidos = caracteres_html_inversa($rowDatos['antecedentesMorbidos']);
	$factoresEstresantes = caracteres_html_inversa($rowDatos['factoresEstresantes']);
	$anamnesis = caracteres_html_inversa($rowDatos['anamnesis']);
	$examenMental = caracteres_html_inversa($rowDatos['examenMental']);
	$tratamientoActual = caracteres_html_inversa($rowDatos['tratamientoActual']);
	$opinionTratamiento = caracteres_html_inversa($rowDatos['opinionTratamiento']);
	$comentarios = caracteres_html_inversa($rowDatos['comentarios']);
	$diagnosticoLicenciaMedica = caracteres_html_inversa($rowDatos['diagnosticoLicenciaMedica']);
	$opinionSobreDiagnostico = caracteres_html_inversa($rowDatos['opinionSobreDiagnostico']);
	$comentariosDLM = caracteres_html_inversa($rowDatos['comentariosDLM']);
	$eje1 = caracteres_html_inversa($rowDatos['eje1']);
	$eje2 = caracteres_html_inversa($rowDatos['eje2']);
	$eje3 = caracteres_html_inversa($rowDatos['eje3']);
	$eje4 = caracteres_html_inversa($rowDatos['eje4']);
	$eje5 = caracteres_html_inversa($rowDatos['eje5']);
        $ttoRedGES = $rowDatos['ttoRedGES'];
	$lugarRedGES = $rowDatos['lugarRedGES'] ;
        
        
	$diasAcumulados = $rowDatos['diasAcumulados'];
	if($diasAcumulados == 0)
	{
		$diasAcumulados = 'No se dispone de esta información';
	}
	$fechaInicioUL = VueltaFecha($rowDatos['fechaInicioUL']);
	if($fechaInicioUL == '00-00-0000')
	{
		$fechaInicioUL = "No se dispone de esta información";
	}
	$diasReposoIndicados = $rowDatos['diasReposoIndicados'];
	if($diasReposoIndicados == 0)
	{
		$diasReposoIndicados = 'No se dispone de esta información';
	}
	$correspondeReposo = $rowDatos['correspondeReposo'];
	if($correspondeReposo == 'SI')
	{
		$periodo = $rowDatos['periodo'];
		if($periodo == 'COMPLETO')
		{
			$fraseCorrespondeReposo = 'SI, POR UN PER�?ODO COMPLETO';
		}
		else
		{
			$fraseCorrespondeReposo = 'SI, POR UN PER�?ODO REDUCIDO';
		}
	}
	if($correspondeReposo == 'NO'){
		$fraseCorrespondeReposo = 'NO';
	}
	if($correspondeReposo == ''){
		$fraseCorrespondeReposo = '';
	}
		

	
	//REINTEGRO
	$pronosticoReintegro = $rowDatos['pronosticoReintegro'];
	if($pronosticoReintegro != '')
	{
		if($pronosticoReintegro == 'CON UN TRATAMIENTO ADECUADO PACIENTE EN CONDICIONES DE REINTEGRARSE EN [ ] DIAS A SU ACTIVIDAD LABORAL')
		{
			$diasPronostico = $rowDatos['diasPronostico'];
			$fraseReintegro = 'CON UN TRATAMIENTO ADECUADO PACIENTE EN CONDICIONES DE REINTEGRARSE EN '.$diasPronostico.' DIAS A SU ACTIVIDAD LABORAL';
		}
		else
		{
			$fraseReintegro = $pronosticoReintegro;
		}
	}
	$comentarios2 = caracteres_html_inversa($rowDatos['comentarios2']);
	$enfermedadlaboral=$rowDatos['enfermedadlaboral'] ;
	$nombreCompletoPaciente = caracteres_html_inversa(nombreCompletoPaciente($idPaciente, $conectar));
	$rutPaciente = rutPaciente($idPaciente, $conectar);
	$dvPaciente = DigitoVerificador($rutPaciente);
	$rutPaciente = PonerPunto($rutPaciente).'-'.$dvPaciente;
	$direccion = direccionPaciente($idPaciente, $conectar);
	$comuna = caracteres_html_inversa(retornaComuna(idComunaPaciente($idPaciente, $conectar), $conectar));
        $ciudad = strtoupper($rowDatos['ciudad']);
        $nombreCompletoPrestador = caracteres_html_inversa(nombreCompletoPrestador ($idPrestador, $conectar));
	$rutPrestador = rutPrestador ($idPrestador, $conectar);
	$dvPrestador = DigitoVerificador($rutPrestador);
	$rutPrestador = PonerPunto($rutPrestador).'-'.$dvPrestador;
       
///////////////////////////////////////////////////////////////////////////////
//PDF
	class PDF extends FPDF
	{		
		//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-20);
			//Arial italic 8
			$this->SetFont('Arial','',5);
			//Número de página
			$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
			$this->Ln(8);
			$this->MultiCell(0,5,utf8_decode('Copyright © 2010 Cetep, Centro de Estudio y Tratamiento de Enfermedades Psiquiátricas Ltda. Prohibida la reproducción total o parcial, sin autorización escrita de Cetep. Para ordenar copias o solicitar permiso de reproducción, por favor contáctese por teléfono (56-2) 7840831, por e-mail: contacto@cetep.cl, o bien escriba a Soria 626, Las Condes, Santiago - Chile.'), 1);
//			$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
//			$this->Ln(15);
//			$this->Cell(0,10,'Página hola',0,0,'C');
		}
	}
	//Creación del objeto de la clase heredada
	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	//$pdf->Image('../../templates/defecto/imagenes/fondodocumento.png', 0, 0, $pdf->w, $pdf->h);

	$pdf->Image("informes/templates/defecto/imagenes/logoDocumentos.jpg",15,8,28);
	$pdf->Ln();

	$pdf->SetFont('Arial','B',12);
	//Movernos a la derecha
	$pdf->Cell(80);
	$pdf->Cell(160,10,'Peritaje Realizado en '.ucfirst(strtolower($ciudad)),0,0,'C');
	$pdf->Ln(15);
	//Título
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(80);
	$pdf->Cell(30,10,utf8_decode('Informe de Entrevista Psiquiátrica de Peritaje'),0,0,'C');
	$pdf->Ln(10);
	//////////////
	//Datos paciente
     $pdf->SetFont('Arial','B',10);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Fecha: ',0,0,'L');
	$pdf->Cell(10,10,VueltaFecha($fecha),0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Nombre: ',0,0,'L');
	$pdf->Cell(10,10,$nombreCompletoPaciente,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'RUT: ',0,0,'L');
	$pdf->Cell(10,10,$rutPaciente,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Seguro de salud: ',0,0,'L');
	$pdf->Cell(10,10,$isapre,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,utf8_decode('Ocupación: '),0,0,'L');
	$pdf->Cell(10,10,ucfirst(strtolower($ocupacion)),0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Sexo: ',0,0,'L');
	$pdf->Cell(10,10,$sexo,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Edad: ',0,0,'L');
	$pdf->Cell(10,10,$edad,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,utf8_decode('Dirección: '),0,0,'L');
	$pdf->Cell(10,10,$direccion,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Comuna: ',0,0,'L');
	$pdf->Cell(10,10,ucwords(strtolower($comuna)),0,0,'L');
	//Si es región no se muestra la ciudad
	//
/*	if(siEsRegion(ciudadHora($hora, $conectar), $conectar) == 'no')
	{
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'Ciudad: ',0,0,'L');
		$pdf->Cell(10,10,ucfirst(strtolower($ciudad)),0,0,'L');
	}*/	
	//
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,utf8_decode('Médico tratante: '),0,0,'L');
	$pdf->Cell(10,10,ucfirst(strtolower($medicoTratante)),0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'N. Med. tratante: ',0,0,'L');
	$pdf->Cell(10,10,$nombreMedicoTratante,0,0,'L');
	if($numeroLicencia != 0)
	{
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'N. Licencia: ',0,0,'L');
		$pdf->Cell(10,10,$numeroLicencia,0,0,'L');
	}
	
	//Datos paciente
	//////////////
	//////////////
	//Firma
	
if ($fecha >= '2014-08-15' )
{
	//reeemplazo supervisor

		$nombreImagen = $idPrestador.'.jpg';
	//	$nombreImagen = $idPrestador.'.png';

	if(file_exists('informes/templates/defecto/imagenes/firmas/'.$nombreImagen) == true)
	{
		//redimensionar_jpeg('../../templates/defecto/imagenes/firmas/'.$nombreImagen, '../../templates/defecto/imagenes/firmas/'.$nombreImagen, 250, 120, 100);

			$pdf->Image("informes/templates/defecto/imagenes/firmas/$nombreImagen", 0, 100, 0);

	}
	else
	{
		$pdf->Ln(40);
	}

	$pdf->Ln(50);
	$pdf->Image("informes/templates/defecto/imagenes/lineaFirma.gif",10, 140, 0);

	//Cambio de firma a Dra. Ortiz

		$supervisor = 'logocertificado'; //Dra Muñoz
		$nombreSupervisor = 'Comité Revisor Cetep';

	/*if($diferenciaFecha >= 0)
	{

		$supervisor = 32; //Dra Ortiz
		$nombreSupervisor = 'Dra. Vilma Ortiz';
	}
	else
	{
		$supervisor = 10;
		$nombreSupervisor = 'Dr. Juan Pablo Osorio';
	}*/

	//Si NO es Osorio muestro la firma
	if($idPrestador != $supervisor)
	{
		$pdf->Image("informes/templates/defecto/imagenes/".$supervisor.".jpg", 130, 100, 32);
		$pdf->Image("informes/templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
	}
	$pdf->Ln(1);
	$pdf->Cell(5);
	$pdf->SetFont('Arial','',10);
	//Si NO es Osorio muestro la firma
	if($idPrestador != $supervisor)
	{
		$pdf->Image("informes/templates/defecto/imagenes/".$supervisor.".jpg", 130, 100, 32);
		$pdf->Image("informes/templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
	}
	$pdf->Ln(1);
	$pdf->Cell(5);
	$pdf->SetFont('Arial','',10);
	
	if($idPrestador != $supervisor)
	{
		$pdf->Cell(5,5,'Dr(a). '.$nombreCompletoPrestador.'                                                                      '.utf8_decode($nombreSupervisor),0,0,"L");
	}
	else
	{
		$pdf->Ln(4);
		$pdf->Cell(5);
		$pdf->Cell(5,5,'Dr(a). '.$nombreCompletoPrestador.'',0,0,"L");
		$pdf->Ln(4);
		$pdf->Cell(5);
		$pdf->Cell(5,5,utf8_decode('Médico Psiquiátra'),0,0,"L");
	}
	$pdf->Ln(3);
	$pdf->Cell(5);
	if($idPrestador != $supervisor)
	{	
		$pdf->Cell(5,5,utf8_decode('Médico Psiquiátra                                                                                 '),0,0,"L");
	}
	
	//Firma
	//////////////
	
	//fin reemplazo vacaciones	
     }
		else
   	{	
	
	$nombreImagen = $idPrestador.'.jpg';
	
	if(file_exists('informes/templates/defecto/imagenes/firmas/'.$nombreImagen) == true)
	{
		//redimensionar_jpeg('../../templates/defecto/imagenes/firmas/'.$nombreImagen, '../../templates/defecto/imagenes/firmas/'.$nombreImagen, 250, 120, 100);
		$pdf->Image("informes/templates/defecto/imagenes/firmas/$nombreImagen", 0, 100, 0);
		
	}
	else
	{
		$pdf->Ln(40);
	}
	
	$pdf->Ln(50);
	$pdf->Image("informes/templates/defecto/imagenes/lineaFirma.gif",10, 140, 0);
	
	//Cambio de firma a Dra. Ortiz
	if($diferenciaFecha >= 0)
	{
		
		$supervisor = 32; //Dra Ortiz
		$nombreSupervisor = 'Dra. Vilma Ortiz';
	}
	else
	{
		$supervisor = 10;	
		$nombreSupervisor = 'Dr. Juan Pablo Osorio';
	}
	
	//Si NO es Osorio muestro la firma
	if($idPrestador != $supervisor)
	{
		$pdf->Image("informes/templates/defecto/imagenes/firmas/".$supervisor.".jpg", 110, 98, 0);
		$pdf->Image("informes/templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
	}
	$pdf->Ln(1);
	$pdf->Cell(5);
	$pdf->SetFont('Arial','',10);
	//Si NO es Osorio muestro la firma
	if($idPrestador != $supervisor)
	{
		$pdf->Image("informes/templates/defecto/imagenes/firmas/".$supervisor.".jpg", 110, 98, 0);
		$pdf->Image("informes/templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
	}
	$pdf->Ln(1);
	$pdf->Cell(5);
	$pdf->SetFont('Arial','',10);
	
	if($idPrestador != $supervisor)
	{
		$pdf->Cell(5,5,'Dr(a). '.$nombreCompletoPrestador.'                                                                              '.$nombreSupervisor,0,0,"L");
	}
	else
	{
		$pdf->Ln(4);
		$pdf->Cell(5);
		$pdf->Cell(5,5,'Dr(a). '.$nombreCompletoPrestador.'',0,0,"L");
		$pdf->Ln(4);
		$pdf->Cell(5);
		$pdf->Cell(5,5,utf8_decode('Médico Psiquiátra'),0,0,"L");
	}
	$pdf->Ln(3);
	$pdf->Cell(5);
	if($idPrestador != $supervisor)
	{	
		$pdf->Cell(5,5,utf8_decode('Médico Psiquiátra                                                                                 Supervisor Técnico de Peritajes'),0,0,"L");
	}
	
	//Firma
	//////////////
	} //fin firma y reemplazo
	//////////////
	//Informe
	$pdf->Ln(10);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,'HISTORIA CLINICA',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Antecedentes Personales',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($antecedentesPersonales));
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Antecedentes Mórbidos (incluye antecedentes psiquiátricos)'),0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($antecedentesMorbidos));
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Factores estresantes',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($factoresEstresantes));
		
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Anamnesis',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($anamnesis));
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Exámen Mental'),0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($examenMental));
	$pdf->Ln(2);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,'TRATAMIENTO ACTUAL',0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Tratamiento Actual (detallar fármacos y dosis)'),0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($tratamientoActual));
	$pdf->Ln(3);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Paciente Refiere Tratamiento en red GES');
	$pdf->Ln(7);
        $pdf->SetFont('Arial','',10);
        $pdf->MultiCell(0,5,$ttoRedGES);
	    if ($ttoRedGES == 'si') {

    $pdf->Ln(3);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Lugar Tratamiento');
	$pdf->Ln(7);
        $pdf->SetFont('Arial','',10);
        $pdf->MultiCell(0,5,$lugarRedGES);
		}
        $pdf->Ln(5);
		
        $pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Opinión Sobre Tratamiento Actual'),0,0,'L');
	$pdf->Ln(4);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode(ucfirst(strtolower($opinionTratamiento))));
	if($comentarios != '')//Si hay comentarios, los agrego al final
	{
		$pdf->MultiCell(0,5,utf8_decode($comentarios));
	}
	$pdf->Ln(2);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,utf8_decode('DIAGNÓSTICO DE LICENCIA MÉDICA  N° ').$numeroLicencia,0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Diagnóstico de Licencia Médica  N° ').$numeroLicencia,0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($diagnosticoLicenciaMedica));
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Opinión Sobre el Diagnóstico de la Licencia Médica N° ').$numeroLicencia,0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode(ucfirst(strtolower($opinionSobreDiagnostico))));
	if($comentariosDLM != '')//Si hay comentarios, los agrego al final
	{
		$pdf->MultiCell(0,5,utf8_decode($comentariosDLM));
	}
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,utf8_decode('HIPÓTESIS DIAGNÓSTICA'),0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Eje I',0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($eje1));
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'Eje II',0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($eje2));
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'Eje III',0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($eje3));
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'Eje IV',0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($eje4));
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'Eje V',0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($eje5));
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,utf8_decode('CONCLUSIÓN SOBRE REPOSO MÉDICO'),0,0,'L');
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Días acumulados de reposo a la fecha de hoy día (incluye licencia médica N° ').$numeroLicencia.')',0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$diasAcumulados);
	
	
	// si es paciente de cruz blanca no mostrar estos campos
    //fecha de inicio
    //dias de reposo indicados
    //corresponde reposo
    //solicitado por dra. Mgalvez 08/10/2014

    if ($codisapre != 3  ){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Fecha de inicio de licencia N° ').$numeroLicencia,0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$fechaInicioUL);
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Días de reposo indicados en licencia N° ').$numeroLicencia,0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$diasReposoIndicados);
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Respecto a licencia  N° ').$numeroLicencia.utf8_decode(', corresponde reposo'),0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode(ucfirst(strtolower($fraseCorrespondeReposo))));
	/// fin
    }

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Conclusión respecto del reintegro laboral al examen actual del paciente'),0,0,'L');
	if($pronosticoReintegro != '')
	{
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($fraseReintegro));
	}
	else
	{
		$pdf->Ln(5);
	}
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($comentarios2));
	// sacar para cruz blanca , no hay informacion de cuando se habilita para el resto
        if ($codisapre != 3  ){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Enfermedad Laboral'),0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$enfermedadlaboral);
	}
	
	
	//Informe
	//////////////
	
	
	if($tipoSalida == 'I')
	{
		$pdf->Output(str_replace(' ', '_', elimina_acentos($nombreCompletoPaciente)).'.pdf', 'I');
	}
	elseif($tipoSalida == 'F')
	{
        $rutsinformato=	(int)rutPaciente($idPaciente, $conectar);
        $digito = (string)DigitoVerificador($rutsinformato);
        $separador='_';
        $archivo = $rutsinformato.'-'.$digito.$hora.'.pdf' ;
        $carpeta ='informes/informes/';
        //$ruta= ($_SERVER['DOCUMENT_ROOT'].$carpeta);
        $url = $_SERVER["REQUEST_URI"];
        $url = explode("/", $url)[1];
        $ruta= ($_SERVER['HTTP_HOST'].'/'.$url.'/'.$carpeta);
        //$ruta= ($_SERVER['DOCUMENT_ROOT'].$carpeta);
		//echo $carpeta.$archivo;
        //$pdf->Output('$ruta.$archivo', 'F');
        $filepdf=$ruta.$archivo.'.pdf' ;
		$pdf->Output('informes/informes/'.$archivo.'.pdf', 'F');
	    return $filepdf ;
    }
	elseif($tipoSalida == 'D')
	{
        $rutsinformato=	(int)rutPaciente($idPaciente, $conectar);
        $digito = (string)DigitoVerificador($rutsinformato);
        $separador='_';
        $archivo = $nombreCompletoPaciente.'-'.$rutsinformato.'-'.$digito ;
        $carpeta ='informes/informes/';
        $ruta= ($_SERVER['DOCUMENT_ROOT'].$carpeta);
		//echo $carpeta.$archivo;
        //$pdf->Output('$ruta.$archivo', 'F');
        $filepdf=$ruta.$archivo ;
		$pdf->Output('Informe_'.$archivo.'.pdf', 'D');
	    return $filepdf ;
    }
	
	
	
	
	
}
// Fin CREAR INFORME NUEVO
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
//CREAR INFORME ANTIGUO
function crearInformeAntiguo($idHora, $tipoSalida, $carpetaSalida, $conectar)
{	
	$sqlDatos ="
	SELECT 
		i.`id`, 
		i.`paciente`, 
		i.`prestador`, 
		i.`hora`, 
		i.`fecha`, 
		i.`ocupacion`, 
		i.`sexo`, 
		i.`edad`, 
		i.`tiempoLicencia`, 
		i.`medicoTratante`, 
		i.`nombreMedicoTratante`, 
		i.`antecedentesPersonales`, 
		i.`antecedentesMorbidos`, 
		i.`factoresEstresantes`, 
		i.`existeEstresLaboral`, 
		i.`anamnesis`, 
		i.`examenMental`, 
		i.`tratamientoActual`, 
		i.`opinionTratamiento`, 
		i.`comentarios`, 
		i.`diagnosticoLicenciaMedica`, 
		i.`opinionSobreDiagnostico`, 
		i.`eje1`, 
		i.`eje2`, 
		i.`eje3`, 
		i.`eje4`, 
		i.`eje5`, 
		i.`opinionReposoMedico`, 
		i.`siReposoCorresponde`, 
		i.`cuantosDiasReposo`, 
		i.`comentarios2` ,
		i.`enfermedadlaboral` 
	FROM 
		informe_entrevista i
	WHERE 
		i.`hora`=".$idHora."
	";
	//echo $sqlDatos ;
	$result=mysql_query($sqlDatos,$conectar);
	$rowDatos = mysql_fetch_array($result);
	
	$hora = $rowDatos['hora'];
	
	$isapre = nombreIsapre(isapreHora($hora, $conectar), $conectar);
	
	$idPaciente = $rowDatos['paciente'];
	$idPrestador = $rowDatos['prestador'];
	$fecha = fechaFormateadaHora($hora, $conectar);
	$ocupacion = $rowDatos['ocupacion'];
	$sexo = $rowDatos['sexo'];
	$edad = $rowDatos['edad'];
	$tiempoLicencia = $rowDatos['tiempoLicencia'];
	$medicoTratante = utf8_decode(caracteres_html_inversa($rowDatos['medicoTratante']));
	$nombreMedicoTratante = utf8_decode(caracteres_html_inversa($rowDatos['nombreMedicoTratante']));
	$antecedentesPersonales = utf8_decode(caracteres_html_inversa($rowDatos['antecedentesPersonales']));
	$antecedentesMorbidos = utf8_decode(caracteres_html_inversa($rowDatos['antecedentesMorbidos']));
	$factoresEstresantes = utf8_decode(caracteres_html_inversa($rowDatos['factoresEstresantes']));
	$existeEstresLaboral = utf8_decode(caracteres_html_inversa($rowDatos['existeEstresLaboral']));
	$anamnesis = utf8_decode(caracteres_html_inversa($rowDatos['anamnesis']));
	$examenMental = utf8_decode(caracteres_html_inversa($rowDatos['examenMental']));
	$tratamientoActual = utf8_decode(caracteres_html_inversa($rowDatos['tratamientoActual']));
	$opinionTratamiento = utf8_decode(caracteres_html_inversa($rowDatos['opinionTratamiento']));
	$comentarios = utf8_decode(caracteres_html_inversa($rowDatos['comentarios']));
	$diagnosticoLicenciaMedica = utf8_decode(caracteres_html_inversa($rowDatos['diagnosticoLicenciaMedica']));
	$opinionSobreDiagnostico = utf8_decode(caracteres_html_inversa($rowDatos['opinionSobreDiagnostico']));
	$eje1 = utf8_decode(caracteres_html_inversa($rowDatos['eje1']));
	$eje2 = utf8_decode(caracteres_html_inversa($rowDatos['eje2']));
	$eje3 = utf8_decode(caracteres_html_inversa($rowDatos['eje3']));
	$eje4 = utf8_decode(caracteres_html_inversa($rowDatos['eje4']));
	$eje5 = utf8_decode(caracteres_html_inversa($rowDatos['eje5']));
	$opinionReposoMedico = utf8_decode(caracteres_html_inversa($rowDatos['opinionReposoMedico']));
	$siReposoCorresponde = utf8_decode(caracteres_html_inversa($rowDatos['siReposoCorresponde']));
	$cuantosDiasReposo = utf8_decode(caracteres_html_inversa($rowDatos['cuantosDiasReposo']));
	$comentarios2 = utf8_decode(caracteres_html_inversa($rowDatos['comentarios2']));
	$enfermedadlaboral = utf8_decode(caracteres_html_inversa($rowDatos['enfermedadlaboral']));
	$nombreCompletoPaciente = caracteres_html_inversa(nombreCompletoPaciente($idPaciente, $conectar));
	$rutPaciente = rutPaciente($idPaciente, $conectar);
	$dvPaciente = DigitoVerificador($rutPaciente);
	$rutPaciente = PonerPunto($rutPaciente).'-'.$dvPaciente;
	$direccion = direccionPaciente($idPaciente, $conectar);
	$comuna = retornaComuna(idComunaPaciente($idPaciente, $conectar), $conectar);
	$ciudad = strtoupper(nombreCiudad(ciudadHora($hora, $conectar), $conectar));
	
	$nombreCompletoPrestador = caracteres_html_inversa(nombreCompletoPrestador ($idPrestador, $conectar));
	$rutPrestador = rutPrestador ($idPrestador, $conectar);
	$dvPrestador = DigitoVerificador($rutPrestador);
	$rutPrestador = PonerPunto($rutPrestador).'-'.$dvPrestador;
	
	///////////////////////////////////////////////////////////////////////////////
	//PDF
	
	//Creación del objeto de la clase heredada
	$pdf=new FPDF();
	$pdf->AddPage();
	
	$pdf->Image("../../templates/defecto/imagenes/logoDocumentos.jpg",20,8,20);
	$pdf->SetFont('Arial','B',12);
	//Movernos a la derecha
	$pdf->Cell(80);
	
	$pdf->Cell(160,10,ucfirst(strtolower($ciudad)),0,0,'C');
	$pdf->Ln(20);
	
	//Título
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(80);
	$pdf->Cell(30,10,'Informe de Entrevista Psiquiátrica de Peritaje',0,0,'C');
	$pdf->Ln(20);
	
	//////////////
	//Datos paciente
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(80);
	$pdf->Cell(10,10,'FECHA: ',0,0,'R');
	$pdf->Cell(40,10,VueltaFecha($fecha),0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80);
	$pdf->Cell(10,10,'NOMBRE: ',0,0,'R');
	$pdf->Cell(40,10,$nombreCompletoPaciente,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80);
	$pdf->Cell(10,10,'RUT: ',0,0,'R');
	$pdf->Cell(40,10,$rutPaciente,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80);
	$pdf->Cell(10,10,'SEGURO DE SALUD: ',0,0,'R');
	$pdf->Cell(40,10,$isapre,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80);
	$pdf->Cell(10,10,'OCUPACIÓN: ',0,0,'R');
	$pdf->Cell(40,10,ucfirst(strtolower($ocupacion)),0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80);
	$pdf->Cell(10,10,'SEXO: ',0,0,'R');
	$pdf->Cell(40,10,$sexo,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80);
	$pdf->Cell(10,10,'EDAD: ',0,0,'R');
	$pdf->Cell(40,10,$edad,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80);
	$pdf->Cell(10,10,'DIRECCIÓN: ',0,0,'R');
	$pdf->Cell(40,10,$direccion,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80);
	$pdf->Cell(10,10,'COMUNA: ',0,0,'R');
	$pdf->Cell(40,10,ucwords(strtolower($comuna)),0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80);
	$pdf->Cell(10,10,'CIUDAD: ',0,0,'R');
	$pdf->Cell(40,10,ucfirst(strtolower($ciudad)),0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80);
	$pdf->Cell(10,10,'TIEMPO DE LICENCIA: ',0,0,'R');
	$pdf->Cell(40,10,$tiempoLicencia,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80);
	$pdf->Cell(10,10,'MÉDICO TRATANTE: ',0,0,'R');
	$pdf->Cell(40,10,ucfirst(strtolower($medicoTratante)),0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80);
	$pdf->Cell(10,10,'NOMBRE MÉDICO TRATANTE: ',0,0,'R');
	$pdf->Cell(40,10,$nombreMedicoTratante,0,0,'L');
	
	//Datos paciente
	//////////////
	
	//////////////
	//Informe
	$pdf->Ln(15);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Antecedentes Personales',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$antecedentesPersonales);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Antecedentes Mórbidos (incluye antecedentes psiquiátricos)',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$antecedentesMorbidos);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Factores estresantes',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$factoresEstresantes);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'¿Existe algún grado de estrés laboral?',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,ucfirst(strtolower($existeEstresLaboral)));
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Anamnesis',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$anamnesis);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Examen Mental',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$examenMental);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Tratamiento Actual (detallar fármacos y dosis)',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$tratamientoActual);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Opinión Sobre Tratamiento Actual',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,ucfirst(strtolower($opinionTratamiento)));
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Comentario Sobre Tratamiento Actual',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$comentarios);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Diagnóstico de Licencia Médica',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$diagnosticoLicenciaMedica);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Opinión Sobre el Diagnóstico de la Licencia Médica',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,ucfirst(strtolower($opinionSobreDiagnostico)));
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,'HIPÓTESIS DIAGNÓSTICA',0,0,'L');
	
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Eje I',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$eje1);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Eje II',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$eje2);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Eje III',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$eje3);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Eje IV',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$eje4);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Eje V',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$eje5);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Opinión Sobre el Reposo Médico',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,ucfirst(strtolower($opinionReposoMedico)));
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Si el Reposo Corresponde, Especifique',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,ucfirst(strtolower($siReposoCorresponde)));
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Cuántos Días de Reposo Corresponden a Partir de Esta Fecha',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$cuantosDiasReposo);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Comentario Sobre el Reposo',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$comentarios2);
	
	//$pdf->Ln(5);
	//$pdf->SetFont('Arial','B',12);
	//$pdf->Cell(0,10,'Enfermedad Laboral',0,0,'L');
	//$pdf->Ln(8);
	//$pdf->SetFont('Arial','',10);
	//$pdf->MultiCell(0,5,$enfermedadlaboral);
	
	
	//Informe
	//////////////
	
	//////////////
	//Firma
	
	$nombreImagen = $idPrestador.'.jpg';
	
	$pdf->Ln(50);
	$pdf->Cell(60);
	$pdf->Cell(0,0,$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif"));
	$pdf->Ln(1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Dr(a). '.$nombreCompletoPrestador,0,0,'C');
	
	//Firma
	//////////////
	
	$carpeta='';
    $destino='';
	if($tipoSalida == 'I')
	{

		$pdf->Output(str_replace(' ', '_', elimina_acentos($nombreCompletoPaciente)));
		
	}
	elseif($tipoSalida == 'F')
	{
		$carpetaSalida = NULL;
		$dir= NULL;
		$dir= ($_SERVER['DOCUMENT_ROOT'].$carpeta.$destino);

		$pdf->Output('../../../informesRespaldo/'.VueltaFecha($fecha).' - '.ucfirst(strtolower($ciudad)).' - '.str_replace(' ', '_', elimina_acentos($nombreCompletoPaciente)).'.pdf', 'F');
	    return $pdf ;
    }
}
//CREAR INFORME ANTIGUO
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

function file_force_contents($dir, $contents){
        file_put_contents("../../../informesRespaldo/", $contents);
    }
//////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//CREAR INFORME BINARIO
///////////////////////////////////////////////////////////
function crearInformePDFCB($idHora, $tipoSalida, $carpetaSalida, $conectar)
{	
	$sqlDatos = mysql_query("
	SELECT 
		i.`id`, 
		i.`paciente`, 
		`f_html_encode`(`f_ciudadhora`(i.`hora`)) AS ciudad,
		i.`prestador`, 
		i.`hora`,
		DATEDIFF(i.`fecha`, '2011-10-19') AS diferenciaFecha,
		i.`fecha`, 
		i.`ocupacion`, 
		i.`sexo`, 
		i.`edad`, 
		i.`tiempoLicencia`, 
    	i.`medicoTratante`, 
		i.`nombreMedicoTratante`, 
		i.`numeroLicencia`, 
		i.`antecedentesPersonales`, 
		i.`antecedentesMorbidos`, 
		i.`factoresEstresantes`, 
		i.`existeEstresLaboral`, 
		i.`evaluacionEspecifica`, 
		i.`anamnesis`, 
		i.`examenMental`, 
		i.`tratamientoActual`, 
		i.`opinionTratamiento`, 
		i.`comentarios`, 
		i.`diagnosticoLicenciaMedica`, 
		i.`opinionSobreDiagnostico`, 
		i.`comentariosDLM`, 
		i.`eje1`, 
		i.`eje2`, 
		i.`eje3`, 
		i.`eje4`, 
		i.`eje5`, 
		i.`diasAcumulados`, 
		i.`fechaInicioUL`, 
		i.`diasReposoIndicados`, 
		i.`correspondeReposo`, 
		i.`periodo`, 
		i.`pronosticoReintegro`, 
		i.`diasPronostico`, 
		i.`comentarios2`,
        i.`ttoRedGES`,
		i.`lugarRedGES`,
		i.`enfermedadlaboral`
	FROM 	informe_entrevista i
	WHERE  i.`hora`=".$idHora." 	", $conectar);
	$rowDatos = mysql_fetch_array($sqlDatos);
	$hora = $rowDatos['hora'];
    $codisapre = isapreHora($hora, $conectar) ;
	$isapre = nombreIsapre(isapreHora($hora, $conectar), $conectar);
	$idPaciente = $rowDatos['paciente'];
	$idPrestador = $rowDatos['prestador'];
	$diferenciaFecha = $rowDatos['diferenciaFecha'];
	$fecha = fechaFormateadaHora($hora, $conectar);
	$ocupacion = $rowDatos['ocupacion'];
	$sexo = $rowDatos['sexo'];
	$edad = $rowDatos['edad'];
	$tiempoLicencia = $rowDatos['tiempoLicencia'];
	$medicoTratante = utf8_decode(caracteres_html_inversa($rowDatos['medicoTratante']));
	$nombreMedicoTratante = utf8_decode(caracteres_html_inversa($rowDatos['nombreMedicoTratante']));
	$numeroLicencia = $rowDatos['numeroLicencia'];
	$antecedentesPersonales = caracteres_html_inversa($rowDatos['antecedentesPersonales']);
	$antecedentesMorbidos = caracteres_html_inversa($rowDatos['antecedentesMorbidos']);
	$factoresEstresantes = caracteres_html_inversa($rowDatos['factoresEstresantes']);
	$anamnesis = caracteres_html_inversa($rowDatos['anamnesis']);
	$examenMental = caracteres_html_inversa($rowDatos['examenMental']);
	$tratamientoActual = caracteres_html_inversa($rowDatos['tratamientoActual']);
	$opinionTratamiento = caracteres_html_inversa($rowDatos['opinionTratamiento']);
	$comentarios = caracteres_html_inversa($rowDatos['comentarios']);
	$diagnosticoLicenciaMedica = caracteres_html_inversa($rowDatos['diagnosticoLicenciaMedica']);
	$opinionSobreDiagnostico = caracteres_html_inversa($rowDatos['opinionSobreDiagnostico']);
	$comentariosDLM = caracteres_html_inversa($rowDatos['comentariosDLM']);
	$eje1 = caracteres_html_inversa($rowDatos['eje1']);
	$eje2 = caracteres_html_inversa($rowDatos['eje2']);
	$eje3 = caracteres_html_inversa($rowDatos['eje3']);
	$eje4 = caracteres_html_inversa($rowDatos['eje4']);
	$eje5 = caracteres_html_inversa($rowDatos['eje5']);
        $ttoRedGES = $rowDatos['ttoRedGES'];
	$lugarRedGES = $rowDatos['lugarRedGES'] ;
        
        
	$diasAcumulados = $rowDatos['diasAcumulados'];
	if($diasAcumulados == 0)
	{
		$diasAcumulados = 'No se dispone de esta información';
	}
	$fechaInicioUL = VueltaFecha($rowDatos['fechaInicioUL']);
	if($fechaInicioUL == '00-00-0000')
	{
		$fechaInicioUL = "No se dispone de esta información";
	}
	$diasReposoIndicados = $rowDatos['diasReposoIndicados'];
	if($diasReposoIndicados == 0)
	{
		$diasReposoIndicados = 'No se dispone de esta información';
	}
	$correspondeReposo = $rowDatos['correspondeReposo'];
	if($correspondeReposo == 'SI')
	{
		$periodo = $rowDatos['periodo'];
		if($periodo == 'COMPLETO')
		{
			$fraseCorrespondeReposo = 'SI, POR UN PER�?ODO COMPLETO';
		}
		else
		{
			$fraseCorrespondeReposo = 'SI, POR UN PER�?ODO REDUCIDO';
		}
	}
	if($correspondeReposo == 'NO'){
		$fraseCorrespondeReposo = 'NO';
	}
	if($correspondeReposo == ''){
		$fraseCorrespondeReposo = '';
	}
		

	
	//REINTEGRO
	$pronosticoReintegro = $rowDatos['pronosticoReintegro'];
	if($pronosticoReintegro != '')
	{
		if($pronosticoReintegro == 'CON UN TRATAMIENTO ADECUADO PACIENTE EN CONDICIONES DE REINTEGRARSE EN [ ] DIAS A SU ACTIVIDAD LABORAL')
		{
			$diasPronostico = $rowDatos['diasPronostico'];
			$fraseReintegro = 'CON UN TRATAMIENTO ADECUADO PACIENTE EN CONDICIONES DE REINTEGRARSE EN '.$diasPronostico.' DIAS A SU ACTIVIDAD LABORAL';
		}
		else
		{
			$fraseReintegro = $pronosticoReintegro;
		}
	}
	$comentarios2 = caracteres_html_inversa($rowDatos['comentarios2']);
	$enfermedadlaboral=$rowDatos['enfermedadlaboral'] ;
	$nombreCompletoPaciente = caracteres_html_inversa(nombreCompletoPaciente($idPaciente, $conectar));
	$rutPaciente = rutPaciente($idPaciente, $conectar);
	$dvPaciente = DigitoVerificador($rutPaciente);
	$rutPaciente = PonerPunto($rutPaciente).'-'.$dvPaciente;
	$direccion = direccionPaciente($idPaciente, $conectar);
	$comuna = caracteres_html_inversa(retornaComuna(idComunaPaciente($idPaciente, $conectar), $conectar));
     $ciudad = strtoupper($rowDatos['ciudad']);
     $nombreCompletoPrestador = caracteres_html_inversa(nombreCompletoPrestador ($idPrestador, $conectar));
	$rutPrestador = rutPrestador ($idPrestador, $conectar);
	$dvPrestador = DigitoVerificador($rutPrestador);
	$rutPrestador = PonerPunto($rutPrestador).'-'.$dvPrestador;
       
///////////////////////////////////////////////////////////////////////////////
//PDF
/*
	class PDF extends FPDF
	{		
		//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-20);
			//Arial italic 8
			$this->SetFont('Arial','',5);
			//Número de página
			$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
			$this->Ln(8);
			$this->MultiCell(0,5,utf8_decode('Copyright © 2010 Cetep, Centro de Estudio y Tratamiento de Enfermedades Psiquiátricas Ltda. Prohibida la reproducción total o parcial, sin autorización escrita de Cetep. Para ordenar copias o solicitar permiso de reproducción, por favor contáctese por teléfono (56-2) 7840831, por e-mail: contacto@cetep.cl, o bien escriba a Soria 626, Las Condes, Santiago - Chile.'), 1);
//			$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
//			$this->Ln(15);
//			$this->Cell(0,10,'Página hola',0,0,'C');
		}
	}
	*/
	//Creación del objeto de la clase heredada
	$pdf=new FPDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->Image("../../templates/defecto/imagenes/logoDocumentos.jpg",20,8,18);
	$pdf->Ln();

	$pdf->SetFont('Arial','B',12);
	//Movernos a la derecha
	$pdf->Cell(80);
	$pdf->Cell(160,10,'Peritaje Realizado en '.ucfirst(strtolower($ciudad)),0,0,'C');
	$pdf->Ln(15);
	//Título
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(80);
	$pdf->Cell(30,10,utf8_decode('Informe de Entrevista Psiquiátrica de Peritaje'),0,0,'C');
	$pdf->Ln(10);
	//////////////
	//Datos paciente
     $pdf->SetFont('Arial','B',10);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Fecha: ',0,0,'L');
	$pdf->Cell(10,10,VueltaFecha($fecha),0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Nombre: ',0,0,'L');
	$pdf->Cell(10,10,$nombreCompletoPaciente,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'RUT: ',0,0,'L');
	$pdf->Cell(10,10,$rutPaciente,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Seguro de salud: ',0,0,'L');
	$pdf->Cell(10,10,$isapre,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,utf8_decode('Ocupación: '),0,0,'L');
	$pdf->Cell(10,10,ucfirst(strtolower($ocupacion)),0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Sexo: ',0,0,'L');
	$pdf->Cell(10,10,$sexo,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Edad: ',0,0,'L');
	$pdf->Cell(10,10,$edad,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,utf8_decode('Dirección: '),0,0,'L');
	$pdf->Cell(10,10,$direccion,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Comuna: ',0,0,'L');
	$pdf->Cell(10,10,ucwords(strtolower($comuna)),0,0,'L');
	//Si es región no se muestra la ciudad
	//
/*	if(siEsRegion(ciudadHora($hora, $conectar), $conectar) == 'no')
	{
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'Ciudad: ',0,0,'L');
		$pdf->Cell(10,10,ucfirst(strtolower($ciudad)),0,0,'L');
	}*/	
	//
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,utf8_decode('Médico tratante: '),0,0,'L');
	$pdf->Cell(10,10,ucfirst(strtolower($medicoTratante)),0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'N. Med. tratante: ',0,0,'L');
	$pdf->Cell(10,10,$nombreMedicoTratante,0,0,'L');
	if($numeroLicencia != 0)
	{
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'N. Licencia: ',0,0,'L');
		$pdf->Cell(10,10,$numeroLicencia,0,0,'L');
	}
	
	//Datos paciente
	//////////////
	//////////////
	//Firma
	
if ($fecha >= '2014-08-15' )
{
	//reeemplazo supervisor
	
	$nombreImagen = $idPrestador.'.jpg';
	
	if(file_exists('../../templates/defecto/imagenes/firmas/'.$nombreImagen) == true)
	{
		//redimensionar_jpeg('../../templates/defecto/imagenes/firmas/'.$nombreImagen, '../../templates/defecto/imagenes/firmas/'.$nombreImagen, 250, 120, 100);
		$pdf->Image("../../templates/defecto/imagenes/firmas/$nombreImagen", 0, 100, 0);
		
	}
	else
	{
		$pdf->Ln(40);
	}
	
	$pdf->Ln(50);
	$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",10, 140, 0);
	
	//Cambio de firma a Dra. Ortiz
	
		$supervisor = 49; //Dra Muñoz
		$nombreSupervisor = 'Dra. Berta Muñoz López';
	
	/*if($diferenciaFecha >= 0)
	{
		
		$supervisor = 32; //Dra Ortiz
		$nombreSupervisor = 'Dra. Vilma Ortiz';
	}
	else
	{
		$supervisor = 10;	
		$nombreSupervisor = 'Dr. Juan Pablo Osorio';
	}*/
	
	//Si NO es Osorio muestro la firma
	if($idPrestador != $supervisor)
	{
		$pdf->Image("../../templates/defecto/imagenes/firmas/".$supervisor.".jpg", 110, 98, 0);
		$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
	}
	$pdf->Ln(1);
	$pdf->Cell(5);
	$pdf->SetFont('Arial','',10);
	//Si NO es Osorio muestro la firma
	if($idPrestador != $supervisor)
	{
		$pdf->Image("../../templates/defecto/imagenes/firmas/".$supervisor.".jpg", 110, 98, 0);
		$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
	}
	$pdf->Ln(1);
	$pdf->Cell(5);
	$pdf->SetFont('Arial','',10);
	
	if($idPrestador != $supervisor)
	{
		$pdf->Cell(5,5,'Dr(a). '.$nombreCompletoPrestador.'                                                               '.utf8_decode($nombreSupervisor),0,0,"L");
	}
	else
	{
		$pdf->Ln(4);
		$pdf->Cell(5);
		$pdf->Cell(5,5,'Dr(a). '.$nombreCompletoPrestador.'',0,0,"L");
		$pdf->Ln(4);
		$pdf->Cell(5);
		$pdf->Cell(5,5,utf8_decode('Médico Psiquiátra'),0,0,"L");
	}
	$pdf->Ln(3);
	$pdf->Cell(5);
	if($idPrestador != $supervisor)
	{	
		$pdf->Cell(5,5,utf8_decode('Médico Psiquiátra                                                                                 Supervisor Técnico de Peritajes'),0,0,"L");
	}
	
	//Firma
	//////////////
	
	//fin reemplazo vacaciones	
     }
		else
   	{	
	
	$nombreImagen = $idPrestador.'.jpg';
	
	if(file_exists('../../templates/defecto/imagenes/firmas/'.$nombreImagen) == true)
	{
		// redimensionar_jpeg('../../templates/defecto/imagenes/firmas/'.$nombreImagen, '../../templates/defecto/imagenes/firmas/'.$nombreImagen, 250, 120, 100);
		$pdf->Image("../../templates/defecto/imagenes/firmas/$nombreImagen", 0, 100, 0);
		
	}
	else
	{
		$pdf->Ln(40);
	}
	
	$pdf->Ln(50);
	$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",10, 140, 0);
	
	//Cambio de firma a Dra. Ortiz
	if($diferenciaFecha >= 0)
	{
		
		$supervisor = 32; //Dra Ortiz
		$nombreSupervisor = 'Dra. Vilma Ortiz';
	}
	else
	{
		$supervisor = 10;	
		$nombreSupervisor = 'Dr. Juan Pablo Osorio';
	}
	
	//Si NO es Osorio muestro la firma
	if($idPrestador != $supervisor)
	{
		$pdf->Image("../../templates/defecto/imagenes/firmas/".$supervisor.".jpg", 110, 98, 0);
		$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
	}
	$pdf->Ln(1);
	$pdf->Cell(5);
	$pdf->SetFont('Arial','',10);
	//Si NO es Osorio muestro la firma
	if($idPrestador != $supervisor)
	{
		$pdf->Image("../../templates/defecto/imagenes/firmas/".$supervisor.".jpg", 110, 98, 0);
		$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
	}
	$pdf->Ln(1);
	$pdf->Cell(5);
	$pdf->SetFont('Arial','',10);
	
	if($idPrestador != $supervisor)
	{
		$pdf->Cell(5,5,'Dr(a). '.$nombreCompletoPrestador.'                                                               '.$nombreSupervisor,0,0,"L");
	}
	else
	{
		$pdf->Ln(4);
		$pdf->Cell(5);
		$pdf->Cell(5,5,'Dr(a). '.$nombreCompletoPrestador.'',0,0,"L");
		$pdf->Ln(4);
		$pdf->Cell(5);
		$pdf->Cell(5,5,utf8_decode('Médico Psiquiátra'),0,0,"L");
	}
	$pdf->Ln(3);
	$pdf->Cell(5);
	if($idPrestador != $supervisor)
	{	
		$pdf->Cell(5,5,utf8_decode('Médico Psiquiátra                                                                                 Supervisor Técnico de Peritajes'),0,0,"L");
	}
	
	//Firma
	//////////////
	} //fin firma y reemplazo
	//////////////
	//Informe
	$pdf->Ln(10);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,'HISTORIA CLINICA',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Antecedentes Personales',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($antecedentesPersonales));
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Antecedentes Mórbidos (incluye antecedentes psiquiátricos)'),0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($antecedentesMorbidos));
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Factores estresantes',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($factoresEstresantes));
		
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Anamnesis',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($anamnesis));
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Exámen Mental'),0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($examenMental));
	$pdf->Ln(2);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,'TRATAMIENTO ACTUAL',0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Tratamiento Actual (detallar fármacos y dosis)'),0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($tratamientoActual));
	/*$pdf->Ln(3);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Paciente Refiere Tratamiento en red GES');
	$pdf->Ln(7);
        $pdf->SetFont('Arial','',10);
        $pdf->MultiCell(0,5,$ttoRedGES);
        $pdf->Ln(3);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Lugar Tratamiento');
	$pdf->Ln(7);
        $pdf->SetFont('Arial','',10);
        $pdf->MultiCell(0,5,$lugarRedGES);*/
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Opinión Sobre Tratamiento Actual'),0,0,'L');
	$pdf->Ln(4);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode(ucfirst(strtolower($opinionTratamiento))));
	if($comentarios != '')//Si hay comentarios, los agrego al final
	{
		$pdf->MultiCell(0,5,utf8_decode($comentarios));
	}
	$pdf->Ln(2);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,utf8_decode('DIAGNÓSTICO DE LICENCIA MÉDICA  N° ').$numeroLicencia,0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Diagnóstico de Licencia Médica  N° ').$numeroLicencia,0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($diagnosticoLicenciaMedica));
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Opinión Sobre el Diagnóstico de la Licencia Médica N° ').$numeroLicencia,0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode(ucfirst(strtolower($opinionSobreDiagnostico))));
	if($comentariosDLM != '')//Si hay comentarios, los agrego al final
	{
		$pdf->MultiCell(0,5,utf8_decode($comentariosDLM));
	}
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,utf8_decode('HIPÓTESIS DIAGNÓSTICA'),0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Eje I',0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($eje1));
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'Eje II',0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($eje2));
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'Eje III',0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($eje3));
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'Eje IV',0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($eje4));
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'Eje V',0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($eje5));
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,utf8_decode('CONCLUSIÓN SOBRE REPOSO MÉDICO'),0,0,'L');
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Días acumulados de reposo a la fecha de hoy día (incluye licencia médica N° ').$numeroLicencia.')',0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$diasAcumulados);
	// si es paciente de cruz blanca no mostrar estos campos
    //fecha de inicio
    //dias de reposo indicados
    //corresponde reposo
    //solicitado por dra. Mgalvez 08/10/2014

    if ($codisapre != 3  ){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Fecha de inicio de licencia N° ').$numeroLicencia,0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$fechaInicioUL);
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Días de reposo indicados en licencia N° ').$numeroLicencia,0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$diasReposoIndicados);
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Respecto a licencia  N° ').$numeroLicencia.utf8_decode(', corresponde reposo'),0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode(ucfirst(strtolower($fraseCorrespondeReposo))));
	/// fin
    }

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Conclusión respecto del reintegro laboral al examen actual del paciente'),0,0,'L');
	if($pronosticoReintegro != '')
	{
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($fraseReintegro));
	}
	else
	{
		$pdf->Ln(5);
	}
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($comentarios2));
	// sacar para cruz blanca , no hay informacion de cuando se habilita para el resto
    /*
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Enfermedad Laboral'),0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$enfermedadlaboral);
	*/
	
	
	//Informe
	//////////////
	
	
	if($tipoSalida == 'I')
	{
		$pdf->Output(str_replace(' ', '_', elimina_acentos($nombreCompletoPaciente)).'.pdf', 'I');
	}
	elseif($tipoSalida == 'F')
	{
        $rutsinformato=	(int)rutPaciente($idPaciente, $conectar);
        $digito = (string)DigitoVerificador($rutsinformato);
        $separador='_';
        $archivo = $rutsinformato.'-'.$digito.$hora.'_DP'.'.pdf';
        $carpeta ='/agenda/informesRespaldo/';
        $ruta='../../../informesRespaldo/'.$rutsinformato.'-'.$digito.$hora.'_DP'.'.pdf';
		$pdf->Output('../../../informesRespaldo/'.$archivo , 'F');
	    return $ruta ;
    }

}


function crearCertificadoInasistencia($idHora,$conectar){



    $sqlDatos = mysql_query("
			SELECT
				i.`id`,
				i.`hora`,
				i.`ciudad`,
				i.`paciente`,
				`f_datospaciente`(i.`paciente`,1) AS rutpac,
        		`f_datospaciente`(i.`paciente`,2) AS nompac,
        		`f_ciudadhora`(i.`id`) AS ciudad,
				i.`prestador`,
				`f_perito`(i.`prestador`,1) AS rutprestador,
				`f_perito`(i.`prestador`,2) AS nombreprestador,

				i.`isapre`,
				`f_nomisapre`(i.`isapre`) AS nomisa,
				i.`confirmada`,
				date(i.hora) as fecha,
				DATE_FORMAT(i.`hora`, '%e') AS dia,
				DATE_FORMAT(i.`hora`, '%c') AS mes,
				DATE_FORMAT(i.`hora`, '%Y') AS ano,
				DATE_FORMAT(i.`hora`, '%k') AS hora,
				DATE_FORMAT(i.`hora`, '%i') AS minutos
			FROM
				horas i
			WHERE
				i.`id`='" . $idHora . "'
			", $conectar);

    $rowDatos = mysql_fetch_array($sqlDatos);

    $idPaciente = $rowDatos['paciente'];
    $idPrestador = $rowDatos['prestador'];
    $fecha = VueltaFecha($rowDatos['fecha']);
    $isapre = $rowDatos['nomisa'];
    $dia = $rowDatos['dia'];
    $mes = $rowDatos['mes'];
    $ano = $rowDatos['ano'];
    $hora = $rowDatos['hora'];
    $minutos = $rowDatos['minutos'];
    $fecha = $rowDatos['fecha'];
    $idIsapre = $rowDatos['isapre'];

    $nombreCompletoPaciente = $rowDatos['nompac'];
    $rutPaciente =  $rowDatos['rutpac'];
    $ciudad = strtoupper($rowDatos['ciudad']);
    $rutPrestador = $rowDatos['rutprestador'];
    $nombreCompletoPrestador = caracteres_html_inversa($rowDatos['nombreprestador']);

    //Creación del objeto de la clase heredada
    $pdf = new FPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->Image("../../templates/defecto/imagenes/logoDocumentos.jpg", 20, 12, 20);

    $pdf->SetFont('Arial', 'B', 12);
    //Movernos a la derecha
    $pdf->Ln(20);

    $pdf->Cell(0, 10, ucfirst(strtolower($ciudad . ", " . MesPalabra($mes) . " " . $dia . " de " . $ano)), 0, 0, 'R');
    $pdf->Ln(25);

    //Título
    $pdf->SetFont('Arial', '', 15);
    $pdf->Cell(0, 10, 'CERTIFICADO DE INASISTENCIA A PERITAJE', 0, 0, 'C');
    $pdf->Line(45, 63, 165, 63);
    $pdf->Ln(20);

    //////////////
    //Datos paciente
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 5, 'Por medio de la presente certificamos que ' . utf8_decode(utf8_encode($nombreCompletoPaciente)) . ', RUT: ' . $rutPaciente . ', no ' . utf8_decode("concurrió") . ' a la ' . utf8_decode("citación") . ' enviada por su Isapre ' . $isapre . ', para realizar una entrevista psiquiatrica de segunda ' . utf8_decode("opinión el día") . ' ' . $dia . ' de ' . MesPalabra($mes) . ' de ' . $ano . ' a las ' . $hora . ':' . $minutos . ' hrs., en la ciudad de ' . $ciudad);
    $pdf->Ln(10);
    $pdf->MultiCell(0, 5, 'Este certificado se extiende a ' . utf8_decode("petición") . ' de Isapre ' . $isapre . ' para los fines que estime conveniente.');
    $pdf->Ln(20);


    $nombreImagen = $idPrestador . '.jpg';

    if (file_exists('../../templates/defecto/imagenes/firmas/' . $nombreImagen) == true) {
        redimensionar_jpeg('../../templates/defecto/imagenes/firmas/' . $nombreImagen, '../../templates/defecto/imagenes/firmas/' . $nombreImagen, 354, 170, 100);

        $pdf->Image("../../templates/defecto/imagenes/firmas/$nombreImagen", 60, 120, 0);

    } else {
        $pdf->Ln(40);
    }

    $pdf->Ln(40);
    $pdf->Line(70, 165, 140, 165);
    $pdf->Cell(0, 10, 'Dr(a). ' . $nombreCompletoPrestador, 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->Cell(0, 10, 'RUT ' . $rutPrestador, 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->Cell(0, 10, 'Cetep Asociados Ltda.', 0, 0, 'C');


////////

    $ruta='../../../informesRespaldo/'.$rutPaciente.'_DI'.'.PDF';
    if ($isapre = 'Cruz Blanca') {
        $pdf->Output($ruta, 'F');
        $filepdf=$ruta;


    }

    return $filepdf ;
}


function anulaenvioinformeconerror($idHora,$conectar){

$sqlestado=mysql_query("SELECT idhora,fecha, MAX(fecha) AS fecultenvio,EXTRACTVALUE(response, '//CodRespuesta') AS estado,EXTRACTVALUE(response, '//GlosaRespuesta') AS glosa
FROM `envioXML`
WHERE idhora =  $idHora
GROUP BY idhora",$conectar) ;
	
	  $row=mysql_fetch_array($sqlestado);
return $row;

}


function ResumenInforme($idHora, $tipoSalida, $carpetaSalida, $conectar)
{
    $sqlDatos = mysql_query("
	SELECT
		i.`id`,
		i.`paciente`,
		`f_html_encode`(`f_ciudadhora`(i.`hora`)) AS ciudad,
		i.`prestador`,
		i.`hora`,
		DATEDIFF(i.`fecha`, '2011-10-19') AS diferenciaFecha,
		i.`fecha`,
		i.`ocupacion`,
		i.`sexo`,
		i.`edad`,
		i.`tiempoLicencia`,
    	i.`medicoTratante`,
		i.`nombreMedicoTratante`,
		i.`numeroLicencia`,
		i.`antecedentesPersonales`,
		i.`antecedentesMorbidos`,
		i.`factoresEstresantes`,
		i.`existeEstresLaboral`,
		i.`evaluacionEspecifica`,
		i.`anamnesis`,
		i.`examenMental`,
		i.`tratamientoActual`,
		i.`opinionTratamiento`,
		i.`comentarios`,
		i.`diagnosticoLicenciaMedica`,
		i.`opinionSobreDiagnostico`,
		i.`comentariosDLM`,
		i.`diasAcumulados`,
		i.`fechaInicioUL`,
		i.`diasReposoIndicados`,
		i.`correspondeReposo`,
		i.`periodo`,
		i.`pronosticoReintegro`,
		i.`diasPronostico`,
		i.`comentarios2`,
		i.`enfermedadlaboral`
	FROM 	informe_entrevista i
	WHERE  i.`hora`=" . $idHora . " 	", $conectar);
    $rowDatos = mysql_fetch_array($sqlDatos);
    $hora = $rowDatos['hora'];
    $codisapre = isapreHora($hora, $conectar);
    $isapre = nombreIsapre(isapreHora($hora, $conectar), $conectar);
    $idPaciente = $rowDatos['paciente'];
    $idPrestador = $rowDatos['prestador'];
    $diferenciaFecha = $rowDatos['diferenciaFecha'];
    $fecha = fechaFormateadaHora($hora, $conectar);
    $ocupacion = $rowDatos['ocupacion'];
    $sexo = $rowDatos['sexo'];
    $edad = $rowDatos['edad'];
    $medicoTratante = utf8_decode(caracteres_html_inversa($rowDatos['medicoTratante']));
    $nombreMedicoTratante = utf8_decode(caracteres_html_inversa($rowDatos['nombreMedicoTratante']));
    $numeroLicencia = $rowDatos['numeroLicencia'];
    $opinionTratamiento = caracteres_html_inversa($rowDatos['opinionTratamiento']);
    $comentarios = caracteres_html_inversa($rowDatos['comentarios']);
    $diagnosticoLicenciaMedica = caracteres_html_inversa($rowDatos['diagnosticoLicenciaMedica']);
    $opinionSobreDiagnostico = caracteres_html_inversa($rowDatos['opinionSobreDiagnostico']);
    $comentariosDLM = caracteres_html_inversa($rowDatos['comentariosDLM']);
    $diasAcumulados = $rowDatos['diasAcumulados'];
    if ($diasAcumulados == 0) {
        $diasAcumulados = 'No se dispone de esta información';
    }
    $fechaInicioUL = VueltaFecha($rowDatos['fechaInicioUL']);
    if ($fechaInicioUL == '00-00-0000') {
        $fechaInicioUL = "No se dispone de esta información";
    }
    $diasReposoIndicados = $rowDatos['diasReposoIndicados'];
    if ($diasReposoIndicados == 0) {
        $diasReposoIndicados = 'No se dispone de esta información';
    }
    $correspondeReposo = $rowDatos['correspondeReposo'];
    if ($correspondeReposo == 'SI') {
        $periodo = $rowDatos['periodo'];
        if ($periodo == 'COMPLETO') {
            $fraseCorrespondeReposo = 'SI, POR UN PER�?ODO COMPLETO';
        } else {
            $fraseCorrespondeReposo = 'SI, POR UN PER�?ODO REDUCIDO';
        }
    }
    if ($correspondeReposo == 'NO') {
        $fraseCorrespondeReposo = 'NO';
    }
    if ($correspondeReposo == '') {
        $fraseCorrespondeReposo = '';
    }
    //REINTEGRO
    $pronosticoReintegro = $rowDatos['pronosticoReintegro'];
    if ($pronosticoReintegro != '') {
        if ($pronosticoReintegro == 'CON UN TRATAMIENTO ADECUADO PACIENTE EN CONDICIONES DE REINTEGRARSE EN [ ] DIAS A SU ACTIVIDAD LABORAL') {
            $diasPronostico = $rowDatos['diasPronostico'];
            $fraseReintegro = 'CON UN TRATAMIENTO ADECUADO PACIENTE EN CONDICIONES DE REINTEGRARSE EN ' . $diasPronostico . ' DIAS A SU ACTIVIDAD LABORAL';
        } else {
            $fraseReintegro = $pronosticoReintegro;
        }
    }
    $comentarios2 = caracteres_html_inversa($rowDatos['comentarios2']);
    $enfermedadlaboral = $rowDatos['enfermedadlaboral'];
    $nombreCompletoPaciente = caracteres_html_inversa(nombreCompletoPaciente($idPaciente, $conectar));
    $rutPaciente = rutPaciente($idPaciente, $conectar);
    $dvPaciente = DigitoVerificador($rutPaciente);
    $rutPaciente = PonerPunto($rutPaciente) . '-' . $dvPaciente;
    $direccion = direccionPaciente($idPaciente, $conectar);
    $comuna = caracteres_html_inversa(retornaComuna(idComunaPaciente($idPaciente, $conectar), $conectar));
    $ciudad = strtoupper($rowDatos['ciudad']);
    $nombreCompletoPrestador = caracteres_html_inversa(nombreCompletoPrestador($idPrestador, $conectar));
    $rutPrestador = rutPrestador($idPrestador, $conectar);
    $dvPrestador = DigitoVerificador($rutPrestador);
    $rutPrestador = PonerPunto($rutPrestador) . '-' . $dvPrestador;
///////////////////////////////////////////////////////////////////////////////
//PDF
    class PDF extends FPDF
    {
        //Pie de página
        function Footer()
        {
            //Posición: a 1,5 cm del final
            $this->SetY(-20);
            //Arial italic 8
            $this->SetFont('Arial', '', 5);
            //Número de página
            $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
            $this->Ln(8);
            $this->MultiCell(0, 5, utf8_decode('Copyright © 2010 Cetep, Centro de Estudio y Tratamiento de Enfermedades Psiquiátricas Ltda. Prohibida la reproducción total o parcial, sin autorización escrita de Cetep. Para ordenar copias o solicitar permiso de reproducción, por favor contáctese por teléfono (56-2) 7840831, por e-mail: contacto@cetep.cl, o bien escriba a Soria 626, Las Condes, Santiago - Chile.'), 1);
//			$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
//			$this->Ln(15);
//			$this->Cell(0,10,'Página hola',0,0,'C');
        }





        var $angle = 0;

        function Rotate($angle, $x = -1, $y = -1)
        {
            if ($x == -1)
                $x = $this->x;
            if ($y == -1)
                $y = $this->y;
            if ($this->angle != 0)
                $this->_out('Q');
            $this->angle = $angle;
            if ($angle != 0) {
                $angle *= M_PI / 180;
                $c = cos($angle);
                $s = sin($angle);
                $cx = $x * $this->k;
                $cy = ($this->h - $y) * $this->k;
                $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
            }
        }
        function RotatedText($x, $y, $txt, $angle)
        {
            //Text rotated around its origin
            $this->Rotate($angle, $x, $y);
            $this->Text($x, $y, $txt);
            $this->Rotate(0);
        }

        function _endpage()
        {
            if ($this->angle != 0) {
                $this->angle = 0;
                $this->_out('Q');
            }
            parent::_endpage();
        }
        function Header()
        {
            //Put the watermark
            $this->SetFont('Arial', 'B', 50);
            $this->SetTextColor(255, 192, 203);
            $this->RotatedText(35, 190, 'P r e - I n f o r m e ', 45);
        }

    }


    //Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->Image("../../templates/defecto/imagenes/logoDocumentos.jpg", 20, 8, 18);
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 12);
    //Movernos a la derecha
    $pdf->Cell(80);
    $pdf->Cell(160, 10, 'Peritaje Realizado en ' . ucfirst(strtolower($ciudad)), 0, 0, 'C');
    $pdf->Ln(15);
    //Título
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(80);
    $pdf->Cell(30, 10, utf8_decode('Pre-Informe de Entrevista Psiquiátrica de Peritaje'), 0, 0, 'C');
    $pdf->Ln(10);
    //////////////
    //Datos paciente
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(1);
    $pdf->Cell(40, 10, 'Fecha: ', 0, 0, 'L');
    $pdf->Cell(10, 10, VueltaFecha($fecha), 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(1);
    $pdf->Cell(40, 10, 'Nombre: ', 0, 0, 'L');
    $pdf->Cell(10, 10, $nombreCompletoPaciente, 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(1);
    $pdf->Cell(40, 10, 'RUT: ', 0, 0, 'L');
    $pdf->Cell(10, 10, $rutPaciente, 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(1);
    $pdf->Cell(40, 10, 'Seguro de salud: ', 0, 0, 'L');
    $pdf->Cell(10, 10, $isapre, 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(1);
    $pdf->Cell(40, 10, utf8_decode('Ocupación: '), 0, 0, 'L');
    $pdf->Cell(10, 10, ucfirst(strtolower($ocupacion)), 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(1);
    $pdf->Cell(40, 10, 'Sexo: ', 0, 0, 'L');
    $pdf->Cell(10, 10, $sexo, 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(1);
    $pdf->Cell(40, 10, 'Edad: ', 0, 0, 'L');
    $pdf->Cell(10, 10, $edad, 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(1);
    $pdf->Cell(40, 10, utf8_decode('Dirección: '), 0, 0, 'L');
    $pdf->Cell(10, 10, $direccion, 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(1);
    $pdf->Cell(40, 10, 'Comuna: ', 0, 0, 'L');
    $pdf->Cell(10, 10, ucwords(strtolower($comuna)), 0, 0, 'L');
    //Si es región no se muestra la ciudad
    //
    /*	if(siEsRegion(ciudadHora($hora, $conectar), $conectar) == 'no')
        {
            $pdf->Ln(5);
            $pdf->Cell(1);
            $pdf->Cell(40,10,'Ciudad: ',0,0,'L');
            $pdf->Cell(10,10,ucfirst(strtolower($ciudad)),0,0,'L');
        }*/
//
    $pdf->Ln(5);
    $pdf->Cell(1);
    $pdf->Cell(40, 10, utf8_decode('Médico tratante: '), 0, 0, 'L');
    $pdf->Cell(10, 10, ucfirst(strtolower($medicoTratante)), 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(1);
    $pdf->Cell(40, 10, 'N. Med. tratante: ', 0, 0, 'L');
    $pdf->Cell(10, 10, $nombreMedicoTratante, 0, 0, 'L');
    if ($numeroLicencia != 0) {
        $pdf->Ln(5);
        $pdf->Cell(1);
        $pdf->Cell(40, 10, 'N. Licencia: ', 0, 0, 'L');
        $pdf->Cell(10, 10, $numeroLicencia, 0, 0, 'L');
    }

//Datos paciente
//////////////
//////////////
//Firma

    if ($fecha >= '2014-08-15') {
        //reeemplazo supervisor

        $nombreImagen = $idPrestador . '.jpg';

        if (file_exists('../../templates/defecto/imagenes/firmas/' . $nombreImagen) == true) {
            //redimensionar_jpeg('../../templates/defecto/imagenes/firmas/'.$nombreImagen, '../../templates/defecto/imagenes/firmas/'.$nombreImagen, 250, 120, 100);
            $pdf->Image("../../templates/defecto/imagenes/firmas/$nombreImagen", 0, 100, 0);
        } else {
            $pdf->Ln(40);
        }
        $pdf->Ln(50);
        $pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif", 10, 140, 0);
        //Cambio de firma a Dra. Ortiz
        $supervisor = 49; //Dra Muñoz
        $nombreSupervisor = 'Dra. Berta Muñoz López';
        /*if($diferenciaFecha >= 0)
        {
            $supervisor = 32; //Dra Ortiz
            $nombreSupervisor = 'Dra. Vilma Ortiz';
        }
        else
        {
            $supervisor = 10;
            $nombreSupervisor = 'Dr. Juan Pablo Osorio';
        }*/

        //Si NO es Osorio muestro la firma
        if ($idPrestador != $supervisor) {
            //	$pdf->Image("../../templates/defecto/imagenes/firmas/".$supervisor.".jpg", 110, 98, 0);
            //	$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
        }
        $pdf->Ln(1);
        $pdf->Cell(5);
        $pdf->SetFont('Arial', '', 10);
        //Si NO es Osorio muestro la firma
        if ($idPrestador != $supervisor) {
            //	$pdf->Image("../../templates/defecto/imagenes/firmas/".$supervisor.".jpg", 110, 98, 0);
            //	$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
        }
        $pdf->Ln(1);
        $pdf->Cell(5);
        $pdf->SetFont('Arial', '', 10);

        if ($idPrestador != $supervisor) {
            $pdf->Cell(5, 5, 'Dr(a). ' . $nombreCompletoPrestador . '                                                               ', 0, 0, "L");
        } else {
            $pdf->Ln(4);
            $pdf->Cell(5);
            $pdf->Cell(5, 5, 'Dr(a). ' . $nombreCompletoPrestador . '', 0, 0, "L");
            $pdf->Ln(4);
            $pdf->Cell(5);
            $pdf->Cell(5, 5, utf8_decode('Médico Psiquiátra'), 0, 0, "L");
        }
        $pdf->Ln(3);
        $pdf->Cell(5);
        if ($idPrestador != $supervisor) {
            $pdf->Cell(5, 5, utf8_decode('Médico Psiquiátra                                                                                '), 0, 0, "L");
        }

        //Firma
        //////////////

        //fin reemplazo vacaciones
    } else {

        $nombreImagen = $idPrestador . '.jpg';

        if (file_exists('../../templates/defecto/imagenes/firmas/' . $nombreImagen) == true) {
            //redimensionar_jpeg('../../templates/defecto/imagenes/firmas/'.$nombreImagen, '../../templates/defecto/imagenes/firmas/'.$nombreImagen, 250, 120, 100);
            $pdf->Image("../../templates/defecto/imagenes/firmas/$nombreImagen", 0, 100, 0);

        } else {
            $pdf->Ln(40);
        }

        $pdf->Ln(50);
        $pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif", 10, 140, 0);

        //Cambio de firma a Dra. Ortiz
        if ($diferenciaFecha >= 0) {

            $supervisor = 32; //Dra Ortiz
            $nombreSupervisor = 'Dra. Vilma Ortiz';
        } else {
            $supervisor = 10;
            $nombreSupervisor = 'Dr. Juan Pablo Osorio';
        }

        //Si NO es Osorio muestro la firma
        if ($idPrestador != $supervisor) {
            //	$pdf->Image("../../templates/defecto/imagenes/firmas/".$supervisor.".jpg", 110, 98, 0);
            //	$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
        }
        $pdf->Ln(1);
        $pdf->Cell(5);
        $pdf->SetFont('Arial', '', 10);
        //Si NO es Osorio muestro la firma
        if ($idPrestador != $supervisor) {
            //	$pdf->Image("../../templates/defecto/imagenes/firmas/".$supervisor.".jpg", 110, 98, 0);
            //	$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
        }
        $pdf->Ln(1);
        $pdf->Cell(5);
        $pdf->SetFont('Arial', '', 10);

        if ($idPrestador != $supervisor) {
            //	$pdf->Cell(5,5,'Dr(a). '.$nombreCompletoPrestador.'                                                               '.$nombreSupervisor,0,0,"L");
        } else {
            $pdf->Ln(4);
            $pdf->Cell(5);
            $pdf->Cell(5, 5, 'Dr(a). ' . $nombreCompletoPrestador . '', 0, 0, "L");
            $pdf->Ln(4);
            $pdf->Cell(5);
            $pdf->Cell(5, 5, utf8_decode('Médico Psiquiátra'), 0, 0, "L");
        }
        $pdf->Ln(3);
        $pdf->Cell(5);
        if ($idPrestador != $supervisor) {
            //	$pdf->Cell(5,5,utf8_decode('Médico Psiquiátra                                                                                 Supervisor Técnico de Peritajes'),0,0,"L");
        }

        //Firma
        //////////////
    } //fin firma y reemplazo
//////////////
//Informe
//

    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'BU', 12);
    $pdf->Cell(0, 10, utf8_decode('CONCLUSIÓN SOBRE REPOSO MÉDICO'), 0, 0, 'L');

    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, utf8_decode('Días acumulados de reposo a la fecha de hoy día (incluye licencia médica N° ') . $numeroLicencia . ')', 0, 0, 'L');
    $pdf->Ln(7);
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(0, 5, $diasAcumulados);


// si es paciente de cruz blanca no mostrar estos campos
//fecha de inicio
//dias de reposo indicados
//corresponde reposo
//solicitado por dra. Mgalvez 08/10/2014


    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 5, utf8_decode('Fecha de inicio de licencia N° ') . $numeroLicencia, 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(0, 5, $fechaInicioUL);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 5, utf8_decode('Días de reposo indicados en licencia N° ') . $numeroLicencia, 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(0, 5, $diasReposoIndicados);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 5, utf8_decode('Respecto a licencia  N° ') . $numeroLicencia . utf8_decode(', corresponde reposo'), 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(0, 5, utf8_decode(ucfirst(strtolower($fraseCorrespondeReposo))));
    /// fin


    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 5, utf8_decode('Conclusión respecto del reintegro laboral al examen actual del paciente'), 0, 0, 'L');
    if ($pronosticoReintegro != '') {
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(0, 5, utf8_decode($fraseReintegro));
    } else {
        $pdf->Ln(5);
    }
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(0, 5, utf8_decode($comentarios2));
// sacar para cruz blanca , no hay informacion de cuando se habilita para el resto
    if ($codisapre != 3) {
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, utf8_decode('Enfermedad Laboral'), 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(0, 5, $enfermedadlaboral);
    }


//Informe
//////////////


  
	
	if($tipoSalida == 'I')
		{
			$pdf->Output(str_replace(' ', '_', elimina_acentos($nombreCompletoPaciente)).'.pdf', 'I');
		}
		elseif($tipoSalida == 'F')
		{
			$rutsinformato=	(int)rutPaciente($idPaciente, $conectar);
			$digito = (string)DigitoVerificador($rutsinformato);
			$separador='_';
			$archivo = $rutsinformato.'-'.$digito.$hora.'.pdf' ;
			$carpeta ='/agendadesa/informesRespaldo/';
			$ruta= ($_SERVER['DOCUMENT_ROOT'].$carpeta);
			//echo $carpeta.$archivo;
			//$pdf->Output('$ruta.$archivo', 'F');
			$filepdf=$ruta.$archivo ;
			$pdf->Output('../../../informesRespaldo/'.$archivo, 'F');
			return $filepdf ;
		}
		elseif($tipoSalida == 'D')
		{
			$rutsinformato=	(int)rutPaciente($idPaciente, $conectar);
			$digito = (string)DigitoVerificador($rutsinformato);
			$separador='_';
			$archivo = $rutsinformato.'-'.$digito.$hora.'.pdf' ;
			$carpeta ='/agendadesa/informesRespaldo/';
			$ruta= ($_SERVER['DOCUMENT_ROOT'].$carpeta);
			//echo $carpeta.$archivo;
			//$pdf->Output('$ruta.$archivo', 'F');
			$filepdf=$ruta.$archivo ;
			$pdf->Output('Pre-Informe'.$archivo, 'D');
			return $filepdf ;
		}

}

	function crearInformeNuevoEspecial($idHora, $tipoSalida, $carpetaSalida, $conectar)
	{


		$sqlDatos = mysql_query("
	SELECT
		i.`id`,
		i.`paciente`,
		`f_html_encode`(`f_ciudadhora`(i.`hora`)) AS ciudad,
		i.`prestador`,
		i.`hora`,
		DATEDIFF(i.`fecha`, '2011-10-19') AS diferenciaFecha,
		i.`fecha`,
		i.`ocupacion`,
		i.`sexo`,
		i.`edad`,
		i.`tiempoLicencia`,
    	i.`medicoTratante`,
		i.`nombreMedicoTratante`,
		i.`numeroLicencia`,
		i.`antecedentesPersonales`,
		i.`antecedentesMorbidos`,
		i.`factoresEstresantes`,
		i.`existeEstresLaboral`,
		i.`evaluacionEspecifica`,
		i.`anamnesis`,
		i.`examenMental`,
		i.`tratamientoActual`,
		i.`opinionTratamiento`,
		i.`comentarios`,
		i.`diagnosticoLicenciaMedica`,
		i.`opinionSobreDiagnostico`,
		i.`comentariosDLM`,
		i.`eje1`,
		i.`eje2`,
		i.`eje3`,
		i.`eje4`,
		i.`eje5`,
		i.`diasAcumulados`,
		i.`fechaInicioUL`,
		i.`diasReposoIndicados`,
		i.`correspondeReposo`,
		i.`periodo`,
		i.`pronosticoReintegro`,
		i.`diasPronostico`,
		i.`comentarios2`,
        i.`ttoRedGES`,
		i.`lugarRedGES`,
		i.`enfermedadlaboral`
	FROM 	informe_entrevista i
	WHERE  i.`hora`=".$idHora." 	", $conectar);
		$rowDatos = mysql_fetch_array($sqlDatos);
		$hora = $rowDatos['hora'];
		$codisapre = isapreHora($hora, $conectar) ;
		$isapre = nombreIsapre(isapreHora($hora, $conectar), $conectar);
		$idPaciente = $rowDatos['paciente'];
		$idPrestador = $rowDatos['prestador'];
		$diferenciaFecha = $rowDatos['diferenciaFecha'];
		$fecha = fechaFormateadaHora($hora, $conectar);
		$ocupacion = $rowDatos['ocupacion'];
		$sexo = $rowDatos['sexo'];
		$edad = $rowDatos['edad'];
		$tiempoLicencia = $rowDatos['tiempoLicencia'];
		$medicoTratante = utf8_decode(caracteres_html_inversa($rowDatos['medicoTratante']));
		$nombreMedicoTratante = utf8_decode(caracteres_html_inversa($rowDatos['nombreMedicoTratante']));
		$numeroLicencia = $rowDatos['numeroLicencia'];
		$antecedentesPersonales = caracteres_html_inversa($rowDatos['antecedentesPersonales']);
		$antecedentesMorbidos = caracteres_html_inversa($rowDatos['antecedentesMorbidos']);
		$factoresEstresantes = caracteres_html_inversa($rowDatos['factoresEstresantes']);
		$anamnesis = caracteres_html_inversa($rowDatos['anamnesis']);
		$examenMental = caracteres_html_inversa($rowDatos['examenMental']);
		$tratamientoActual = caracteres_html_inversa($rowDatos['tratamientoActual']);
		$opinionTratamiento = caracteres_html_inversa($rowDatos['opinionTratamiento']);
		$comentarios = caracteres_html_inversa($rowDatos['comentarios']);
		$diagnosticoLicenciaMedica = caracteres_html_inversa($rowDatos['diagnosticoLicenciaMedica']);
		$opinionSobreDiagnostico = caracteres_html_inversa($rowDatos['opinionSobreDiagnostico']);
		$comentariosDLM = caracteres_html_inversa($rowDatos['comentariosDLM']);
		$eje1 = caracteres_html_inversa($rowDatos['eje1']);
		$eje2 = caracteres_html_inversa($rowDatos['eje2']);
		$eje3 = caracteres_html_inversa($rowDatos['eje3']);
		$eje4 = caracteres_html_inversa($rowDatos['eje4']);
		$eje5 = caracteres_html_inversa($rowDatos['eje5']);
		$ttoRedGES = $rowDatos['ttoRedGES'];
		$lugarRedGES = $rowDatos['lugarRedGES'] ;


		$diasAcumulados = $rowDatos['diasAcumulados'];
		if($diasAcumulados == 0)
		{
			$diasAcumulados = 'No se dispone de esta información';
		}
		$fechaInicioUL = VueltaFecha($rowDatos['fechaInicioUL']);
		if($fechaInicioUL == '00-00-0000')
		{
			$fechaInicioUL = "No se dispone de esta información";
		}
		$diasReposoIndicados = $rowDatos['diasReposoIndicados'];
		if($diasReposoIndicados == 0)
		{
			$diasReposoIndicados = 'No se dispone de esta información';
		}
		$correspondeReposo = $rowDatos['correspondeReposo'];
		if($correspondeReposo == 'SI')
		{
			$periodo = $rowDatos['periodo'];
			if($periodo == 'COMPLETO')
			{
				$fraseCorrespondeReposo = 'SI, POR UN PER�?ODO COMPLETO';
			}
			else
			{
				$fraseCorrespondeReposo = 'SI, POR UN PER�?ODO REDUCIDO';
			}
		}
		if($correspondeReposo == 'NO'){
			$fraseCorrespondeReposo = 'NO';
		}
		if($correspondeReposo == ''){
			$fraseCorrespondeReposo = '';
		}



		//REINTEGRO
		$pronosticoReintegro = $rowDatos['pronosticoReintegro'];
		if($pronosticoReintegro != '')
		{
			if($pronosticoReintegro == 'CON UN TRATAMIENTO ADECUADO PACIENTE EN CONDICIONES DE REINTEGRARSE EN [ ] DIAS A SU ACTIVIDAD LABORAL')
			{
				$diasPronostico = $rowDatos['diasPronostico'];
				$fraseReintegro = 'CON UN TRATAMIENTO ADECUADO PACIENTE EN CONDICIONES DE REINTEGRARSE EN '.$diasPronostico.' DIAS A SU ACTIVIDAD LABORAL';
			}
			else
			{
				$fraseReintegro = $pronosticoReintegro;
			}
		}
		$comentarios2 = caracteres_html_inversa($rowDatos['comentarios2']);
		$enfermedadlaboral=$rowDatos['enfermedadlaboral'] ;
		$nombreCompletoPaciente = caracteres_html_inversa(nombreCompletoPaciente($idPaciente, $conectar));
		$rutPaciente = rutPaciente($idPaciente, $conectar);
		$dvPaciente = DigitoVerificador($rutPaciente);
		$rutPaciente = PonerPunto($rutPaciente).'-'.$dvPaciente;
		$direccion = direccionPaciente($idPaciente, $conectar);
		$comuna = caracteres_html_inversa(retornaComuna(idComunaPaciente($idPaciente, $conectar), $conectar));
		$ciudad = strtoupper($rowDatos['ciudad']);
		$nombreCompletoPrestador = caracteres_html_inversa(nombreCompletoPrestador ($idPrestador, $conectar));
		$rutPrestador = rutPrestador ($idPrestador, $conectar);
		$dvPrestador = DigitoVerificador($rutPrestador);
		$rutPrestador = PonerPunto($rutPrestador).'-'.$dvPrestador;

///////////////////////////////////////////////////////////////////////////////
//PDF
		class PDF extends FPDF
		{
			//Pie de página
			function Footer()
			{
				//Posición: a 1,5 cm del final
				$this->SetY(-20);
				//Arial italic 8
				$this->SetFont('Arial','',5);
				//Número de página
				$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
				$this->Ln(8);
				$this->MultiCell(0,5,utf8_decode('Copyright © 2010 Cetep, Centro de Estudio y Tratamiento de Enfermedades Psiquiátricas Ltda. Prohibida la reproducción total o parcial, sin autorización escrita de Cetep. Para ordenar copias o solicitar permiso de reproducción, por favor contáctese por teléfono (56-2) 7840831, por e-mail: contacto@cetep.cl, o bien escriba a Soria 626, Las Condes, Santiago - Chile.'), 1);
//			$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
//			$this->Ln(15);
//			$this->Cell(0,10,'Página hola',0,0,'C');
			}
		}
		//Creación del objeto de la clase heredada
		$pdf=new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->Image("../../templates/defecto/imagenes/logoDocumentos.jpg",20,8,18);
		$pdf->Ln();

		$pdf->SetFont('Arial','B',12);
		//Movernos a la derecha
		$pdf->Cell(80);
		$pdf->Cell(160,10,'Peritaje Realizado en '.ucfirst(strtolower($ciudad)),0,0,'C');
		$pdf->Ln(15);
		//Título
		$pdf->SetFont('Arial','B',15);
		$pdf->Cell(80);
		$pdf->Cell(30,10,utf8_decode('Informe de Entrevista Psiquiátrica de Peritaje'),0,0,'C');
		$pdf->Ln(10);
		//////////////
		//Datos paciente
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'Fecha: ',0,0,'L');
		$pdf->Cell(10,10,VueltaFecha($fecha),0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'Nombre: ',0,0,'L');
		$pdf->Cell(10,10,$nombreCompletoPaciente,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'RUT: ',0,0,'L');
		$pdf->Cell(10,10,$rutPaciente,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'Seguro de salud: ',0,0,'L');
		$pdf->Cell(10,10,$isapre,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,utf8_decode('Ocupación: '),0,0,'L');
		$pdf->Cell(10,10,ucfirst(strtolower($ocupacion)),0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'Sexo: ',0,0,'L');
		$pdf->Cell(10,10,$sexo,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'Edad: ',0,0,'L');
		$pdf->Cell(10,10,$edad,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,utf8_decode('Dirección: '),0,0,'L');
		$pdf->Cell(10,10,$direccion,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'Comuna: ',0,0,'L');
		$pdf->Cell(10,10,ucwords(strtolower($comuna)),0,0,'L');
		//Si es región no se muestra la ciudad
		//
		/*	if(siEsRegion(ciudadHora($hora, $conectar), $conectar) == 'no')
			{
				$pdf->Ln(5);
				$pdf->Cell(1);
				$pdf->Cell(40,10,'Ciudad: ',0,0,'L');
				$pdf->Cell(10,10,ucfirst(strtolower($ciudad)),0,0,'L');
			}*/
		//
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,utf8_decode('Médico tratante: '),0,0,'L');
		$pdf->Cell(10,10,ucfirst(strtolower($medicoTratante)),0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'N. Med. tratante: ',0,0,'L');
		$pdf->Cell(10,10,$nombreMedicoTratante,0,0,'L');
		if($numeroLicencia != 0)
		{
			$pdf->Ln(5);
			$pdf->Cell(1);
			$pdf->Cell(40,10,'N. Licencia: ',0,0,'L');
			$pdf->Cell(10,10,$numeroLicencia,0,0,'L');
		}

		//Datos paciente
		//////////////
		//////////////
		//Firma

		if ($fecha >= '2014-08-15' )
		{
			//reeemplazo supervisor

			$nombreImagen = $idPrestador.'.jpg';
			$nombreImagen = $idPrestador.'.jpg';

			if(file_exists('../../templates/defecto/imagenes/firmas/'.$nombreImagen) == true)
			{
				//redimensionar_jpeg('../../templates/defecto/imagenes/firmas/'.$nombreImagen, '../../templates/defecto/imagenes/firmas/'.$nombreImagen, 250, 120, 100);

				$pdf->Image("../../templates/defecto/imagenes/firmas/$nombreImagen", 0, 100, 0);

			}
			else
			{
				$pdf->Ln(40);
			}

			$pdf->Ln(50);
			$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",10, 140, 0);

			//Cambio de firma a Dra. Ortiz

			$supervisor = 49; //Dra Muñoz
			$nombreSupervisor = 'Dra. Berta Muñoz López';

			/*if($diferenciaFecha >= 0)
			{

				$supervisor = 32; //Dra Ortiz
				$nombreSupervisor = 'Dra. Vilma Ortiz';
			}
			else
			{
				$supervisor = 10;
				$nombreSupervisor = 'Dr. Juan Pablo Osorio';
			}*/

			//Si NO es Osorio muestro la firma
			if($idPrestador != $supervisor)
			{
			//	$pdf->Image("../../templates/defecto/imagenes/firmas/".$supervisor.".jpg", 110, 98, 0);
			//	$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
			}
			$pdf->Ln(1);
			$pdf->Cell(5);
			$pdf->SetFont('Arial','',10);
			//Si NO es Osorio muestro la firma
			if($idPrestador != $supervisor)
			{
			//	$pdf->Image("../../templates/defecto/imagenes/firmas/".$supervisor.".jpg", 110, 98, 0);
			//	$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
			}
			$pdf->Ln(1);
			$pdf->Cell(5);
			$pdf->SetFont('Arial','',10);



				$pdf->Ln(4);
				$pdf->Cell(5);
				$pdf->Cell(5,5,'Dr(a). '.$nombreCompletoPrestador.'',0,0,"L");
				$pdf->Ln(4);
				$pdf->Cell(5);
				$pdf->Cell(5,5,utf8_decode('Médico Psiquiátra'),0,0,"L");

			$pdf->Ln(3);
			$pdf->Cell(5);


			//Firma
			//////////////

			//fin reemplazo vacaciones
		}
		else
		{

			$nombreImagen = $idPrestador.'.jpg';

			if(file_exists('../../templates/defecto/imagenes/firmas/'.$nombreImagen) == true)
			{
				//redimensionar_jpeg('../../templates/defecto/imagenes/firmas/'.$nombreImagen, '../../templates/defecto/imagenes/firmas/'.$nombreImagen, 250, 120, 100);
				$pdf->Image("../../templates/defecto/imagenes/firmas/$nombreImagen", 0, 100, 0);

			}
			else
			{
				$pdf->Ln(40);
			}

			$pdf->Ln(50);
			$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",10, 140, 0);

			//Cambio de firma a Dra. Ortiz
			if($diferenciaFecha >= 0)
			{

				$supervisor = 32; //Dra Ortiz
				$nombreSupervisor = 'Dra. Vilma Ortiz';
			}
			else
			{
				$supervisor = 10;
				$nombreSupervisor = 'Dr. Juan Pablo Osorio';
			}

			//Si NO es Osorio muestro la firma
			
			$pdf->Ln(1);
			$pdf->Cell(5);
			$pdf->SetFont('Arial','',10);
			//Si NO es Osorio muestro la firma
			
			$pdf->Ln(1);
			$pdf->Cell(5);
			$pdf->SetFont('Arial','',10);

			
				$pdf->Ln(4);
				$pdf->Cell(5);
				$pdf->Cell(5,5,'Dr(a). '.$nombreCompletoPrestador.'',0,0,"L");
				$pdf->Ln(4);
				$pdf->Cell(5);
				$pdf->Cell(5,5,utf8_decode('Médico Psiquiátra'),0,0,"L");
			
			$pdf->Ln(3);
			$pdf->Cell(5);


			//Firma
			//////////////
		} //fin firma y reemplazo
		//////////////
		//Informe
		$pdf->Ln(10);
		$pdf->SetFont('Arial','BU',12);
		$pdf->Cell(0,10,'HISTORIA CLINICA',0,0,'L');
		$pdf->Ln(8);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'Antecedentes Personales',0,0,'L');
		$pdf->Ln(8);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($antecedentesPersonales));

		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Antecedentes Mórbidos (incluye antecedentes psiquiátricos)'),0,0,'L');
		$pdf->Ln(8);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($antecedentesMorbidos));

		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'Factores estresantes',0,0,'L');
		$pdf->Ln(8);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($factoresEstresantes));

		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'Anamnesis',0,0,'L');
		$pdf->Ln(8);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($anamnesis));

		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Exámen Mental'),0,0,'L');
		$pdf->Ln(8);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($examenMental));
		$pdf->Ln(2);
		$pdf->SetFont('Arial','BU',12);
		$pdf->Cell(0,10,'TRATAMIENTO ACTUAL',0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Tratamiento Actual (detallar fármacos y dosis)'),0,0,'L');
		$pdf->Ln(7);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($tratamientoActual));
		$pdf->Ln(3);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'Paciente Refiere Tratamiento en red GES');
		$pdf->Ln(7);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,$ttoRedGES);
		if ($ttoRedGES == 'si') {

			$pdf->Ln(3);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,'Lugar Tratamiento');
			$pdf->Ln(7);
			$pdf->SetFont('Arial','',10);
			$pdf->MultiCell(0,5,$lugarRedGES);
		}
		$pdf->Ln(5);

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,utf8_decode('Opinión Sobre Tratamiento Actual'),0,0,'L');
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode(ucfirst(strtolower($opinionTratamiento))));
		if($comentarios != '')//Si hay comentarios, los agrego al final
		{
			$pdf->MultiCell(0,5,utf8_decode($comentarios));
		}
		$pdf->Ln(2);
		$pdf->SetFont('Arial','BU',12);
		$pdf->Cell(0,10,utf8_decode('DIAGNÓSTICO DE LICENCIA MÉDICA  N° ').$numeroLicencia,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Diagnóstico de Licencia Médica  N° ').$numeroLicencia,0,0,'L');
		$pdf->Ln(7);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($diagnosticoLicenciaMedica));

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,utf8_decode('Opinión Sobre el Diagnóstico de la Licencia Médica N° ').$numeroLicencia,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode(ucfirst(strtolower($opinionSobreDiagnostico))));
		if($comentariosDLM != '')//Si hay comentarios, los agrego al final
		{
			$pdf->MultiCell(0,5,utf8_decode($comentariosDLM));
		}

		$pdf->Ln(2);
		$pdf->SetFont('Arial','BU',12);
		$pdf->Cell(0,10,utf8_decode('HIPÓTESIS DIAGNÓSTICA'),0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'Eje I',0,0,'L');
		$pdf->Ln(7);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($eje1));
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,'Eje II',0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($eje2));
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,'Eje III',0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($eje3));
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,'Eje IV',0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($eje4));
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,'Eje V',0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($eje5));

		$pdf->Ln(2);
		$pdf->SetFont('Arial','BU',12);
		$pdf->Cell(0,10,utf8_decode('CONCLUSIÓN SOBRE REPOSO MÉDICO'),0,0,'L');

		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Días acumulados de reposo a la fecha de hoy día (incluye licencia médica N° ').$numeroLicencia.')',0,0,'L');
		$pdf->Ln(7);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,$diasAcumulados);


		// si es paciente de cruz blanca no mostrar estos campos
		//fecha de inicio
		//dias de reposo indicados
		//corresponde reposo
		//solicitado por dra. Mgalvez 08/10/2014

		if ($codisapre != 3  ){
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,5,utf8_decode('Fecha de inicio de licencia N° ').$numeroLicencia,0,0,'L');
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',10);
			$pdf->MultiCell(0,5,$fechaInicioUL);

			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,5,utf8_decode('Días de reposo indicados en licencia N° ').$numeroLicencia,0,0,'L');
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',10);
			$pdf->MultiCell(0,5,$diasReposoIndicados);

			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,5,utf8_decode('Respecto a licencia  N° ').$numeroLicencia.utf8_decode(', corresponde reposo'),0,0,'L');
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',10);
			$pdf->MultiCell(0,5,utf8_decode(ucfirst(strtolower($fraseCorrespondeReposo))));
			/// fin
		}

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,utf8_decode('Conclusión respecto del reintegro laboral al examen actual del paciente'),0,0,'L');
		if($pronosticoReintegro != '')
		{
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',10);
			$pdf->MultiCell(0,5,utf8_decode($fraseReintegro));
		}
		else
		{
			$pdf->Ln(5);
		}
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($comentarios2));
		// sacar para cruz blanca , no hay informacion de cuando se habilita para el resto
		if ($codisapre != 3  ){
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,5,utf8_decode('Enfermedad Laboral'),0,0,'L');
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',10);
			$pdf->MultiCell(0,5,$enfermedadlaboral);
		}


		//Informe
		//////////////


		if($tipoSalida == 'I')
		{
			$pdf->Output(str_replace(' ', '_', elimina_acentos($nombreCompletoPaciente)).'.pdf', 'I');
		}
		elseif($tipoSalida == 'F')
		{
			$rutsinformato=	(int)rutPaciente($idPaciente, $conectar);
			$digito = (string)DigitoVerificador($rutsinformato);
			$separador='_';
			$archivo = $rutsinformato.'-'.$digito.$hora.'.pdf' ;
			$carpeta ='/agendadesa/informesRespaldo/';
			$ruta= ($_SERVER['DOCUMENT_ROOT'].$carpeta);
			//echo $carpeta.$archivo;
			//$pdf->Output('$ruta.$archivo', 'F');
			$filepdf=$ruta.$archivo ;
			$pdf->Output('../../../informesRespaldo/'.$archivo, 'F');
			return $filepdf ;
		}





	}


	function crearInformeLaboral($idHora, $tipoSalida, $carpetaSalida, $conectar)
	{


		$sqlDatos = mysql_query("
	SELECT
		i.`id`,
		i.`paciente`,
		`f_html_encode`(`f_ciudadhora`(i.`hora`)) AS ciudad,
		i.`prestador`,
		i.`hora`,
		DATEDIFF(i.`fecha`, '2011-10-19') AS diferenciaFecha,
		i.`fecha`,
		i.`ocupacion`,
		i.`sexo`,
		i.`edad`,
		i.`tiempoLicencia`,
    	i.`medicoTratante`,
		i.`nombreMedicoTratante`,
		i.`numeroLicencia`,
		i.`antecedentesPersonales`,
		i.`antecedentesMorbidos`,
		i.`factoresEstresantes`,
		i.`existeEstresLaboral`,
		i.`evaluacionEspecifica`,
		i.`anamnesis`,
		i.`examenMental`,
		i.`tratamientoActual`,
		i.`opinionTratamiento`,
		i.`comentarios`,
		i.`diagnosticoLicenciaMedica`,
		i.`opinionSobreDiagnostico`,
		i.`comentariosDLM`,
		i.`eje1`,
		i.`eje2`,
		i.`eje3`,
		i.`eje4`,
		i.`eje5`,
		i.`diasAcumulados`,
		i.`fechaInicioUL`,
		i.`diasReposoIndicados`,
		i.`correspondeReposo`,
		i.`periodo`,
		i.`pronosticoReintegro`,
		i.`diasPronostico`,
		i.`comentarios2`,
        i.`ttoRedGES`,
		i.`lugarRedGES`,
		i.`enfermedadlaboral`
	FROM 	informe_entrevista i
	WHERE  i.`hora`=".$idHora." 	", $conectar);
		$rowDatos = mysql_fetch_array($sqlDatos);
		$hora = $rowDatos['hora'];
		$codisapre = isapreHora($hora, $conectar) ;
		$isapre = nombreIsapre(isapreHora($hora, $conectar), $conectar);
		$idPaciente = $rowDatos['paciente'];
		$idPrestador = $rowDatos['prestador'];
		$diferenciaFecha = $rowDatos['diferenciaFecha'];
		$fecha = fechaFormateadaHora($hora, $conectar);
		$ocupacion = $rowDatos['ocupacion'];
		$sexo = $rowDatos['sexo'];
		$edad = $rowDatos['edad'];
		$tiempoLicencia = $rowDatos['tiempoLicencia'];
		$medicoTratante = utf8_decode(caracteres_html_inversa($rowDatos['medicoTratante']));
		$nombreMedicoTratante = utf8_decode(caracteres_html_inversa($rowDatos['nombreMedicoTratante']));
		$numeroLicencia = $rowDatos['numeroLicencia'];
		$antecedentesPersonales = caracteres_html_inversa($rowDatos['antecedentesPersonales']);
		$antecedentesMorbidos = caracteres_html_inversa($rowDatos['antecedentesMorbidos']);
		$factoresEstresantes = caracteres_html_inversa($rowDatos['factoresEstresantes']);
		$anamnesis = caracteres_html_inversa($rowDatos['anamnesis']);
		$examenMental = caracteres_html_inversa($rowDatos['examenMental']);
		$tratamientoActual = caracteres_html_inversa($rowDatos['tratamientoActual']);
		$opinionTratamiento = caracteres_html_inversa($rowDatos['opinionTratamiento']);
		$comentarios = caracteres_html_inversa($rowDatos['comentarios']);
		$diagnosticoLicenciaMedica = caracteres_html_inversa($rowDatos['diagnosticoLicenciaMedica']);
		$opinionSobreDiagnostico = caracteres_html_inversa($rowDatos['opinionSobreDiagnostico']);
		$comentariosDLM = caracteres_html_inversa($rowDatos['comentariosDLM']);
		$eje1 = caracteres_html_inversa($rowDatos['eje1']);
		$eje2 = caracteres_html_inversa($rowDatos['eje2']);
		$eje3 = caracteres_html_inversa($rowDatos['eje3']);
		$eje4 = caracteres_html_inversa($rowDatos['eje4']);
		$eje5 = caracteres_html_inversa($rowDatos['eje5']);
		$ttoRedGES = $rowDatos['ttoRedGES'];
		$lugarRedGES = $rowDatos['lugarRedGES'] ;


		$diasAcumulados = $rowDatos['diasAcumulados'];
		if($diasAcumulados == 0)
		{
			$diasAcumulados = 'No se dispone de esta información';
		}
		$fechaInicioUL = VueltaFecha($rowDatos['fechaInicioUL']);
		if($fechaInicioUL == '00-00-0000')
		{
			$fechaInicioUL = "No se dispone de esta información";
		}
		$diasReposoIndicados = $rowDatos['diasReposoIndicados'];
		if($diasReposoIndicados == 0)
		{
			$diasReposoIndicados = 'No se dispone de esta información';
		}
		$correspondeReposo = $rowDatos['correspondeReposo'];
		if($correspondeReposo == 'SI')
		{
			$periodo = $rowDatos['periodo'];
			if($periodo == 'COMPLETO')
			{
				$fraseCorrespondeReposo = 'SI, POR UN PER�?ODO COMPLETO';
			}
			else
			{
				$fraseCorrespondeReposo = 'SI, POR UN PER�?ODO REDUCIDO';
			}
		}
		if($correspondeReposo == 'NO'){
			$fraseCorrespondeReposo = 'NO';
		}
		if($correspondeReposo == ''){
			$fraseCorrespondeReposo = '';
		}



		//REINTEGRO
		$pronosticoReintegro = $rowDatos['pronosticoReintegro'];
		if($pronosticoReintegro != '')
		{
			if($pronosticoReintegro == 'CON UN TRATAMIENTO ADECUADO PACIENTE EN CONDICIONES DE REINTEGRARSE EN [ ] DIAS A SU ACTIVIDAD LABORAL')
			{
				$diasPronostico = $rowDatos['diasPronostico'];
				$fraseReintegro = 'CON UN TRATAMIENTO ADECUADO PACIENTE EN CONDICIONES DE REINTEGRARSE EN '.$diasPronostico.' DIAS A SU ACTIVIDAD LABORAL';
			}
			else
			{
				$fraseReintegro = $pronosticoReintegro;
			}
		}
		$comentarios2 = caracteres_html_inversa($rowDatos['comentarios2']);
		$enfermedadlaboral=$rowDatos['enfermedadlaboral'] ;
		$nombreCompletoPaciente = caracteres_html_inversa(nombreCompletoPaciente($idPaciente, $conectar));
		$rutPaciente = rutPaciente($idPaciente, $conectar);
		$dvPaciente = DigitoVerificador($rutPaciente);
		$rutPaciente = PonerPunto($rutPaciente).'-'.$dvPaciente;
		$direccion = direccionPaciente($idPaciente, $conectar);
		$comuna = caracteres_html_inversa(retornaComuna(idComunaPaciente($idPaciente, $conectar), $conectar));
		$ciudad = strtoupper($rowDatos['ciudad']);
		$nombreCompletoPrestador = caracteres_html_inversa(nombreCompletoPrestador ($idPrestador, $conectar));
		$rutPrestador = rutPrestador ($idPrestador, $conectar);
		$dvPrestador = DigitoVerificador($rutPrestador);
		$rutPrestador = PonerPunto($rutPrestador).'-'.$dvPrestador;

///////////////////////////////////////////////////////////////////////////////
//PDF
		class PDF extends FPDF
		{
			//Pie de página
			function Footer()
			{
				//Posición: a 1,5 cm del final
				$this->SetY(-20);
				//Arial italic 8
				$this->SetFont('Arial','',5);
				//Número de página
				$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
				$this->Ln(8);
				$this->MultiCell(0,5,utf8_decode('Copyright © 2010 Cetep, Centro de Estudio y Tratamiento de Enfermedades Psiquiátricas Ltda. Prohibida la reproducción total o parcial, sin autorización escrita de Cetep. Para ordenar copias o solicitar permiso de reproducción, por favor contáctese por teléfono (56-2) 7840831, por e-mail: contacto@cetep.cl, o bien escriba a Soria 626, Las Condes, Santiago - Chile.'), 1);
//			$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
//			$this->Ln(15);
//			$this->Cell(0,10,'Página hola',0,0,'C');
			}


		var $angle = 0;

		function Rotate($angle, $x = -1, $y = -1)
		{
			if ($x == -1)
				$x = $this->x;
			if ($y == -1)
				$y = $this->y;
			if ($this->angle != 0)
				$this->_out('Q');
			$this->angle = $angle;
			if ($angle != 0) {
				$angle *= M_PI / 180;
				$c = cos($angle);
				$s = sin($angle);
				$cx = $x * $this->k;
				$cy = ($this->h - $y) * $this->k;
				$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
			}
		}
		function RotatedText($x, $y, $txt, $angle)
		{
			//Text rotated around its origin
			$this->Rotate($angle, $x, $y);
			$this->Text($x, $y, $txt);
			$this->Rotate(0);
		}

		function _endpage()
		{
			if ($this->angle != 0) {
				$this->angle = 0;
				$this->_out('Q');
			}
			parent::_endpage();
		}
		function Header()
		{
			//Put the watermark
			$this->SetFont('Arial', 'B', 15);
			$this->SetTextColor(255, 192, 203);
			$this->RotatedText(100, 120, utf8_decode('Comité Evaluador') , 0);
			$this->RotatedText(100, 124, utf8_decode('Peritajes Laborales') , 0);

		}

	}


	//Creación del objeto de la clase heredada
		$pdf=new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->Image("../../templates/defecto/imagenes/logoDocumentos.jpg",20,8,18);
		$pdf->Ln();

		$pdf->SetFont('Arial','B',12);
		//Movernos a la derecha
		$pdf->Cell(80);
		$pdf->Cell(160,10,'Peritaje Realizado en '.ucfirst(strtolower($ciudad)),0,0,'C');
		$pdf->Ln(15);
		//Título
		$pdf->SetFont('Arial','B',15);
		$pdf->Cell(80);
		$pdf->Cell(30,10,utf8_decode('Informe de Entrevista Psiquiátrica de Peritaje'),0,0,'C');
		$pdf->Ln(10);
		//////////////
		//Datos paciente
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'Fecha: ',0,0,'L');
		$pdf->Cell(10,10,VueltaFecha($fecha),0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'Nombre: ',0,0,'L');
		$pdf->Cell(10,10,$nombreCompletoPaciente,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'RUT: ',0,0,'L');
		$pdf->Cell(10,10,$rutPaciente,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'Seguro de salud: ',0,0,'L');
		$pdf->Cell(10,10,$isapre,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,utf8_decode('Ocupación: '),0,0,'L');
		$pdf->Cell(10,10,ucfirst(strtolower($ocupacion)),0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'Sexo: ',0,0,'L');
		$pdf->Cell(10,10,$sexo,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'Edad: ',0,0,'L');
		$pdf->Cell(10,10,$edad,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,utf8_decode('Dirección: '),0,0,'L');
		$pdf->Cell(10,10,$direccion,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'Comuna: ',0,0,'L');
		$pdf->Cell(10,10,ucwords(strtolower($comuna)),0,0,'L');
		//Si es región no se muestra la ciudad
		//
		/*	if(siEsRegion(ciudadHora($hora, $conectar), $conectar) == 'no')
			{
				$pdf->Ln(5);
				$pdf->Cell(1);
				$pdf->Cell(40,10,'Ciudad: ',0,0,'L');
				$pdf->Cell(10,10,ucfirst(strtolower($ciudad)),0,0,'L');
			}*/
		//
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,utf8_decode('Médico tratante: '),0,0,'L');
		$pdf->Cell(10,10,ucfirst(strtolower($medicoTratante)),0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'N. Med. tratante: ',0,0,'L');
		$pdf->Cell(10,10,$nombreMedicoTratante,0,0,'L');
		if($numeroLicencia != 0)
		{
			$pdf->Ln(5);
			$pdf->Cell(1);
			$pdf->Cell(40,10,'N. Licencia: ',0,0,'L');
			$pdf->Cell(10,10,$numeroLicencia,0,0,'L');
		}

		//Datos paciente
		//////////////
		//////////////
		//Firma

			$nombreImagen = $idPrestador.'.jpg';

			if(file_exists('../../templates/defecto/imagenes/firmas/'.$nombreImagen) == true)
			{
				//redimensionar_jpeg('../../templates/defecto/imagenes/firmas/'.$nombreImagen, '../../templates/defecto/imagenes/firmas/'.$nombreImagen, 250, 120, 100);
				$pdf->Image("../../templates/defecto/imagenes/firmas/$nombreImagen", 0, 100, 0);

			}
			else
			{
				$pdf->Ln(40);
			}

			$pdf->Ln(50);
			$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",10, 140, 0);

			//Cambio de firma a Dra. Ortiz
			if($diferenciaFecha >= 0)
			{

				$supervisor = 32; //Dra Ortiz
				$nombreSupervisor = 'Dra. Vilma Ortiz';
			}
			else
			{
				$supervisor = 10;
				$nombreSupervisor = 'Dr. Juan Pablo Osorio';
			}

			//Si NO es Osorio muestro la firma
			if($idPrestador != $supervisor)
			{
				$pdf->Image("../../templates/defecto/imagenes/firmas/".$supervisor.".jpg", 110, 98, 0);
				$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
			}
			$pdf->Ln(1);
			$pdf->Cell(5);
			$pdf->SetFont('Arial','',10);
			//Si NO es Osorio muestro la firma
			if($idPrestador != $supervisor)
			{
				$pdf->Image("../../templates/defecto/imagenes/"."logoDocumentos.jpg", 110, 98, 0);
				$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
			}
			$pdf->Ln(1);
			$pdf->Cell(5);
			$pdf->SetFont('Arial','',10);

			if($idPrestador != $supervisor)
			{
				$pdf->Cell(5,5,'Dr(a). '.$nombreCompletoPrestador.'                                                               '.$nombreSupervisor,0,0,"L");
			}
			else
			{
				$pdf->Ln(4);
				$pdf->Cell(5);
				$pdf->Cell(5,5,'Dr(a). '.$nombreCompletoPrestador.'',0,0,"L");
				$pdf->Ln(4);
				$pdf->Cell(5);
				$pdf->Cell(5,5,utf8_decode('Médico Psiquiátra'),0,0,"L");
			}
			$pdf->Ln(3);
			$pdf->Cell(5);
			if($idPrestador != $supervisor)
			{
				$pdf->Cell(5,5,utf8_decode('Médico Psiquiátra                                                                                 Supervisor Técnico de Peritajes'),0,0,"L");
			}

			//Firma
			//////////////
		 //fin firma y reemplazo
		//////////////
		//Informe
		$pdf->Ln(10);
		$pdf->SetFont('Arial','BU',12);
		$pdf->Cell(0,10,'HISTORIA CLINICA',0,0,'L');
		$pdf->Ln(8);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'Antecedentes Personales',0,0,'L');
		$pdf->Ln(8);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($antecedentesPersonales));

		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Antecedentes Mórbidos (incluye antecedentes psiquiátricos)'),0,0,'L');
		$pdf->Ln(8);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($antecedentesMorbidos));

		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'Factores estresantes',0,0,'L');
		$pdf->Ln(8);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($factoresEstresantes));

		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'Anamnesis',0,0,'L');
		$pdf->Ln(8);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($anamnesis));

		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Exámen Mental'),0,0,'L');
		$pdf->Ln(8);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($examenMental));
		$pdf->Ln(2);
		$pdf->SetFont('Arial','BU',12);
		$pdf->Cell(0,10,'TRATAMIENTO ACTUAL',0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Tratamiento Actual (detallar fármacos y dosis)'),0,0,'L');
		$pdf->Ln(7);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($tratamientoActual));
		$pdf->Ln(3);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'Paciente Refiere Tratamiento en red GES');
		$pdf->Ln(7);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,$ttoRedGES);
		if ($ttoRedGES == 'si') {

			$pdf->Ln(3);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,'Lugar Tratamiento');
			$pdf->Ln(7);
			$pdf->SetFont('Arial','',10);
			$pdf->MultiCell(0,5,$lugarRedGES);
		}
		$pdf->Ln(5);

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,utf8_decode('Opinión Sobre Tratamiento Actual'),0,0,'L');
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode(ucfirst(strtolower($opinionTratamiento))));
		if($comentarios != '')//Si hay comentarios, los agrego al final
		{
			$pdf->MultiCell(0,5,utf8_decode($comentarios));
		}
		$pdf->Ln(2);
		$pdf->SetFont('Arial','BU',12);
		$pdf->Cell(0,10,utf8_decode('DIAGNÓSTICO DE LICENCIA MÉDICA  N° ').$numeroLicencia,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Diagnóstico de Licencia Médica  N° ').$numeroLicencia,0,0,'L');
		$pdf->Ln(7);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($diagnosticoLicenciaMedica));

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,utf8_decode('Opinión Sobre el Diagnóstico de la Licencia Médica N° ').$numeroLicencia,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode(ucfirst(strtolower($opinionSobreDiagnostico))));
		if($comentariosDLM != '')//Si hay comentarios, los agrego al final
		{
			$pdf->MultiCell(0,5,utf8_decode($comentariosDLM));
		}

		$pdf->Ln(2);
		$pdf->SetFont('Arial','BU',12);
		$pdf->Cell(0,10,utf8_decode('HIPÓTESIS DIAGNÓSTICA'),0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'Eje I',0,0,'L');
		$pdf->Ln(7);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($eje1));
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,'Eje II',0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($eje2));
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,'Eje III',0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($eje3));
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,'Eje IV',0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($eje4));
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,'Eje V',0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($eje5));

		$pdf->Ln(2);
		$pdf->SetFont('Arial','BU',12);
		$pdf->Cell(0,10,utf8_decode('CONCLUSIÓN SOBRE REPOSO MÉDICO'),0,0,'L');

		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Días acumulados de reposo a la fecha de hoy día (incluye licencia médica N° ').$numeroLicencia.')',0,0,'L');
		$pdf->Ln(7);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,$diasAcumulados);


		// si es paciente de cruz blanca no mostrar estos campos
		//fecha de inicio
		//dias de reposo indicados
		//corresponde reposo
		//solicitado por dra. Mgalvez 08/10/2014

		if ($codisapre != 3  ){
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,5,utf8_decode('Fecha de inicio de licencia N° ').$numeroLicencia,0,0,'L');
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',10);
			$pdf->MultiCell(0,5,$fechaInicioUL);

			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,5,utf8_decode('Días de reposo indicados en licencia N° ').$numeroLicencia,0,0,'L');
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',10);
			$pdf->MultiCell(0,5,$diasReposoIndicados);

			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,5,utf8_decode('Respecto a licencia  N° ').$numeroLicencia.utf8_decode(', corresponde reposo'),0,0,'L');
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',10);
			$pdf->MultiCell(0,5,utf8_decode(ucfirst(strtolower($fraseCorrespondeReposo))));
			/// fin
		}

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,utf8_decode('Conclusión respecto del reintegro laboral al examen actual del paciente'),0,0,'L');
		if($pronosticoReintegro != '')
		{
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',10);
			$pdf->MultiCell(0,5,utf8_decode($fraseReintegro));
		}
		else
		{
			$pdf->Ln(5);
		}
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($comentarios2));
		// sacar para cruz blanca , no hay informacion de cuando se habilita para el resto
		if ($codisapre != 3  ){
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,5,utf8_decode('Enfermedad Laboral'),0,0,'L');
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',10);
			$pdf->MultiCell(0,5,$enfermedadlaboral);
		}


		//Informe
		//////////////


		if($tipoSalida == 'I')
		{
			$pdf->Output(str_replace(' ', '_', elimina_acentos($nombreCompletoPaciente)).'.pdf', 'I');
		}
		elseif($tipoSalida == 'F')
		{
			$rutsinformato=	(int)rutPaciente($idPaciente, $conectar);
			$digito = (string)DigitoVerificador($rutsinformato);
			$separador='_';
			$archivo = $rutsinformato.'-'.$digito.$hora.'.pdf' ;
			$carpeta ='/agendadesa/informesRespaldo/';
			$ruta= ($_SERVER['DOCUMENT_ROOT'].$carpeta);
			//echo $carpeta.$archivo;
			//$pdf->Output('$ruta.$archivo', 'F');
			$filepdf=$ruta.$archivo ;
			$pdf->Output('../../../informesRespaldo/'.$archivo, 'F');
			return $filepdf ;
		}





	}

	function importarInformeExcel ($file,$rutpaciente ,$fechacitacion, $ocupacion , $sexo , $edad , $medicotratante , $nombremedicotratante , $foliolicencia , $antecedentesPersonales , $antecedentesMorbidos , $factoresEstresantes , $anamnesis , $examenMental , $tratamientoActual, $opinionTratamiento , $comentarios, $diagnosticoLicenciaMedica , $opinionSobreDiagnostico ,$comentariosDLM,$eje1 , $eje2 , $eje3 , $eje4, $eje5 , $comentarios2 , $diasAcumulados, $fechaInicioUL , $diasReposoIndicados , $correspondeReposo ,$periodo , $ttoRedGes,$lugarRedGes ,$enfermedadlaboral,$conn){

		$query = "INSERT INTO uploadInforme_entrevista (
													    	archivo,
														  rut,
														  fecha,
														  ocupacion,
														  sexo,
														  edad,
														  medicoTratante,
														  nombreMedicoTratante,
														  numeroLicencia,
														  antecedentesPersonales,
														  antecedentesMorbidos,
														  factoresEstresantes,
														  anamnesis,
														  examenMental,
														  tratamientoActual,
														  opinionTratamiento,
														  comentarios,
														  diagnosticoLicenciaMedica,
														  opinionSobreDiagnostico,
														  comentariosDLM,
														  eje1,
														  eje2,
														  eje3,
														  eje4,
														  eje5,
														  comentarios2,
														  diasAcumulados,
														  fechaInicioUL,
														  diasReposoIndicados,
														  correspondeReposo,
														  periodo,
														  ttoRedGes,
														  lugarRedGes,
														  enfermedadlaboral
														)VALUES ('" . $file . "','" . $rutpaciente . "','" . $fechacitacion . "','" . $ocupacion . "','" . $sexo . "','" . $edad . "','" . $medicotratante . "','" . $nombremedicotratante . "','" . $foliolicencia . "', '" . $antecedentesPersonales . "','" . $antecedentesMorbidos . "','" . $factoresEstresantes . "','" . $anamnesis . "','" . $examenMental . "','" . $tratamientoActual . "', '" . $opinionTratamiento . "','" . $comentarios . "','" . $diagnosticoLicenciaMedica . "' ,'" . $opinionSobreDiagnostico . "','" . $comentariosDLM . "','" . $eje1 . "','" . $eje2 . "','" . $eje3 . "','" . $eje4 . "','" . $eje5 . "','" . $comentarios2 . "','" . $diasAcumulados . "','" . $fechaInicioUL . "','" . $diasReposoIndicados . "','" . $correspondeReposo . "','" . $periodo . "','" . $ttoRedGes . "','" . $lugarRedGes . "','" . $enfermedadlaboral . "' ) ";

		$result = mysql_query($query, $conn);
		//$dbo->query($query) ;
		$sqlupdate = "UPDATE uploadInforme_entrevista SET prestador =f_peritoxrut(SUBSTR(archivo,25,8),1) ,
						paciente= f_datospacientesxid(rut,1) ,
						hora =f_idhorapaciente(paciente,prestador,fecha,SUBSTR(archivo,36,2)) ,
						ciudad = SUBSTR(archivo,36,2) where archivo = '$file' ";

		$resultupdate = mysql_query($sqlupdate, $conn);

	}

function traspasoDatosexcel($idhora,$conn){
	$sqlinsertinforme = "INSERT INTO informe_entrevista (
						  confirmado,
						  paciente,
						  prestador,
						  hora,
						  fecha,
						  ocupacion,
						  sexo,
						  edad,
						  medicoTratante,
						  nombreMedicoTratante,
						  numeroLicencia,
						  antecedentesPersonales,
						  antecedentesMorbidos,
						  factoresEstresantes,
						  anamnesis,
						  examenMental,
						  tratamientoActual,
						  opinionTratamiento,
						  comentarios,
						  diagnosticoLicenciaMedica,
						  opinionSobreDiagnostico,
						  comentariosDLM,
						  eje1,
						  eje2,
						  eje3,
						  eje4,
						  eje5,
						  opinionReposoMedico,
						  siReposoCorresponde,
						  cuantosDiasReposo,
						  comentarios2,
						  diasAcumulados,
						  fechaInicioUL,
						  diasReposoIndicados,
						  correspondeReposo,
						  periodo,
						  diasPeriodo,
						  pronosticoReintegro,
						  diasPronostico,
						  publicado,
						  ttoRedGes,
						  lugarRedGes,
						  enfermedadlaboral
						)
						SELECT
						  confirmado,
						  paciente,
						  prestador,
						  hora,
						  fecha,
						  ocupacion,
						  sexo,
						  edad,
						  medicoTratante,
						  nombreMedicoTratante,
						  numeroLicencia,
						  antecedentesPersonales,
						  antecedentesMorbidos,
						  factoresEstresantes,
						  anamnesis,
						  examenMental,
						  tratamientoActual,
						  opinionTratamiento,
						  comentarios,
						  diagnosticoLicenciaMedica,
						  opinionSobreDiagnostico,
						  comentariosDLM,
						  eje1,
						  eje2,
						  eje3,
						  eje4,
						  eje5,
						  opinionReposoMedico,
						  siReposoCorresponde,
						  cuantosDiasReposo,
						  comentarios2,
						  diasAcumulados,
						  fechaInicioUL,
						  diasReposoIndicados,
						  correspondeReposo,
						  periodo,
						  diasPeriodo,
						  pronosticoReintegro,
						  diasPronostico,
						  publicado,
						  ttoRedGes,
						  lugarRedGes,
						  enfermedadlaboral
						FROM
						   uploadInforme_entrevista
						WHERE hora = '" . $idhora . "'	";
	$resultinsertinforme = mysql_query($sqlinsertinforme, $conn);



}
	
function InformePublicado($hora, $conectar)
{
	$sql = mysql_query("SELECT
		e.`fechaPublicacion`
	FROM
		informe_entrevista e
	WHERE
		e.hora=$hora
	", $conectar);
	$row = mysql_fetch_array($sql);
	$existe =existeInformeEntrevista2($hora, $conectar);
	if ($existe > 0)
	{
		return  $row['fechaPublicacion'];
	}else {

			return  '0000-00-00' ;


	}
}
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
//CREAR INFORME NUEVO
//Crea el informe NUEVO
function crearInformeNuevoTrauma($idHora, $tipoSalida, $carpetaSalida)
{	
	$sqlDatos = "
	SELECT 
		i.`id`, 
		i.`paciente`, 
		SUBSTR(`f_html_encode`(`f_ciudadhora`(i.`hora`)),1,8) AS ciudad,
       `f_datospaciente`(i.`paciente`,3) AS nombrepaciente,		

		i.`prestador`, 
		i.`hora`,
		DATEDIFF(i.`fecha`, '2011-10-19') AS diferenciaFecha,		`f_datospaciente`(i.`paciente`,2) AS nombre_paciente,		
		i.`fecha`, 
		i.`ocupacion`, 
		i.`sexo`, 
		i.`edad`, 
    	i.`medicoTratante`,
		i.`nombreMedicoTratante`, 
		i.`numeroLicencia`, 
		i.`antecedentesPersonales`, 
		i.`antecedentesMedicos`,
		i.`antecedentestraumatologicos`,
		i.`anamnesis`,
		i.`rxexamenlaboratorio`,
		i.`examenfisico`,
		i.`enfermedadlaboral`,
    	i.`tratamientoActual`,
	    i.`ttopendiente`,
        i.`ttosugerido`,
		i.`diagnosticoLicenciaMedica`,
	    i.`diagnosticoTMT`,
	    i.`diagnosticoconcomitantes`,
        i.`gradolimitacionfuncional`,
        i.`opinionSobreDiagnostico`,
		i.`comentariosDLM`, 
		i.`diasAcumulados`,
		i.`fechaInicioUL`, 
		i.`diasReposoIndicados`, 
		i.`correspondeReposo`, 
		i.`periodo`, 
		i.`comentarios2`,
        i.`ttoRedGES`,
		i.`lugarRedGES`
	FROM 	informe_traumatologico i
	WHERE  i.`hora`=".$idHora;
        
        $db = getConnection();
        $stmt = $db->prepare($sqlDatos);
        $stmt->execute();
        $rowDatos = $stmt->fetch(PDO::FETCH_ASSOC);
        
	//$rowDatos = mysql_fetch_array($sqlDatos);
	$hora = $rowDatos['hora'];
        
        $codisapre = 4; 
        
        
        die($codisapre);
        die('aca');
        
	$isapre = 'Colmena';
	$idPaciente = $rowDatos['paciente'];
	$nombrepaciente =utf8_decode(caracteres_html_inversa($rowDatos['nombrepaciente']));
	$idPrestador = $rowDatos['prestador'];
	$diferenciaFecha = $rowDatos['diferenciaFecha'];
	$fecha = fechaFormateadaHora($hora, $conectar);
	$ocupacion = $rowDatos['ocupacion'];
	$sexo = $rowDatos['sexo'];
	$edad = $rowDatos['edad'];
	$medicoTratante = utf8_decode(caracteres_html_inversa($rowDatos['medicoTratante']));
	$nombreMedicoTratante = utf8_decode(caracteres_html_inversa($rowDatos['nombreMedicoTratante']));
	$numeroLicencia = $rowDatos['numeroLicencia'];
	$antecedentesPersonales = caracteres_html_inversa($rowDatos['antecedentesPersonales']);
	$antecedentesMedicos = caracteres_html_inversa($rowDatos['antecedentesMedicos']);
	$antecedentestraumatologicos= caracteres_html_inversa($rowDatos['antecedentestraumatologicos']);

	$anamnesis = caracteres_html_inversa($rowDatos['anamnesis']);
	$rxexamenlaboratorio =caracteres_html_inversa($rowDatos['rxexamenlaboratorio']);
	$examenfisico = caracteres_html_inversa($rowDatos['examenfisico']);
	$enfermedadlaboral = caracteres_html_inversa($rowDatos['enfermedadlaboral']);
	$tratamientoActual = caracteres_html_inversa($rowDatos['tratamientoActual']);
	$ttopendiente =caracteres_html_inversa($rowDatos['ttopendiente']);
	$ttosugerido = caracteres_html_inversa($rowDatos['ttosugerido']);
	$diagnosticoLicenciaMedica = caracteres_html_inversa($rowDatos['diagnosticoLicenciaMedica']);
	$diagnosticoTMT = caracteres_html_inversa($rowDatos['diagnosticoTMT']);
	$diagnosticoconcomitantes = caracteres_html_inversa($rowDatos['diagnosticoconcomitantes']);
	$gradolimitacionfuncional =caracteres_html_inversa($rowDatos['gradolimitacionfuncional']);
	$opinionSobreDiagnostico = caracteres_html_inversa($rowDatos['opinionSobreDiagnostico']);

	$comentariosDLM = caracteres_html_inversa($rowDatos['comentariosDLM']);

    $ttoRedGES = $rowDatos['ttoRedGES'];
	$lugarRedGES = $rowDatos['lugarRedGES'] ;
        
        
	$diasAcumulados = $rowDatos['diasAcumulados'];
	if($diasAcumulados == 0)
	{
		$diasAcumulados = 'No se dispone de esta información';
	}
	$fechaInicioUL = VueltaFecha($rowDatos['fechaInicioUL']);
	if($fechaInicioUL == '00-00-0000')
	{
		$fechaInicioUL = "No se dispone de esta información";
	}
	$diasReposoIndicados = $rowDatos['diasReposoIndicados'];
	if($diasReposoIndicados == 0)
	{
		$diasReposoIndicados = 'No se dispone de esta información';
	}
	$correspondeReposo = $rowDatos['correspondeReposo'];
	if($correspondeReposo == 'SI')
	{
		$periodo = $rowDatos['periodo'];
		if($periodo == 'COMPLETO')
		{
			$fraseCorrespondeReposo = 'SI, POR UN PER�?ODO COMPLETO';
		}
		else
		{
			$fraseCorrespondeReposo = 'SI, POR UN PER�?ODO REDUCIDO';
		}
	}
	if($correspondeReposo == 'NO'){
		$fraseCorrespondeReposo = 'NO';
	}
	if($correspondeReposo == ''){
		$fraseCorrespondeReposo = '';
	}
		

	
	//REINTEGRO
	$pronosticoReintegro = $rowDatos['pronosticoReintegro'];
	if($pronosticoReintegro != '')
	{
		if($pronosticoReintegro == 'CON UN TRATAMIENTO ADECUADO PACIENTE EN CONDICIONES DE REINTEGRARSE EN [ ] DIAS A SU ACTIVIDAD LABORAL')
		{
			$diasPronostico = $rowDatos['diasPronostico'];
			$fraseReintegro = 'CON UN TRATAMIENTO ADECUADO PACIENTE EN CONDICIONES DE REINTEGRARSE EN '.$diasPronostico.' DIAS A SU ACTIVIDAD LABORAL';
		}
		else
		{
			$fraseReintegro = $pronosticoReintegro;
		}
	}
	$comentarios2 = caracteres_html_inversa($rowDatos['comentarios2']);            
	$nombreCompletoPaciente =$nombrepaciente ;
	$nombreCompletoPaciente = nombreCompletoPaciente($idPaciente, $conectar);
	//	$nombreCompletoPaciente = utf8_decode(caracteres_html_inversa(nombreCompletoPaciente($idPaciente, $conectar)));

	$rutPaciente = rutPaciente($idPaciente, $conectar);
	$dvPaciente = DigitoVerificador($rutPaciente);
	$rutPaciente = PonerPunto($rutPaciente).'-'.$dvPaciente;
	$direccion = direccionPaciente($idPaciente, $conectar);
	$comuna = caracteres_html_inversa(retornaComuna(idComunaPaciente($idPaciente, $conectar), $conectar));
     $ciudad = strtoupper($rowDatos['ciudad']);
     $nombreCompletoPrestador = caracteres_html_inversa(nombreCompletoPrestador ($idPrestador, $conectar));
	$rutPrestador = rutPrestador ($idPrestador, $conectar);
	$dvPrestador = DigitoVerificador($rutPrestador);
	$rutPrestador = PonerPunto($rutPrestador).'-'.$dvPrestador;
       
///////////////////////////////////////////////////////////////////////////////
//PDF
	class PDF extends FPDF
	{		
		//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-20);
			//Arial italic 8
			$this->SetFont('Arial','',5);
			//Número de página
			$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
			$this->Ln(8);
			$this->MultiCell(0,5,utf8_decode('Copyright © 2010 Cetep, Centro de Estudio y Tratamiento de Enfermedades Psiquiátricas Ltda. Prohibida la reproducción total o parcial, sin autorización escrita de Cetep. Para ordenar copias o solicitar permiso de reproducción, por favor contáctese por teléfono (56-2) 7840831, por e-mail: contacto@cetep.cl, o bien escriba a Soria 626, Las Condes, Santiago - Chile.'), 1);
//			$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
//			$this->Ln(15);
//			$this->Cell(0,10,'Página hola',0,0,'C');
		}
	}
	//Creación del objeto de la clase heredada
	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->Image("../../templates/defecto/imagenes/logoDocumentos.jpg",20,8,18);
	$pdf->Ln();
	$pdf->Image("../../templates/defecto/imagenes/iso_blanco.jpg",19,22,22);
	$pdf->SetFont('Arial','B',12);
	//Movernos a la derecha
	$pdf->Cell(80);
	$pdf->Cell(160,10,'Peritaje Realizado en '.ucfirst(strtolower($ciudad)),0,0,'C');
	$pdf->Ln(15);
	//Título
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(80);
	$pdf->Cell(30,10,utf8_decode('Informe de Entrevista Traumatológico de Peritaje'),0,0,'C');
	$pdf->Ln(10);
	//////////////
	//Datos paciente
     $pdf->SetFont('Arial','B',10);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Fecha: ',0,0,'L');
	$pdf->Cell(10,10,VueltaFecha($fecha),0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Nombre: ',0,0,'L');
	$pdf->Cell(10,10,caracteres_html_inversa($nombreCompletoPaciente,0,0,'L'));
//	$pdf->Cell(10,10,$nombrepaciente,0,0,'L');

	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'RUT: ',0,0,'L');
	$pdf->Cell(10,10,$rutPaciente,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Seguro de salud: ',0,0,'L');
	$pdf->Cell(10,10,$isapre,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,utf8_decode('Ocupación: '),0,0,'L');
	$pdf->Cell(10,10,ucfirst(strtolower($ocupacion)),0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Sexo: ',0,0,'L');
	$pdf->Cell(10,10,$sexo,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Edad: ',0,0,'L');
	$pdf->Cell(10,10,$edad,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,utf8_decode('Dirección: '),0,0,'L');
	$pdf->Cell(10,10,$direccion,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'Comuna: ',0,0,'L');
	$pdf->Cell(10,10,ucwords(strtolower($comuna)),0,0,'L');
	//Si es región no se muestra la ciudad
	//
/*	if(siEsRegion(ciudadHora($hora, $conectar), $conectar) == 'no')
	{
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'Ciudad: ',0,0,'L');
		$pdf->Cell(10,10,ucfirst(strtolower($ciudad)),0,0,'L');
	}*/	
	//
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,utf8_decode('Médico tratante: '),0,0,'L');
	$pdf->Cell(10,10,ucfirst(strtolower($medicoTratante)),0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->Cell(40,10,'N. Med. tratante: ',0,0,'L');
	$pdf->Cell(10,10,$nombreMedicoTratante,0,0,'L');
	if($numeroLicencia != 0)
	{
		$pdf->Ln(5);
		$pdf->Cell(1);
		$pdf->Cell(40,10,'N. Licencia: ',0,0,'L');
		$pdf->Cell(10,10,$numeroLicencia,0,0,'L');
	}
	
	//Datos paciente
	//////////////
	//////////////
	//Firma
	
if ($fecha >= '2014-08-15' )
{
	//reeemplazo supervisor
	
	$nombreImagen = $idPrestador.'.jpg';
	
	if(file_exists('../../templates/defecto/imagenes/firmas/'.$nombreImagen) == true)
	{
		redimensionar_jpeg('../../templates/defecto/imagenes/firmas/'.$nombreImagen, '../../templates/defecto/imagenes/firmas/'.$nombreImagen, 250, 120, 100);
		$pdf->Image("../../templates/defecto/imagenes/firmas/$nombreImagen", 0, 100, 0);
		
	}
	else
	{
		$pdf->Ln(40);
	}
	
	$pdf->Ln(50);
	$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",10, 140, 0);
	


	$pdf->Ln(1);
	$pdf->Cell(5);
	$pdf->SetFont('Arial','',10);
	//Si NO es Osorio muestro la firma

	$pdf->Ln(1);
	$pdf->Cell(5);
	$pdf->SetFont('Arial','',10);
	

		$pdf->Cell(5,5,'Dr(a). '.$nombreCompletoPrestador,0,0,"L");

		$pdf->Ln(4);

	$pdf->Ln(3);
	$pdf->Cell(5);

		$pdf->Cell(5,5,utf8_decode('Médico Traumatologo'),0,0,"L");

	
	//Firma
	//////////////
	
	//fin reemplazo vacaciones	
     }
		else
   	{	
	
	$nombreImagen = $idPrestador.'.jpg';
	
	if(file_exists('../../templates/defecto/imagenes/firmas/'.$nombreImagen) == true)
	{
		redimensionar_jpeg('../../templates/defecto/imagenes/firmas/'.$nombreImagen, '../../templates/defecto/imagenes/firmas/'.$nombreImagen, 250, 120, 100);
		$pdf->Image("../../templates/defecto/imagenes/firmas/$nombreImagen", 0, 100, 0);
		
	}
	else
	{
		$pdf->Ln(40);
	}
	
	$pdf->Ln(50);
	$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",10, 140, 0);
	
    //Si NO es Osorio muestro la firma
	/*if($idPrestador != $supervisor)
	{
	//	$pdf->Image("../../templates/defecto/imagenes/firmas/".$supervisor.".jpg", 110, 98, 0);
	//	$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
	}*/
	$pdf->Ln(1);
	$pdf->Cell(5);
	$pdf->SetFont('Arial','',10);
	//Si NO es Osorio muestro la firma
	/*if($idPrestador != $supervisor)
	{
		//$pdf->Image("../../templates/defecto/imagenes/firmas/".$supervisor.".jpg", 110, 98, 0);
	//	$pdf->Image("../../templates/defecto/imagenes/lineaFirma.gif",120, 140, 0);
	}*/
	$pdf->Ln(1);
	$pdf->Cell(5);
	$pdf->SetFont('Arial','',10);
	

		$pdf->Ln(4);
		$pdf->Cell(5);
		$pdf->Cell(5,5,'Dr(a). '.$nombreCompletoPrestador.'',0,0,"L");
		$pdf->Ln(4);
		$pdf->Cell(5);
		$pdf->Cell(5,5,utf8_decode('Médico Traumatólogo'),0,0,"L");

	$pdf->Ln(3);
	$pdf->Cell(5);

	
	//Firma
	//////////////
	} //fin firma y reemplazo
	//////////////
	//Informe
	$pdf->Ln(10);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,'HISTORIA CLINICA',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Antecedentes Personales',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($antecedentesPersonales));
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Antecedentes Medicos'),0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($antecedentesMedicos));
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Antecedentes Traumatólogicos'),0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($antecedentestraumatologicos));
		
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Anamnesis',0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($anamnesis));
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Origen Laboral');
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$enfermedadlaboral);
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Imagenes y Exámenes de Laboratorio'),0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($rxexamenlaboratorio));
	$pdf->Ln(2);
/*	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Imágenes y Examenes de Laboratorio:'),0,0,'L');
	$pdf->Ln(4);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode(ucfirst(strtolower($rxexamenlaboratorio))));
*/
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Examen Físico:'),0,0,'L');
	$pdf->Ln(4);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($examenfisico));

	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,'TRATAMIENTO ACTUAL',0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Tratamiento Actual (detallar fármacos y dosis)'),0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($tratamientoActual));
	$pdf->Ln(3);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Tratamiento Sugerido'),0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($ttosugerido));
	$pdf->Ln(3);

	    /*if ($ttoRedGES == 'si') {

    $pdf->Ln(3);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'Lugar Tratamiento');
	$pdf->Ln(7);
        $pdf->SetFont('Arial','',10);
        $pdf->MultiCell(0,5,$lugarRedGES);
		}*/



	$pdf->Ln(2);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,utf8_decode('DIAGNÓSTICO DE LICENCIA MÉDICA  N° ').$numeroLicencia,0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Diagnóstico de Licencia Médica  N° ').$numeroLicencia,0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($diagnosticoLicenciaMedica));
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Opinión Sobre el Diagnóstico de la Licencia Médica N° ').$numeroLicencia,0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($opinionSobreDiagnostico));
	if($comentariosDLM != '')//Si hay comentarios, los agrego al final
	{
		$pdf->MultiCell(0,5,utf8_decode($comentariosDLM));
	}
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,utf8_decode('HIPÓTESIS DIAGNÓSTICA'),0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Diagnóstico TMT'),0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($diagnosticoTMT ));
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Diagnóstico médico concomitantes'),0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($diagnosticoconcomitantes));
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Grado Limitación funcional'),0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($gradolimitacionfuncional));
	$pdf->SetFont('Arial','B',12);
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,utf8_decode('CONCLUSIÓN SOBRE REPOSO MÉDICO'),0,0,'L');
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('Días acumulados de reposo a la fecha de hoy día (incluye licencia médica N° ').$numeroLicencia.')',0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$diasAcumulados);
	
	
	// si es paciente de cruz blanca no mostrar estos campos
    //fecha de inicio
    //dias de reposo indicados
    //corresponde reposo
    //solicitado por dra. Mgalvez 08/10/2014

    if ($codisapre != 3  ){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Fecha de inicio de licencia N° ').$numeroLicencia,0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$fechaInicioUL);
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Días de reposo indicados en licencia N° ').$numeroLicencia,0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,$diasReposoIndicados);
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Respecto a licencia  N° ').$numeroLicencia.utf8_decode(', corresponde reposo'),0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode(ucfirst(strtolower($fraseCorrespondeReposo))));
	/// fin
    }

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Conclusión respecto del reintegro laboral al examen actual del paciente'),0,0,'L');
	if($pronosticoReintegro != '')
	{
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,5,utf8_decode($fraseReintegro));
	}
	else
	{
		$pdf->Ln(5);
	}
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($comentarios2));
     
	
	
	//Informe
	//////////////
	
	
	if($tipoSalida == 'I')
	{
		$pdf->Output(str_replace(' ', '_', elimina_acentos($nombreCompletoPaciente)).'.pdf', 'I');
	}
	elseif($tipoSalida == 'F')
	{
        $rutsinformato=	(int)rutPaciente($idPaciente, $conectar);
        $digito = (string)DigitoVerificador($rutsinformato);
        $separador='_';
        $archivo = $rutsinformato.'-'.$digito.$hora.'.pdf' ;
        $carpeta ='/agendadesa/informesRespaldo/';
        $ruta= ($_SERVER['DOCUMENT_ROOT'].$carpeta);
		//echo $carpeta.$archivo;
        //$pdf->Output('$ruta.$archivo', 'F');
        $filepdf=$ruta.$archivo ;
		$pdf->Output('../../../informesRespaldo/'.$archivo, 'F');
	    return $filepdf ;
    }else{
		$$nombreCompletoPaciente = caracteres_html_inversa(nombreCompletoPaciente($idPaciente, $conectar));
		$rutsinformato=	(int)rutPaciente($idPaciente, $conectar);
		$digito = (string)DigitoVerificador($rutsinformato);
		$separador='_';
		$archivo = $nombreCompletoPaciente.'-'.$rutsinformato.'-'.$digito.'.pdf' ;

		$carpeta ='/agendadesa/informesRespaldo/';

		$ruta= ($_SERVER['DOCUMENT_ROOT'].$carpeta);

		//echo $carpeta.$archivo;

		//$pdf->Output('$ruta.$archivo', 'F');

		$filepdf=$ruta.$archivo ;

		$pdf->Output($archivo, 'D');

		return $filepdf ;
	}

	
	
	
	
	
}
// Fin CREAR INFORME NUEVO
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////


?>