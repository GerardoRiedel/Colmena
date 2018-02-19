<?php 
	session_name("agenda2");
session_start();

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=historial_de_peritajes.xls");
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
	
	$idPrestador = $_POST['idPrestador'];
	$mes = $_POST['mes'];
	$ano = $_POST['ano'];
	
	//Todos los prestadores
	if($idPrestador == 0)
	{
		$query = "
		SELECT 
			h.`id`, 
			DATE_FORMAT(h.`hora`, '%d-%m-%Y %k:%i') as fecha, 
			h.`paciente`, 
			h.`prestador` 
		FROM 
			horas h
		WHERE 
			h.`hora` BETWEEN '$ano-$mes-01' AND '$ano-$mes-31' AND 
			h.`asiste`='si'
		ORDER BY 
			h.`prestador` ASC, 
			h.`hora` ASC";
	}
	else //Prestador seleccionado
	{
		$query = "
		SELECT 
			h.`id`, 
			DATE_FORMAT(h.`hora`, '%d-%m-%Y %k:%i') as fecha, 
			h.`paciente`, 
			h.`prestador` 
		FROM 
			horas h
		WHERE 
			h.`hora` BETWEEN '$ano-$mes-01' AND '$ano-$mes-31' AND
			h.`prestador`=$idPrestador AND 
			h.`asiste`='si'
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
	$total = 0;
	
	$sql = mysql_query($query, $conectar);
	
	while($row = mysql_fetch_array($sql))
	{
		$hora = $row[fecha];
		$nombrePrestador = nombreCompletoPrestadorApellido ($row[prestador], $conectar);
		$nombrePaciente = nombreCompletoPacienteApellido($row[paciente], $conectar);
		$rutPaciente = rutPaciente($row[paciente], $conectar);
		$rutPaciente = PonerPunto($rutPaciente).'-'.DigitoVerificador($rutPaciente);
		$isapre = nombreIsapre(isaprePaciente($row[paciente], $conectar), $conectar);
		?>
		<tr>
			<td height="33" align="center"><?php echo $hora; ?></td>
			<td align="left" style="padding-left:10px"><?php echo $nombrePrestador; ?>&nbsp;</td>
			<td align="left" style="padding-left:10px"><?php echo $nombrePaciente; ?>&nbsp;</td>
			<td align="left"><?php echo $rutPaciente; ?>&nbsp;</td>
			<td align="left"><?php echo $isapre; ?></td>
		</tr>
		<?php 
		$total++;
	}
	?>
</table>
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="35">&nbsp;</td>
	</tr>
	<tr>
		<td><span class="letraDocumento" style="padding-left:10px"><strong>Total: <?php echo $total; ?> prestaciones </strong></span></td>
	</tr>
</table>
