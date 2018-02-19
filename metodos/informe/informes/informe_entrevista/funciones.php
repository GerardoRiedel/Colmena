<?php

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
        if (empty($hora)){
            echo '{"ConsultarExpediente": "Sin Informe Creado"}';
            die;
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
        if (!class_exists('PDF')) {
   // Put class TestClass here

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
        }
	//Creación del objeto de la clase heredada
        $pdf='';
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
            //$carpeta ='agenda/ws/colmena/informes/informes/';
            $carpeta ='ws/informe/informes/informes/';
            $url = $_SERVER["REQUEST_URI"];
            
            $url = explode("/", $url);
            $url = $url[1];
            $ruta= ('http://'.$_SERVER['HTTP_HOST'].'/'.$url.'/'.$carpeta);
            
            
            //$ruta= ($_SERVER['DOCUMENT_ROOT'].$carpeta);
                    //echo $carpeta.$archivo;
            //$pdf->Output('$ruta.$archivo', 'F');
            $filepdf=$ruta.$archivo;
            $pdf->Output('informes/informes/'.$archivo, 'F');
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


function funcionInformeInasistencia($idHora)
{
    
	//session_name("agenda2");
        //session_start();
	//
	//include('../../../lib/html2pdf/html2pdf.class.php');
	//include('../../../lib/pacientes/funciones.php');
	//include('../../../lib/isapres/funciones.php');
	//include('../../../lib/usuarios/funciones.php');
	//include('../../../lib/horas/funciones.php');
	//include('../../../lib/prestadores/funciones.php');
	//include('../../../lib/informe_entrevista/funciones.php');
	//include('../../../lib/querys/comunas.php');
	//include('../../../lib/querys/ciudades.php');
	//include('../../../lib/datos.php');
	//include('../../../lib/funciones.php');
	//include('../../../lib/conectar.php');

	//$conectar = conectar();
	$db = getConnection();
 	$content = ob_start();
	
	//$idHora = $_GET['id'];
	//$destino = $_GET['tiposalida'];
        $destino = 'I';


	//$id = existeInformeEntrevista($idHora, $conectar);
	
	$sqlDatos = "
	SELECT 
		i.`id`, 
		i.`hora`, 
		i.`ciudad`, 
		i.`paciente`, 
		i.`prestador`, 
		i.`isapre`, 
		i.`confirmada`, 
		i.numerolicencia,
		DATE_FORMAT(i.`hora`, '%e') AS dia,
		DATE_FORMAT(i.`hora`, '%c') AS mes,
		DATE_FORMAT(i.`hora`, '%Y') AS ano,
		DATE_FORMAT(i.`hora`, '%k') AS hora,
		DATE_FORMAT(i.`hora`, '%i') AS minutos
	FROM 
		horas i
	WHERE 
		i.`id`=".$idHora."";
	
	$stmt = $db->prepare($sqlDatos);
        $stmt->execute();
        $rowDatos = $stmt->fetch(PDO::FETCH_ASSOC);
        $conectar = '';
	//$rowDatos = mysql_fetch_array($sqlDatos);
	//var_dump($rowDatos);
	$idPaciente = $rowDatos['paciente'];
	$idPrestador = $rowDatos['prestador'];
        $fecha = $rowDatos['dia'].'-'.$rowDatos['mes'].'-'.$rowDatos['ano'];
	//$fecha = VueltaFecha($rowDatos['fecha']);
	$codisa = $rowDatos['isapre'];
	$isapre = nombreIsapre($rowDatos['isapre'], $conectar);
	$dia = $rowDatos['dia'];
	$mes = $rowDatos['mes'];
	$ano = $rowDatos['ano'];
	$hora = $rowDatos['hora'];
	$minutos = $rowDatos['minutos'];

	$nombreCompletoPaciente = nombreCompletoPaciente($idPaciente, $conectar);
	$rutPaciente = rutPaciente($idPaciente, $conectar);
	$dvPaciente = DigitoVerificador($rutPaciente);
	$rutPaciente = PonerPunto($rutPaciente).'-'.$dvPaciente;
	$direccion = direccionPaciente($idPaciente, $conectar);
	$comuna = retornaComuna(idComunaPaciente($idPaciente, $conectar), $conectar);
	$ciudad = utf8_decode((nombreCiudad(ciudadHora($idHora, $conectar), $conectar)));
        $arrCiudad  = explode(' ',$ciudad);
        $ciudad     = $arrCiudad[0];
	$rutPrestador = rutPrestador($idPrestador, $conectar);
	$rutPrestador = PonerPunto($rutPrestador).'-'.DigitoVerificador($rutPrestador);
	$licencia = $rowDatos['numerolicencia'];

if  ($codisa == 1){
	$glosaNumlic = 'Licencia Nro.'.$licencia.',';
}else {
	$glosaNumlic = '';
}

?>
<style type="text/css">
<!--
.letraDocumento
{
	font-family:  Arial, Helvetica, sans-serif;
	font-size: 18px;
	color: #000000;
}
.letraDocumentoTitulo
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 22px;
	color: #000000;
	font-weight:bolder;
}
-->
</style>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 <?php $content = '
     
<html xmlns="http://www.w3.org/1999/xhtml">
   
<head>
<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>
  
<table width="600" height="149" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="51" align="left" valign="top">
			<table width="600" height="654" border="0" cellpadding="0" cellspacing="0">
				<tr>
				  <td height="62" colspan="2" align="left" valign="top">&nbsp;&nbsp;&nbsp;<img  src="http://cetep.cl/agenda/contenido/templates/defecto/imagenes/logoDocumentos.jpg" width="80" height="62" /></td>
				  <td align="right" valign="top">&nbsp;</td>
			  </tr>
                              
				<tr>
					<td height="61" colspan="2" align="left" valign="middle"></td>
					<td width="22%" align="right" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td height="52" colspan="3" align="right" valign="top" class="letraDocumento">'.
                                        $ciudad.', '. MesPalabra($mes).' '.$dia.' de '.$ano.'.</td>
				</tr>
				<tr>
					<td height="34" colspan="3" align="center" valign="bottom" class="letraDocumentoTitulo"><u>CERTIFICADO DE INASISTENCIA A PERITAJE</u></td>
				</tr>
				<tr>
					<td height="34" colspan="3" align="left" valign="bottom">&nbsp;</td>
				</tr>
				<tr>
					<td width="21%" height="34" align="left" valign="bottom"><p class="letraDocumento" align="justify">&nbsp;</p></td>
					<td width="57%" align="left" valign="bottom"><span class="letraDocumento">Por medio de la presente certificamos que <strong>'.utf8_encode($nombreCompletoPaciente).'</strong>, RUT <strong>'. $rutPaciente.'</strong>, '. $glosaNumlic.'  no concurri&oacute; a la citaci&oacute;n enviada por su Isapre Colmena, para realizar una entrevista psiqui&aacute;trica de segunda opini&oacute;n el d&iacute;a '. $dia.' de '. MesPalabra($mes).' de '. $ano.' a las '.$hora.':'.$minutos.' hrs., en la ciudad de 
	'.$ciudad.' 
	<br />
							<br />
Este certificado se extiende a petici&oacute;n de <strong>Colmena</strong> para los fines que estime conveniente.</span></td>
					<td height="34" align="left" valign="bottom">&nbsp;</td>
				</tr>
				<tr>
					<td height="201" colspan="3" align="left" valign="bottom"><table width="354" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td width="354" align="center">
							
								<img src="../../contenido/templates/defecto/imagenes/firmas/'.$idPrestador.'.jpg" width="354" height="170"/>
								
							</td>
						</tr>
						<tr>
							<td width="354" align="center"><img src="../../contenido/templates/defecto/imagenes/linea.gif" width="343" height="1"/></td>
						</tr>
						<tr>
							<td width="354" align="center" class="letraDocumento">Dr(a). '. nombreCompletoPrestador($idPrestador, $conectar).'<br />
								 RUT '.$rutPrestador.' <br />
								<strong>Cetep Asociados Ltda.</strong></td>
						</tr>
					</table></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="98" align="left" valign="top"> <br /></td>
	</tr>
</table>
</body>
</html>';


        //$pdf='';
	//$pdf=new PDF();
	if ($destino == 'I') {
		//$content = ob_get_clean();
                //$content = ob_start();
            $archivo=	(int)rutPaciente($idPaciente, $conectar);
		//$archivo =  nombreCompletoPaciente($idPaciente, $conectar);
		$html2pdf = new HTML2PDF('P', 'Letter', 'es', array(20, 20, 20, 20));
		$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
                //$pdf->Output('informes/informes/'.$archivo.'.pdf', 'F');
                $html2pdf->Output('informes/informes/'.$archivo.'.pdf', "F");
		//$html2pdf->Output('Certificado'.$archivo.'.pdf', "I");
                $carpeta ='agenda/ws/informe/informes/informes/'.$archivo.'.pdf';
                //$carpeta ='informes/informes/'.$archivo.'.pdf';
                $url = $_SERVER["REQUEST_URI"];
            
                $url = explode("/", $url);
                $url = $url[1];
                $ruta= ('http://'.$_SERVER['HTTP_HOST'].'/'.$url.'/'.$carpeta);
            
            $filepdfInasistencia=$ruta;
	    return $filepdfInasistencia ;

	} 



}

?>

