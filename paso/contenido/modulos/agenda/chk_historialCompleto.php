<?php 
	session_name("agenda2");
session_start();

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=historial_de_peritajes.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	include('../../../lib/pacientes/funciones.php');
	include('../../../lib/horas/funciones.php');
	include('../../../lib/prestadores/funciones.php');
	include('../../../lib/usuarios/funciones.php');
	include('../../../lib/isapres/funciones.php');
	include('../../../lib/encuesta_peritaje/funciones.php');
	include('../../../lib/informe_entrevista/funciones.php');
	include('../../../lib/querys/ciudades.php');
	include('../../../lib/querys/comunas.php');
	include('../../../lib/datos.php');
	include('../../../lib/funciones.php');
	include('../../../lib/conectar.php');
	
	$conectar = conectar();

	$desde = VueltaFecha($_POST['desde']);
	$hasta = VueltaFecha(str_replace('/','-', sumaFechas($_POST['hasta'], 1))); 
	
	//Todos los prestadores
	$query = "
	SELECT 
		h.`id`, 
		DATE_FORMAT(h.`hora`, '%d-%m-%Y') as fecha, 
		DATE_FORMAT(h.`hora`, '%k:%i') as hora, 
		h.`paciente`, 
		h.`prestador`,
		h.`ciudad`,
		h.`confirmada`,
		h.`asiste`
	FROM 
		horas h
	WHERE 
		h.`hora` BETWEEN '$desde' AND '$hasta'
	ORDER BY 
		h.`hora` ASC";

?>
<table width="1209" height="45" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#FFFFFF" class="borde_tabla">
	<tr>
		<td width="102" height="22" align="center" class="letraDocumentoTitulo"><strong>Fecha</strong></td>
		<td width="60" align="center" class="letraDocumentoTitulo"><strong>Hora</strong></td>
		<td width="203" align="center" class="letraDocumentoTitulo"><strong>Prestador</strong></td>
		<td width="97" align="center" class="letraDocumentoTitulo"><strong>RUT</strong></td>
		<td width="100" align="center" class="letraDocumentoTitulo"><strong>Isapre</strong></td>
		<td width="79" align="center" class="letraDocumentoTitulo"><strong>Confirmado</strong></td>
		<td width="91" align="center" class="letraDocumentoTitulo"><strong>Asisti&oacute;</strong></td>
		<td width="82" align="center" class="letraDocumentoTitulo"><strong>Sexo</strong></td>
		<td width="69" align="center" class="letraDocumentoTitulo"><strong>Edad</strong></td>
		<td width="149" align="center" class="letraDocumentoTitulo"><strong>Actividad</strong></td>
		<td width="153" align="center" class="letraDocumentoTitulo"><strong>Ciudad peritaje</strong></td>
	</tr>
	<?php 
	$total = 0;
	
	$sql = mysql_query($query, $conectar);
	
	while($row = mysql_fetch_array($sql))
	{
		$idHora = $row[id];
		$fecha = $row[fecha];
		$hora = $row[hora];
		$ciudad = nombreCiudad($row[ciudad], $conectar);
		$nombrePrestador = nombreCompletoPrestadorApellido ($row[prestador], $conectar);
		$nombrePaciente = nombreCompletoPacienteApellido($row[paciente], $conectar);
		$rutPaciente = rutPaciente($row[paciente], $conectar);
		$rutPaciente = PonerPunto($rutPaciente).'-'.DigitoVerificador($rutPaciente);
		$isapre = nombreIsapre(isaprePaciente($row[paciente], $conectar), $conectar);
		$confirma = $row[confirmada];
		$asiste = $row[asiste];
		
		if(idInformeEntrevistaHora($idHora, $conectar) != NULL)
		{
			$idInforme = idInformeEntrevistaHora($idHora, $conectar);
			$sexo = sexoEntrevistaHora($idInforme, $conectar);
			$edad = edadEntrevistaHora($idInforme, $conectar);
			$actividad = ocupacionEntrevistaHora($idInforme, $conectar);
		}
		else
		{
			$sexo = 'n/a';
			$edad = 'n/a';
			$actividad = 'n/a';
		}
		$idComuna = idComunaPaciente($row[paciente], $conectar);
		$region = ucwords(str_replace('Regi&oacute;n','', retornaRegion($idComuna, $conectar)));
		
		?>
		<tr>
			<td height="21" align="center"><?php echo $fecha; ?></td>
			<td align="center"><?php echo $hora; ?></td>
			<td align="left" style="padding-left:10px"><?php echo $nombrePrestador; ?>&nbsp;</td>
			<td align="center"><?php echo $rutPaciente; ?>&nbsp;</td>
			<td align="left" style="padding-left:10px"><?php echo $isapre; ?></td>
			<td align="center"><?php echo $confirma; ?></td>
			<td align="center"><?php echo $asiste; ?></td>
			<td align="center"><?php echo $sexo; ?></td>
			<td align="center"><?php echo $edad; ?></td>
			<td align="left"><?php echo $actividad; ?></td>
			<td align="left"><?php echo $ciudad; ?></td>
		</tr>
		<?php 
		$total++;
	}
	?>
</table>
