<?php
//modificado 09-01-2014
function datosInformeId($id, $conectar){
	$sql = mysql_query("
	SELECT 
		* 
	FROM 
		informe_traumatologico i
	WHERE 
		i.`id`=".$id, $conectar);
	return mysql_fetch_array($sql);
}
function datosInformeHora($hora, $conectar){
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

//function crearInformeEntrevistaNuevo($idPaciente, $idPrestador, $hora, $fecha, $ocupacion, $sexo, $edad, $tiempoLicencia, $medicoTratante, $nombreMedicoTratante, $numeroLicencia, $antecedentesPersonales, $antecedentesMorbidos, $factoresEstresantes, $existeEstresLaboral, $evaluacionEspecifica, $anamnesis, $examenMental, $tratamientoActual, $opinionTratamiento, $comentarios, $diagnosticoLicenciaMedica, $opinionSobreDiagnostico, $comentariosDLM, $eje1, $eje2, $eje3, $eje4, $eje5, $diasAcumulados, $fechaInicioUL, $diasReposoIndicados, $correspondeReposo, $periodo, $diasPeriodo, $pronosticoReintegro, $diasPronostico, $comentarios2,$ttoRedGes,$lugarRedGes,$enfermedadlaboral, $conectar)
function crearInformeEntrevistaNuevo($idPaciente,$idPrestador,$hora,$fecha,$ocupacion,$sexo,$edad,$medicoTratante,$nombreMedicoTratante,$numeroLicencia,$antecedentesPersonales,$antecedentesMedicos,$antecedentesTraumatologicos,$anamnesis,$rxexamenlaboratorio,$examenfisico,$tratamientoActual,$tratamientoPendiente,$tratamientoSugerido,$opinionTratamiento,$diagnosticoLicenciaMedica,$opinionSobreDiagnostico,$comentariosDLM,$diagnosticoTMT,$diagnosticoconcomitantes,$gradolimitacionfuncional,$comentarios2,$diasAcumulados,$fechaInicioUL,$diasReposoIndicados,$correspondeReposo,$periodo,$enfermedadLaboral,$conectar)

{
	$sql = "INSERT INTO informe_traumatologico
		(paciente,
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
  antecedentesMedicos,
  antecedentestraumatologicos,
  anamnesis,
  rxexamenlaboratorio,
  examenfisico,
  tratamientoActual,
  ttopendiente,
  ttosugerido,
  opinionTratamiento,
  diagnosticoLicenciaMedica,
  opinionSobreDiagnostico,
  comentariosDLM,
  diagnosticoTMT,
  diagnosticoconcomitantes,
  gradolimitacionfuncional,
  comentarios2,
  diasAcumulados,
  fechaInicioUL,
  diasReposoIndicados,
  correspondeReposo,
  periodo,
  enfermedadlaboral)
 VALUES
  (
  '".$idPaciente."',
  '".$idPrestador."',
  '".$hora."',
  '".$fecha."',
  '".$ocupacion."',
  '".$sexo."',
  '".$edad."',
  '".$medicoTratante."',
  '".$nombreMedicoTratante."',
  '".$numeroLicencia."',
  '".$antecedentesPersonales."',
  '".$antecedentesMedicos."',
  '".$antecedentesTraumatologicos."',
  '".$anamnesis."',
  '".$rxexamenlaboratorio."',
  '".$examenfisico."',
  '".$tratamientoActual."',
  '".$tratamientoPendiente."',
  '".$tratamientoSugerido."',
  '".$opinionTratamiento."',
  '".$diagnosticoLicenciaMedica."',
  '".$opinionSobreDiagnostico."',
  '".$comentariosDLM."',
  '".$diagnosticoTMT."',
  '".$diagnosticoconcomitantes."',
  '".$gradolimitacionfuncional."',
  '".$comentarios2."',
  '".$diasAcumulados."',
  '".$fechaInicioUL."',
  '".$diasReposoIndicados."',
  '".$correspondeReposo."',
  '".$periodo."',
  '".$enfermedadLaboral."'
  )";


    $result=mysql_query($sql,$conectar);

	if($result == false)
	{
		die('No se ingres&oacute; el informe');
	}	
}

function editarInformeEntrevistaNuevo($id, $idPaciente, $idPrestador,$hora,$fecha ,$ocupacion,$sexo,$edad,$medicoTratante,$nombreMedicoTratante,$numeroLicencia,$antecedentesPersonales,$antecedentesMedicos,$antecedentesTraumatologicos,$anamnesis,$rxexamenlaboratorio,$examenfisico,$enfermedadLaboral,$tratamientoActual,$tratamientoPendiente,$tratamientoSugerido,$opinionTratamiento,$diagnosticoLicenciaMedica,$opinionSobreDiagnostico,$comentariosDLM,$diasAcumulados,$diasReposoIndicados,$correspondeReposo,$periodo,$comentarios2,$diagnosticoTMT,$diagnosticoconcomitantes,$gradolimitacionfuncional,$fechaInicioUL,$conectar)
{
	$confirmado = 0;

	$sql ="
	UPDATE
		informe_traumatologico
	SET
		confirmado=".$confirmado.",
		paciente='".$idPaciente."',
		prestador='".$idPrestador."',
		hora='".$hora."',
		fecha='".$fecha."',
		ocupacion='".$ocupacion."',
		sexo='".$sexo."',
		edad='".$edad."',
		medicoTratante='".$medicoTratante."',
		nombreMedicoTratante='".$nombreMedicoTratante."',
		numeroLicencia='".$numeroLicencia."',
		antecedentesPersonales='".$antecedentesPersonales."',
		antecedentesMedicos='".$antecedentesMedicos."',
		antecedentestraumatologicos='".$antecedentesTraumatologicos."',
		anamnesis='".$anamnesis."',
  		rxexamenlaboratorio = '".$rxexamenlaboratorio."',
  		examenfisico = '".$examenfisico."',
	  	enfermedadlaboral = '".$enfermedadLaboral."',
	  	tratamientoActual = '".$tratamientoActual."',
  		ttopendiente = '".$tratamientoPendiente."',
  		ttosugerido = '".$tratamientoSugerido."',
  		opinionTratamiento = '".$opinionTratamiento."',
  		diagnosticoLicenciaMedica = '".$diagnosticoLicenciaMedica."',
  		opinionSobreDiagnostico ='".$opinionSobreDiagnostico."',
  		comentariosDLM = '".$comentariosDLM."',
  		diagnosticoTMT = '".$diagnosticoTMT."',
  		diagnosticoconcomitantes = '".$diagnosticoconcomitantes."',
  		gradolimitacionfuncional = '".$gradolimitacionfuncional."',
  		comentarios2 = '".$comentarios2."',
  		diasAcumulados = '".$diasAcumulados."',
  		diasReposoIndicados = '".$diasReposoIndicados."',
  		correspondeReposo = '".$correspondeReposo."',
  		periodo = '".$periodo."',
		fechaInicioUL = '".$fechaInicioUL."'
  		WHERE id='$id' ";

	 $result =mysql_query($sql,$conectar);
	if($result == false)
	{
		die('No se edito el informe!!!');
	}
    
}

function siInformesNoConfirmados($conectar){
	$sql = mysql_query("
	SELECT id 
	FROM informe_traumatologico
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
	FROM informe_traumatologico 
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
		informe_traumatologico e
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
    FROM informe_traumatologico e
	WHERE e.`hora`=$hora", $conectar);
    $row = mysql_fetch_array($sql);
    $numreg =$row['numreg'];


    if($numreg == 0)
    {
        return false ;
    }
    else
    {
        return true;

    }
}



function idInformeEntrevistaHora($hora, $conectar)
{
	$sql = mysql_query("
	SELECT 
		e.`id` 
	FROM 
		informe_traumatologico e
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
		informe_traumatologico e
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
		informe_traumatologico e
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
		informe_traumatologico e
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
		informe_traumatologico e
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
function crearInformeNuevo($idHora, $tipoSalida, $carpetaSalida, $conectar)
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
			$fraseCorrespondeReposo = 'SI, POR UN PERÍODO COMPLETO';
		}
		else
		{
			$fraseCorrespondeReposo = 'SI, POR UN PERÍODO REDUCIDO';
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
	$pdf->Cell(10,10,utf8_decode($nombreCompletoPaciente),0,0,'L');
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
	$pdf->Cell(0,10,'Antecedentes Traumatólogicos',0,0,'L');
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
	$pdf->Cell(0,10,utf8_decode('imagenes y Exámenes de Laboratorio'),0,0,'L');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($rxexamenlaboratorio));
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Imágenes y Examenes de Laboratorio:'),0,0,'L');
	$pdf->Ln(4);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode(ucfirst(strtolower($rxexamenlaboratorio))));

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('Examen Físico:'),0,0,'L');
	$pdf->Ln(4);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode(ucfirst(strtolower($examenfisico))));

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
	$pdf->Cell(0,10,'Diagnóstico TMT',0,0,'L');
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($diagnosticoTMT ));
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'Diagnóstico médico concomitantes',0,0,'L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,utf8_decode($diagnosticoconcomitantes));
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'Grado Limitacióm funcional',0,0,'L');
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
		$pdf->Output('../../../informesRespaldo/'.$archivo.'.pdf', 'F');
	    return $filepdf ;
    }
	
	
	
	
	
}
// Fin CREAR INFORME NUEVO
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
//CREAR INFORME ANTIGUO

function DescargarArchivo($fichero)
{
//$destino="../../../informesRespaldo/";
$basefichero = basename($fichero);
//header( "Content-Type: application/octet-stream");
header('application/octet-stream/bin') ;	
header( "Content-Length: ".filesize($fichero));
header( "Content-Disposition:attachment;filename=" .$basefichero." ");
//readfile($fichero);
}
function file_force_contents($dir, $contents){
        file_put_contents("../../../informesRespaldo/", $contents);
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
				`f_perito2`(i.`prestador`,1) AS rutprestador,
				`f_perito2`(i.`prestador`,2) AS nombreprestador,

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
    $pdf->Image("../../templates/defecto/imagenes/iso_blanco.jpg", 20, 29, 20);

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














?>