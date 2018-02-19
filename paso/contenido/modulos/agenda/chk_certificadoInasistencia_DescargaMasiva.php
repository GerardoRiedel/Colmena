<?php 
	session_name("agenda2");
	session_start();
	
	include_once('../../../lib/fpdf/fpdf.php');
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/isapres/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/prestadores/funciones.php');
	include('../../../lib/informe_entrevista/funciones.php');
	include('../../../lib/querys/comunas.php');
	include('../../../lib/querys/ciudades.php');
	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');

	$conectar = conectar();

	ini_set('max_execution_time','1000');

	
	$desde = VueltaFecha($_POST['desde']);
	$hasta = VueltaFecha($_POST['hasta']);
	$perito = $_POST['perito'];
	$isapre = $_POST['isapre'];
	
	echo $desde." - ".$hasta." - ".$perito." - ".$isapre;

		
	//Si seleccionó perito
	if($perito != 0)	{
		$peritoAdd = "AND prestador='".$perito."'";
	}
	
	//Si seleccionó isapre
	if($isapre != 0)
	{
		$isapreAdd = "AND isapre='".$isapre."'";
	}

	$sql = mysql_query("SELECT 
		id, fecha, hora
	FROM 
		horas
	WHERE 
		date(hora) BETWEEN '".$desde."' AND '".$hasta."' 
		".$peritoAdd." ".$isapreAdd." 
		AND asiste = 'no'
	ORDER BY
		id ASC", $conectar);	
		
		echo "<br><br>SELECT 
		id, fecha, hora
	FROM 
		horas
	WHERE 
		date(hora) BETWEEN '".$desde."' AND '".$hasta."' 
		".$peritoAdd." ".$isapreAdd." 
		AND asiste = 'no'
	ORDER BY
		id ASC";

		while ($res = mysql_fetch_array($sql))
		{
			
			$idHora = $res[id];	
			$sqlDatos = mysql_query("
			SELECT 
				i.`id`, 
				i.`hora`, 
				i.`ciudad`, 
				i.`paciente`, 
				i.`prestador`, 
				i.`isapre`, 
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
				i.`id`='".$idHora."'
			", $conectar);
			
			$rowDatos = mysql_fetch_array($sqlDatos);
			
			$idPaciente = $rowDatos[paciente];
			$idPrestador = $rowDatos[prestador];
			$fecha = VueltaFecha($rowDatos[fecha]);
			$isapre = nombreIsapre($rowDatos[isapre], $conectar);
			$dia = $rowDatos[dia];
			$mes = $rowDatos[mes];
			$ano = $rowDatos[ano];
			$hora = $rowDatos[hora];
			$minutos = $rowDatos[minutos];
			$fecha = $rowDatos[fecha];
			$idIsapre = $rowDatos[isapre];
		
			$nombreCompletoPaciente = nombreCompletoPaciente($idPaciente, $conectar);
			$rutPaciente = rutPaciente($idPaciente, $conectar);
			$dvPaciente = DigitoVerificador($rutPaciente);
			$rutPaciente = PonerPunto($rutPaciente).'-'.$dvPaciente;
			$direccion = direccionPaciente($idPaciente, $conectar);
			$comuna = retornaComuna(idComunaPaciente($idPaciente, $conectar), $conectar);
			$ciudad = strtoupper(nombreCiudad(ciudadHora($idHora, $conectar), $conectar));
			$rutPrestador = rutPrestador($idPrestador, $conectar);
			$rutPrestador = PonerPunto($rutPrestador).'-'.DigitoVerificador($rutPrestador);
			$nombreCompletoPrestador = caracteres_html_inversa(nombreCompletoPrestador($idPrestador, $conectar));





				//Creación del objeto de la clase heredada
				$pdf=new FPDF();
				$pdf->AliasNbPages();
				$pdf->AddPage();				
				$pdf->Image("../../templates/defecto/imagenes/logoDocumentos.jpg",20,12,20);
				$pdf->Image("../../templates/defecto/imagenes/iso_blanco.jpg",20,29,20);

				$pdf->SetFont('Arial','B',12);
				//Movernos a la derecha
				$pdf->Ln(20);
				
				$pdf->Cell(0,10,ucfirst(strtolower($ciudad.", ".MesPalabra($mes)." ".$dia." de ".$ano)),0,0,'R');
				$pdf->Ln(25);
				
				//Título
				$pdf->SetFont('Arial','',15);
				$pdf->Cell(0,10,'CERTIFICADO DE INASISTENCIA A PERITAJE',0,0,'C');
				$pdf->Line(45,63,165,63);
				$pdf->Ln(20);
				
				//////////////
				//Datos paciente
				$pdf->SetFont('Arial','',12);
				$pdf->MultiCell(0,5,'Por medio de la presente certificamos que '.utf8_decode(utf8_encode($nombreCompletoPaciente)).', RUT: '.$rutPaciente.', no '.utf8_decode("concurrió").' a la '.utf8_decode("citación").' enviada por su Isapre '.$isapre.', para realizar una entrevista psiquiatrica de segunda '.utf8_decode("opinión el día").' '. $dia.' de '.MesPalabra($mes).' de '.$ano.' a las '.$hora.':'.$minutos.' hrs., en la ciudad de '.$ciudad);
 				$pdf->Ln(10);
				$pdf->MultiCell(0,5,'Este certificado se extiende a '.utf8_decode("petición").' de Isapre '.$isapre.' para los fines que estime conveniente.');
				$pdf->Ln(20);
				
				
				
				$nombreImagen = $idPrestador.'.jpg';
				
				if(file_exists('../../templates/defecto/imagenes/firmas/'.$nombreImagen) == true)
				{
					redimensionar_jpeg('../../templates/defecto/imagenes/firmas/'.$nombreImagen, '../../templates/defecto/imagenes/firmas/'.$nombreImagen, 354, 170, 100);
			
					$pdf->Image("../../templates/defecto/imagenes/firmas/$nombreImagen",  60, 120, 0);
					
				}
				else
				{
					$pdf->Ln(40);
				}
				
				$pdf->Ln(40);
				$pdf->Line(70,165,140,165);
				$pdf->Cell(0,10,'Dr(a). '.$nombreCompletoPrestador,0,0,'C');
				$pdf->Ln(5);
				$pdf->Cell(0,10,'RUT '.$rutPrestador,0,0,'C');
				$pdf->Ln(5);
				$pdf->Cell(0,10,'Cetep Asociados Ltda.',0,0,'C');


/////////////
			if ($isapre == "Fonasa")
			{
				$isapreDescarga = "F";	
			}elseif ($isapre == "Consalud")
			{
				$isapreDescarga = "CS";	
			}elseif ($isapre == "Colmena")
			{
				$isapreDescarga = "CL";	
			}elseif ($isapre == "Banmedica")
			{
				$isapreDescarga = "B";	
			}elseif ($isapre == "Vida Tres")
			{
				$isapreDescarga = "VT";	
			}elseif ($isapre == "Masvida")
			{
				$isapreDescarga = "MV";	
			}elseif ($isapre == "Cruz Blanca")
			{
				$isapreDescarga = "CB";	
			}elseif ($isapre == "Fundación" || $idIsapre == 17 )
			{
				$isapreDescarga = "FD";	
			}else
			{
				$isapreDescarga = "NO IDENTIFICADA";	
			}

			if (!file_exists('C:/certificadosInasistencia_2013/'))
			{
				mkdir('C:/certificadosInasistencia_2013/', 0777, true);
			}else
			{
				if (!file_exists('C:/certificadosInasistencia_2013/'.$fecha.'-Certificado_Inasistencia-'.ucfirst(strtolower($ciudad)).'-'.$isapreDescarga.'-'.str_replace(' ', '-', elimina_acentos($nombreCompletoPaciente)).'.pdf'))
				{
						$pdf->Output('C:/certificadosInasistencia_2013/'.$fecha.'-Certificado_Inasistencia-'.ucfirst(strtolower($ciudad)).'-'.$isapreDescarga.'-'.str_replace(' ', '-', elimina_acentos($nombreCompletoPaciente)).'.pdf', 'F');				
						/*<a href='../../../informesRespaldo/".VueltaFecha($fecha)." - ".ucfirst(strtolower($ciudad))." - ".str_replace(" ", "_", elimina_acentos($nombreCompletoPaciente)).".pdf'>Fecha informe: ".VueltaFecha($fecha)." - ".ucfirst(strtolower($ciudad))." - ".str_replace(" ", "_", elimina_acentos($nombreCompletoPaciente)).".pdf'</a>*/				
				}			
			}
		}			

	echo "Los certificados en PDF han sido exitosamente descargados";


?>