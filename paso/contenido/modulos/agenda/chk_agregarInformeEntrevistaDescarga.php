<?php 
	session_name("agenda2");
session_start();
	
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/isapres/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/prestadores/funciones.php');
	include('../../../lib/encuesta_peritaje/funciones.php');
	include('../../../lib/querys/comunas.php');
	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');

	header("Content-type: application/application/msword");
	header("Content-Disposition: attachment; filename=Encuesta_Peritaje.doc");
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
	
	$idHora = $_GET['id'];
	
	$id = existeEncuestaPeritaje($idHora, $conectar);

	$sexo = sexoEncuestaPeritaje($id, $conectar);
	$edad = edadEncuestaPeritaje($id, $conectar);

	$idPaciente = idPacienteHora($idHora, $conectar);	
	$idIsapre = isaprePaciente($idPaciente, $conectar);
	$isapre = nombreIsapre($idIsapre, $conectar);
	$idComuna = idComunaPaciente($idPaciente, $conectar);
	$comuna = retornaComuna($idComuna, $conectar);
	
	$actividad = actividadEncuestaPeritaje($id, $conectar);
	$tiempoDeLM = tiempoDeLMEncuestaPeritaje($id, $conectar);
	$diagnosticoLM = diagnosticoLMEncuestaPeritaje($id, $conectar);
	$opinionDiagnostico = opinionDiagnosticoEncuestaPeritaje($id, $conectar);
	$correspondeReposo = correspondeReposoEncuestaPeritaje($id, $conectar);
	$tratante = tratanteEncuestaPeritaje($id, $conectar);
	$opinionTratamiento = opinionTratamientoEncuestaPeritaje($id, $conectar);
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
<table width="100%" height="149" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td height="51" align="left" valign="top" class="letra7">
			<table width="100%" height="50" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="left" valign="bottom" class="tituloDocumento"><img src="<?php echo $IMAGENES2; ?>/cetep.png" width="124" height="62" /></td>
				</tr>
				<tr>
					<td align="center" valign="bottom" class="tituloDocumento">Encuesta peritaje Psiqui&aacute;trico </td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="98" align="left" valign="top" class="letra7"> <br />
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="28" align="right" class="letraDocumentoTitulo">Sexo:</td>
					<td class="letraDocumento" style="padding-left:15;"><?php echo $sexo; ?>&nbsp;</td>
				</tr>
				<tr>
					<td width="37%" height="28" align="right" class="letraDocumentoTitulo">Edad:</td>
					<td width="63%" class="letraDocumento" style="padding-left:15;"><?php echo $edad; ?>&nbsp;</td>
				</tr>
				<tr>
					<td height="28" align="right" class="letraDocumentoTitulo">Isapre:</td>
					<td class="letraDocumento" style="padding-left:15;"><?php echo $isapre; ?>&nbsp;</td>
				</tr>
				<tr>
					<td height="28" align="right" class="letraDocumentoTitulo">Comuna:</td>
					<td class="letraDocumento" style="padding-left:15;"><?php echo $comuna; ?>&nbsp;</td>
				</tr>
				<tr>
					<td height="28" align="right" class="letraDocumentoTitulo">Actividad: </td>
					<td class="letraDocumento" style="padding-left:15;"><?php echo $actividad; ?>&nbsp;</td>
				</tr>
				<tr>
					<td height="28" align="right" class="letraDocumentoTitulo">Tiempo de LM: </td>
					<td class="letraDocumento" style="padding-left:15;"><?php echo $tiempoDeLM; ?>&nbsp;</td>
				</tr>
				<tr>
					<td height="28" align="right" class="letraDocumentoTitulo">Diagn&oacute;stico LM:</td>
					<td class="letraDocumento" style="padding-left:15;"><?php echo $diagnosticoLM; ?>&nbsp;</td>
				</tr>
				<tr>
					<td height="28" align="right" class="letraDocumentoTitulo">Opini&oacute;n sobre diagn&oacute;stico: </td>
					<td class="letraDocumento" style="padding-left:15;"><?php echo $opinionDiagnostico; ?>&nbsp;</td>
				</tr>
				<tr>
					<td height="28" align="right" class="letraDocumentoTitulo">Corresponde reposo actual: </td>
					<td class="letraDocumento" style="padding-left:15;"><?php echo $correspondeReposo; ?>&nbsp;</td>
				</tr>
				<tr>
					<td height="28" align="right" class="letraDocumentoTitulo">Tratante:</td>
					<td class="letraDocumento" style="padding-left:15;"><?php echo $tratante; ?>&nbsp;</td>
				</tr>
				<tr>
					<td height="28" align="right" class="letraDocumentoTitulo">Opini&oacute;n sobre tratamiento </td>
					<td class="letraDocumento" style="padding-left:15;"><?php echo $opinionTratamiento; ?>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
