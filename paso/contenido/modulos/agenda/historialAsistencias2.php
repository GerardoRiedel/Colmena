<?php 
	session_name("agenda2");
session_start();

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=historial_de_asistencias.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/prestadores/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/isapres/funciones.php');
	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');
	
	$conectar = conectar();
	
	$idIsapre = $_POST['isapre'];
	$mes = $_POST['mes'];
	$ano = $_POST['ano'];
	
	//Todas las isapres
	if($idIsapre == 0)
	{
		$queryAsiste = "
		SELECT 
			h.`id`, 
			DATE_FORMAT(h.`hora`, '%d-%m-%Y %k:%i') as fecha, 
			h.`paciente`, 
			h.`prestador`,
			h.`isapre` 
		FROM 
			horas h
		WHERE 
			h.`hora` BETWEEN '$ano-$mes-01' AND '$ano-$mes-31' AND 
			h.`asiste`='si'
		ORDER BY 
			h.`isapre` ASC, 
			h.`prestador` ASC, 
			h.`hora` ASC";

		$queryNoAsiste = "
		SELECT 
			h.`id`, 
			DATE_FORMAT(h.`hora`, '%d-%m-%Y %k:%i') as fecha, 
			h.`paciente`, 
			h.`prestador`,
			h.`isapre` 
		FROM 
			horas h
		WHERE 
			h.`hora` BETWEEN '$ano-$mes-01' AND '$ano-$mes-31' AND 
			h.`asiste`='no'
		ORDER BY 
			h.`isapre` ASC, 
			h.`prestador` ASC, 
			h.`hora` ASC";

	}
	else //Isapre seleccionada
	{
		$queryAsiste = "
		SELECT 
			h.`id`, 
			DATE_FORMAT(h.`hora`, '%d-%m-%Y %k:%i') as fecha, 
			h.`paciente`,
			h.`isapre`, 
			h.`prestador` 
		FROM 
			horas h
		WHERE 
			h.`hora` BETWEEN '$ano-$mes-01' AND '$ano-$mes-31' AND
			h.`isapre`=$idIsapre AND 
			h.`asiste`='si'
		ORDER BY 
			h.`prestador` ASC, 
			h.`hora` ASC";

		$queryNoAsiste = "
		SELECT 
			h.`id`, 
			DATE_FORMAT(h.`hora`, '%d-%m-%Y %k:%i') as fecha, 
			h.`paciente`,
			h.`isapre`, 
			h.`prestador` 
		FROM 
			horas h
		WHERE 
			h.`hora` BETWEEN '$ano-$mes-01' AND '$ano-$mes-31' AND
			h.`isapre`=$idIsapre AND 
			h.`asiste`='no'
		ORDER BY 
			h.`prestador` ASC, 
			h.`hora` ASC";
	}
	
?>
<table width="878" height="57" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#FFFFFF" class="borde_tabla">
	<tr>
		<td width="8%" height="22" align="center" class="letraDocumentoTitulo"><strong>Hora</strong></td>
		<td width="27%" align="center" class="letraDocumentoTitulo"><strong>Prestador</strong></td>
		<td width="27%" align="center" class="letraDocumentoTitulo"><strong>Paciente</strong></td>
		<td width="18%" align="center" class="letraDocumentoTitulo"><strong>RUT</strong></td>
		<td width="20%" align="center" class="letraDocumentoTitulo"><strong>Isapre</strong></td>
	</tr>
	<?php 
	$totalAsiste = 0;
	
	$sqlAsiste = mysql_query($queryAsiste, $conectar);
	
	while($rowAsiste = mysql_fetch_array($sqlAsiste))
	{
		$hora = $rowAsiste[fecha];
		$nombrePrestador = nombreCompletoPrestadorApellido ($rowAsiste[prestador], $conectar);
		$nombrePaciente = nombreCompletoPacienteApellido($rowAsiste[paciente], $conectar);
		$rutPaciente = rutPaciente($rowAsiste[paciente], $conectar);
		$rutPaciente = PonerPunto($rutPaciente).'-'.DigitoVerificador($rutPaciente);
		$isapre = nombreIsapre(isaprePaciente($rowAsiste[paciente], $conectar), $conectar);
		?>
		<tr>
			<td height="33" align="center"><?php echo $hora; ?></td>
			<td align="left" style="padding-left:10px"><?php echo $nombrePrestador; ?>&nbsp;</td>
			<td align="left" style="padding-left:10px"><?php echo $nombrePaciente; ?>&nbsp;</td>
			<td align="left"><?php echo $rutPaciente; ?>&nbsp;</td>
			<td align="left"><?php echo $isapre; ?></td>
		</tr>
		<?php 
		$totalAsiste++;
	}
	?>
</table>
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="25">&nbsp;</td>
	</tr>
	<tr>
		<td><span class="letraDocumento" style="padding-left:10px"><strong>Total: <?php echo $totalAsiste; ?> prestaciones asistidas </strong></span></td>
	</tr>
</table>
<br />
<br />
<table width="878" height="57" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#FFFFFF" class="borde_tabla">
	<tr>
		<td width="8%" height="22" align="center" class="letraDocumentoTitulo"><strong>Hora</strong></td>
		<td width="27%" align="center" class="letraDocumentoTitulo"><strong>Prestador</strong></td>
		<td width="27%" align="center" class="letraDocumentoTitulo"><strong>Paciente</strong></td>
		<td width="18%" align="center" class="letraDocumentoTitulo"><strong>RUT</strong></td>
		<td width="20%" align="center" class="letraDocumentoTitulo"><strong>Isapre</strong></td>
	</tr>
	<?php 
	$totalNoAsiste = 0;
	
	$sqlNoAsiste = mysql_query($queryNoAsiste, $conectar);
	
	while($rowNoAsiste = mysql_fetch_array($sqlNoAsiste))
	{
		$hora = $rowNoAsiste[fecha];
		$nombrePrestador = nombreCompletoPrestadorApellido ($rowNoAsiste[prestador], $conectar);
		$nombrePaciente = nombreCompletoPacienteApellido($rowNoAsiste[paciente], $conectar);
		$rutPaciente = rutPaciente($rowNoAsiste[paciente], $conectar);
		$rutPaciente = PonerPunto($rutPaciente).'-'.DigitoVerificador($rutPaciente);
		$isapre = nombreIsapre(isaprePaciente($rowNoAsiste[paciente], $conectar), $conectar);
		?>
	<tr>
		<td height="33" align="center"><?php echo $hora; ?></td>
		<td align="left" style="padding-left:10px"><?php echo $nombrePrestador; ?>&nbsp;</td>
		<td align="left" style="padding-left:10px"><?php echo $nombrePaciente; ?>&nbsp;</td>
		<td align="left"><?php echo $rutPaciente; ?>&nbsp;</td>
		<td align="left"><?php echo $isapre; ?></td>
	</tr>
	<?php 
		$totalNoAsiste++;
	}
	?>
</table>
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="25">&nbsp;</td>
	</tr>
	<tr>
		<td><span class="letraDocumento" style="padding-left:10px"><strong>Total: <?php echo $totalNoAsiste; ?> prestaciones no asistidas </strong></span></td>
	</tr>
</table>
