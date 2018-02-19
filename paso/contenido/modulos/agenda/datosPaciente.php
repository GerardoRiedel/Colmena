<?php 
	session_name("agenda2");
session_start();
	
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/isapres/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/querys/comunas.php');
	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');
	
	$conectar = conectar();
	
	$idHora = $_GET['hora'];
	
	$fecha = fechaHora($idHora, $conectar);
	$idPaciente = idPacienteHora($idHora, $conectar);
	$rutPaciente = PonerPunto(rutPaciente($idPaciente, $conectar));
	$nombresPaciente = nombresPaciente($idPaciente, $conectar);
	$apellidoPaternoPaciente = apellidoPaternoPaciente($idPaciente, $conectar);
	$apellidoMaternoPaciente = apellidoMaternoPaciente($idPaciente, $conectar);
	$telefonoPaciente = telefonoPaciente($idPaciente, $conectar);
	$celularPaciente = celularPaciente($idPaciente, $conectar);
	$emailPaciente = emailPaciente($idPaciente, $conectar);
	$direccionPaciente = direccionPaciente($idPaciente, $conectar);
	$idComunaPaciente = idComunaPaciente($idPaciente, $conectar);
	$isapreHora = isapreHora($idHora, $conectar);
	$observacionHora = observacionHora($idHora, $conectar);
?>

<link href="../../templates/defecto/estilos.css" rel="stylesheet" type="text/css">
<br />
<br />
<br />
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="borde_tabla">
		<tr>
			<td height="29" colspan="2" align="center" bgcolor="#AACCFF" class="tituloTablas">Datos del Paciente </td>
		</tr>
		<tr>
			<td width="50%" height="30" align="right" class="letra7" style="padding-right:10px;">RUT:</td>
			<td class="letra7" style="padding-left:10px;">
				<?php echo $rutPaciente; ?>			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Nombres:</td>
			<td class="letra7" style="padding-left:10px;">
				<?php echo $nombresPaciente; ?>			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Apellido Paterno: </td>
			<td class="letra7" style="padding-left:10px;">
				<?php echo $apellidoPaternoPaciente; ?>			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Apellido Materno: </td>
			<td class="letra7" style="padding-left:10px;">
				<?php echo $apellidoMaternoPaciente; ?>			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Tel&eacute;fono:</td>
			<td class="letra7" style="padding-left:10px;">
				<?php echo $telefonoPaciente; ?>			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Celular:</td>
			<td class="letra7" style="padding-left:10px;">
				<?php echo $celularPaciente; ?>			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Email:</td>
			<td class="letra7" style="padding-left:10px;">
				<?php echo $emailPaciente; ?>			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Direcci&oacute;n:</td>
			<td class="letra7" style="padding-left:10px; padding-right:10px;">
				<?php echo $direccionPaciente; ?>			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Comuna:</td>
			<td class="letra7" style="padding-left:10px;">
				<?php echo retornaComuna($idComunaPaciente, $conectar); ?>			</td>
		</tr>
		<tr>
			<td height="30" align="right" class="letra7" style="padding-right:10px;">Isapre:</td>
			<td class="letra7" style="padding-left:10px;">
				<?php echo nombreIsapre($isapreHora, $conectar); ?>			</td>
		</tr>
		<tr>
			<td height="30" align="right" valign="top" class="letra7" style="padding-right:10px; padding-top:5px;">Observaci&oacute;n:</td>
			<td class="letra7" style="padding-left:10px; padding-top:5px; padding-bottom:5px;">
				<?php echo $observacionHora; ?>			</td>
		</tr>
	</table>
