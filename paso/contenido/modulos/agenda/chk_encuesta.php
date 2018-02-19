<?php 
	session_name("agenda2");
session_start();
	
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

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=Encuesta_Peritaje_Psiquiatrico.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	$conectar = conectar();
	
	//Verifico si el usuario es prestador y lo saco
	if(tipoUsuario($_SESSION['idUsuario'], $conectar) == 'isapre')
	{
		$_SESSION['msj'] = 'No tiene acceso';
		
		header('Location: '.$TEMPLATE_DIR2.'/mensajes.php');
		die();
	}
	
	$idHora = $_GET['hora'];
	
	$id = existeInformeEntrevista($idHora, $conectar);
	
	$sqlDatos = mysql_query("
	SELECT
	  DATE_FORMAT(h.`hora`, '%d/%m/%Y') as fecha,
	  i.`sexo`,
	  i.`edad`,
	  i.`ocupacion`,
	  isa.`isapre`,
	  c.`ciudad`,
	  i.`medicoTratante`,
	  i.`tiempoLicencia`,
	  i.`diagnosticoLicenciaMedica`,
	  i.`opinionSobreDiagnostico`,
	  i.`opinionTratamiento`,
	  i.`opinionReposoMedico`,
	  i.`existeEstresLaboral`
	FROM
	  horas h,
	  informe_entrevista i,
	  isapres isa,
	  ciudades c 
	WHERE
	  h.`id`='$idHora' AND
	  i.`hora`=h.`id` AND
	  isa.`id`=h.`isapre` AND
	  c.`id`=h.`ciudad`
	", $conectar);
	
	$rowDatos = mysql_fetch_array($sqlDatos);
	
	$fecha = $rowDatos[fecha];
	$sexo = $rowDatos[sexo];
	$edad = $rowDatos[edad];
	$ocupacion = $rowDatos[ocupacion];
	$isapre = $rowDatos[isapre];
	$ciudad = $rowDatos[ciudad];
	$medicoTratante = $rowDatos[medicoTratante];
	$tiempoLicencia = $rowDatos[tiempoLicencia];
	$diagnosticoLicenciaMedica = $rowDatos[diagnosticoLicenciaMedica];
	$opinionSobreDiagnostico = $rowDatos[opinionSobreDiagnostico];
	$opinionTratamiento = $rowDatos[opinionTratamiento];
	$opinionReposoMedico = $rowDatos[opinionReposoMedico];
	$existeEstresLaboral = $rowDatos[existeEstresLaboral];
	
?>

<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
.letraDocumentoTitulo
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #000000;
	font-weight:bolder;
}
.letraDocumento
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #000000;
}
.tituloDocumento
{
	font-family:"Trebuchet MS", Tahoma, Verdana;
	color:#000000;
	font-size:16px;
	font-weight:bolder;
}

-->
</style>
<table width="1582" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="95" align="center" class="letraDocumentoTitulo">Fecha</td>
		<td width="45" align="center" class="letraDocumentoTitulo">Sexo</td>
		<td width="45" align="center" class="letraDocumentoTitulo">Edad</td>
		<td width="121" align="center" class="letraDocumentoTitulo">Ocupaci&oacute;n</td>
		<td width="89" align="center" class="letraDocumentoTitulo">Seguro</td>
		<td width="74" align="center" class="letraDocumentoTitulo">Ciudad</td>
		<td width="120" align="center" class="letraDocumentoTitulo">M&eacute;dico T.</td>
		<td width="90" align="center" class="letraDocumentoTitulo">T. Licencia</td>
		<td width="200" align="center" class="letraDocumentoTitulo">Diagn&oacute;stico LM</td>
		<td width="200" align="center" class="letraDocumentoTitulo">Op. Diagn&oacute;stico</td>
		<td width="192" align="center" class="letraDocumentoTitulo">Op. Tratamiento</td>
		<td width="206" align="center" class="letraDocumentoTitulo">Op. Reposo</td>
		<td width="77" align="center" class="letraDocumentoTitulo">Estr&eacute;s</td>
	</tr>
	<tr>
		<td><?php echo $fecha; ?>&nbsp;</td>
		<td><?php echo $sexo; ?>&nbsp;</td>
		<td><?php echo $edad; ?>&nbsp;</td>
		<td><?php echo $ocupacion; ?>&nbsp;</td>
		<td><?php echo $isapre; ?>&nbsp;</td>
		<td><?php echo $ciudad; ?>&nbsp;</td>
		<td><?php echo $medicoTratante; ?>&nbsp;</td>
		<td><?php echo $tiempoLicencia; ?>&nbsp;</td>
		<td><?php echo $diagnosticoLicenciaMedica; ?>&nbsp;</td>
		<td><?php echo $opinionSobreDiagnostico; ?>&nbsp;</td>
		<td><?php echo $opinionTratamiento; ?></td>
		<td><?php echo $opinionReposoMedico; ?>&nbsp;</td>
		<td><?php echo $existeEstresLaboral; ?>&nbsp;</td>
	</tr>
</table>
