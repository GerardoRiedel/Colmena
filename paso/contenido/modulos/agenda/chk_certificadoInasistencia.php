<?php 
	session_name("agenda2");
session_start();
	
	include('../../../lib/html2pdf/html2pdf.class.php');
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
	
 	ob_start();
	
	$idHora = $_GET['id'];

	$destino = $_GET['tiposalida'];


	$id = existeInformeEntrevista($idHora, $conectar);
	
	$sqlDatos = mysql_query("
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
		i.`id`=".$idHora."
	", $conectar);
	
	$rowDatos = mysql_fetch_array($sqlDatos);
	
	$idPaciente = $rowDatos['paciente'];
	$idPrestador = $rowDatos['prestador'];
	$fecha = VueltaFecha($rowDatos['fecha']);
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
				  <td height="62" colspan="2" align="left" valign="top">&nbsp;&nbsp;&nbsp;<img  src="../../templates/defecto/imagenes/logoDocumentos.jpg" width="80" height="62" /></td>
				  <td align="right" valign="top">&nbsp;</td>
			  </tr>
				<tr>
					<td height="61" colspan="2" align="left" valign="middle"></td>
					<td width="22%" align="right" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td height="52" colspan="3" align="right" valign="top" class="letraDocumento"><?php substr($ciudad,strpos($ciudad,' '),strlen($ciudad));?>, <?php echo MesPalabra($mes).' '.$dia.' de '.$ano; ?>.</td>
				</tr>
				<tr>
					<td height="34" colspan="3" align="center" valign="bottom" class="letraDocumentoTitulo"><u>CERTIFICADO DE INASISTENCIA A PERITAJE</u></td>
				</tr>
				<tr>
					<td height="34" colspan="3" align="left" valign="bottom">&nbsp;</td>
				</tr>
				<tr>
					<td width="21%" height="34" align="left" valign="bottom"><p class="letraDocumento" align="justify">&nbsp;</p></td>
					<td width="57%" align="left" valign="bottom"><span class="letraDocumento">Por medio de la presente certificamos que <strong><?php echo utf8_encode($nombreCompletoPaciente); ?></strong>, RUT <strong><?php echo $rutPaciente; ?></strong>, <?php echo $glosaNumlic;?>  no concurri&oacute; a la citaci&oacute;n enviada por <?php if ($isapre!='Fonasa'){
	echo 'su Isapre '.$isapre;
	}else{
		echo $isapre;
	}?> , para realizar una entrevista psiqui&aacute;trica de segunda opini&oacute;n el d&iacute;a <?php echo $dia; ?> de <?php echo MesPalabra($mes); ?> de <?php echo $ano; ?> a las <?php echo $hora.':'.$minutos; ?> hrs., en la ciudad de <?php 
	
	if ($isapre!='Fonasa'){
	echo ($ciudad);
	}else{
		
		$ciudadstring = substr($ciudad,strpos($ciudad,' '),strlen($ciudad));
			echo utf8_encode($ciudadstring)	;
//		echo $ciudad2;
	}?>
	<br />
							<br />
Este certificado se extiende a petici&oacute;n de <strong><?php 
if ($isapre!='Fonasa'){
	echo 'Isapre '.$isapre;
	}else{
		echo $isapre;
	}?></strong> para los fines que estime conveniente.</span></td>
					<td height="34" align="left" valign="bottom">&nbsp;</td>
				</tr>
				<tr>
					<td height="201" colspan="3" align="left" valign="bottom"><table width="354" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td width="354" align="center">
							<?php 
							if(file_exists('../../templates/defecto/imagenes/firmas/'.$idPrestador.'.jpg') == true)
							{
								?>
								<img src="../../templates/defecto/imagenes/firmas/<?php echo $idPrestador;?>.jpg" width="354" height="170"/>
								<?php 
							}
							?>
							</td>
						</tr>
						<tr>
							<td width="354" align="center"><img src="../../templates/defecto/imagenes/linea.gif" width="343" height="1"/></td>
						</tr>
						<tr>
							<td width="354" align="center" class="letraDocumento">Dr(a). <?php echo nombreCompletoPrestador($idPrestador, $conectar); ?><br />
								 RUT <?php echo $rutPrestador; ?> <br />
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
</html>
<?php
	if ($destino == 'I') {
		$content = ob_get_clean();
		$archivo =  nombreCompletoPaciente($idPaciente, $conectar);
		$html2pdf = new HTML2PDF('P', 'Letter', 'es', array(20, 20, 20, 20));
		$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('Certificado'.$archivo.'.pdf', "I");

	} elseif($destino == 'D')
	{
		$content = ob_get_clean();
		$archivo = nombreCompletoPaciente($idPaciente, $conectar);
		$html2pdf = new HTML2PDF('P', 'Letter', 'es', array(20, 20, 20, 20));
		$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('Certificado-'.$archivo.'.pdf', "D");

	}
	elseif($destino == '')
	{
		$content = ob_get_clean();
		$archivo =  nombreCompletoPaciente($idPaciente, $conectar);
		$html2pdf = new HTML2PDF('P', 'Letter', 'es', array(20, 20, 20, 20));
		$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('Certificado.pdf', "I");

	}


?>